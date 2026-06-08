<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class AddSortParagraphsActivityItemSeeder extends Seeder
{
    public function run()
    {
        $localURL = public_path('storage/activity-items/');
        $storageURL = '/storage/activity-items/';

        $sortParagraphsImg = 'YXKUebOppiDqTW7c6lLzAHHYxSKUsKSIEa6weXW3.png';

        $organizations = DB::table('organizations')->pluck('id');
        $currentDate = now();

        $this->insertActivityItem($localURL, $sortParagraphsImg, $organizations, $storageURL, $currentDate);
    }

    public function copyImage($image)
    {
        $liveURL = 'https://studio.frameworkconsulting.com/api/storage/activity-items/';
        $localURL = public_path('storage/activity-items/');

        $liveImageSrc = $liveURL . $image;
        $destination = $localURL . $image;

        if (@file_get_contents($liveImageSrc)) {
            copy($liveImageSrc, $destination);
        }
    }

    private function insertActivityItem($localURL, $sortParagraphsImg, $organizations, $storageURL, $currentDate)
    {
        foreach ($organizations as $organization) {
            $activityTypes = DB::table('activity_types')->whereOrganizationId($organization)->pluck('id', 'title');

            if (!isset($activityTypes['Questions'])) {
                continue;
            }

            if (!File::exists($localURL . $sortParagraphsImg)) {
                $this->copyImage($sortParagraphsImg);
            }

            $activityItem = [
                'title'            => 'Sort Paragraphs',
                'image'            => $storageURL . $sortParagraphsImg,
                'description'      => 'Arrange paragraphs in the correct order',
                'activity_type_id' => $activityTypes['Questions'],
                'h5pLib'           => 'H5P.SortParagraphs 0.11',
                'demo_activity_id' => '0',
                'demo_video_id'    => '',
                'type'             => 'h5p',
                'created_at'       => $currentDate,
                'deleted_at'       => null,
                'organization_id'  => $organization,
            ];

            DB::table('activity_items')->updateOrInsert(
                ['title' => 'Sort Paragraphs', 'organization_id' => $organization],
                $activityItem
            );
        }
    }
}
