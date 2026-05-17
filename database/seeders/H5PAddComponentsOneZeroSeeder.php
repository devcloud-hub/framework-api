<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class H5PAddComponentsOneZeroSeeder extends Seeder
{
    public function run()
    {
        $params = ['name' => "H5P.Components", "major_version" => 1, "minor_version" => 0];
        $lib = DB::table('h5p_libraries')->where($params)->first();

        if (empty($lib)) {
            $libId = DB::table('h5p_libraries')->insertGetId([
                'name' => 'H5P.Components',
                'title' => 'Components',
                'major_version' => 1,
                'minor_version' => 0,
                'patch_version' => 97,
                'embed_types' => 'iframe',
                'runnable' => 0,
                'restricted' => 0,
                'fullscreen' => 0,
                'preloaded_js' => 'dist/h5p-components.js',
                'preloaded_css' => 'dist/h5p-components.css',
                'drop_library_css' => '',
                'semantics' => '',
                'tutorial_url' => ' ',
                'has_icon' => 0
            ]);

        $jQueryUIParams = ['name' => "jQuery.ui", "major_version" => 1, "minor_version" => 10];
        $jQueryUILib = DB::table('h5p_libraries')->where($jQueryUIParams)->first();
        $jQueryUILibId = $jQueryUILib->id;
        DB::table('h5p_libraries_libraries')->insert(['library_id' => $libId, 'required_library_id' => $jQueryUILibId, 'dependency_type' => 'preloaded']);
        }
    }
}
