<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class H5PAddTableOneTwoSeeder extends Seeder
{
    public function run()
    {
        $params = ['name' => "H5P.Table", "major_version" => 1, "minor_version" => 2];
        $lib = DB::table('h5p_libraries')->where($params)->first();

        if (empty($lib)) {
            $libId = DB::table('h5p_libraries')->insertGetId([
                'name' => 'H5P.Table',
                'title' => 'Table',
                'major_version' => 1,
                'minor_version' => 2,
                'patch_version' => 8,
                'embed_types' => 'iframe',
                'runnable' => 0,
                'restricted' => 0,
                'fullscreen' => 0,
                'preloaded_js' => 'scripts/table.js',
                'preloaded_css' => 'styles/table.css',
                'drop_library_css' => '',
                'semantics' => $this->getSemantics(),
                'tutorial_url' => ' ',
                'has_icon' => 1
            ]);

            $this->insertLibrariesLanguages($libId);
        }
    }

    private function getSemantics()
    {
        return '[
  {
    "name": "text",
    "type": "text",
    "widget": "html",
    "label": "Table",
    "importance": "high",
    "default": "<figure class=\\"table\\"><table class=\\"h5p-table\\"><thead><tr><th>Heading Column 1</th><th>Heading Column 2</th></tr></thead><tbody><tr><td>Row 1 Col 1</td><td>Row 1 Col 2</td></tr><tr><td>Row 2 Col 1</td><td>Row 2 Col 2</td></tr></tbody></table></figure>",
    "tags": [
      "strong",
      "em",
      "del",
      "a",
      "table",
      "code"
    ],
    "font": {
      "color": true
    }
  }
]';
    }

    private function insertLibrariesLanguages(int $libId)
    {
        DB::table('h5p_libraries_languages')->insert([
            'library_id' => $libId,
            'language_code' => 'en',
            'translation' => json_encode(json_decode('{"semantics":[{"label":"Table","default":"<table class=\"h5p-table\"><thead><tr><th scope=\"col\">Heading Column 1</th><th scope=\"col\">Heading Column 2</th></tr></thead><tbody><tr><td>Row 1 Col 1</td><td>Row 1 Col 2</td></tr><tr><td>Row 2 Col 1</td><td>Row 2 Col 2</td></tr></tbody></table>"}]}'), JSON_PRETTY_PRINT|JSON_UNESCAPED_UNICODE)
        ]);

        DB::table('h5p_libraries_languages')->insert([
            'library_id' => $libId,
            'language_code' => 'ar',
            'translation' => json_encode(json_decode('{"semantics":[{"label":"الجدول","default":"<table class=\"h5p-table\"><thead><tr><th scope=\"col\">Heading Column 1</th><th scope=\"col\">Heading Column 2</th></tr></thead><tbody><tr><td>Row 1 Col 1</td><td>Row 1 Col 2</td></tr><tr><td>Row 2 Col 1</td><td>Row 2 Col 2</td></tr></tbody></table>"}]}'), JSON_PRETTY_PRINT|JSON_UNESCAPED_UNICODE)
        ]);

        DB::table('h5p_libraries_languages')->insert([
            'library_id' => $libId,
            'language_code' => 'bg',
            'translation' => json_encode(json_decode('{"semantics":[{"label":"Таблица","default":"<table class=\"h5p-table\"><thead><tr><th scope=\"col\">Заглавна колона 1</th><th scope=\"col\">Заглавна колона 2</th></tr></thead><tbody><tr><td>Ред 1 Колона 1</td><td>Ред 1 Колона 2</td></tr><tr><td>Ред 2 Колона 1</td><td>Ред 2 Колона 2</td></tr></tbody></table>"}]}'), JSON_PRETTY_PRINT|JSON_UNESCAPED_UNICODE)
        ]);

        DB::table('h5p_libraries_languages')->insert([
            'library_id' => $libId,
            'language_code' => 'ca',
            'translation' => json_encode(json_decode('{"semantics":[{"label":"Taula","default":"<table class=\"h5p-table\"><thead><tr><th scope=\"col\"> Encapçalat Columna 1</th><th scope=\"col\"> Encapçalat Columna 2</th></tr></thead><tbody><tr><td>Fila 1 Col 1</td><td>Fila 1 Col 2</td></tr><tr><td>Fila 2 Col 1</td><td>Fila 2 Col 2</td></tr></tbody></table>"}]}'), JSON_PRETTY_PRINT|JSON_UNESCAPED_UNICODE)
        ]);

        DB::table('h5p_libraries_languages')->insert([
            'library_id' => $libId,
            'language_code' => 'cs',
            'translation' => json_encode(json_decode('{"semantics":[{"label":"Tabulka","default":"<table class=\"h5p-table\"><thead><tr><th scope=\"col\">Nadpis sloupce 1</th><th scope=\"col\">Nadpis sloupce 2</th></tr></thead><tbody><tr><td>Řádek 1 Sloupec 1</td><td>Řádek 1 Sloupec 2</td></tr><tr><td>Řádek 2 Sloupec 1</td><td>Řádek 2 Sloupec 2</td></tr></tbody></table>"}]}'), JSON_PRETTY_PRINT|JSON_UNESCAPED_UNICODE)
        ]);

        DB::table('h5p_libraries_languages')->insert([
            'library_id' => $libId,
            'language_code' => 'cy',
            'translation' => json_encode(json_decode('{"semantics":[{"label":"Tabl","default":"<table class=\"h5p-table\"><thead><tr><th scope=\"col\">Pennawd Colofn 1</th><th scope=\"col\">Pennawd Colofn 2</th></tr></thead><tbody><tr><td>Rhes 1 Col 1</td><td>Rhes 1 Col 2</td></tr><tr><td>Rhes 2 Col 1</td><td>Rhes 2 Col 2</td></tr></tbody></table>"}]}'), JSON_PRETTY_PRINT|JSON_UNESCAPED_UNICODE)
        ]);

        DB::table('h5p_libraries_languages')->insert([
            'library_id' => $libId,
            'language_code' => 'de',
            'translation' => json_encode(json_decode('{"semantics":[{"label":"Tabelle","default":"<table class=\"h5p-table\"><thead><tr><th scope=\"col\">Überschrift Spalte 1</th><th scope=\"col\">Überschrift Spalte 2</th></tr></thead><tbody><tr><td>Zeile 1 Spalte 1</td><td>Zeile 1 Spalte 2</td></tr><tr><td>Zeile 2 Spalte 1</td><td>Zeile 2 Spalte 2</td></tr></tbody></table>"}]}'), JSON_PRETTY_PRINT|JSON_UNESCAPED_UNICODE)
        ]);

        DB::table('h5p_libraries_languages')->insert([
            'library_id' => $libId,
            'language_code' => 'el',
            'translation' => json_encode(json_decode('{"semantics":[{"label":"Πίνακας","default":"<table class=\"h5p-table\"><thead><tr><th scope=\"col\">Επικεφαλίδα Στήλης 1</th><th scope=\"col\">Επικεφαλίδα Στήλης 2</th></tr></thead><tbody><tr><td>Γρ 1 Στ 1</td><td>Γρ 1 Στ 2</td></tr><tr><td>Γρ 2 Στ 1</td><td>Γρ 2 Στ 2</td></tr></tbody></table>"}]}'), JSON_PRETTY_PRINT|JSON_UNESCAPED_UNICODE)
        ]);

        DB::table('h5p_libraries_languages')->insert([
            'library_id' => $libId,
            'language_code' => 'es-mx',
            'translation' => json_encode(json_decode('{"semantics":[{"label":"Tabla","default":"<table class=\"h5p-table\"><thead><tr><th scope=\"col\">Encabezado Columna 1</th><th scope=\"col\">Encabezado Columna 2</th></tr></thead><tbody><tr><td>Fila 1 Col 1</td><td>Fila 1 Col 2</td></tr><tr><td>Fila 2 Col 1</td><td>Fila 2 Col 2</td></tr></tbody></table>"}]}'), JSON_PRETTY_PRINT|JSON_UNESCAPED_UNICODE)
        ]);

        DB::table('h5p_libraries_languages')->insert([
            'library_id' => $libId,
            'language_code' => 'es',
            'translation' => json_encode(json_decode('{"semantics":[{"label":"Tabla","default":"<table class=\"h5p-table\"><thead><tr><th scope=\"col\">Encabezado Columna 1</th><th scope=\"col\">Encabezado Columna 2</th></tr></thead><tbody><tr><td>Fila 1 Col 1</td><td>Fila 1 Col 2</td></tr><tr><td>Fila 2 Col 1</td><td>Fila 2 Col 2</td></tr></tbody></table>"}]}'), JSON_PRETTY_PRINT|JSON_UNESCAPED_UNICODE)
        ]);

        DB::table('h5p_libraries_languages')->insert([
            'library_id' => $libId,
            'language_code' => 'et',
            'translation' => json_encode(json_decode('{"semantics":[{"label":"Tabel","default":"<table class=\"h5p-table\"><thead><tr><th scope=\"col\">Päise veerg 1</th><th scope=\"col\">Päise veerg 2</th></tr></thead><tbody><tr><td>Rea 1 veerg 1</td><td>Rea 1 veerg 2</td></tr><tr><td>Rea 2 veerg 1</td><td>Rea 2 veerg 2</td></tr></tbody></table>"}]}'), JSON_PRETTY_PRINT|JSON_UNESCAPED_UNICODE)
        ]);

        DB::table('h5p_libraries_languages')->insert([
            'library_id' => $libId,
            'language_code' => 'eu',
            'translation' => json_encode(json_decode('{"semantics":[{"label":"Taula","default":"<table class=\"h5p-table\"><thead><tr><th scope=\"col\">Goialdeko 1. zutabea</th><th scope=\"col\">Goialdeko 2. zutabea</th></tr></thead><tbody><tr><td>1. errenkada 1. zutabea</td><td>1. errenkada 2. zutabea</td></tr><tr><td>2. Errenkada 1. zutabea</td><td>2. errenkada 2. zutabea</td></tr></tbody></table>"}]}'), JSON_PRETTY_PRINT|JSON_UNESCAPED_UNICODE)
        ]);

        DB::table('h5p_libraries_languages')->insert([
            'library_id' => $libId,
            'language_code' => 'fa',
            'translation' => json_encode(json_decode('{"semantics":[{"label":"جدول","default":"<table class=\"h5p-table\"><thead><tr><th scope=\"col\">Heading Column 1</th><th scope=\"col\">Heading Column 2</th></tr></thead><tbody><tr><td>Row 1 Col 1</td><td>Row 1 Col 2</td></tr><tr><td>Row 2 Col 1</td><td>Row 2 Col 2</td></tr></tbody></table>"}]}'), JSON_PRETTY_PRINT|JSON_UNESCAPED_UNICODE)
        ]);

        DB::table('h5p_libraries_languages')->insert([
            'library_id' => $libId,
            'language_code' => 'fi',
            'translation' => json_encode(json_decode('{"semantics":[{"label":"Taulukko","default":"<table class=\"h5p-table\"><thead><tr><th scope=\"col\">Ensimmäisen sarakkeen otsikko</th><th scope=\"col\">Toisen sarakkeen otsikko</th></tr></thead><tbody><tr><td>Rivi 1 Sarake 1</td><td>Rivi 1 Sarake 2</td></tr><tr><td>Rivi 2 Sarake 1</td><td>Rivi 2 Sarake 2</td></tr></tbody></table>"}]}'), JSON_PRETTY_PRINT|JSON_UNESCAPED_UNICODE)
        ]);

        DB::table('h5p_libraries_languages')->insert([
            'library_id' => $libId,
            'language_code' => 'fr',
            'translation' => json_encode(json_decode('{"semantics":[{"label":"Tableau","default":"<table class=\"h5p-table\"><thead><tr><th scope=\"col\">Heading Column 1</th><th scope=\"col\">Heading Column 2</th></tr></thead><tbody><tr><td>Row 1 Col 1</td><td>Row 1 Col 2</td></tr><tr><td>Row 2 Col 1</td><td>Row 2 Col 2</td></tr></tbody></table>"}]}'), JSON_PRETTY_PRINT|JSON_UNESCAPED_UNICODE)
        ]);

        DB::table('h5p_libraries_languages')->insert([
            'library_id' => $libId,
            'language_code' => 'gl',
            'translation' => json_encode(json_decode('{"semantics":[{"label":"Táboa","default":"<table class=\"h5p-table\"><thead><tr><th scope=\"col\">Columna cabaceira 1</th><th scope=\"col\">Columna cabeceira 2</th></tr></thead><tbody><tr><td>Fila 1 Col 1</td><td>Fila 1 Col 2</td></tr><tr><td>Fila 2 Col 1</td><td>Fila 2 Col 2</td></tr></tbody></table>"}]}'), JSON_PRETTY_PRINT|JSON_UNESCAPED_UNICODE)
        ]);

        DB::table('h5p_libraries_languages')->insert([
            'library_id' => $libId,
            'language_code' => 'he',
            'translation' => json_encode(json_decode('{"semantics":[{"label":"טבלה","default":"<table class=\"h5p-table\"><thead><tr><th scope=\"col\">כותרת עמודה 1</th><th scope=\"col\">כותרת עמודה 2</th></tr></thead><tbody><tr><td>שורה 1 עמודה 1</td><td>שורה 1 עמודה 2</td></tr><tr><td>שורה 2 עמודה 1</td><td>שורה 2 עמודה 2</td></tr></tbody></table>"}]}'), JSON_PRETTY_PRINT|JSON_UNESCAPED_UNICODE)
        ]);

        DB::table('h5p_libraries_languages')->insert([
            'library_id' => $libId,
            'language_code' => 'it',
            'translation' => json_encode(json_decode('{"semantics":[{"label":"Tabella","default":"<table class=\"h5p-table\"><thead><tr><th scope=\"col\">Intestazione Colonna 1</th><th scope=\"col\">Intestazione Colonna 2</th></tr></thead><tbody><tr><td>Riga 1 Colonna 1</td><td>Riga 1 Colonna 2</td></tr><tr><td>Riga 2 Colonna 1</td><td>Riga 2 Colonna 2</td></tr></tbody></table>"}]}'), JSON_PRETTY_PRINT|JSON_UNESCAPED_UNICODE)
        ]);

        DB::table('h5p_libraries_languages')->insert([
            'library_id' => $libId,
            'language_code' => 'ka',
            'translation' => json_encode(json_decode('{"semantics":[{"label":"ცხრილი","default":"<table class=\"h5p-table\"><thead><tr><th scope=\"col\">სათაურის სვეტი 1</th><th scope=\"col\">სათაურის სვეტი 2</th></tr></thead><tbody><tr><td>სტრ1 სვ 1</td><td>სტრ 1 სვ 2</td></tr><tr><td>სტრ 2 სვ 1</td><td>სტრ 2 სვ 2</td></tr></tbody></table>"}]}'), JSON_PRETTY_PRINT|JSON_UNESCAPED_UNICODE)
        ]);

        DB::table('h5p_libraries_languages')->insert([
            'library_id' => $libId,
            'language_code' => 'km',
            'translation' => json_encode(json_decode('{"semantics":[{"label":"Table","default":"<table class=\"h5p-table\"><thead><tr><th scope=\"col\">ក្បាលជួរឈរទី 1</th><th scope=\"col\">ក្បាលជួរឈរទី 2</th></tr></thead><tbody><tr><td>ជួរដេកទី 1 ជួរឈរទី 1</td><td>ជួរដេកទី 1 ជួរឈរទី 2</td></tr><tr><td>ជួរដេកទី 2 ជួរឈរទី 1</td><td>ជួរដេកទី 2 ជួរឈរទី 2</td></tr></tbody></table>"}]}'), JSON_PRETTY_PRINT|JSON_UNESCAPED_UNICODE)
        ]);

        DB::table('h5p_libraries_languages')->insert([
            'library_id' => $libId,
            'language_code' => 'ko',
            'translation' => json_encode(json_decode('{"semantics":[{"label":"테이블","default":"<table class=\"h5p-table\"><thead><tr><th scope=\"col\">제목 열 1</th><th scope=\"col\">제목 열 2</th></tr></thead><tbody><tr><td>행 1 열 1</td><td>행 1 열 2</td></tr><tr><td>행 2 열 1</td><td>행 2 열 2</td></tr></tbody></table>"}]}'), JSON_PRETTY_PRINT|JSON_UNESCAPED_UNICODE)
        ]);

        DB::table('h5p_libraries_languages')->insert([
            'library_id' => $libId,
            'language_code' => 'lt',
            'translation' => json_encode(json_decode('{"semantics":[{"default":"<table class=\"h5p-table\"><thead><tr><th scope=\"col\">1 antraštės stulpelis</th><th scope=\"col\">2 antraštės stulpelis</th></tr></thead><tbody><tr><td>1 eilutė 1 stulpelis</td><td>1 eilutė 2 stulpelis</td></tr><tr><td>2 eilutė 1 stulpelis</td><td> eilutė 2 stulpelis</td></tr></tbody></table>","label":"Lentelė"}]}'), JSON_PRETTY_PRINT|JSON_UNESCAPED_UNICODE)
        ]);

        DB::table('h5p_libraries_languages')->insert([
            'library_id' => $libId,
            'language_code' => 'lv',
            'translation' => json_encode(json_decode('{"semantics":[{"label":"Tabula","default":"<table class=\"h5p-table\"><thead><tr><th scope=\"col\">Virsraksta kolonna 1</th><th scope=\"col\">Virsraksta kolonna 2</th></tr></thead><tbody><tr><td>Rinda 1 Kol 1</td><td>Rinda 1 Kol 2</td></tr><tr><td>Rinda 2 Kol 1</td><td>Rinda 2 Kol 2</td></tr></tbody></table>"}]}'), JSON_PRETTY_PRINT|JSON_UNESCAPED_UNICODE)
        ]);

        DB::table('h5p_libraries_languages')->insert([
            'library_id' => $libId,
            'language_code' => 'mn',
            'translation' => json_encode(json_decode('{"semantics":[{"label":"Хүснэгт","default":"<table class=\"h5p-table\"><thead><tr><th scope=\"col\">Гарчиг 1-р багана</th><th scope=\"col\">Гарчиг 2-р багана</th></tr> </thead><tbody><tr><td>1-р мөр багана 1</td><td>1-р мөр 2</td></tr><tr><td>2-р мөр багана 1</td> <td>2-р мөр багана 2</td></tr></tbody></table>"}]}'), JSON_PRETTY_PRINT|JSON_UNESCAPED_UNICODE)
        ]);

        DB::table('h5p_libraries_languages')->insert([
            'library_id' => $libId,
            'language_code' => 'nb',
            'translation' => json_encode(json_decode('{"semantics":[{"label":"Tabell","default":"<table class=\"h5p-table\"><thead><tr><th scope=\"col\">Overskrift kolonne 1</th><th scope=\"col\">Overskrift kolonne 2</th></tr></thead><tbody><tr><td>Rad 1, kolonne 1</td><td>Rad 1, kolonne 2</td></tr><tr><td>Rad 2, kolonne 1</td><td>Rad 2, kolonne 2</td></tr></tbody></table>"}]}'), JSON_PRETTY_PRINT|JSON_UNESCAPED_UNICODE)
        ]);

        DB::table('h5p_libraries_languages')->insert([
            'library_id' => $libId,
            'language_code' => 'nl',
            'translation' => json_encode(json_decode('{"semantics":[{"label":"Tabel","default":"<table class=\"h5p-table\"><thead><tr><th scope=\"col\">Koptekst Kolom 1</th><th scope=\"col\">Koptekst Kolom 2</th></tr></thead><tbody><tr><td>Rij 1 Kol 1</td><td>Rij 1 Kol 2</td></tr><tr><td>Rij 2 Kol 1</td><td>Rij 2 Kol 2</td></tr></tbody></table>"}]}'), JSON_PRETTY_PRINT|JSON_UNESCAPED_UNICODE)
        ]);

        DB::table('h5p_libraries_languages')->insert([
            'library_id' => $libId,
            'language_code' => 'nn',
            'translation' => json_encode(json_decode('{"semantics":[{"label":"Tabell","default":"<table class=\"h5p-table\"><thead><tr><th scope=\"col\">Overskrift kolonne 1</th><th scope=\"col\">Overskrift kolonne 2</th></tr></thead><tbody><tr><td>Rad 1, kolonne 1</td><td>Rad 1, kolonne 2</td></tr><tr><td>Rad 2, kolonne 1</td><td>Rad 2, kolonne 2</td></tr></tbody></table>"}]}'), JSON_PRETTY_PRINT|JSON_UNESCAPED_UNICODE)
        ]);

        DB::table('h5p_libraries_languages')->insert([
            'library_id' => $libId,
            'language_code' => 'pt-br',
            'translation' => json_encode(json_decode('{"semantics":[{"label":"Tabela","default":"<table class=\"h5p-table\"><thead><tr><th scope=\"col\">Título da Coluna 1</th><th scope=\"col\">Título da Coluna 2</th></tr></thead><tbody><tr><td>Lin 1 Col 1</td><td>Lin 1 Col 2</td></tr><tr><td>Lin 2 Col 1</td><td>Lin 2 Col 2</td></tr></tbody></table>"}]}'), JSON_PRETTY_PRINT|JSON_UNESCAPED_UNICODE)
        ]);

        DB::table('h5p_libraries_languages')->insert([
            'library_id' => $libId,
            'language_code' => 'pt',
            'translation' => json_encode(json_decode('{"semantics":[{"label":"Tabela","default":"<table class=\"h5p-table\"><thead><tr><th scope=\"col\">Cabeçalho Coluna 1</th><th scope=\"col\">Cabeçalho Coluna 2</th></tr></thead><tbody><tr><td>Linha 1 Coluna 1</td><td>Linha 1 Coluna 2</td></tr><tr><td>Linha 2 Coluna 1</td><td>Linha 2 Coluna 2</td></tr></tbody></table>"}]}'), JSON_PRETTY_PRINT|JSON_UNESCAPED_UNICODE)
        ]);

        DB::table('h5p_libraries_languages')->insert([
            'library_id' => $libId,
            'language_code' => 'ro',
            'translation' => json_encode(json_decode('{"semantics":[{"label":"Tabel","default":"<table class=\"h5p-table\"><thead><tr><th scope=\"col\">Antet Coloana 1</th><th scope=\"col\">Antet Coloana 2</th></tr></thead><tbody><tr><td>Rând 1 Col 1</td><td>Rând 1 Col 2</td></tr><tr><td>Rând 2 Col 1</td><td>Rând 2 Col 2</td></tr></tbody></table>"}]}'), JSON_PRETTY_PRINT|JSON_UNESCAPED_UNICODE)
        ]);

        DB::table('h5p_libraries_languages')->insert([
            'library_id' => $libId,
            'language_code' => 'ru',
            'translation' => json_encode(json_decode('{"semantics":[{"label":"Таблица","default":"<table class=\"h5p-table\"><thead><tr><th scope=\"col\">Заголовок столбца 1</th><th scope=\"col\">Заголовок столбца 2</th></tr></thead><tbody><tr><td>Строка 1 Столбец 1</td><td>Строка 1 Столбец 2</td></tr><tr><td>Строка 2 Столбец 1</td><td>Строка 2 Столбец 2</td></tr></tbody></table>"}]}'), JSON_PRETTY_PRINT|JSON_UNESCAPED_UNICODE)
        ]);

        DB::table('h5p_libraries_languages')->insert([
            'library_id' => $libId,
            'language_code' => 'sl',
            'translation' => json_encode(json_decode('{"semantics":[{"label":"Tabela","default":"<table class=\"h5p-table\"><thead><tr><th scope=\"col\">Naslov stolpca 1</th><th scope=\"col\">Naslov stolpca 2</th></tr></thead><tbody><tr><td>Vrstica 1 Stolpec 1</td><td>Vrstica 1 Stolpec 2</td></tr><tr><td>Vrstica 2 Stolpec 1</td><td>Vrstica 2 Stolpec 2</td></tr></tbody></table>"}]}'), JSON_PRETTY_PRINT|JSON_UNESCAPED_UNICODE)
        ]);

        DB::table('h5p_libraries_languages')->insert([
            'library_id' => $libId,
            'language_code' => 'sma',
            'translation' => json_encode(json_decode('{"semantics":[{"label":"Table","default":"<table class=\"h5p-table\"><thead><tr><th scope=\"col\">Heading Column 1</th><th scope=\"col\">Heading Column 2</th></tr></thead><tbody><tr><td>Row 1 Col 1</td><td>Row 1 Col 2</td></tr><tr><td>Row 2 Col 1</td><td>Row 2 Col 2</td></tr></tbody></table>"}]}'), JSON_PRETTY_PRINT|JSON_UNESCAPED_UNICODE)
        ]);

        DB::table('h5p_libraries_languages')->insert([
            'library_id' => $libId,
            'language_code' => 'sme',
            'translation' => json_encode(json_decode('{"semantics":[{"label":"Table","default":"<table class=\"h5p-table\"><thead><tr><th scope=\"col\">Heading Column 1</th><th scope=\"col\">Heading Column 2</th></tr></thead><tbody><tr><td>Row 1 Col 1</td><td>Row 1 Col 2</td></tr><tr><td>Row 2 Col 1</td><td>Row 2 Col 2</td></tr></tbody></table>"}]}'), JSON_PRETTY_PRINT|JSON_UNESCAPED_UNICODE)
        ]);

        DB::table('h5p_libraries_languages')->insert([
            'library_id' => $libId,
            'language_code' => 'smj',
            'translation' => json_encode(json_decode('{"semantics":[{"label":"Table","default":"<table class=\"h5p-table\"><thead><tr><th scope=\"col\">Heading Column 1</th><th scope=\"col\">Heading Column 2</th></tr></thead><tbody><tr><td>Row 1 Col 1</td><td>Row 1 Col 2</td></tr><tr><td>Row 2 Col 1</td><td>Row 2 Col 2</td></tr></tbody></table>"}]}'), JSON_PRETTY_PRINT|JSON_UNESCAPED_UNICODE)
        ]);

        DB::table('h5p_libraries_languages')->insert([
            'library_id' => $libId,
            'language_code' => 'sv',
            'translation' => json_encode(json_decode('{"semantics":[{"label":"Tabell","default":"<table class=\"h5p-table\"><thead><tr><th scope=\"col\">Rubrik kolumn 1</th><th scope=\"col\">Rubrik kolumn 2</th></tr></thead><tbody><tr><td>Rad 1 kolumn 1</td><td>Rad 1 kolumn 2</td></tr><tr><td>Rad 2 kolumn 1</td><td>Rad 2 kolumn 2</td></tr></tbody></table>"}]}'), JSON_PRETTY_PRINT|JSON_UNESCAPED_UNICODE)
        ]);

        DB::table('h5p_libraries_languages')->insert([
            'library_id' => $libId,
            'language_code' => 'sw',
            'translation' => json_encode(json_decode('{"semantics":[{"label":"Jedwali","default":"<table class=\"h5p-table\"><thead><tr><th scope=\"col\">Kichwa safu wima 1</th><th scope=\"col\">Kichwa safu wima 2</th></tr></thead><tbody><tr><td>Safu mlalo 1 safu wima 1</td><td>Safu mlalo 1 Safu wima 2</td></tr><tr><td>Safu mlalo 2 Safu wima 1</td><td>Safu mlalo 2 Safu wima 2</td></tr></tbody></table>"}]}'), JSON_PRETTY_PRINT|JSON_UNESCAPED_UNICODE)
        ]);

        DB::table('h5p_libraries_languages')->insert([
            'library_id' => $libId,
            'language_code' => 'te',
            'translation' => json_encode(json_decode('{"semantics":[{"label":"టేబుల్","default":"<table class=\"h5p-table\"><thead><tr><th scope=\"col\">హెడింగ్ కాలమ్ 1</th><th scope=\"col\">హెడింగ్ కాలమ్ 2</th></tr></thead><tbody><tr><td>వరుస 1 Col 1</td><td>వరుస 1 Col 2</td></tr><tr><td>వరుస 2 Col 1</td><td>వరుస 2 Col 2</td></tr></tbody></table>"}]}'), JSON_PRETTY_PRINT|JSON_UNESCAPED_UNICODE)
        ]);

        DB::table('h5p_libraries_languages')->insert([
            'library_id' => $libId,
            'language_code' => 'tr',
            'translation' => json_encode(json_decode('{"semantics":[{"label":"Tablo","default":"<table class=\"h5p-table\"><thead><tr><th scope=\"col\">Başlık Sütunu 1</th><th scope=\"col\">Başlık Sütunu 2</th></tr></thead><tbody><tr><td>Satır 1 Sütun 1</td><td>Satır 1 Sütun 2</td></tr><tr><td>Satır 2 Sütun 1</td><td>Satır 2 Sütun 2</td></tr></tbody></table>"}]}'), JSON_PRETTY_PRINT|JSON_UNESCAPED_UNICODE)
        ]);

        DB::table('h5p_libraries_languages')->insert([
            'library_id' => $libId,
            'language_code' => 'uk',
            'translation' => json_encode(json_decode('{"semantics":[{"label":"Таблиця","default":"<table class=\"h5p-table\"><thead><tr><th scope=\"col\">Заголовок стовпця 1</th><th scope=\"col\">Заголовок стовпця 2</th></tr></thead><tbody><tr><td>Рядок 1 Стовпець 1</td><td>Рядок 1 Стовпець 2</td></tr><tr><td>Рядок 2 Стовпець 1</td><td>Рядок 2 Стовпець 2</td></tr></tbody></table>"}]}'), JSON_PRETTY_PRINT|JSON_UNESCAPED_UNICODE)
        ]);

        DB::table('h5p_libraries_languages')->insert([
            'library_id' => $libId,
            'language_code' => 'zh-cn',
            'translation' => json_encode(json_decode('{"semantics":[{"label":"表格","default":"<table class=\"h5p-table\"><thead><tr><th scope=\"col\">标题栏1</th><th scope=\"col\">标题栏2</th></tr></thead><tbody><tr><td>行1列1</td><td>行1列2</td></tr><tr><td>行2列1</td><td>行2列2</td></tr></tbody></table>"}]}'), JSON_PRETTY_PRINT|JSON_UNESCAPED_UNICODE)
        ]);

        DB::table('h5p_libraries_languages')->insert([
            'library_id' => $libId,
            'language_code' => 'zh',
            'translation' => json_encode(json_decode('{"semantics":[{"label":"表格","default":"<table class=\"h5p-table\"><thead><tr><th scope=\"col\">標題欄1</th><th scope=\"col\">標題欄2</th></tr></thead><tbody><tr><td>欄1列1</td><td>欄2列1</td></tr><tr><td>欄1列2</td><td>欄2列2</td></tr></tbody></table>"}]}'), JSON_PRETTY_PRINT|JSON_UNESCAPED_UNICODE)
        ]);
    }
}
