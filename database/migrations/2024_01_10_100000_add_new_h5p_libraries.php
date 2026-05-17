<?php

use Database\Seeders\H5PAddRowOneOneSeeder;
use Database\Seeders\H5PAddComponentsOneZeroSeeder;
use Database\Seeders\H5PAddTableOneTwoSeeder;
use Database\Seeders\H5PAddDragQuestionOneFifteenSeeder;
use Database\Seeders\H5PAddMultiMediaChoiceZeroThreeSeeder;
use Database\Seeders\H5PAddAgamottoOneSevenSeeder;
use Database\Seeders\H5PAddImageSliderOneOneSeeder;
use Database\Seeders\H5PAddQuestionSetOneTwentyOneSeeder;
use Database\Seeders\H5PAddColumnOneTwentySeeder;
use Database\Seeders\H5PAddInteractiveVideoOneTwentyEightSeeder;
use Database\Seeders\H5PAddCoursePresentationOneTwentySevenSeeder;
use Database\Seeders\H5PAddDictationOneThreeSeeder;
use Illuminate\Database\Migrations\Migration;

class AddNewH5PLibraries extends Migration
{
    /**
     * Run the migrations.
     *
     * Order is critical — each seeder may reference libraries inserted by earlier seeders:
     *
     * H5PEditor.InteractiveVideo-1.26 (inline in IV seeder) preloads:
     *   H5P.Table-1.2, H5P.DragQuestion-1.15, H5P.MultiMediaChoice-0.3
     *
     * H5PEditor.CoursePresentation-1.26 (inline in CP seeder) preloads:
     *   H5P.Table-1.2, H5P.DragQuestion-1.15, H5P.MultiMediaChoice-0.3, H5P.InteractiveVideo-1.28
     *
     * So the required order is:
     *   Row, Components, Table → DragQuestion, MultiMediaChoice → IV → CP
     *
     * @return void
     */
    public function up()
    {
        // 1. Pure dependency libs (no new-lib deps)
        \Artisan::call('db:seed', ['--class' => H5PAddRowOneOneSeeder::class, '--force' => true]);
        \Artisan::call('db:seed', ['--class' => H5PAddComponentsOneZeroSeeder::class, '--force' => true]);
        \Artisan::call('db:seed', ['--class' => H5PAddTableOneTwoSeeder::class, '--force' => true]);

        // 2. Runnable libs that only need Components (and Table/Row already seeded above)
        //    DragQuestion and MultiMediaChoice must come here because both
        //    H5PEditor.InteractiveVideo-1.26 and H5PEditor.CoursePresentation-1.26
        //    list them as preloaded dependencies.
        \Artisan::call('db:seed', ['--class' => H5PAddDragQuestionOneFifteenSeeder::class, '--force' => true]);
        \Artisan::call('db:seed', ['--class' => H5PAddMultiMediaChoiceZeroThreeSeeder::class, '--force' => true]);

        // 3. Other runnable libs with no cross-deps on new libs
        \Artisan::call('db:seed', ['--class' => H5PAddAgamottoOneSevenSeeder::class, '--force' => true]);
        \Artisan::call('db:seed', ['--class' => H5PAddImageSliderOneOneSeeder::class, '--force' => true]);
        \Artisan::call('db:seed', ['--class' => H5PAddQuestionSetOneTwentyOneSeeder::class, '--force' => true]);
        \Artisan::call('db:seed', ['--class' => H5PAddColumnOneTwentySeeder::class, '--force' => true]);

        // 4. IV must come before CP because H5PEditor.CoursePresentation-1.26
        //    lists H5P.InteractiveVideo-1.28 as a preloaded dependency.
        \Artisan::call('db:seed', ['--class' => H5PAddInteractiveVideoOneTwentyEightSeeder::class, '--force' => true]);
        \Artisan::call('db:seed', ['--class' => H5PAddCoursePresentationOneTwentySevenSeeder::class, '--force' => true]);

        // 5. No cross-deps on other new libs
        \Artisan::call('db:seed', ['--class' => H5PAddDictationOneThreeSeeder::class, '--force' => true]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
