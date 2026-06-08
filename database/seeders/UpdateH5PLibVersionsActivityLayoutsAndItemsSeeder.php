<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UpdateH5PLibVersionsActivityLayoutsAndItemsSeeder extends Seeder
{
    // Maps old h5pLib values => new h5pLib value
    private array $itemUpdates = [
        'H5P.CoursePresentation 1.22' => 'H5P.CoursePresentation 1.27',
        'H5P.InteractiveVideo 1.21'   => 'H5P.InteractiveVideo 1.28',
        'H5P.InteractiveVideo 1.22'   => 'H5P.InteractiveVideo 1.28',
        'H5P.InteractiveVideo 1.24'   => 'H5P.InteractiveVideo 1.28',
        'H5P.Agamotto 1.5'            => 'H5P.Agamotto 1.7',
        'H5P.Column 1.15'             => 'H5P.Column 1.20',
        'H5P.Dictation 1.0'           => 'H5P.Dictation 1.3',
        'H5P.DragQuestion 1.14'       => 'H5P.DragQuestion 1.15',
        'H5P.QuestionSet 1.20'        => 'H5P.QuestionSet 1.21',
    ];

    private array $layoutUpdates = [
        'H5P.Column 1.15'             => 'H5P.Column 1.20',
        'H5P.CoursePresentation 1.22' => 'H5P.CoursePresentation 1.27',
        'H5P.CoursePresentation 1.24' => 'H5P.CoursePresentation 1.27',
        'H5P.InteractiveVideo 1.22'   => 'H5P.InteractiveVideo 1.28',
        'H5P.InteractiveVideo 1.24'   => 'H5P.InteractiveVideo 1.28',
        'H5P.QuestionSet 1.20'        => 'H5P.QuestionSet 1.21',
    ];

    public function run(): void
    {
        foreach ($this->itemUpdates as $from => $to) {
            DB::table('activity_items')
                ->where('h5pLib', $from)
                ->update(['h5pLib' => $to, 'updated_at' => now()]);
        }

        foreach ($this->layoutUpdates as $from => $to) {
            DB::table('activity_layouts')
                ->where('h5pLib', $from)
                ->update(['h5pLib' => $to, 'updated_at' => now()]);
        }
    }
}
