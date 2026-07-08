<?php

use Database\Seeders\H5PAddEmbeddedJSDependencyToQuestionSetSeeder;
use Illuminate\Database\Migrations\Migration;

class AddEmbeddedJSDependencyToQuestionSet extends Migration
{
    public function up()
    {
        \Artisan::call('db:seed', ['--class' => H5PAddEmbeddedJSDependencyToQuestionSetSeeder::class, '--force' => true]);
    }

    public function down()
    {
        //
    }
}
