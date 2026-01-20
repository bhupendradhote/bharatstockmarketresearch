<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use App\Models\KycVerification;
use Illuminate\Support\Facades\Auth;

class DigioKycController extends Controller
{
    /**
     * Show KYC page
     */
    public function index()
    {
        return view('UserDashboard.settings.kyc_upgrade');
    }
   
    public function testDirectRedirect(Request $request)
    {
        $user = Auth::user();

        if (!$user) {
            return response()->json([
                'success' => false,
                'note' => 'UNAUTHENTICATED'
            ], 401);
        }

        $mobile = $request->phone ?? $user->phone;
        $name   = $request->name ?? $user->name;

        /**
         * 1️⃣ Get latest KYC of user
         */
        $lastKyc = KycVerification::where('user_id', $user->id)
            ->latest()
            ->first();

        /**
         * 🚫 BLOCK if KYC still ACTIVE (Digio rule)
         */
        if ($lastKyc && in_array($lastKyc->status, [
            'initiated',
            'pending',
            'approval_pending',
            'approved'
        ])) {
            return response()->json([
                'success' => false,
                'note' => 'KYC already in progress or completed'
            ]);
        }

        /**
         * 🧹 DELETE OLD KYC if REJECTED / FAILED / EXPIRED
         */
        if ($lastKyc && in_array($lastKyc->status, [
            'rejected',
            'failed',
            'expired'
        ])) {
            KycVerification::where('user_id', $user->id)
                ->whereIn('status', ['rejected', 'failed', 'expired'])
                ->delete();
        }

        try {
            /**
             * 2️⃣ CREATE NEW DIGIO KYC
             */
            $referenceId   = 'KYC_' . time();
            $transactionId = $referenceId;

            $payload = [
                "template_name"       => env('DIGIO_WORKFLOW_NAME'),
                "customer_identifier" => $mobile,
                "customer_name"       => $name,
                "reference_id"        => $referenceId,
                "transaction_id"      => $transactionId,
                "notify_customer"     => false,
                "expire_in_days"      => 1,
                "message"             => "KYC Verification"
            ];

            $apiUrl = rtrim(env('DIGIO_API_BASE_URL'), '/') .
                '/client/kyc/v2/request/with_template';

            Log::info('DIGIO_KYC_REQUEST', [
                'user_id' => $user->id,
                'url'     => $apiUrl,
                'payload' => $payload
            ]);

            $response = Http::withBasicAuth(
                    env('DIGIO_CLIENT_ID'),
                    env('DIGIO_CLIENT_SECRET')
                )
                ->withHeaders([
                    'Content-Type' => 'application/json'
                ])
                ->timeout(30)
                ->post($apiUrl, $payload);

            /**
             * 🔴 FULL DIGIO ERROR
             */
            if (!$response->successful()) {
                Log::error('DIGIO_KYC_API_ERROR', [
                    'status' => $response->status(),
                    'body'   => $response->body()
                ]);

                return response()->json([
                    'success' => false,
                    'note' => 'Digio API error',
                    'http_status' => $response->status(),
                    'digio_error' => $response->json()
                ]);
            }

            $data = $response->json();

            if (empty($data['id'])) {
                return response()->json([
                    'success' => false,
                    'note' => 'Digio response missing document id',
                    'digio_error' => $data
                ]);
            }

            $documentId = $data['id'];

            /**
             * ❌ BLOCK DGO
             */
            if (str_starts_with($documentId, 'DGO')) {
                return response()->json([
                    'success' => false,
                    'note' => 'DGO flow not supported'
                ]);
            }

            /**
             * 3️⃣ CREATE NEW DB ENTRY (FRESH)
             */
            KycVerification::create([
                'user_id'           => $user->id,
                'digio_document_id' => $documentId,
                'customer_name'     => $name,
                'customer_mobile'   => $mobile,
                'customer_email'    => $user->email,
                'reference_id'      => $referenceId,
                'transaction_id'    => $transactionId,
                'status'            => 'initiated',
                'kyc_details'       => json_encode([
                    'type' => 're-kyc'
                ]),
                'raw_response'      => json_encode($data)
            ]);

            /**
             * 4️⃣ REDIRECT URL (UI)
             */
            $redirectBase = str_contains(env('DIGIO_API_BASE_URL'), 'ext.digio')
                ? 'https://ext.digio.in/#/gateway/login/'
                : 'https://app.digio.in/#/gateway/login/';

            $redirectUrl = $redirectBase .
                $documentId . '/' .
                time() . '/' .
                $mobile .
                '?redirect_url=' . urlencode(route('digio.callback'));

            return response()->json([
                'success'      => true,
                'document_id'  => $documentId,
                'redirect_url' => $redirectUrl
            ]);

        } catch (\Exception $e) {
            Log::error('DIGIO_KYC_EXCEPTION', [
                'message' => $e->getMessage()
            ]);

            return response()->json([
                'success' => false,
                'note' => 'Server exception',
                'error' => $e->getMessage()
            ], 500);
        }
    } 


    public function callback(Request $request)
    {
        Log::info('================ DIGIO CALLBACK START ================');
        Log::info('Callback Payload', $request->all());

        $digioId = $request->input('digio_doc_id'); // KID...
        $callbackStatus = $request->input('status');

        Log::info('Parsed Callback Data', [
            'digio_id'         => $digioId,
            'callback_status' => $callbackStatus,
        ]);

        if (!$digioId) {
            Log::error('Callback FAILED: digio_doc_id missing');
            return response()->json(['error' => 'Invalid callback'], 400);
        }

        // 1️⃣ DB record check
        $kyc = DB::table('kyc_verifications')
            ->where('digio_document_id', $digioId)
            ->first();

        if (!$kyc) {
            Log::error('KYC NOT FOUND in DB', [
                'digio_document_id' => $digioId
            ]);
            return response()->json(['error' => 'KYC not found'], 404);
        }

        Log::info('KYC Record Found', [
            'db_status' => $kyc->status,
            'user_id'   => $kyc->user_id,
        ]);

        // 2️⃣ Manual approval (sirf approval_pending pe)
        if ($kyc->status === 'initiated') {
            Log::info('Status = initiated → calling manual approval');

            $approvalResponse = $this->approveKycManually($digioId);

            Log::info('Manual Approval Finished', [
                'response' => $approvalResponse
            ]);
        } else {
            Log::info('Manual approval skipped (status != approval_pending)');
        }

        // 3️⃣ FINAL STATUS + DETAILS FETCH
        Log::info('Calling Digio RESPONSE API');
        $this->fetchAndUpdateKycStatus($digioId);

        Log::info('================ DIGIO CALLBACK END =================');

        // ⚠️ browser testing only
        return redirect()->route('kyc.index');
    }

    private function approveKycManually($id)
    {
        Log::info('---- Manual Approval START ----', [
            'id' => $id
        ]);

        $url = env('DIGIO_API_BASE_URL')
            . "/client/kyc/v2/request/{$id}/manage_approval";

        Log::info('Manual Approval URL', ['url' => $url]);

        $response = Http::withBasicAuth(
            env('DIGIO_CLIENT_ID'),
            env('DIGIO_CLIENT_SECRET')
        )->post($url, [
            "status" => "approved"   // ✅ CORRECT AS PER DIGIO DOC
        ]);

        Log::info('Manual Approval HTTP Response', [
            'http_status' => $response->status(),
            'body'        => $response->json()
        ]);

        if (!$response->successful()) {
            Log::error('Manual Approval FAILED', [
                'id'       => $id,
                'response' => $response->body()
            ]);
        }

        Log::info('---- Manual Approval END ----');

        return $response->json();
    }

    private function fetchAndUpdateKycStatus($id)
    {
        Log::info('---- STATUS RESPONSE API START ----', [
            'id' => $id
        ]);

        if (!$id) {
            Log::error('STATUS RESPONSE ABORTED: id is NULL');
            return;
        }

        $url = env('DIGIO_API_BASE_URL')
            . "/client/kyc/v2/{$id}/response";

        Log::info('Status Response URL', ['url' => $url]);

        $response = Http::withBasicAuth(
            env('DIGIO_CLIENT_ID'),
            env('DIGIO_CLIENT_SECRET')
        )->post($url);   // ⚠️ POST, not GET

        Log::info('Status Response HTTP Result', [
            'http_status' => $response->status(),
            'raw_body'    => $response->body()
        ]);

        if (!$response->successful()) {
            Log::error('Status Response FAILED', [
                'id'       => $id,
                'response' => $response->body()
            ]);
            return;
        }

        $data = $response->json();

        Log::info('Parsed Status Response', $data);

        // DB UPDATE (sirf existing columns)
        $updated = DB::table('kyc_verifications')
            ->where('digio_document_id', $id)
            ->update([
                'status'       => $data['status'] ?? null,
                'raw_response' => json_encode($data),
                'updated_at'   => now()
            ]);

        Log::info('DB Update Result', [
            'rows_updated' => $updated,
            'final_status' => $data['status'] ?? null
        ]);

        Log::info('---- STATUS RESPONSE API END ----');
    }

    public function digioCallback(Request $request)
    {
        $user = Auth::user();

        if (!$user) {
            return redirect()->route('login');
        }

        /**
         * ======================================
         * 1️⃣ FIND USER'S LATEST ACTIVE KYC
         * (initiated / pending)
         * ======================================
         */
        $kyc = KycVerification::where('user_id', $user->id)
            ->whereIn('status', ['initiated', 'approval_pending', 'pending', 'processing'])
            ->latest()
            ->first();

        if (!$kyc) {
            return redirect()
                ->route('user.dashboard')
                ->with('error', 'No active KYC request found.');
        }

        $documentId = $kyc->digio_document_id;

        try {
            /**
             * ======================================
             * 2️⃣ VERIFY STATUS FROM DIGIO (TRUTH)
             * ======================================
             */
            $apiUrl = env('DIGIO_API_BASE_URL') .
                '/client/kyc/v2/' . $documentId . '/response';

            $response = Http::withBasicAuth(
                env('DIGIO_CLIENT_ID'),
                env('DIGIO_CLIENT_SECRET')
            )
            ->timeout(30)
            ->post($apiUrl);

            if ($response->failed()) {
                Log::error('Digio callback verification failed', [
                    'user_id' => $user->id,
                    'document_id' => $documentId,
                    'response' => $response->json()
                ]);

                return redirect()
                    ->route('user.dashboard')
                    ->with('error', 'Unable to verify KYC at the moment.');
            }

            $digioData = $response->json();
            $status = strtolower($digioData['status'] ?? 'pending');

            /**
             * ======================================
             * 3️⃣ UPDATE DATABASE
             * ======================================
             */
            $aadhaarDetails = null;
            if (!empty($digioData['actions'][0]['details']['aadhaar'])) {
                $aadhaarDetails = $digioData['actions'][0]['details']['aadhaar'];
            }

            $kyc->update([
                'status' => $status,

                'aadhaar_details' => $aadhaarDetails,

                'kyc_completed_at' =>
                    in_array($status, ['approved', 'completed', 'success'])
                        ? now()
                        : null,

                'kyc_expires_at' =>
                    isset($digioData['expire_in_days'])
                        ? now()->addDays($digioData['expire_in_days'])
                        : $kyc->kyc_expires_at,

                'raw_response' => $digioData,
            ]);

            /**
             * ======================================
             * 4️⃣ USER REDIRECT MESSAGE
             * ======================================
             */
            if (in_array($status, ['approved', 'completed', 'success'])) {
                return redirect()
                    ->route('user.dashboard')
                    ->with('success', '✅ KYC verified successfully');
            }

            if (in_array($status, ['approval_pending', 'pending', 'processing'])) {
                return redirect()
                    ->route('user.dashboard')
                    ->with('info', '⏳ KYC submitted and pending approval');
            }

            return redirect()
                ->route('user.dashboard')
                ->with('error', '❌ KYC verification failed');

        } catch (\Exception $e) {
            Log::error('Digio callback exception', [
                'user_id' => $user->id,
                'document_id' => $documentId,
                'error' => $e->getMessage()
            ]);

            return redirect()
                ->route('user.dashboard')
                ->with('error', 'KYC verification error. Please try again.');
        }
    }

        public function checkKycStatusDirect(Request $request)
    {
        $user = Auth::user();

        if (!$user) {
            return response()->json([
                'success' => false,
                'error'   => 'UNAUTHENTICATED'
            ], 401);
        }

        /**
         * 1️⃣ GET USER'S LATEST KYC RECORD
         */
        $kyc = KycVerification::where('user_id', $user->id)
            ->latest()
            ->first();

        if (!$kyc) {
            return response()->json([
                'success' => true,
                'kyc_status' => 'none',
                'message' => 'No KYC found for user'
            ], 200);
        }

        $documentId = $kyc->digio_document_id;

        try {
            /**
             * 2️⃣ CALL DIGIO RESPONSE API
             */
            $apiUrl = env('DIGIO_API_BASE_URL', 'https://api.digio.in')
                . '/client/kyc/v2/' . $documentId . '/response';

            $response = Http::withBasicAuth(
                env('DIGIO_CLIENT_ID'),
                env('DIGIO_CLIENT_SECRET')
            )
            ->timeout(30)
            ->post($apiUrl);

            $digioData = $response->json();

            if ($response->failed()) {
                return response()->json([
                    'success' => false,
                    'error'   => 'DIGIO_API_ERROR',
                    'details' => $digioData
                ], $response->status());
            }

            /**
             * 3️⃣ NORMALIZE STATUS
             */
            $status = strtolower($digioData['status'] ?? 'pending');

            /**
             * 4️⃣ EXTRACT AADHAAR (SAFE)
             */
            $aadhaarDetails = null;

            if (
                isset($digioData['actions'][0]['details']['aadhaar']) &&
                is_array($digioData['actions'][0]['details']['aadhaar'])
            ) {
                $aadhaarDetails = $digioData['actions'][0]['details']['aadhaar'];
            }

            /**
             * 5️⃣ UPDATE DATABASE
             */
            $kyc->update([
                'status' => $status,
                'aadhaar_details' => $aadhaarDetails,
                'kyc_completed_at' =>
                    in_array($status, ['approved', 'completed', 'success'])
                        ? now()
                        : null,
                'kyc_expires_at' =>
                    isset($digioData['expire_in_days'])
                        ? now()->addDays($digioData['expire_in_days'])
                        : $kyc->kyc_expires_at,
                'raw_response' => $digioData,
            ]);

            // 🔁 Refresh model to get latest DB values
            $kyc->refresh();

            /**
             * 6️⃣ RETURN CLEAN RESPONSE FOR UI
             */
            return response()->json([
                'success'      => true,
                'kyc_status'   => $kyc->status,   // 🔑 UI uses this
                'document_id'  => $documentId,
                'expires_at'   => $kyc->kyc_expires_at,
                'completed_at' => $kyc->kyc_completed_at,
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'error'   => 'DIGIO_CONNECTION_ERROR',
                'message' => $e->getMessage()
            ], 500);
        }
    }

}
