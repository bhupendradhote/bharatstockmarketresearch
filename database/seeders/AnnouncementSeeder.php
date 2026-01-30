<?php

namespace Database\Seeders;

use App\Models\Announcement;
use Illuminate\Database\Seeder;
use Carbon\Carbon;

class AnnouncementSeeder extends Seeder
{
    public function run(): void
    {
        $announcements = [
            [
                'title' => 'New Notification Center & Learning modules',
                'type' => 'Features',
                'content' => 'Now Track all Alerts in one place and learn logic behind each tip via structured modules.',
                'detail' => "Scheduled between 11.30 PM and 12.30 PM on Sunday night. During the time: \n\n • Exist logged-in users may experience brief disconnects \n • New logins and KYC documents uploads may be temporarily unavailable.",
                'published_at' => Carbon::now(),
            ],
            [
                'title' => 'Change in Package bill Cycle',
                'type' => 'Service Update',
                'content' => 'Monthly plans now renew exactly 30 days from activation time for more transparent bills.',
                'detail' => 'Your billing cycle has been updated to provide better transparency. No action is required from your side.',
                'published_at' => Carbon::now()->subDays(2),
            ],
            [
                'title' => 'Plan maintenance window',
                'type' => 'Others',
                'content' => 'Short maintenance window this weekend; reading access stays on, but new logins will be restricted.',
                'detail' => 'We are performing routine server maintenance to improve performance.',
                'published_at' => Carbon::now()->subDays(3),
            ]
        ];

        foreach ($announcements as $announcement) {
            Announcement::create($announcement);
        }
    }
}
