<?php

use Database\Seeders\H5PAddSortParagraphsZeroElevenSeeder;
use Illuminate\Database\Migrations\Migration;

class AddSortParagraphsH5PLibrary extends Migration
{
    public function up()
    {
        \Artisan::call('db:seed', ['--class' => H5PAddSortParagraphsZeroElevenSeeder::class, '--force' => true]);
    }

    public function down()
    {
        $subquery = function ($q) {
            $q->select('id')->from('h5p_libraries')
                ->where('name', 'H5P.SortParagraphs')
                ->where('major_version', 0)
                ->where('minor_version', 11);
        };

        DB::table('h5p_libraries_languages')->whereIn('library_id', $subquery)->delete();
        DB::table('h5p_libraries_libraries')->whereIn('library_id', $subquery)->delete();

        DB::table('h5p_libraries')
            ->where('name', 'H5P.SortParagraphs')
            ->where('major_version', 0)
            ->where('minor_version', 11)
            ->delete();
    }
}
