<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Faq;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class FaqApiController extends Controller
{
    // ===== LIST FAQS =====
    public function index(Request $request)
    {
        $query = Faq::query()->orderBy('sort_order');

        if ($request->page_type) {
            $query->where('page_type', $request->page_type);
        }

        if ($request->page_slug) {
            $query->where('page_slug', $request->page_slug);
        }

        return response()->json([
            'success' => true,
            'data' => $query->get()
        ]);
    }

    // ===== CREATE MULTIPLE FAQS =====
    public function store(Request $request)
    {
        $validated = $request->validate([
            'page_type'    => 'required|string|max:100',
            'page_slug'    => 'nullable|string|max:150',

            'questions'    => 'required|array|min:1',
            'questions.*'  => 'required|string|max:255',

            'answers'      => 'required|array|min:1',
            'answers.*'    => 'required|string',

            'sort_order'   => 'nullable|integer',
            'status'       => 'required|boolean',
        ]);

        DB::transaction(function () use ($validated) {
            foreach ($validated['questions'] as $index => $question) {
                Faq::create([
                    'page_type'  => $validated['page_type'],
                    'page_slug'  => $validated['page_slug'] ?? null,
                    'question'   => $question,
                    'answer'     => $validated['answers'][$index],
                    'sort_order' => $validated['sort_order'] ?? 0,
                    'status'     => $validated['status'],
                ]);
            }
        });

        return response()->json([
            'success' => true,
            'message' => 'FAQs created successfully'
        ]);
    }

    // ===== UPDATE SINGLE FAQ =====
    public function update(Request $request, $id)
    {
        $faq = Faq::findOrFail($id);

        $validated = $request->validate([
            'page_type'  => 'required|string|max:100',
            'page_slug'  => 'nullable|string|max:150',

            'question'   => 'required|string|max:255',
            'answer'     => 'required|string',

            'sort_order' => 'nullable|integer',
            'status'     => 'required|boolean',
        ]);

        $faq->update([
            'page_type'  => $validated['page_type'],
            'page_slug'  => $validated['page_slug'] ?? null,
            'question'   => $validated['question'],
            'answer'     => $validated['answer'],
            'sort_order' => $validated['sort_order'] ?? 0,
            'status'     => $validated['status'],
        ]);

        return response()->json([
            'success' => true,
            'message' => 'FAQ updated successfully',
            'data' => $faq
        ]);
    }

    // ===== DELETE FAQ =====
    public function destroy($id)
    {
        $faq = Faq::findOrFail($id);
        $faq->delete();

        return response()->json([
            'success' => true,
            'message' => 'FAQ deleted successfully'
        ]);
    }
}
