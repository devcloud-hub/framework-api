<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class H5PUpdateCPEditor126AddCPOneTwentySevenDependencySeeder extends Seeder
{
    public function run()
    {
        $editorLib = DB::table('h5p_libraries')
            ->where(['name' => 'H5PEditor.CoursePresentation', 'major_version' => 1, 'minor_version' => 26])
            ->first();

        if (empty($editorLib)) {
            return;
        }

        $cpLib = DB::table('h5p_libraries')
            ->where(['name' => 'H5P.CoursePresentation', 'major_version' => 1, 'minor_version' => 27])
            ->first();

        if (empty($cpLib)) {
            return;
        }

        $alreadyExists = DB::table('h5p_libraries_libraries')
            ->where([
                'library_id' => $editorLib->id,
                'required_library_id' => $cpLib->id,
                'dependency_type' => 'preloaded',
            ])
            ->exists();

        if (!$alreadyExists) {
            DB::table('h5p_libraries_libraries')->insert([
                'library_id' => $editorLib->id,
                'required_library_id' => $cpLib->id,
                'dependency_type' => 'preloaded',
            ]);
        }
    }
}
