<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class H5PAddColumnOneTwentySeeder extends Seeder
{
    public function run()
    {
        $h5pColumnLibParams = ['name' => "H5P.Column", "major_version" => 1, "minor_version" => 20];
        $h5pColumnLib = DB::table('h5p_libraries')->where($h5pColumnLibParams)->first();

        if (empty($h5pColumnLib)) {
            $h5pColumnLibId = DB::table('h5p_libraries')->insertGetId([
                'name' => 'H5P.Column',
                'title' => 'Page',
                'major_version' => 1,
                'minor_version' => 20,
                'patch_version' => 0,
                'embed_types' => 'iframe',
                'runnable' => 1,
                'restricted' => 0,
                'fullscreen' => 0,
                'preloaded_js' => 'scripts/h5p-column.js',
                'preloaded_css' => 'styles/h5p-column.css',
                'drop_library_css' => '',
                'semantics' => $this->getSemantics(),
                'tutorial_url' => ' ',
                'has_icon' => 1
            ]);

            $this->insertLibrariesLanguages($h5pColumnLibId);

            $organizations = DB::table('organizations')->pluck('id');
            $currentDate = now();

            foreach ($organizations as $organizationId) {
                $activityTypes = DB::table('activity_types')->whereOrganizationId($organizationId)->pluck('id', 'title');
                if (!isset($activityTypes['Multimedia'])) {
                    continue;
                }
                $params = ['title' => 'Column Layout', 'organization_id' => $organizationId];
                DB::table('activity_items')->updateOrInsert($params, [
                    'title' => 'Column Layout',
                    'image' => '',
                    'description' => 'Display content in a column layout',
                    'activity_type_id' => $activityTypes['Multimedia'],
                    'h5pLib' => 'H5P.Column 1.20',
                    'demo_activity_id' => '0',
                    'demo_video_id' => '',
                    'type' => 'h5p',
                    'created_at' => $currentDate,
                    'deleted_at' => null,
                    'organization_id' => $organizationId,
                ]);
            }
        }
    }

    private function getSemantics()
    {
        return '[
  {
    "name": "content",
    "label": "List of Column Content",
    "importance": "high",
    "type": "list",
    "min": 1,
    "entity": "content",
    "field": {
      "name": "content",
      "type": "group",
      "fields": [
        {
          "name": "content",
          "type": "library",
          "importance": "high",
          "label": "Content",
          "options": [
            "H5P.Accordion 1.0",
            "H5P.Agamotto 1.6",
            "H5P.Audio 1.5",
            "H5P.AudioRecorder 1.0",
            "H5P.Blanks 1.14",
            "H5P.Chart 1.2",
            "H5P.Collage 0.3",
            "H5P.CoursePresentation 1.27",
            "H5P.Dialogcards 1.9",
            "H5P.DocumentationTool 1.8",
            "H5P.DragQuestion 1.15",
            "H5P.DragText 1.10",
            "H5P.Essay 1.5",
            "H5P.GuessTheAnswer 1.5",
            "H5P.Table 1.2",
            "H5P.AdvancedText 1.1",
            "H5P.IFrameEmbed 1.0",
            "H5P.Image 1.1",
            "H5P.ImageHotspots 1.10",
            "H5P.ImageHotspotQuestion 1.8",
            "H5P.ImageSlider 1.1",
            "H5P.InteractiveVideo 1.28",
            "H5P.Link 1.3",
            "H5P.MarkTheWords 1.11",
            "H5P.MemoryGame 1.3",
            "H5P.MultiChoice 1.16",
            "H5P.Questionnaire 1.3",
            "H5P.QuestionSet 1.21",
            "H5P.Row 1.1",
            "H5P.SingleChoiceSet 1.11",
            "H5P.Summary 1.10",
            "H5P.Timeline 1.1",
            "H5P.TrueFalse 1.8",
            "H5P.Video 1.6",
            "H5P.MultiMediaChoice 0.3"
          ]
        },
        {
          "name": "useSeparator",
          "type": "select",
          "importance": "low",
          "label": "Separate content with a horizontal ruler",
          "default": "auto",
          "options": [
            {
              "value": "auto",
              "label": "Automatic (default)"
            },
            {
              "value": "disabled",
              "label": "Never use ruler above"
            },
            {
              "value": "enabled",
              "label": "Always use ruler above"
            }
          ]
        }
      ]
    }
  }
]';
    }

    private function insertLibrariesLanguages(int $h5pColumnLibId)
    {
        DB::table('h5p_libraries_languages')->insert([
            'library_id' => $h5pColumnLibId,
            'language_code' => 'af',
            'translation' => json_encode(json_decode('{"semantics":[{"label":"Lys van kolominhoud","entity":"inhoud","field":{"fields":[{"label":"Inhoud"},{"label":"Skei die inhoud met \'n horisontale liniaal","options":[{"label":"Outomaties (verstek)"},{"label":"Moet nooit liniaal hierbo gebruik nie"},{"label":"Gebruik altyd die liniaal hierbo"}]}]}}]}'), JSON_PRETTY_PRINT|JSON_UNESCAPED_UNICODE)
        ]);

        DB::table('h5p_libraries_languages')->insert([
            'library_id' => $h5pColumnLibId,
            'language_code' => 'ar',
            'translation' => json_encode(json_decode('{"semantics":[{"label":"قائمة بمحتوى العمود","entity":"المحتوى","field":{"fields":[{"label":"المحتوى"},{"label":"محتوى منفصل مع مسطرة أفقية","options":[{"label":"اتوماتيكي ( افتراضي )"},{"label":"لا تستخدم ابدا المسطرة اعلاه"},{"label":"استخدم دومًا المسطرة أعلاه"}]}]}}]}'), JSON_PRETTY_PRINT|JSON_UNESCAPED_UNICODE)
        ]);

        DB::table('h5p_libraries_languages')->insert([
            'library_id' => $h5pColumnLibId,
            'language_code' => 'bg',
            'translation' => json_encode(json_decode('{"semantics":[{"label":"Списък на съдържание Колони","entity":"съдържание","field":{"fields":[{"label":"Съдържание"},{"label":"Разделете съдържанието с хоризонтален линеал","options":[{"label":"Автоматично (по подразбиране)"},{"label":"Никога не използвайте линеал по-горе"},{"label":"Винаги използвайте линеал по-горе"}]}]}}]}'), JSON_PRETTY_PRINT|JSON_UNESCAPED_UNICODE)
        ]);

        DB::table('h5p_libraries_languages')->insert([
            'library_id' => $h5pColumnLibId,
            'language_code' => 'bs',
            'translation' => json_encode(json_decode('{"semantics":[{"label":"lista sadržaja stupca","entity":"sadržaj","field":{"fields":[{"label":"Sadržaj"},{"label":"Razdvoji sadržaje sa linijom","options":[{"label":"Automatski (default)"},{"label":"Nikad ne koristi razdvajanje gore"},{"label":"Uvijek koristi razdvajanje gore"}]}]}}]}'), JSON_PRETTY_PRINT|JSON_UNESCAPED_UNICODE)
        ]);

        DB::table('h5p_libraries_languages')->insert([
            'library_id' => $h5pColumnLibId,
            'language_code' => 'ca',
            'translation' => json_encode(json_decode('{"semantics":[{"label":"Llista del contingut de la columna","entity":"contingut","field":{"fields":[{"label":"Contingut"},{"label":"Separa el contingut amb un regle horitzontal","options":[{"label":"Automàtic (opció predeterminada)"},{"label":"No utilitzis mai el regle de la part superior"},{"label":"Utilitza sempre el regle de la part superior"}]}]}}]}'), JSON_PRETTY_PRINT|JSON_UNESCAPED_UNICODE)
        ]);

        DB::table('h5p_libraries_languages')->insert([
            'library_id' => $h5pColumnLibId,
            'language_code' => 'cs',
            'translation' => json_encode(json_decode('{"semantics":[{"label":"Seznam obsahu sloupců","entity":"obsah","field":{"fields":[{"label":"Obsah"},{"label":"Oddělit obsah vodorovnou čárou","options":[{"label":"Automaticky (výchozí)"},{"label":"Nikdy neoddělovat vodorovnou čarou shora"},{"label":"Vždy oddělovat vodorovnou čarou shora"}]}]}}]}'), JSON_PRETTY_PRINT|JSON_UNESCAPED_UNICODE)
        ]);

        DB::table('h5p_libraries_languages')->insert([
            'library_id' => $h5pColumnLibId,
            'language_code' => 'cy',
            'translation' => json_encode(json_decode('{"semantics":[{"label":"Rhestr o Gynnwys y Golofn","entity":"cynnwys","field":{"fields":[{"label":"Cynnwys"},{"label":"Gwahanwch gynnwys gyda mesurydd llorweddol","options":[{"label":"Awtomatig (diofyn)"},{"label":"Byth yn defnyddio mesurydd uwchben"},{"label":"Wastad yn defnyddio mesurydd uwchben"}]}]}}]}'), JSON_PRETTY_PRINT|JSON_UNESCAPED_UNICODE)
        ]);

        DB::table('h5p_libraries_languages')->insert([
            'library_id' => $h5pColumnLibId,
            'language_code' => 'da',
            'translation' => json_encode(json_decode('{"semantics":[{"label":"List of Column Content","entity":"content","field":{"fields":[{"label":"Content"},{"label":"Separate content with a horizontal ruler","options":[{"label":"Automatic (default)"},{"label":"Never use ruler above"},{"label":"Always use ruler above"}]}]}}]}'), JSON_PRETTY_PRINT|JSON_UNESCAPED_UNICODE)
        ]);

        DB::table('h5p_libraries_languages')->insert([
            'library_id' => $h5pColumnLibId,
            'language_code' => 'de',
            'translation' => json_encode(json_decode('{"semantics":[{"label":"Liste der Spalteninhalte","entity":"Inhalt","field":{"fields":[{"label":"Inhalt"},{"label":"Trenne Inhalt mit einer horizontalen Linie","options":[{"label":"Automatisch (Voreinstellung)"},{"label":"Vor diesem Inhalt nie eine Trennlinie anzeigen"},{"label":"Vor diesem Inhalt immer eine Trennlinie anzeigen"}]}]}}]}'), JSON_PRETTY_PRINT|JSON_UNESCAPED_UNICODE)
        ]);

        DB::table('h5p_libraries_languages')->insert([
            'library_id' => $h5pColumnLibId,
            'language_code' => 'el',
            'translation' => json_encode(json_decode('{"semantics":[{"label":"Λίστα αντικειμένων σε στήλες","entity":"αντικειμενου","field":{"fields":[{"label":"Αντικείμενο"},{"label":"Διαχωρισμός αντικειμένων με οριζόντια γραμμή","options":[{"label":"Αυτόματο (προεπιλογή)"},{"label":"Ποτέ με διαχωριστικό"},{"label":"Πάντα με διαχωριστικό"}]}]}}]}'), JSON_PRETTY_PRINT|JSON_UNESCAPED_UNICODE)
        ]);

        DB::table('h5p_libraries_languages')->insert([
            'library_id' => $h5pColumnLibId,
            'language_code' => 'es-mx',
            'translation' => json_encode(json_decode('{"semantics":[{"label":"Lista de Contenido de Columna","entity":"contenido","field":{"fields":[{"label":"Contenido"},{"label":"Separar contenido con una regla horizontal","options":[{"label":"Automático (predeterminado)"},{"label":"Nunca usar regla arriba"},{"label":"Siempre usar regla arriba"}]}]}}]}'), JSON_PRETTY_PRINT|JSON_UNESCAPED_UNICODE)
        ]);

        DB::table('h5p_libraries_languages')->insert([
            'library_id' => $h5pColumnLibId,
            'language_code' => 'es',
            'translation' => json_encode(json_decode('{"semantics":[{"label":"Lista de Contenido de Columna","entity":"contenido","field":{"fields":[{"label":"Contenido"},{"label":"Separar contenido con una regla horizontal","options":[{"label":"Automático (predeterminado)"},{"label":"Nunca usar regla arriba"},{"label":"Siempre usar regla arriba"}]}]}}]}'), JSON_PRETTY_PRINT|JSON_UNESCAPED_UNICODE)
        ]);

        DB::table('h5p_libraries_languages')->insert([
            'library_id' => $h5pColumnLibId,
            'language_code' => 'et',
            'translation' => json_encode(json_decode('{"semantics":[{"label":"Veeru sisu loetelu","entity":"sisu","field":{"fields":[{"label":"Sisu"},{"label":"Eralda sisu horisontaaljoonega","options":[{"label":"Automaatne (vaikimisi)"},{"label":"Ära kasuta eraldajat kunagi"},{"label":"Alati kasuta eraldajat"}]}]}}]}'), JSON_PRETTY_PRINT|JSON_UNESCAPED_UNICODE)
        ]);

        DB::table('h5p_libraries_languages')->insert([
            'library_id' => $h5pColumnLibId,
            'language_code' => 'eu',
            'translation' => json_encode(json_decode('{"semantics":[{"label":"Zutabearen edukiaren zerrenda","entity":"edukia","field":{"fields":[{"label":"Edukia"},{"label":"Erregla horizontal batez banatutako edukia","options":[{"label":"Automatikoa (lehenetsia)"},{"label":"Ez erabili inoiz goiko erregela"},{"label":"Erabili beti goiko erregela"}]}]}}]}'), JSON_PRETTY_PRINT|JSON_UNESCAPED_UNICODE)
        ]);

        DB::table('h5p_libraries_languages')->insert([
            'library_id' => $h5pColumnLibId,
            'language_code' => 'fa',
            'translation' => json_encode(json_decode('{"semantics":[{"label":"لیست محتوای ستون","entity":"محتوا","field":{"fields":[{"label":"محتوا"},{"label":"محتوای جداگانه با یک خط‌کش افقی","options":[{"label":"خودکار (پیش‌فرض)"},{"label":"هیچ وقت از خط‌کش بالا استفاده نکنید"},{"label":"همیشه از خط‌کش بالا استفاده کنید"}]}]}}]}'), JSON_PRETTY_PRINT|JSON_UNESCAPED_UNICODE)
        ]);

        DB::table('h5p_libraries_languages')->insert([
            'library_id' => $h5pColumnLibId,
            'language_code' => 'fi',
            'translation' => json_encode(json_decode('{"semantics":[{"label":"Osiot","entity":"osio","field":{"fields":[{"label":"Osion sisältö"},{"label":"Erota osio vaakaviivalla","options":[{"label":"Auto (oletus)"},{"label":"Älä koskaan käytä erotinta"},{"label":"Käytä erotinta aina"}]}]}}]}'), JSON_PRETTY_PRINT|JSON_UNESCAPED_UNICODE)
        ]);

        DB::table('h5p_libraries_languages')->insert([
            'library_id' => $h5pColumnLibId,
            'language_code' => 'fr',
            'translation' => json_encode(json_decode('{"semantics":[{"label":"Liste des contenus empilés","entity":"contenu","field":{"fields":[{"label":"Contenu"},{"label":"Séparer le contenu avec un délimiteur horizontal","options":[{"label":"Automatique (défaut)"},{"label":"Ne jamais afficher le séparateur au-dessus"},{"label":"Toujours afficher le séparateur au-dessus"}]}]}}]}'), JSON_PRETTY_PRINT|JSON_UNESCAPED_UNICODE)
        ]);

        DB::table('h5p_libraries_languages')->insert([
            'library_id' => $h5pColumnLibId,
            'language_code' => 'gl',
            'translation' => json_encode(json_decode('{"semantics":[{"label":"Listado do Contido da Columna","entity":"contido","field":{"fields":[{"label":"Contido"},{"label":"Separar o contido cunha regra horizontal","options":[{"label":"Automático (por defecto)"},{"label":"Nunca usar regra enriba"},{"label":"Sempre usar regla enriba"}]}]}}]}'), JSON_PRETTY_PRINT|JSON_UNESCAPED_UNICODE)
        ]);

        DB::table('h5p_libraries_languages')->insert([
            'library_id' => $h5pColumnLibId,
            'language_code' => 'he',
            'translation' => json_encode(json_decode('{"semantics":[{"label":"רשימה של תכנים בעמוד","entity":"תוכן","field":{"fields":[{"label":"תוכן"},{"label":"הפרדת תכנים בעזרת קו אופקי","options":[{"label":"אוטומטי (ברירת־מחדל)"},{"label":"ללא הפרדה"},{"label":"הפרדה תמיד"}]}]}}]}'), JSON_PRETTY_PRINT|JSON_UNESCAPED_UNICODE)
        ]);

        DB::table('h5p_libraries_languages')->insert([
            'library_id' => $h5pColumnLibId,
            'language_code' => 'hu',
            'translation' => json_encode(json_decode('{"semantics":[{"label":"List of Column Content","entity":"content","field":{"fields":[{"label":"Content"},{"label":"Separate content with a horizontal ruler","options":[{"label":"Automatic (default)"},{"label":"Never use ruler above"},{"label":"Always use ruler above"}]}]}}]}'), JSON_PRETTY_PRINT|JSON_UNESCAPED_UNICODE)
        ]);

        DB::table('h5p_libraries_languages')->insert([
            'library_id' => $h5pColumnLibId,
            'language_code' => 'it',
            'translation' => json_encode(json_decode('{"semantics":[{"label":"Elenco dei contenuti di Column","entity":"contenuto","field":{"fields":[{"label":"Contenuto"},{"label":"Separa il contenuto con una riga orizzontale","options":[{"label":"Automatico (impostazione predefinita)"},{"label":"Non utilizzare mai la riga di separazione qui sopra"},{"label":"Usa sempre la riga di separazione qui sopra"}]}]}}]}'), JSON_PRETTY_PRINT|JSON_UNESCAPED_UNICODE)
        ]);

        DB::table('h5p_libraries_languages')->insert([
            'library_id' => $h5pColumnLibId,
            'language_code' => 'ja',
            'translation' => json_encode(json_decode('{"semantics":[{"label":"カラムコンテンツのリスト","entity":"コンテンツ","field":{"fields":[{"label":"コンテンツ"},{"label":"水平線でコンテンツを分割","options":[{"label":"自動（デフォルト）"},{"label":"水平線を使わない"},{"label":"水平線を使う"}]}]}}]}'), JSON_PRETTY_PRINT|JSON_UNESCAPED_UNICODE)
        ]);

        DB::table('h5p_libraries_languages')->insert([
            'library_id' => $h5pColumnLibId,
            'language_code' => 'ka',
            'translation' => json_encode(json_decode('{"semantics":[{"label":"სვეტის შინაარსის ჩამონათვალი","entity":"შინაარსი","field":{"fields":[{"label":"შინაარსი"},{"label":"შინაარსის ჰორიზონტალური ხაზით გაყოფა","options":[{"label":"ავტომატური (სტანდარტული)"},{"label":"არასოდეს გამოიყენო ზედა სახაზავი"},{"label":"ყოველთვის გამოიყენე ქვედა სახაზავი"}]}]}}]}'), JSON_PRETTY_PRINT|JSON_UNESCAPED_UNICODE)
        ]);

        DB::table('h5p_libraries_languages')->insert([
            'library_id' => $h5pColumnLibId,
            'language_code' => 'ko',
            'translation' => json_encode(json_decode('{"semantics":[{"label":"열(column)로된 콘텐츠 목록","entity":" 콘텐츠","field":{"fields":[{"label":"콘텐츠"},{"label":"수평 눈금자로 내용 구분","options":[{"label":"자동 (기본값)"},{"label":"눈금자 사용 않기e"},{"label":"항상눈금자 사용하기"}]}]}}]}'), JSON_PRETTY_PRINT|JSON_UNESCAPED_UNICODE)
        ]);

        DB::table('h5p_libraries_languages')->insert([
            'library_id' => $h5pColumnLibId,
            'language_code' => 'lt',
            'translation' => json_encode(json_decode('{"semantics":[{"label":"Stulpelio turinio sąrašas","entity":"turinys","field":{"fields":[{"label":"Turinys"},{"label":"Atskirti turinį horizontalia liniuote","options":[{"label":"Automatinis (numatytasis)"},{"label":"Niekada nenaudoti liniuotės aukščiau"},{"label":"Visada naudoti liniuotę aukščiau"}]}]}}]}'), JSON_PRETTY_PRINT|JSON_UNESCAPED_UNICODE)
        ]);

        DB::table('h5p_libraries_languages')->insert([
            'library_id' => $h5pColumnLibId,
            'language_code' => 'lv',
            'translation' => json_encode(json_decode('{"semantics":[{"label":"Kolonnu satura saraksts","entity":"saturs","field":{"fields":[{"label":"Saturs"},{"label":"Atdalīt saturu ar horizontālu līniju","options":[{"label":"Automātisks (pēc noklusējuma)"},{"label":"Nekad neizmantot augšējo līniju"},{"label":"Vienmēr izmantot augšējo līniju"}]}]}}]}'), JSON_PRETTY_PRINT|JSON_UNESCAPED_UNICODE)
        ]);

        DB::table('h5p_libraries_languages')->insert([
            'library_id' => $h5pColumnLibId,
            'language_code' => 'mn',
            'translation' => json_encode(json_decode('{"semantics":[{"label":"Баганын агуулгын жагсаалт","entity":"агуулга","field":{"fields":[{"label":"Агуулга"},{"label":"Агуулгыг хэвтээ захирагчаар тусгаарла","options":[{"label":"Автомат (өгөгдмөл)"},{"label":"Дээрх захирагчийг хэзээ ч бүү ашиглаарай"},{"label":"Дээрх захирагчийг үргэлж ашиглаарай"}]}]}}]}'), JSON_PRETTY_PRINT|JSON_UNESCAPED_UNICODE)
        ]);

        DB::table('h5p_libraries_languages')->insert([
            'library_id' => $h5pColumnLibId,
            'language_code' => 'nb',
            'translation' => json_encode(json_decode('{"semantics":[{"label":"Liste med kolonneinnhold","entity":"innhold","field":{"fields":[{"label":"Innhold"},{"label":"Skill ut innhold med ei horisontal linje","options":[{"label":"Automatisk (standard)"},{"label":"Aldri bruk linje over"},{"label":"Alltid bruk linje over"}]}]}}]}'), JSON_PRETTY_PRINT|JSON_UNESCAPED_UNICODE)
        ]);

        DB::table('h5p_libraries_languages')->insert([
            'library_id' => $h5pColumnLibId,
            'language_code' => 'nl',
            'translation' => json_encode(json_decode('{"semantics":[{"label":"Lijst met kolominhoud","entity":"inhoud","field":{"fields":[{"label":"Inhoud"},{"label":"Scheid de inhoud met een horizontale lijn","options":[{"label":"Automatisch (standaard)"},{"label":"Gebruik nooit een lijn erboven"},{"label":"Gebruik altijd een lijn erboven"}]}]}}]}'), JSON_PRETTY_PRINT|JSON_UNESCAPED_UNICODE)
        ]);

        DB::table('h5p_libraries_languages')->insert([
            'library_id' => $h5pColumnLibId,
            'language_code' => 'nn',
            'translation' => json_encode(json_decode('{"semantics":[{"label":"Liste med kolonneinnhald","entity":"innhald","field":{"fields":[{"label":"Innhald"},{"label":"Skil ut innhald med ei horisontal linje","options":[{"label":"Automatisk (standard)"},{"label":"Aldri bruk linje over"},{"label":"Alltid bruk linje over"}]}]}}]}'), JSON_PRETTY_PRINT|JSON_UNESCAPED_UNICODE)
        ]);

        DB::table('h5p_libraries_languages')->insert([
            'library_id' => $h5pColumnLibId,
            'language_code' => 'pl',
            'translation' => json_encode(json_decode('{"semantics":[{"label":"Lista zawartości kolumny","entity":"zawartość","field":{"fields":[{"label":"Zawartość"},{"label":"Oddziel zawartość poziomą linijką","options":[{"label":"Automatyczne (domyślnie)"},{"label":"Nigdy nie używaj linijki powyżej"},{"label":"Zawsze używaj linijki powyżej"}]}]}}]}'), JSON_PRETTY_PRINT|JSON_UNESCAPED_UNICODE)
        ]);

        DB::table('h5p_libraries_languages')->insert([
            'library_id' => $h5pColumnLibId,
            'language_code' => 'pt-br',
            'translation' => json_encode(json_decode('{"semantics":[{"label":"Lista de conteúdo da coluna","entity":"conteúdo","field":{"fields":[{"label":"Conteúdo"},{"label":"Separar os conteúdos com uma linha horizontal","options":[{"label":"Automático (padrão)"},{"label":"Nunca utilizar linha acima"},{"label":"Sempre utilizar linha acima"}]}]}}]}'), JSON_PRETTY_PRINT|JSON_UNESCAPED_UNICODE)
        ]);

        DB::table('h5p_libraries_languages')->insert([
            'library_id' => $h5pColumnLibId,
            'language_code' => 'pt',
            'translation' => json_encode(json_decode('{"semantics":[{"label":"Lista do conteúdo da coluna","entity":"conteúdo","field":{"fields":[{"label":"Conteúdo"},{"label":"Separar conteúdos com uma linha horizontal","options":[{"label":"Automático (predefinição)"},{"label":"Nunca usar a régua acima"},{"label":"Utilizar sempre a régua acima"}]}]}}]}'), JSON_PRETTY_PRINT|JSON_UNESCAPED_UNICODE)
        ]);

        DB::table('h5p_libraries_languages')->insert([
            'library_id' => $h5pColumnLibId,
            'language_code' => 'ro',
            'translation' => json_encode(json_decode('{"semantics":[{"label":"Listă de conținut în coloană","entity":"conținut","field":{"fields":[{"label":"Conținut"},{"label":"Separă conținutul cu o linie orizontală","options":[{"label":"Automat (implicit)"},{"label":"Nu utiliza niciodată linie deasupra"},{"label":"Utilizează întotdeauna linie deasupra"}]}]}}]}'), JSON_PRETTY_PRINT|JSON_UNESCAPED_UNICODE)
        ]);

        DB::table('h5p_libraries_languages')->insert([
            'library_id' => $h5pColumnLibId,
            'language_code' => 'ru',
            'translation' => json_encode(json_decode('{"semantics":[{"label":"Список содержимого контента","entity":"контент","field":{"fields":[{"label":"Контент"},{"label":"Разделить контент горизонтальной линией","options":[{"label":"Автоматически (по умолчанию)"},{"label":"Никогда не использовать линию сверху"},{"label":"Всегда использовать линию сверху"}]}]}}]}'), JSON_PRETTY_PRINT|JSON_UNESCAPED_UNICODE)
        ]);

        DB::table('h5p_libraries_languages')->insert([
            'library_id' => $h5pColumnLibId,
            'language_code' => 'sl',
            'translation' => json_encode(json_decode('{"semantics":[{"label":"Seznam vsebine stolpca","entity":"vsebina","field":{"fields":[{"label":"Vsebina"},{"label":"Vsebino loči z vodoravno črto","options":[{"label":"Samodejno (privzeto)"},{"label":"Nikoli ne loči s črto zgoraj"},{"label":"Vedno loči s črto zgoraj"}]}]}}]}'), JSON_PRETTY_PRINT|JSON_UNESCAPED_UNICODE)
        ]);

        DB::table('h5p_libraries_languages')->insert([
            'library_id' => $h5pColumnLibId,
            'language_code' => 'sma',
            'translation' => json_encode(json_decode('{"semantics":[{"label":"List of Column Content","entity":"content","field":{"fields":[{"label":"Content"},{"label":"Separate content with a horizontal ruler","options":[{"label":"Automatic (default)"},{"label":"Never use ruler above"},{"label":"Always use ruler above"}]}]}}]}'), JSON_PRETTY_PRINT|JSON_UNESCAPED_UNICODE)
        ]);

        DB::table('h5p_libraries_languages')->insert([
            'library_id' => $h5pColumnLibId,
            'language_code' => 'sme',
            'translation' => json_encode(json_decode('{"semantics":[{"label":"List of Column Content","entity":"content","field":{"fields":[{"label":"Content"},{"label":"Separate content with a horizontal ruler","options":[{"label":"Automatic (default)"},{"label":"Never use ruler above"},{"label":"Always use ruler above"}]}]}}]}'), JSON_PRETTY_PRINT|JSON_UNESCAPED_UNICODE)
        ]);

        DB::table('h5p_libraries_languages')->insert([
            'library_id' => $h5pColumnLibId,
            'language_code' => 'smj',
            'translation' => json_encode(json_decode('{"semantics":[{"label":"List of Column Content","entity":"content","field":{"fields":[{"label":"Content"},{"label":"Separate content with a horizontal ruler","options":[{"label":"Automatic (default)"},{"label":"Never use ruler above"},{"label":"Always use ruler above"}]}]}}]}'), JSON_PRETTY_PRINT|JSON_UNESCAPED_UNICODE)
        ]);

        DB::table('h5p_libraries_languages')->insert([
            'library_id' => $h5pColumnLibId,
            'language_code' => 'sr',
            'translation' => json_encode(json_decode('{"semantics":[{"label":"Списак садржаја колоне","entity":"content","field":{"fields":[{"label":"Садржај"},{"label":"Одвојите садржај водоравним лењиром","options":[{"label":"Аутоматски (default)"},{"label":"Никада не користите лењир изнад"},{"label":"Увек користите лењир горе"}]}]}}]}'), JSON_PRETTY_PRINT|JSON_UNESCAPED_UNICODE)
        ]);

        DB::table('h5p_libraries_languages')->insert([
            'library_id' => $h5pColumnLibId,
            'language_code' => 'sv',
            'translation' => json_encode(json_decode('{"semantics":[{"label":"Lista med innehåll i kolumn","entity":"innehåll","field":{"fields":[{"label":"Innehåll"},{"label":"Separera innehåll med horisontell linje","options":[{"label":"Automatisk (standard)"},{"label":"Använd aldrig linje ovanför"},{"label":"Använd alltid linje ovanför"}]}]}}]}'), JSON_PRETTY_PRINT|JSON_UNESCAPED_UNICODE)
        ]);

        DB::table('h5p_libraries_languages')->insert([
            'library_id' => $h5pColumnLibId,
            'language_code' => 'sw',
            'translation' => json_encode(json_decode('{"semantics":[{"label":"Orodha ya Maudhui ya Safu wima","entity":"maudhui","field":{"fields":[{"label":"Maudhui"},{"label":"Tenganisha maudhui kwa rula mlalo","options":[{"label":"Otomatiki (chaguo-msingi)"},{"label":"Kamwe usitumie rula hapo juu"},{"label":"Kila wakati tumia rula hapo juu"}]}]}}]}'), JSON_PRETTY_PRINT|JSON_UNESCAPED_UNICODE)
        ]);

        DB::table('h5p_libraries_languages')->insert([
            'library_id' => $h5pColumnLibId,
            'language_code' => 'te',
            'translation' => json_encode(json_decode('{"semantics":[{"label":"కాలమ్ కంటెంట్ జాబితా","entity":"కంటెంట్","field":{"fields":[{"label":"కంటెంట్"},{"label":"సమాంతర రూలర్‌తో కంటెంట్‌ను వేరు చేయండి","options":[{"label":"ఆటోమేటిక్ (డిఫాల్ట్)"},{"label":"పైన ఉన్న రూలర్‌ని ఎప్పుడూ ఉపయోగించవద్దు"},{"label":"ఎల్లప్పుడూ పైన ఉన్న రూలర్‌ని ఉపయోగించండి"}]}]}}]}'), JSON_PRETTY_PRINT|JSON_UNESCAPED_UNICODE)
        ]);

        DB::table('h5p_libraries_languages')->insert([
            'library_id' => $h5pColumnLibId,
            'language_code' => 'tr',
            'translation' => json_encode(json_decode('{"semantics":[{"label":"Sütun İçerikler Listesi","entity":"content","field":{"fields":[{"label":"İçerik"},{"label":"İçerikleri bir cetvelle yatay olarak ayırın","options":[{"label":"Otomatik (varsayılan)"},{"label":"Asla yukarıdaki cetveli kullanma"},{"label":"Her zaman yukarıdaki cetveli kullan"}]}]}}]}'), JSON_PRETTY_PRINT|JSON_UNESCAPED_UNICODE)
        ]);

        DB::table('h5p_libraries_languages')->insert([
            'library_id' => $h5pColumnLibId,
            'language_code' => 'uk',
            'translation' => json_encode(json_decode('{"semantics":[{"label":"Список вмісту колонки","entity":"контент","field":{"fields":[{"label":"Контент"},{"label":"Розділити контент горизонтальною лінією","options":[{"label":"Автоматично (за замовчуванням)"},{"label":"Ніколи не використовувати лінію зверху"},{"label":"Завжди використовувати лінію зверху"}]}]}}]}'), JSON_PRETTY_PRINT|JSON_UNESCAPED_UNICODE)
        ]);

        DB::table('h5p_libraries_languages')->insert([
            'library_id' => $h5pColumnLibId,
            'language_code' => 'vi',
            'translation' => json_encode(json_decode('{"semantics":[{"label":"Danh sách nội dung của Cột","entity":"nội dung","field":{"fields":[{"label":"Nội dung"},{"label":"Phân cách nội dung bằng một đường thẳng ngang","options":[{"label":"Tự động (mặc định)"},{"label":"Không dùng đường phân cách ở trên"},{"label":"Luôn dùng đường phân cách ở trên"}]}]}}]}'), JSON_PRETTY_PRINT|JSON_UNESCAPED_UNICODE)
        ]);

        DB::table('h5p_libraries_languages')->insert([
            'library_id' => $h5pColumnLibId,
            'language_code' => 'zh',
            'translation' => json_encode(json_decode('{"semantics":[{"label":"欄位內容","entity":"content","field":{"fields":[{"label":"內容"},{"label":"用水平線分隔內容","options":[{"label":"自動（預設）"},{"label":"永不使用"},{"label":"永遠使用"}]}]}}]}'), JSON_PRETTY_PRINT|JSON_UNESCAPED_UNICODE)
        ]);
    }
}
