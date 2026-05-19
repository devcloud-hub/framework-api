<?php

use Database\Seeders\H5PUpdateCPEditor126AddCPOneTwentySevenDependencySeeder;
use Illuminate\Database\Migrations\Migration;

class UpdateCpEditor126AddCp127Dependency extends Migration
{
    public function up()
    {
        \Artisan::call('db:seed', [
            '--class' => H5PUpdateCPEditor126AddCPOneTwentySevenDependencySeeder::class,
            '--force' => true,
        ]);
    }

    public function down()
    {
        //
    }
}
