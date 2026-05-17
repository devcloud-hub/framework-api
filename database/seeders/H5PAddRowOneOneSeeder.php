<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class H5PAddRowOneOneSeeder extends Seeder
{
    public function run()
    {
        $h5pRowLibParams = ['name' => "H5P.Row", "major_version" => 1, "minor_version" => 1];
        $h5pRowLib = DB::table('h5p_libraries')->where($h5pRowLibParams)->first();

        if (empty($h5pRowLib)) {
            DB::table('h5p_libraries')->insertGetId([
                'name' => 'H5P.Row',
                'title' => 'Row',
                'major_version' => 1,
                'minor_version' => 1,
                'patch_version' => 1,
                'embed_types' => 'iframe',
                'runnable' => 0,
                'restricted' => 0,
                'fullscreen' => 0,
                'preloaded_js' => 'h5p-row.js',
                'preloaded_css' => 'h5p-row.css',
                'drop_library_css' => '',
                'semantics' => $this->getSemantics(),
                'tutorial_url' => ' ',
                'has_icon' => 0
            ]);
        }
    }

    private function getSemantics()
    {
        return '[
  {
    "name": "columns",
    "type": "list",
    "label": "Columns",
    "importance": "high",
    "max": 4,
    "field": {
      "name": "column",
      "type": "group",
      "importance": "high",
      "fields": [
        {
          "name": "width",
          "label": "Width",
          "type": "number",
          "description": "Column width in percentage.",
          "optional": true,
          "max": 100
        },
        {
          "name": "content",
          "label": "Column",
          "type": "library",
          "options": [
            "H5P.RowColumn 1.1"
          ]
        }
      ]
    }
  }
]';
    }
}
