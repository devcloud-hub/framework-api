<?php

use Database\Seeders\AddSortParagraphsActivityItemSeeder;
use Illuminate\Database\Migrations\Migration;

class AddSortParagraphsActivityItem extends Migration
{
    public function up()
    {
        \Artisan::call('db:seed', [
            '--class' => AddSortParagraphsActivityItemSeeder::class,
            '--force' => true,
        ]);
    }

    public function down()
    {
        DB::table('activity_items')
            ->where('title', 'Sort Paragraphs')
            ->where('h5pLib', 'H5P.SortParagraphs 0.11')
            ->delete();
    }
}
