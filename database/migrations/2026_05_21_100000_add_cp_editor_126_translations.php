<?php

use Database\Seeders\H5PAddCPEditorOneTwentySixTranslationSeeder;
use Illuminate\Database\Migrations\Migration;

class AddCpEditor126Translations extends Migration
{
    public function up()
    {
        \Artisan::call('db:seed', [
            '--class' => H5PAddCPEditorOneTwentySixTranslationSeeder::class,
            '--force' => true
        ]);
    }

    public function down()
    {
        //
    }
}
