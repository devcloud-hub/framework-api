<?php

use Database\Seeders\UpdateH5PLibVersionsActivityLayoutsAndItemsSeeder;
use Illuminate\Database\Migrations\Migration;

class UpdateH5PLibVersionsActivityLayoutsAndItems extends Migration
{
    public function up()
    {
        \Artisan::call('db:seed', [
            '--class' => UpdateH5PLibVersionsActivityLayoutsAndItemsSeeder::class,
            '--force' => true,
        ]);
    }

    public function down()
    {
        // activity_items rollback
        $itemRollback = [
            'H5P.CoursePresentation 1.27' => 'H5P.CoursePresentation 1.22',
            'H5P.InteractiveVideo 1.28'   => 'H5P.InteractiveVideo 1.24',
            'H5P.DragQuestion 1.15'       => 'H5P.DragQuestion 1.14',
            // QuestionSet: only roll back entries titled 'Quiz' or 'Quiz 1.20'
            // to avoid touching 'Quiz (Question Set)' which was already at 1.21
        ];

        DB::table('activity_items')
            ->where('h5pLib', 'H5P.CoursePresentation 1.27')
            ->update(['h5pLib' => 'H5P.CoursePresentation 1.22', 'updated_at' => now()]);

        DB::table('activity_items')
            ->where('h5pLib', 'H5P.InteractiveVideo 1.28')
            ->whereIn('title', ['Interactive Video'])
            ->update(['h5pLib' => 'H5P.InteractiveVideo 1.24', 'updated_at' => now()]);

        DB::table('activity_items')
            ->where('h5pLib', 'H5P.DragQuestion 1.15')
            ->update(['h5pLib' => 'H5P.DragQuestion 1.14', 'updated_at' => now()]);

        DB::table('activity_items')
            ->where('h5pLib', 'H5P.QuestionSet 1.21')
            ->whereIn('title', ['Quiz', 'Quiz 1.20'])
            ->update(['h5pLib' => 'H5P.QuestionSet 1.20', 'updated_at' => now()]);

        // activity_layouts rollback
        DB::table('activity_layouts')
            ->where('h5pLib', 'H5P.Column 1.20')
            ->update(['h5pLib' => 'H5P.Column 1.15', 'updated_at' => now()]);

        DB::table('activity_layouts')
            ->where('h5pLib', 'H5P.CoursePresentation 1.27')
            ->update(['h5pLib' => 'H5P.CoursePresentation 1.24', 'updated_at' => now()]);

        DB::table('activity_layouts')
            ->where('h5pLib', 'H5P.InteractiveVideo 1.28')
            ->update(['h5pLib' => 'H5P.InteractiveVideo 1.24', 'updated_at' => now()]);

        DB::table('activity_layouts')
            ->where('h5pLib', 'H5P.QuestionSet 1.21')
            ->update(['h5pLib' => 'H5P.QuestionSet 1.20', 'updated_at' => now()]);
    }
}
