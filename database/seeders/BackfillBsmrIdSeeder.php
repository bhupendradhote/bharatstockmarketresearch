<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Carbon\Carbon;

class BackfillBsmrIdSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Get all users ordered by creation date
        $users = User::orderBy('created_at', 'asc')->get();

        // 2. Global Sequence Counter (Started outside the loop)
        $globalSequence = 0;

        foreach ($users as $user) {
            // Format date as YYYYMMDD
            $datePrefix = Carbon::parse($user->created_at)->format('Ymd');

            // Increment Global Sequence
            $globalSequence++;

            // Pad with zeros (e.g., 1 -> 01, 10 -> 10)
            $sequencePadded = str_pad($globalSequence, 2, '0', STR_PAD_LEFT);

            // Save with Hyphen: Date - Global Sequence
            $user->bsmr_id = $datePrefix . '-' . $sequencePadded;
            $user->save();

            $this->command->info("User ID {$user->id} updated to: {$user->bsmr_id}");
        }
    }
}
