<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class H5PAddEmbeddedJSDependencyToQuestionSetSeeder extends Seeder
{
    public function run()
    {
        $qsLib = DB::table('h5p_libraries')
            ->where(['name' => 'H5P.QuestionSet', 'major_version' => 1, 'minor_version' => 21])
            ->first();

        if (empty($qsLib)) {
            return;
        }

        $ejsLib = DB::table('h5p_libraries')
            ->where(['name' => 'EmbeddedJS', 'major_version' => 1, 'minor_version' => 0])
            ->first();

        if (empty($ejsLib)) {
            return;
        }

        $exists = DB::table('h5p_libraries_libraries')
            ->where([
                'library_id' => $qsLib->id,
                'required_library_id' => $ejsLib->id,
                'dependency_type' => 'preloaded',
            ])
            ->exists();

        if (!$exists) {
            DB::table('h5p_libraries_libraries')->insert([
                'library_id' => $qsLib->id,
                'required_library_id' => $ejsLib->id,
                'dependency_type' => 'preloaded',
            ]);
        }
    }
}
