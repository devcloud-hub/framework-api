<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class H5PAddImageSliderOneOneSeeder extends Seeder
{
    public function run()
    {
        $h5pImageSliderLibParams = ['name' => "H5P.ImageSlider", "major_version" => 1, "minor_version" => 1];
        $h5pImageSliderLib = DB::table('h5p_libraries')->where($h5pImageSliderLibParams)->first();

        if (empty($h5pImageSliderLib)) {
            $h5pImageSliderLibId = DB::table('h5p_libraries')->insertGetId([
                'name' => 'H5P.ImageSlider',
                'title' => 'Image Slider',
                'major_version' => 1,
                'minor_version' => 1,
                'patch_version' => 27,
                'embed_types' => 'iframe',
                'runnable' => 1,
                'restricted' => 0,
                'fullscreen' => 1,
                'preloaded_js' => 'image-slider.js',
                'preloaded_css' => 'image-slider.css',
                'drop_library_css' => '',
                'semantics' => $this->getSemantics(),
                'tutorial_url' => ' ',
                'has_icon' => 1
            ]);

            $this->insertDependentLibraries($h5pImageSliderLibId);
            $this->insertLibrariesLanguages($h5pImageSliderLibId);

            $organizations = DB::table('organizations')->pluck('id');
            $currentDate = now();
            $storageURL = '/storage/activity-items/';

            foreach ($organizations as $organizationId) {
                $activityTypes = DB::table('activity_types')->whereOrganizationId($organizationId)->pluck('id', 'title');
                if (!isset($activityTypes['Photo / Images'])) {
                    continue;
                }
                $params = ['title' => 'Image Slider', 'organization_id' => $organizationId];
                DB::table('activity_items')->updateOrInsert($params, [
                    'title' => 'Image Slider',
                    'image' => '',
                    'description' => 'Create an interactive image slider for learners to browse through images',
                    'activity_type_id' => $activityTypes['Photo / Images'],
                    'h5pLib' => 'H5P.ImageSlider 1.1',
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

    private function insertDependentLibraries($h5pImageSliderLibId)
    {
        $h5pShowWhenParams = ['name' => "H5PEditor.ShowWhen", "major_version" => 1, "minor_version" => 0];
        $h5pShowWhenLib = DB::table('h5p_libraries')->where($h5pShowWhenParams)->first();
        $h5pShowWhenLibId = $h5pShowWhenLib->id;
        DB::table('h5p_libraries_libraries')->insert([
            'library_id' => $h5pImageSliderLibId,
            'required_library_id' => $h5pShowWhenLibId,
            'dependency_type' => 'editor'
        ]);
    }

    private function getSemantics()
    {
        return '[
  {
    "label": "Images",
    "name": "imageSlides",
    "type": "list",
    "field": {
      "label": "Image Slide",
      "name": "imageSlide",
      "type": "group",
      "fields": [
        {
          "label": "Image Slide",
          "name": "imageSlide",
          "type": "library",
          "options": [
            "H5P.ImageSlide 1.1"
          ]
        }
      ]
    }
  },
  {
    "label": "Aspect ratio",
    "name": "aspectRatioMode",
    "type": "select",
    "description": "Automatic means fixed aspect ratio automatically determined based on the images",
    "default": "auto",
    "options": [
      {
        "value": "auto",
        "label": "Automatic"
      },
      {
        "value": "custom",
        "label": "Custom"
      },
      {
        "value": "notFixed",
        "label": "Not fixed"
      }
    ]
  },
  {
    "label": "Aspect Ratio Settings",
    "name": "aspectRatio",
    "type": "group",
    "widget": "showWhen",
    "expanded": true,
    "showWhen": {
      "rules": [
        {
          "field": "aspectRatioMode",
          "equals": "custom"
        }
      ]
    },
    "fields": [
      {
        "label": "Aspect ratio width",
        "name": "aspectWidth",
        "type": "number",
        "default": 4,
        "description": "If you use 4 here, and 3 for the height the aspect ratio will be 4:3"
      },
      {
        "label": "Aspect ratio height",
        "name": "aspectHeight",
        "type": "number",
        "default": 3,
        "description": "If you use 3 here, and 4 for the width the aspect ratio will be 4:3"
      }
    ]
  },
  {
    "name": "a11y",
    "type": "group",
    "label": "Image slider accessibility",
    "importance": "low",
    "common": true,
    "fields": [
      {
        "name": "nextSlide",
        "type": "text",
        "label": "Label for next slide buttons",
        "importance": "low",
        "default": "Next Image",
        "description": "This is only used for read-speakers. It won\'t be displayed."
      },
      {
        "name": "prevSlide",
        "type": "text",
        "label": "Label for previous slide buttons",
        "importance": "low",
        "default": "Previous Image",
        "description": "This is only used for read-speakers. It won\'t be displayed."
      },
      {
        "name": "gotoSlide",
        "type": "text",
        "label": "Label for slide buttons",
        "importance": "low",
        "default": "Go to image %slide",
        "description": "This is only used for read-speakers. It won\'t be displayed. %slide is a variable and will be replaced with the image number."
      }
    ]
  }
]';
    }

    private function insertLibrariesLanguages(int $h5pImageSliderLibId)
    {
        DB::table('h5p_libraries_languages')->insert([
            'library_id' => $h5pImageSliderLibId,
            'language_code' => 'en',
            'translation' => json_encode(json_decode('{"semantics":[{"label":"Images","field":{"label":"Image Slide","fields":[{"label":"Image Slide"}]}},{"label":"Aspect ratio","description":"Automatic means fixed aspect ratio automatically determined based on the images","options":[{"label":"Automatic"},{"label":"Custom"},{"label":"Not fixed"}]},{"label":"Aspect Ratio Settings","fields":[{"label":"Aspect ratio width","description":"If you use 4 here, and 3 for the height the aspect ratio will be 4:3"},{"label":"Aspect ratio height","description":"If you use 3 here, and 4 for the width the aspect ratio will be 4:3"}]},{"label":"Image slider accessibility","fields":[{"label":"Label for next slide buttons","default":"Next Image","description":"This is only used for read-speakers. It won\'t be displayed."},{"label":"Label for previous slide buttons","default":"Previous Image","description":"This is only used for read-speakers. It won\'t be displayed."},{"label":"Label for slide buttons","default":"Go to image %slide","description":"This is only used for read-speakers. It won\'t be displayed. %slide is a variable and will be replaced with the image number."}]}]}'), JSON_PRETTY_PRINT|JSON_UNESCAPED_UNICODE)
        ]);

        DB::table('h5p_libraries_languages')->insert([
            'library_id' => $h5pImageSliderLibId,
            'language_code' => 'af',
            'translation' => json_encode(json_decode('{"semantics":[{"label":"Prente","field":{"label":"Prent skyfie","fields":[{"label":"Prent Skyfie"}]}},{"label":"Beeldverhouding","description":"Met outomaties word \'n vaste beeldverhouding bedoel wat outomaties bepaal word op grond van die prente","options":[{"label":"Outomaties"},{"label":"Pasgemaak"},{"label":"Nie vasgestel nie"}]},{"label":"Beeldverhouding instellings","fields":[{"label":"Beeldverhouding wydte","description":"Indien jy 4 hier en 3 vir die hoogte gebruik, is die beeldverhouding 4:3"},{"label":"Beeldverhouding hoogte","description":"As jy hier 3 en 4 vir die breedte gebruik, is die beeldverhouding 4:3"}]},{"label":"Beeldskyfie toeganklikheid","fields":[{"label":"Etiket vir volgende skyfie knoppies","default":"Volgende Prent","description":"Hierdie word slegs vir spreeklesers gebruik. Dit sal nie vertoon word nie."},{"label":"Etiket vir vorige skyfie knoppie","default":"Vorige Prent","description":"Hierdie word slegs vir spreeklesers gebruik. Dit sal nie vertoon word nie."},{"label":"Etiket vir skyfieknoppie","default":"Gaan na prent %slide","description":"Hierdie word slegs vir spreeklesers gebruik. Dit sal nie vertoon word nie. %slide is \'n veranderlike en sal vervang word deur \'n prentnommer."}]}]}'), JSON_PRETTY_PRINT|JSON_UNESCAPED_UNICODE)
        ]);

        DB::table('h5p_libraries_languages')->insert([
            'library_id' => $h5pImageSliderLibId,
            'language_code' => 'ar',
            'translation' => json_encode(json_decode('{"semantics":[{"label":"صور","field":{"label":"شريحة صور","fields":[{"label":"شريحة صور"}]}},{"label":"أبعاد النسبة","description":"تلقائي يعني أبعاد النسبة الثابتة والتي تحدد حسب الصور","options":[{"label":"آلي"},{"label":"عرف"},{"label":"غير ثابت"}]},{"label":"إعدادات أبعاد النسبة","fields":[{"label":"عرض أبعاد النسبة","description":"إذا كنت تستخدم 4 هنا، و 3 لارتفاع أبعاد النسبة فسيكون 4:3"},{"label":"ارتفاع أبعاد النسبة","description":"إذا كنت تستخدم 3 هنا، و 4 لعرض أبعاد النسبة فسيكون 4:3"}]},{"label":"إمكانية الوصول لشريط تمرير الصور","fields":[{"label":"التسمية لأزرار الشريحة التالية","default":"الصورة التالية","description":"تستخدم هذه فقط لبرامج read-speakers. لن تعرض."},{"label":"التسمية لأزرار الشريحة السابقة","default":"الصورة السابقة","description":"تستخدم هذه فقط لبرامج read-speakers. لن تعرض."},{"label":"التسمية لأزرار الشريحة","default":"انتقل للصورة %slide","description":"تستخدم هذه فقط لبرامج read-speakers. لن تُعرض. %slide متغير وسيُستبدل برقم الصورة."}]}]}'), JSON_PRETTY_PRINT|JSON_UNESCAPED_UNICODE)
        ]);

        DB::table('h5p_libraries_languages')->insert([
            'library_id' => $h5pImageSliderLibId,
            'language_code' => 'bg',
            'translation' => json_encode(json_decode('{"semantics":[{"label":"Изображения","field":{"label":"Слайд с изображение","fields":[{"label":"Слайд с изображение"}]}},{"label":"Съотношение на аспектите","description":"Автоматично означава, че фиксираното съотношение на аспекта се определя автоматично на база на размера на отделните изображения","options":[{"label":"Автоматично"},{"label":"Персонализирано"},{"label":"Без корекция"}]},{"label":"Настройки на съотношението на аспекта","fields":[{"label":"Ширина на съотношението на аспекта","description":"Ако тук използвате 4 и 3 за височина, съотношението на страните ще бъде 4:3"},{"label":"Височина на съотношението на аспекта","description":"Ако тук използвате 3 и 4 за ширина, съотношението на страните ще бъде 4:3"}]},{"label":"Достъпност на слайдера с изображения","fields":[{"label":"Етикет за бутоните за следващ слайд","default":"Следващо изображение","description":"Това се използва единствено от четците на глас. Няма да се показва на екрана."},{"label":"Етикет за бутоните за предишен слайд","default":"Предишно изображение","description":"Това се използва единствено от четците на глас. Няма да се показва на екрана."},{"label":"Етикет за бутоните за слайд","default":"Към изображение %slide","description":"Това се използва единствено от четците на глас. Няма да се показва на екрана. %slide е променлива, която ще бъде заместена с номера на изображението."}]}]}'), JSON_PRETTY_PRINT|JSON_UNESCAPED_UNICODE)
        ]);

        DB::table('h5p_libraries_languages')->insert([
            'library_id' => $h5pImageSliderLibId,
            'language_code' => 'ca',
            'translation' => json_encode(json_decode('{"semantics":[{"label":"Imatges","field":{"label":"Diapositiva d’imatge","fields":[{"label":"Diapositiva d’imatge"}]}},{"label":"Relació d’aspecte","description":"\"Automàtica\" fa referència a una relació d’aspecte fixa que es determina automàticament en funció de les imatges","options":[{"label":"Automàtic"},{"label":"Personalitzar"},{"label":"No fixa"}]},{"label":"Arranjament de la relació d’aspecte","fields":[{"label":"Amplada de la relació d’aspecte","description":"Si utilitzeu 3 aquí, i 4 per a l’amplada, la relació d’aspecte serà 4:3"},{"label":"Alçada de la relació d’aspecte","description":"Si utilitzeu 3 aquí, i 4 per a l’amplada, la relació d’aspecte serà 4:3"}]},{"label":"Accessibilitat del control lliscant de la imatge","fields":[{"label":"Etiqueta del botó de diapositiva següent","default":"Imatge següent","description":"Només s’utilitza per a altaveus de lectura. No es mostrarà."},{"label":"Etiqueta del botó de diapositiva anterior","default":"Imatge anterior","description":"Només s’utilitza per a altaveus de lectura. No es mostrarà."},{"label":"Etiqueta per als botons lliscants","default":"Ves a la imatge %slide","description":"Només s’utilitza per a altaveus de lectura. No es mostrarà. %slide és una variable que se substituirà pel número de la imatge."}]}]}'), JSON_PRETTY_PRINT|JSON_UNESCAPED_UNICODE)
        ]);

        DB::table('h5p_libraries_languages')->insert([
            'library_id' => $h5pImageSliderLibId,
            'language_code' => 'cs',
            'translation' => json_encode(json_decode('{"semantics":[{"label":"Obrázky","field":{"label":"Presentace obrázků","fields":[{"label":"Presentace obrázků"}]}},{"label":"Poměr stran","description":"Automaticky znamená fixní poměr stran automaticky určený na základě obrázků","options":[{"label":"Automaticky"},{"label":"Vlastní"},{"label":"Nenastaveno"}]},{"label":"Nastavení poměru stran","fields":[{"label":"Šířka poměru stran","description":"Pokud použijete zde 4 a 3 pro výšku, bude poměr stran 4: 3"},{"label":"Výška poměru stran","description":"Pokud zde použijete 3 a 4 pro šířku, bude poměr stran 4: 3"}]},{"label":"Přístupnost presentace obrázků","fields":[{"label":"Popisek tlačítka pro další snímek","default":"Další obrázek","description":"Používá se pouze pro rčtecí zařízení. Nezobrazí se."},{"label":"Popisek tlačítka pro předchozí snímek","default":"Předchozí obrázek","description":"Používá se pouze pro rčtecí zařízení. Nezobrazí se."},{"label":"Popisek pro posuvná tlačítka","default":"Přejdi na obrázek %slide","description":"Používá se pouze pro rčtecí zařízení. Nezobrazí se. %slide je proměnná a bude nahrazena číslem obrázku."}]}]}'), JSON_PRETTY_PRINT|JSON_UNESCAPED_UNICODE)
        ]);

        DB::table('h5p_libraries_languages')->insert([
            'library_id' => $h5pImageSliderLibId,
            'language_code' => 'de',
            'translation' => json_encode(json_decode('{"semantics":[{"label":"Bilder","field":{"label":"Bild","fields":[{"label":"Bild"}]}},{"label":"Seitenverhältnis","description":"Automatisch bedeutet, dass ein festes Seitenverhältnis genutzt wird, das automatisch anhand der Bilder bestimmt wird","options":[{"label":"Automatisch"},{"label":"Benutzerdefiniert"},{"label":"Nicht festgelegt"}]},{"label":"Einstellungen zum Seitenverhältnis","fields":[{"label":"Relative Breite","description":"Wenn Du hier 4 und für die Höhe 3 verwendest, beträgt das Seitenverhältnis 4:3"},{"label":"Relative Höhe","description":"Wenn du hier 3 und für die Breite 4 verwendest, beträgt das Seitenverhältnis 4:3"}]},{"label":"Barrierefreiheit des Image-Sliders","fields":[{"label":"Beschriftung des \"Nächtes Bild\"-Buttons","default":"Nächstes Bild","description":"Dies wird nur für Vorlesewerkzeuge verwendet. Es wird nicht angezeigt."},{"label":"Beschriftung des \"Vorheriges Bild\"-Buttons","default":"Vorheriges Bild","description":"Dies wird nur für Vorlesewerkzeuge verwendet. Es wird nicht angezeigt."},{"label":"Beschriftung der Buttons für die Direktnavigation zu Bildern","default":"Gehe zu Bild %slide","description":"Dies wird nur für Vorlesewerkzeuge verwendet. Es wird nicht angezeigt. %slide ist ein Platzhalter und wird durch die Bild-Nummer ersetzt."}]}]}'), JSON_PRETTY_PRINT|JSON_UNESCAPED_UNICODE)
        ]);

        DB::table('h5p_libraries_languages')->insert([
            'library_id' => $h5pImageSliderLibId,
            'language_code' => 'el',
            'translation' => json_encode(json_decode('{"semantics":[{"label":"Εικόνες","field":{"label":"Διαφάνεια εικόνας","fields":[{"label":"Διαφάνεια εικόνας"}]}},{"label":"Αναλογία διαστάσεων","description":"Η επιλογή \"αυτόματη\" σημαίνει ότι η αναλογία διαστάσεων καθορίζεται αυτόματα με βάση τις εικόνες.","options":[{"label":"Αυτόματη"},{"label":"Προσαρμοσμένη"},{"label":"Μη καθορισμένη"}]},{"label":"Ρυθμίσεις αναλογίας διαστάσεων","fields":[{"label":"Πλάτος αναλογίας","description":"Εάν ορίσετε 4 σε αυτό το πεδίο και 3 στο ύψος η αναλογία θα είναι 4:3"},{"label":"Ύψος αναλογίας","description":"Εάν ορίσετε 3 σε αυτό το πεδίο και 4 στο πλάτος η αναλογία θα είναι 4:3"}]},{"label":"Ρυθμίσεις Προσβασιμότητας","fields":[{"label":"Ετικέτα κουμπιού μετάβασης στην επόμενη διαφάνεια","default":"Επόμενη εικόνα","description":"Αυτό το κείμενο χρησιμοποιείται μόνο για ακουστική υποβοήθηση. Δεν θα εμφανίζεται."},{"label":"Ετικέτα κουμπιού μετάβασης στην προηγούμενη διαφάνεια","default":"Προηγούμενη εικόνα","description":"Αυτό το κείμενο χρησιμοποιείται μόνο για ακουστική υποβοήθηση. Δεν θα εμφανίζεται."},{"label":"Ετικέτα κουμπιού μετάβασης σε συγκεκριμένη διαφάνεια","default":"Μετάβαση στην εικόνα %slide","description":"Αυτό το κείμενο χρησιμοποιείται μόνο για ακουστική υποβοήθηση. Δεν θα εμφανίζεται. To %slide αποτελεί μια μεταβλητή που θα αντικατασταθεί από τον αριθμό της εικόνας."}]}]}'), JSON_PRETTY_PRINT|JSON_UNESCAPED_UNICODE)
        ]);

        DB::table('h5p_libraries_languages')->insert([
            'library_id' => $h5pImageSliderLibId,
            'language_code' => 'es-mx',
            'translation' => json_encode(json_decode('{"semantics":[{"label":"Imágenes","field":{"label":"Página con Imagen","fields":[{"label":"Página con Imagen"}]}},{"label":"Proporción de aspecto","description":"Automático significa proporción de aspecto fija determinada automáticamente basada en las imágenes","options":[{"label":"Automática"},{"label":"Personalizada"},{"label":"No fija"}]},{"label":"Configuraciones de Proporción de Aspecto","fields":[{"label":"Ancho de proporción de aspecto","description":"Si usa 4 aquí, y 3 para la altura, la proporción de aspecto será de 4:3"},{"label":"Altura de proporción de aspecto","description":"Si usa 3 aquí, y 4 para el ancho, la proporción de aspecto será de be 4:3"}]},{"label":"Accesibilidad de deslizador de imagen","fields":[{"label":"Etiqueta para botones de Imagen Siguiente","default":"Imagen Siguiente","description":"Esto es usado solamente para Lectores de texto en voz alta. No será mostrado."},{"label":"Etiqueta para botones Imagen anterior","default":"Imagen Anterior","description":"Esto es usado solamente para Lectores de texto en voz alta. No será mostrado."},{"label":"Etiqueta para botones de página","default":"Ir a la imagen %slide","description":"Esto es usado solamente para Lectores de texto en voz alta. No será mostrado. %slide es una variable y será remplazado con el número de la imagen."}]}]}'), JSON_PRETTY_PRINT|JSON_UNESCAPED_UNICODE)
        ]);

        DB::table('h5p_libraries_languages')->insert([
            'library_id' => $h5pImageSliderLibId,
            'language_code' => 'es',
            'translation' => json_encode(json_decode('{"semantics":[{"label":"Imágenes","field":{"label":"Pase de diapositivas","fields":[{"label":"Pase de diapositivas"}]}},{"label":"Proporción de aspecto","description":"Automático significa proporción de aspecto fija, determinada automáticamente y basada en las imágenes","options":[{"label":"Automática"},{"label":"Personalizada"},{"label":"No fija"}]},{"label":"Configuración de Proporción de aspecto","fields":[{"label":"Anchura de proporción de aspecto","description":"Si usas 4 aquí, y 3 para la altura, la proporción de aspecto será de 4:3"},{"label":"Altura de proporción de aspecto","description":"Si usas 3 aquí, y 4 para el ancho, la proporción de aspecto será de be 4:3"}]},{"label":"Accesibilidad del pase de diapositivas","fields":[{"label":"Etiqueta para botones de Imagen Siguiente","default":"Imagen Siguiente","description":"Usado solamente para lectores de pantalla. No se mostrará."},{"label":"Etiqueta para botones Imagen anterior","default":"Imagen Anterior","description":"Usado solamente para lectores de pantalla. No se mostrará."},{"label":"Etiqueta para botones de diapositiva","default":"Ir a la imagen %slide","description":"Usado solamente para lectores de pantalla. No se mostrará. %slide es una variable y será reemplazada por el número de la imagen."}]}]}'), JSON_PRETTY_PRINT|JSON_UNESCAPED_UNICODE)
        ]);

        DB::table('h5p_libraries_languages')->insert([
            'library_id' => $h5pImageSliderLibId,
            'language_code' => 'et',
            'translation' => json_encode(json_decode('{"semantics":[{"label":"Pildid","field":{"label":"Pildislaid","fields":[{"label":"Pildislaid"}]}},{"label":"Kuvasuhe","description":"Automaatne tähendab fikseeritud automaatset kuvasuhet piltide põhjal","options":[{"label":"Automaatne"},{"label":"Kohandatud"},{"label":"Pole fikseeritud"}]},{"label":"Kuvasuhte seadmed","fields":[{"label":"Kuvasuhte laius","description":"Kui sa paned siia 4 ja kõrguseks 3, siis kuvasuhe on 4:3"},{"label":"Kuvasuhte kõrgus","description":"Kui sa paned siia 3 ja laiuseks 4, siis kuvasuhe on 4:3"}]},{"label":"Pildiliuguri ligipääsetavus","fields":[{"label":"Silt järgmine slaid nuppudele","default":"Järgmine pilt","description":"Seda kasutavad ainult lugerid. Seda ei näidata ekraanil."},{"label":"Silt eelmine slaid nuppudele","default":"Eelmine pilt","description":"Seda kasutavad ainult lugerid. Seda ei näidata ekraanil."},{"label":"Silt slaidi nuppudele","default":"Mine pildile %slide","description":"Seda kasutavad ainult lugerid. Seda ei näidata ekraanil. %slide on muutuja, mis asendatakse pildi numbriga."}]}]}'), JSON_PRETTY_PRINT|JSON_UNESCAPED_UNICODE)
        ]);

        DB::table('h5p_libraries_languages')->insert([
            'library_id' => $h5pImageSliderLibId,
            'language_code' => 'eu',
            'translation' => json_encode(json_decode('{"semantics":[{"label":"Irudiak","field":{"label":"Irudien Aurkezpena","fields":[{"label":"Irudien Aurkezpena"}]}},{"label":"Itxura-proportzioa","description":"Automatikoa aukeratuta irudietan oinarritutako itxura-proportzioa automatikoki zehaztuko da","options":[{"label":"Automatikoa"},{"label":"Pertsonalizatua"},{"label":"Lotu gabea"}]},{"label":"Itxura-proportzioaren Ezarpenak","fields":[{"label":"Itxura-proportzioaren zabalera","description":"Hemen 4 eta altueran 3 jartzen baduzu itxura-proportzioa 4:3 izango da"},{"label":"Itxura-proportzioaren altuera","description":"Hemen 3 eta zabaleran 4 jartzen baduzu itxura-proportzioa 4:3 izango da"}]},{"label":"Irudien Aurkezpenaren Eskuragarritasuna","fields":[{"label":"Hurrengo diapositibaren botoiarentzako etiketa","default":"Hurrengo Irudia","description":"Hau soilik irakurgailu-bozgorailuentzako erabiltzen da. Ez da erakutsiko."},{"label":"Aurreko diapositibaren botoiarentzako etiketa","default":"Aurreko Irudia","description":"Hau soilik irakurgailu-bozgorailuentzako erabiltzen da. Ez da erakutsiko."},{"label":"Diapositiba-botoientzako etiketa","default":"Joan %slide irudira","description":"Hau soilik irakurgailu-bozgorailuentzako erabiltzen da. Ez da erakutsiko. %slide aldagai bat da eta irudiaren zenbakiarekin ordezkatuko da."}]}]}'), JSON_PRETTY_PRINT|JSON_UNESCAPED_UNICODE)
        ]);

        DB::table('h5p_libraries_languages')->insert([
            'library_id' => $h5pImageSliderLibId,
            'language_code' => 'fa',
            'translation' => json_encode(json_decode('{"semantics":[{"label":"تصاویر","field":{"label":"اسلاید تصاویر","fields":[{"label":"اسلاید تصویر"}]}},{"label":"نسبت ابعاد","description":"خودکار به معنای نسبت ابعاد ثابت است که بر اساس تصاویر تعیین می‌شود.","options":[{"label":"خودکار"},{"label":"سفارشی"},{"label":"بدون نسبت ثابت"}]},{"label":"تنظیمات نسبت ابعاد","fields":[{"label":"عرض نسبت ابعاد","description":"اگر اینجا 4 و برای ارتفاع نسبت ابعاد 3 را وارد کنید، نسبت 4:3 خواهد بود."},{"label":"ارتفاع نسبت ابعاد","description":"اگر اینجا 3 و برای عرض نسبت ابعاد 4 را وارد کنید، نسبت 4:3 خواهد بود."}]},{"label":"دسترسی‌پذیری اسلایدر تصاویر","fields":[{"label":"برچسب دکمه اسلاید بعدی","default":"تصویر بعدی","description":"این فقط برای نرم‌افزارهای خواندن صفحه استفاده می‌شود و نمایش داده نخواهد شد."},{"label":"برچسب دکمه اسلاید قبلی","default":"تصویر قبلی","description":"این فقط برای نرم‌افزارهای خواندن صفحه استفاده می‌شود و نمایش داده نخواهد شد."},{"label":"برچسب دکمه‌های اسلاید","default":"برو به تصویر %slide","description":"این فقط برای نرم‌افزارهای خواندن صفحه استفاده می‌شود و نمایش داده نخواهد شد. %slide یک متغیر است و با شماره تصویر جایگزین می‌شود."}]}]}'), JSON_PRETTY_PRINT|JSON_UNESCAPED_UNICODE)
        ]);

        DB::table('h5p_libraries_languages')->insert([
            'library_id' => $h5pImageSliderLibId,
            'language_code' => 'fi',
            'translation' => json_encode(json_decode('{"semantics":[{"label":"Kuvat","field":{"label":"Liukuvat kuvat","fields":[{"label":"Liukuvat kuvat"}]}},{"label":"Kuvasuhde","description":"Automaattinen tarkoittaa kiinteää kuvasuhdetta joka määritetään automaattisesti kuvatiedoston perusteella","options":[{"label":"Automaattinen"},{"label":"Räätälöity"},{"label":"Ei kiinteää kuvasuhdetta"}]},{"label":"Kuvasuhdeasetukset","fields":[{"label":"Kuvasuhteen leveys","description":"Jos käytät tässä arvoa 4 ja korkeudelle arvoa 3 niin kuvasuhteeksi muodostuu 4:3"},{"label":"Kuvasuhteen korkeus","description":"Jos käytät tässä arvoa 3 ja korkeudelle arvoa 4 niin kuvasuhteeksi muodostuu 4:3"}]},{"label":"Liukuvien kuvien esteettömyysasetukset","fields":[{"label":"Teksti seuraavaan diaan vievälle painikkeelle","default":"Seuraava kuva","description":"Tätä käytetään ruudunlukijoille, sitä ei näytetä itse esityksessä."},{"label":"Teksti edelliselle dialle vievälle painikkeelle","default":"Edellinen kuva","description":"Tätä käytetään ruudunlukijoille, sitä ei näytetä itse esityksessä."},{"label":"Teksti slide-navigointipainikkeille","default":"Siirry kuvaan %slide","description":"Tätä käytetään ruudunlukijoille, sitä ei näytetä itse esityksessä. Muuttuja %slide korvataan kuvan sivunumerolla."}]}]}'), JSON_PRETTY_PRINT|JSON_UNESCAPED_UNICODE)
        ]);

        DB::table('h5p_libraries_languages')->insert([
            'library_id' => $h5pImageSliderLibId,
            'language_code' => 'fr',
            'translation' => json_encode(json_decode('{"semantics":[{"label":"Images","field":{"label":"Diapositive","fields":[{"label":"Diapositive"}]}},{"label":"Ratio de l\'affichage","description":"Indiquez : \"Automatique\" pour un ratio d\'affichage déterminé par celui des images de l\'album nécessitant la plus grande hauteur d\'affichage, \"Personnalisé\" pour fixer un ratio de votre choix pour tout l\'album, et \"Variable\" pour un ratio qui s\'adaptera à celui de chaque image de l\'album.","options":[{"label":"Automatique"},{"label":"Personnalisé"},{"label":"Variable"}]},{"label":"Paramétrages du ratio de l\'affichage","fields":[{"label":"Ratio en largeur de l\'affichage :","description":"Si vous indiquez 4 ici, et 3 pour la hauteur, le ratio de l\'affichage de l\'album qui en résultera sera de quatre-tiers : 4:3."},{"label":"Ratio en hauteur de l\'affichage :","description":"Si vous indiquez 3 ici, et 4 pour la largeur, le ratio de l\'affichage de l\'album qui en résultera sera de quatre-tiers : 4:3."}]},{"label":"Paramètres d\'accessibilité de l\'album d\'images","fields":[{"label":"Libellé du bouton image suivante","default":"Image suivante","description":"Cette mention n\'apparaîtra pas à l\'écran et ne sera employée que par les outils d\'accessibilité améliorée par synthèse vocale."},{"label":"Libellé du bouton image précédente","default":"Image précédente","description":"Cette mention n\'apparaîtra pas à l\'écran et ne sera employée que par les outils d\'accessibilité améliorée par synthèse vocale."},{"label":"Libellé pour le bouton des diapositives","default":"Aller à l\'image numéro %slide","description":"Cette mention n\'apparaîtra pas à l\'écran et ne sera employée que par les outils d\'accessibilité améliorée par synthèse vocale. La mention %slide est un texte générique auquel se substituera le numéro effectif dans l\'album de l\'image affichée à ce moment-là."}]}]}'), JSON_PRETTY_PRINT|JSON_UNESCAPED_UNICODE)
        ]);

        DB::table('h5p_libraries_languages')->insert([
            'library_id' => $h5pImageSliderLibId,
            'language_code' => 'gl',
            'translation' => json_encode(json_decode('{"semantics":[{"label":"Imaxes","field":{"label":"Pase de Dipositivas","fields":[{"label":"Pase de Diapositivas"}]}},{"label":"Relación de aspecto","description":"Automático significa relación de aspecto fixo determinado automaticamente a partir das imaxes","options":[{"label":"Automático"},{"label":"Personalizado"},{"label":"Non fixado"}]},{"label":"Configuración da relación de aspecto","fields":[{"label":"Anchura da relación de aspecto","description":"Se usas 4 aquí e 3 para a altura, a relación de aspecto será 4:3"},{"label":"Altura da relación de aspecto","description":"Se usas 3 aquí e 4 para a anchura, a relación de aspecto será 4:3"}]},{"label":"Accesibilidade do pase de diapositivas","fields":[{"label":"Etiqueta para os botóns de diapositiva seguinte","default":"Imaxe Seguinte","description":"Só usado para os lectores de pantalla. Non se amosará ao usuario."},{"label":"Etiqueta para os botóns de diapositiva anterior","default":"Imaxe Anterior","description":"Só usado para os lectores de pantalla. Non se amosará ao usuario."},{"label":"Etiqueta para os botóns de diapositiva","default":"Ir á Imaxe %slide","description":"Só usado para os lectores de pantalla. Non se amosará ao usuario. %slide é a variable e substituirase polo número da imaxe."}]}]}'), JSON_PRETTY_PRINT|JSON_UNESCAPED_UNICODE)
        ]);

        DB::table('h5p_libraries_languages')->insert([
            'library_id' => $h5pImageSliderLibId,
            'language_code' => 'it',
            'translation' => json_encode(json_decode('{"semantics":[{"label":"Immagini","field":{"label":"Image Slide","fields":[{"label":"Image Slide"}]}},{"label":"Proporzioni","description":"Automatico significa proporzioni fisse determinate automaticamente in base alle immagini","options":[{"label":"Automatico"},{"label":"Personalizzato"},{"label":"Non fisso"}]},{"label":"Impostazione delle proporzioni","fields":[{"label":"Larghezza delle proporzioni","description":"Se usi 4 qui e 3 per l\'altezza, la proporzione sarà 4:3"},{"label":"Altezza delle proporzioni","description":"Se usi 3 qui e 4 per la larghezza, la proporzione sarà 4:3"}]},{"label":"Accessibilità dello slider dell\'immagine","fields":[{"label":"Etichetta dei pulsanti per la prossima slide","default":"Prossima immagine","description":"Questo è usato soltanto per lettori vocali. Non sarà visualizzato"},{"label":"Etichetta dei pulsanti per la slide precedente","default":"Immagine precedente","description":"Questo è usato soltanto per lettori vocali. Non sarà visualizzato"},{"label":"Etichetta dei pulsanti per le slide","default":"Vai all\'immagine %slide","description":"Questo è usato soltanto per i lettori vocali. Non sarà visualizzato. %slide è una variabile e sarà sostituita dal numero dell\'immagine"}]}]}'), JSON_PRETTY_PRINT|JSON_UNESCAPED_UNICODE)
        ]);

        DB::table('h5p_libraries_languages')->insert([
            'library_id' => $h5pImageSliderLibId,
            'language_code' => 'ka',
            'translation' => json_encode(json_decode('{"semantics":[{"label":"სურათები","field":{"label":"სურათის სლაიდი","fields":[{"label":"სურათის სლაიდი"}]}},{"label":"ასპექტის თანაფარდობა","description":"ავტომატური ნიშნავს ფიქსირებული ასპექტის თანაფარდობას ავტომატურად განსაზღვრული სურათების საფუძველზე","options":[{"label":"ავტომატური"},{"label":"არასტანდარტული"},{"label":"მოსაგვარებელი"}]},{"label":"ასპექტის თანაფარდობის პარამეტრები","fields":[{"label":"ასპექტის თანაფარდობის სიგანე","description":"თუ აქ იყენებთ 4-ს და სიმაღლისთვის 3-ს, ასპექტის თანაფარდობა იქნება 4:3"},{"label":"ასპექტის თანაფარდობის სიმაღლე","description":"თუ აქ იყენებთ 3-ს და სიგანისთვის 4-ს, ასპექტის თანაფარდობა იქნება 4:3"}]},{"label":"სურათის სლაიდერის ხელმისაწვდომობა","fields":[{"label":"შემდეგი სლაიდის ღილაკის წარწერა","default":"შემდეგი სურათი","description":"ეს გამოიყენება მხოლოდ ტექსტის გამხმოვანებლისთვის. არ გამოჩნდება."},{"label":"წინა სლაიდის ღილაკების წარწერა","default":"წინა სურათი","description":"ეს გამოიყენება მხოლოდ ტექსტის გამხმოვანებლისთვის. არ გამოჩნდება."},{"label":"სლაიდის ღილაკების წარწერა","default":"გადადი სურათზე %slide","description":"მხოლოდ ტექსტის გამხმოვანებლისთვის. არ გამოჩნდება. %slide არის ცვლადი და ჩანაცვლდება სურათის ნომრით."}]}]}'), JSON_PRETTY_PRINT|JSON_UNESCAPED_UNICODE)
        ]);

        DB::table('h5p_libraries_languages')->insert([
            'library_id' => $h5pImageSliderLibId,
            'language_code' => 'ko',
            'translation' => json_encode(json_decode('{"semantics":[{"label":"이미지","field":{"label":"이미지 슬라이드","fields":[{"label":"이미지 슬라이드"}]}},{"label":"가로 세로 비율","description":"자동설정은 이미지를 기반으로 자동으로 결정되는 가로 세로 비율을 의미합니다.","options":[{"label":"자동설정"},{"label":"사용자 지정"},{"label":"고정되지 않음"}]},{"label":"가로 세로 비율 설정","fields":[{"label":"너비 설정","description":"여기서 4로 설정하고 높이를 3으로 하는 경우 가로 세로 비율은 4:3이 됩니다."},{"label":"높이 설정","description":"여기서 3으로 설정하고 너비를 3으로 하는 경우 가로 세로 비율은 4:3이 됩니다."}]},{"label":"이미지 슬라이더 접근성","fields":[{"label":"다음 슬라이드 버튼에 대한 라벨","default":"다음 이미지","description":"이것은 읽기 스피커에만 사용됩니다. 표시되지 않습니다."},{"label":"이전 슬라이드 버튼에 대한 라벨","default":"이전 이미지","description":"이것은 읽기 스피커에만 사용됩니다. 표시되지 않습니다."},{"label":"슬라이드 버튼의 라벨","default":"이미지 %slide 로 이동","description":"이것은 읽기 스피커에만 사용됩니다. 표시되지 않습니다. %slide는 변수이므로 이미지 번호로 바뀝니다."}]}]}'), JSON_PRETTY_PRINT|JSON_UNESCAPED_UNICODE)
        ]);

        DB::table('h5p_libraries_languages')->insert([
            'library_id' => $h5pImageSliderLibId,
            'language_code' => 'lt',
            'translation' => json_encode(json_decode('{"semantics":[{"label":"Paveikslai","field":{"label":"Paveiksliuko skaidrė","fields":[{"label":"Paveiksliuko skaidrė"}]}},{"label":"Kraštinių santykis","description":"Automatinis reiškia fiksuotą kraštinių santykį, kuris automatiškai nustatomas pagal paveikslus","options":[{"label":"Automatinis"},{"label":"Pasirenkamas"},{"label":"Nefiksuotas"}]},{"label":"Kraštinių santykio nustatymai","fields":[{"label":"Plotis","description":"Jei čia naudosite 4, o aukščiui – 3, kraštinių santykis bus 4:3"},{"label":"Aukštis","description":"Jei čia naudosite 3, o pločiui – 4, formato santykis bus 4:3"}]},{"label":"Paveiksliukų slinktuko pritaikomumas","fields":[{"label":"Kitos skaidrės mygtuko pavadinimas","default":"Kitas paveikslas","description":"Tai naudojama tik įgarsinant tekstą. Tai nebus rodoma."},{"label":"Ankstesnės skaidrės mygtuko pavadinimas","default":"Ankstesnis paveikslas","description":"Tai naudojama tik teksto įgarsinimui. Tai nebus rodoma."},{"label":"Skaidrės mygtuko pavadinimas","default":"Pereiti prie %slide skaidrės","description":"Tai naudojama tik teksto įgarsinimui. Tai nebus rodoma. %slide yra kintamasis ir bus pakeistas paveikslo numeriu."}]}]}'), JSON_PRETTY_PRINT|JSON_UNESCAPED_UNICODE)
        ]);

        DB::table('h5p_libraries_languages')->insert([
            'library_id' => $h5pImageSliderLibId,
            'language_code' => 'lv',
            'translation' => json_encode(json_decode('{"semantics":[{"label":"Attēli","field":{"label":"Attēla slaids","fields":[{"label":"Attēla slaids"}]}},{"label":"Malu attiecība","description":"Automātiski nozīmē fiksētu malu attiecību, kas tiek automātiski noteikta, pamatojoties uz attēliem","options":[{"label":"Automātiski"},{"label":"Pielāgots"},{"label":"Nav nemainīgs"}]},{"label":"Malu attiecību iestatījumi","fields":[{"label":"Malu attiecības platums","description":"Ja šeit izmantojat 4 un augstumam 3, malu attiecība būs 4:3"},{"label":"Malu attiecības augstums","description":"Ja šeit izmantojat 3 un platumam 4, malu attiecība būs 4:3"}]},{"label":"Attēlu slīdņa pieejamība","fields":[{"default":"Nākamais attēls","description":"Tiek izmantots tikai ekrāna lasītājiem. Netiks atspoguļots.","label":"Nākamā slaida pogu etiķete"},{"label":"Iepriekšējā slaida pogu etiķete","default":"Iepriekšējais attēls","description":"Tiek izmantots tikai ekrāna lasītājiem. Netiks atspoguļots."},{"label":"Slaidu pogu etiķete","default":"Dodieties uz attēlu %slide","description":"To izmanto tikai ekrāna lasītājiem. Tas netiks parādīts. %slide ir mainīgais un tiks aizstāts ar attēla numuru."}]}]}'), JSON_PRETTY_PRINT|JSON_UNESCAPED_UNICODE)
        ]);

        DB::table('h5p_libraries_languages')->insert([
            'library_id' => $h5pImageSliderLibId,
            'language_code' => 'mn',
            'translation' => json_encode(json_decode('{"semantics":[{"field":{"label":"Зургийн слайд","fields":[{"label":"Зургийн слайд"}]},"label":"Зургууд"},{"label":"Хэсгийн харьцаа","options":[{"label":"Автомат"},{"label":"Захиалгат"},{"label":"Засагдаагүй"}],"description":"Автомат гэдэг нь зураг дээр тулгуурлан автоматаар тодорхойлогддог тогтмол харьцааг хэлнэ"},{"fields":[{"label":"Харьцааны өргөн","description":"Хэрэв та энд 4, өндрийн хувьд 3-ыг ашиглавал харьцаа 4:3 болно"},{"label":"Харьцааны өндөр","description":"Хэрэв та энд 3-ыг, өргөний хувьд 4-ийг ашиглавал харьцаа 4:3 болно"}],"label":"Харьцааны тохиргоо"},{"label":"Зургийн слайдерт хандах боломжтой","fields":[{"default":"Дараагийн зураг","label":"Дараагийн слайдын товчлууруудын шошго","description":"Үүнийг зөвхөн уншдаг чанга яригчдад ашигладаг. Энэ нь харагдахгүй."},{"label":"Өмнөх слайдын товчлууруудын шошго","description":"Үүнийг зөвхөн уншдаг чанга яригчдад ашигладаг. Энэ нь харагдахгүй.","default":"Өмнөх зураг"},{"default":"Зураг %slide руу очно уу","label":"Слайд товчлууруудын шошго","description":"Үүнийг зөвхөн уншдаг чанга яригчдад ашигладаг. Энэ нь харагдахгүй. %slide нь хувьсагч бөгөөд зургийн дугаараар солигдох болно."}]}]}'), JSON_PRETTY_PRINT|JSON_UNESCAPED_UNICODE)
        ]);

        DB::table('h5p_libraries_languages')->insert([
            'library_id' => $h5pImageSliderLibId,
            'language_code' => 'nb',
            'translation' => json_encode(json_decode('{"semantics":[{"label":"Bilder","field":{"label":"Bilde","fields":[{"label":"Bilde"}]}},{"label":"Forhold mellom bredde og høyde","description":"Hvis du velger \"Automatisk\", beholder bildene forholdet mellom bredde og høyde.","options":[{"label":"Automatisk"},{"label":"Egendefinert"},{"label":"Ikke fast"}]},{"label":"Innstillinger for forholdet mellom bredde og høyde","fields":[{"label":"Bredde","description":"Hvis du setter 4 her og 3 for høyde, blir sideforholdet 4 : 3."},{"label":"Høyde","description":"Hvis du setter 3 her og 4 for bredde, blir sideforholdet 4 : 3."}]},{"label":"Tilgjengelighet for bildeserien","fields":[{"label":"Navn på \"Neste bilde\"-knapp","default":"Neste bilde","description":"Dette blir bare brukt av skjermleser. Det blir ikke vist."},{"label":"Navn på \"Forrige bilde\"-knapp","default":"Forrige bilde","description":"Dette blir bare brukt av skjermleser. Det blir ikke vist."},{"label":"Navn på knapp for direktenavigasjon til bildene","default":"Gå til bilde %slide","description":"Dette blir bare brukt av skjermleser. Det blir ikke vist. %slide er en variabel og blir erstattet med det aktuelle bildenummeret."}]}]}'), JSON_PRETTY_PRINT|JSON_UNESCAPED_UNICODE)
        ]);

        DB::table('h5p_libraries_languages')->insert([
            'library_id' => $h5pImageSliderLibId,
            'language_code' => 'nl',
            'translation' => json_encode(json_decode('{"semantics":[{"label":"Afbeeldingen","field":{"label":"Afbeeldingsdia","fields":[{"label":"Afbeeldingsdia"}]}},{"label":"Beeldverhouding","description":"Automatisch betekent een vaste beeldverhouding die vanzelf wordt bepaald op basis van de beelden","options":[{"label":"Automatisch"},{"label":"Aangepast"},{"label":"Niet gefixeerd"}]},{"label":"Instellingen beeldverhouding","fields":[{"label":"De breedte van de beeldverhouding","description":"Als je hier 4 en 3 voor de hoogte gebruikt, dan is de beeldverhouding 4:3"},{"label":"De hoogte van de beeldverhouding","description":"Als je hier 3 en 4 voor de breedte gebruikt, dan is de beeldverhouding 4:3"}]},{"label":"Toegankelijkheid van afbeeldingsschuifregelaar","fields":[{"label":"Label voor \"Volgende dia\"-knoppen","default":"Volgende afbeelding","description":"Dit wordt alleen gebruikt voor schermlezers. Het wordt niet getoond."},{"label":"Label voor \"Vorige dia\"-knoppen","default":"Vorige afbeelding","description":"Dit wordt alleen gebruikt voor schermlezers. Het wordt niet getoond."},{"label":"Label voor \"Dia\"-knoppen","default":"Ga naar afbeelding %slide","description":"Dit wordt alleen gebruikt voor schermlezers. Het wordt niet getoond. %slide is een variabele en zal worden vervangen door het afbeeldingsnummer."}]}]}'), JSON_PRETTY_PRINT|JSON_UNESCAPED_UNICODE)
        ]);

        DB::table('h5p_libraries_languages')->insert([
            'library_id' => $h5pImageSliderLibId,
            'language_code' => 'nn',
            'translation' => json_encode(json_decode('{"semantics":[{"label":"Bilete","field":{"fields":[{"label":"Bilete"}],"label":"Bilete"}},{"options":[{"label":"Automatisk"},{"label":"Eigendefinert"},{"label":"Ikkje fast"}],"label":"Forhold mellom breidde og høgde","description":"Om du vel \"Automatisk\", beheld bileta forholdet mellom breidde og høgde."},{"label":"Innstillingar for forholdet mellom breidde og høgde","fields":[{"label":"Breidde","description":"Dersom du set 4 her og 3 for høgde, blir sideforholdet 4 : 3."},{"label":"Høgde","description":"Dersom du set 3 her og 4 for breidde, blir sideforholdet 4 : 3."}]},{"label":"Tilgjengelegheit for biletserien","fields":[{"default":"Neste bilete","description":"Dette blir berre brukt av skjermlesar. Det blir ikkje vist.","label":"Namn på \"Neste bilete\"-knapp"},{"label":"Namn på \"Førre bilete\"-knapp","default":"Førre bilete","description":"Dette blir berre brukt av skjermlesar. Det blir ikkje vist."},{"label":"Namn på knappen for direktenavigasjon til bileta","default":"Gå til bilete %slide","description":"Dette blir berre brukt av skjermlesar. Det blir ikkje vist. %slide er ein variabel og blir erstatta med det aktuelle biletnummeret."}]}]}'), JSON_PRETTY_PRINT|JSON_UNESCAPED_UNICODE)
        ]);

        DB::table('h5p_libraries_languages')->insert([
            'library_id' => $h5pImageSliderLibId,
            'language_code' => 'pl',
            'translation' => json_encode(json_decode('{"semantics":[{"label":"Obrazy","field":{"label":"Slajd z obrazem","fields":[{"label":"Slajd z obrazem"}]}},{"label":"Współczynnik proporcji","description":"Automatyczny oznacza stały współczynnik proporcji automatycznie określany na podstawie obrazów","options":[{"label":"Automatyczny"},{"label":"Niestandardowy"},{"label":"Nie określony"}]},{"label":"Ustawienia współczynnika proporcji","fields":[{"label":"Szerokość współczynnika proporcji","description":"Jeśli użyjesz tu 4, a dla wysokości 3, to współczynnik wyniesie 4:3"},{"label":"Wysokość współczynnika proporcji","description":"Jeśli wpiszesz tu 3, a dla szerokości 4, to współczynnik wyniesie 4:3"}]},{"label":"Dostępność slidera","fields":[{"label":"Etykieta przycisku Dalej","default":"Dalej","description":"Wyłącznie dla czytników. Tekst nie zostanie wyświetlony."},{"label":"Etykieta przycisku Wstecz","default":"Wstecz","description":"Wyłącznie dla czytników. Tekst nie zostanie wyświetlony."},{"label":"Etykieta dla przycisków slajdów","default":"Idź do obrazu %slide","description":"Wyłącznie dla czytników. Tekst nie zostanie wyświetlony. %slide jest zmienną i zostanie zastąpiony numerem obrazu."}]}]}'), JSON_PRETTY_PRINT|JSON_UNESCAPED_UNICODE)
        ]);

        DB::table('h5p_libraries_languages')->insert([
            'library_id' => $h5pImageSliderLibId,
            'language_code' => 'pt-br',
            'translation' => json_encode(json_decode('{"semantics":[{"label":"Imagens","field":{"label":"Slide de Imagem","fields":[{"label":"Slide de Imagem"}]}},{"label":"Relação de aspecto","description":"Automático significa relação de aspecto fixa determinada automaticamente com base nas imagens","options":[{"label":"Automático"},{"label":"Personalizado"},{"label":"Não fixado"}]},{"label":"Ajustes da relação de aspecto","fields":[{"label":"Largura da relação de aspecto","description":"Se você usar 4 aqui, e 3 para a altura a relação de aspecto será 4:3"},{"label":"Altura da relação de aspecto","description":"Se você usar 3 aqui, e 4 para a largura a relação de aspecto será de 4:3"}]},{"label":"Acessibilidade do controle deslizante de imagem","fields":[{"label":"Rótulo para o botão \"Próximo Slide\"","default":"Próxima Imagem","description":"Isto só é usado para leitores de tela. Não será exibido."},{"label":"Rótulo do botão \"Slide Anterior\"","default":"Imagem Anterior","description":"Isto só é usado para leitores de tela. Não será exibido."},{"label":"Rótulo dos botões Slide","default":"Ir para a imagem %slide","description":"Isto só é usado para leitores de tela. Não será exibido. O %slide é uma variável e será substituído pelo número da imagem."}]}]}'), JSON_PRETTY_PRINT|JSON_UNESCAPED_UNICODE)
        ]);

        DB::table('h5p_libraries_languages')->insert([
            'library_id' => $h5pImageSliderLibId,
            'language_code' => 'pt',
            'translation' => json_encode(json_decode('{"semantics":[{"label":"Imagens","field":{"label":"Slides","fields":[{"label":"Slides"}]}},{"label":"Proporção","description":"Automático significa proporção fixa determinada automaticamente com base nas imagens","options":[{"label":"Automático"},{"label":"Personalizado"},{"label":"Variável"}]},{"label":"Configurações da proporção do ecrã","fields":[{"label":"Largura","description":"Se usar 4 aqui e 3 para a altura, a proporção será de 4:3"},{"label":"Altura","description":"Se usar 3 aqui e 4 para a largura, a proporção será de 4:3"}]},{"label":"Acessibilidade do controlo deslizante de imagem","fields":[{"label":"Etiqueta para os botões de próxima imagem","default":"Imagem seguinte","description":"É usado apenas para altifalantes de leitura. Não será mostrado."},{"label":"Etiqueta para os botões de imagem anterior","default":"Imagem anterior","description":"É usado apenas para altifalantes de leitura. Não será mostrado."},{"label":"Etiqueta para os botões de escolha de imagem","default":"Ir para a imagem %slide","description":"É usado apenas para altifalantes de leitura. Não será mostrado. %slide é uma variável e será substituída pelo número da imagem."}]}]}'), JSON_PRETTY_PRINT|JSON_UNESCAPED_UNICODE)
        ]);

        DB::table('h5p_libraries_languages')->insert([
            'library_id' => $h5pImageSliderLibId,
            'language_code' => 'ro',
            'translation' => json_encode(json_decode('{"semantics":[{"label":"Imagini","field":{"label":"Diapozitiv imagine","fields":[{"label":"Diapozitiv imagine"}]}},{"label":"Raport de aspect","description":"Automat înseamnă un raport de aspect fix, determinat automat pe baza imaginilor","options":[{"label":"Automat"},{"label":"Personalizat"},{"label":"Nefixat"}]},{"label":"Setări raport de aspect","fields":[{"label":"Lățime raport de aspect","description":"Dacă folosiți 4 aici și 3 pentru înălțime, raportul de aspect va fi 4:3"},{"label":"Înălțime raport de aspect","description":"Dacă folosiți 3 aici și 4 pentru lățime, raportul de aspect va fi 4:3"}]},{"label":"Accesibilitate carusel de imagini","fields":[{"label":"Etichetă pentru butoanele de diapozitiv următor","default":"Imaginea următoare","description":"Aceasta este folosită doar de cititoarele de ecran. Nu va fi afișată."},{"label":"Etichetă pentru butoanele de diapozitiv anterior","default":"Imaginea anterioară","description":"Aceasta este folosită doar de cititoarele de ecran. Nu va fi afișată."},{"label":"Etichetă pentru butoanele de diapozitiv","default":"Mergi la imaginea %slide","description":"Aceasta este folosită doar de cititoarele de ecran. Nu va fi afișată. %slide este o variabilă și va fi înlocuită cu numărul imaginii."}]}]}'), JSON_PRETTY_PRINT|JSON_UNESCAPED_UNICODE)
        ]);

        DB::table('h5p_libraries_languages')->insert([
            'library_id' => $h5pImageSliderLibId,
            'language_code' => 'ru',
            'translation' => json_encode(json_decode('{"semantics":[{"label":"Изображения","field":{"label":"Слайд изображения","fields":[{"label":"Слайд изображения"}]}},{"label":"Соотношение сторон","description":"Автоматическое значит фиксированное соотношение сторон основываясь на изображении","options":[{"label":"Автоматическое"},{"label":"Обычное"},{"label":"Не фиксированное"}]},{"label":"Настройки соотношения сторон","fields":[{"label":"Ширина","description":"При значении 4 на этом месте и значении 3 для высоты соотношение сторон будет 4:3"},{"label":"Высота","description":"При значении 3 на этом месте и значении 4 для ширины соотношение сторон будет 4:3"}]},{"label":"Доступность к слайдеру изображения","fields":[{"label":"Ярлыки для кнопок следующих слайдов","default":"Следующее изображение","description":"Используется только для ассистирующих технологии. Не будет отображено."},{"label":"Ярлык для кнопки прошлого слайда","default":"Прошлое изображение","description":"Используется только для ассистирующих технологии. Не будет отображено."},{"label":"Ярлык для кнопки слайда","default":"Перейти на слайд %slide","description":"Используется только для ассистирующих технологии. Не будет отображено. %slide это переменная и будет заменена номером слайда."}]}]}'), JSON_PRETTY_PRINT|JSON_UNESCAPED_UNICODE)
        ]);

        DB::table('h5p_libraries_languages')->insert([
            'library_id' => $h5pImageSliderLibId,
            'language_code' => 'sl',
            'translation' => json_encode(json_decode('{"semantics":[{"label":"Slike","field":{"label":"Slikovni drsnik","fields":[{"label":"Slikovni drsnik"}]}},{"label":"Razmerje","description":"Samodejno pomeni fiksno razmerje stranic, ki se samodejno določi na podlagi slik. Po meri omogoča lasten vnos razmerja.","options":[{"label":"Samodejno"},{"label":"Po meri"},{"label":"Spremenljivo"}]},{"label":"Nastavitev razmerja po meri","fields":[{"label":"Širina stranice","description":"Pri razmerju stranic 4:3 se pod širino vnese 4."},{"label":"Višina stranice","description":"Pri razmerju stranic 4:3 se pod višino vnese 3."}]},{"label":"Dostopnost slikovnega drsnika","fields":[{"label":"Besedilo gumba za ogled nasledje slike","default":"Naslednja slika","description":"Besedilo služi bralnikom zaslonov in ne bo prikazano."},{"label":"Besedilo gumba za ogled prejšnje slike","default":"Prejšnja slika","description":"Besedilo služi bralnikom zaslonov in ne bo prikazano."},{"label":"Besedilo za gumbe drsnika slik","default":"Prikaži sliko %slide","description":"Besedilo služi bralnikom zaslonov in ne bo prikazano. %slide je spremenljivka."}]}]}'), JSON_PRETTY_PRINT|JSON_UNESCAPED_UNICODE)
        ]);

        DB::table('h5p_libraries_languages')->insert([
            'library_id' => $h5pImageSliderLibId,
            'language_code' => 'sma',
            'translation' => json_encode(json_decode('{"semantics":[{"label":"Images","field":{"label":"Image Slide","fields":[{"label":"Image Slide"}]}},{"label":"Aspect ratio","description":"Automatic means fixed aspect ratio automatically determined based on the images","options":[{"label":"Automatic"},{"label":"Custom"},{"label":"Not fixed"}]},{"label":"Aspect Ratio Settings","fields":[{"label":"Aspect ratio width","description":"If you use 4 here, and 3 for the height the aspect ratio will be 4:3"},{"label":"Aspect ratio height","description":"If you use 3 here, and 4 for the width the aspect ratio will be 4:3"}]},{"label":"Image slider accessibility","fields":[{"label":"Label for next slide buttons","default":"Next Image","description":"This is only used for read-speakers. It won\'t be displayed."},{"label":"Label for previous slide buttons","default":"Previous Image","description":"This is only used for read-speakers. It won\'t be displayed."},{"label":"Label for slide buttons","default":"Go to image %slide","description":"This is only used for read-speakers. It won\'t be displayed. %slide is a variable and will be replaced with the image number."}]}]}'), JSON_PRETTY_PRINT|JSON_UNESCAPED_UNICODE)
        ]);

        DB::table('h5p_libraries_languages')->insert([
            'library_id' => $h5pImageSliderLibId,
            'language_code' => 'sme',
            'translation' => json_encode(json_decode('{"semantics":[{"label":"Images","field":{"label":"Image Slide","fields":[{"label":"Image Slide"}]}},{"label":"Aspect ratio","description":"Automatic means fixed aspect ratio automatically determined based on the images","options":[{"label":"Automatic"},{"label":"Custom"},{"label":"Not fixed"}]},{"label":"Aspect Ratio Settings","fields":[{"label":"Aspect ratio width","description":"If you use 4 here, and 3 for the height the aspect ratio will be 4:3"},{"label":"Aspect ratio height","description":"If you use 3 here, and 4 for the width the aspect ratio will be 4:3"}]},{"label":"Image slider accessibility","fields":[{"label":"Label for next slide buttons","default":"Next Image","description":"This is only used for read-speakers. It won\'t be displayed."},{"label":"Label for previous slide buttons","default":"Previous Image","description":"This is only used for read-speakers. It won\'t be displayed."},{"label":"Label for slide buttons","default":"Go to image %slide","description":"This is only used for read-speakers. It won\'t be displayed. %slide is a variable and will be replaced with the image number."}]}]}'), JSON_PRETTY_PRINT|JSON_UNESCAPED_UNICODE)
        ]);

        DB::table('h5p_libraries_languages')->insert([
            'library_id' => $h5pImageSliderLibId,
            'language_code' => 'smj',
            'translation' => json_encode(json_decode('{"semantics":[{"label":"Images","field":{"label":"Image Slide","fields":[{"label":"Image Slide"}]}},{"label":"Aspect ratio","description":"Automatic means fixed aspect ratio automatically determined based on the images","options":[{"label":"Automatic"},{"label":"Custom"},{"label":"Not fixed"}]},{"label":"Aspect Ratio Settings","fields":[{"label":"Aspect ratio width","description":"If you use 4 here, and 3 for the height the aspect ratio will be 4:3"},{"label":"Aspect ratio height","description":"If you use 3 here, and 4 for the width the aspect ratio will be 4:3"}]},{"label":"Image slider accessibility","fields":[{"label":"Label for next slide buttons","default":"Next Image","description":"This is only used for read-speakers. It won\'t be displayed."},{"label":"Label for previous slide buttons","default":"Previous Image","description":"This is only used for read-speakers. It won\'t be displayed."},{"label":"Label for slide buttons","default":"Go to image %slide","description":"This is only used for read-speakers. It won\'t be displayed. %slide is a variable and will be replaced with the image number."}]}]}'), JSON_PRETTY_PRINT|JSON_UNESCAPED_UNICODE)
        ]);

        DB::table('h5p_libraries_languages')->insert([
            'library_id' => $h5pImageSliderLibId,
            'language_code' => 'sv',
            'translation' => json_encode(json_decode('{"semantics":[{"label":"Bilder","field":{"label":"Bild","fields":[{"label":"Bild"}]}},{"label":"Bildförhållande","description":"Automatisk innebär att bildförhållandet automatiskt sätts utifrån bilderna","options":[{"label":"Automatisk"},{"label":"Anpassad"},{"label":"Inte fast"}]},{"label":"Inställningar för bildförhållande","fields":[{"label":"Bredd för bildförhållande","description":"Om du använder 4 här, och 3 för höjd så kommer bildförhållandet bli 4:3"},{"label":"Höjd för bildförhållande","description":"Om du använder 3 här, och 4 för bredd så kommer bildförhållandet bli 4:3"}]},{"label":"Tillgänglighet för Image slider","fields":[{"label":"Etikett för nästa-bild-knappar","default":"Nästa bild","description":"Detta används endast för skärmläsare. Texten kommer inte visas."},{"label":"Etikett för föregående-sida-knappar","default":"Föregående sida","description":"Detta används endast av skärmläsare. Texten kommer inte att visas."},{"label":"Etikett för bild-knappar","default":"Gå til bild %slide","description":"Detta används endast av skärmläsare. Texten kommer inte att visas. %slide är en variabel och kommer att bytas ut till bildnumret."}]}]}'), JSON_PRETTY_PRINT|JSON_UNESCAPED_UNICODE)
        ]);

        DB::table('h5p_libraries_languages')->insert([
            'library_id' => $h5pImageSliderLibId,
            'language_code' => 'sw',
            'translation' => json_encode(json_decode('{"semantics":[{"label":"Picha","field":{"label":"Slaidi ya Picha","fields":[{"label":"Slaidi ya Picha"}]}},{"label":"Uwiano wa vipengele","description":"Kiotomatiki inamaanisha uwiano wa kipengele cha kudumu kuamuliwa kiotomatiki kulingana na picha","options":[{"label":"Otomatiki"},{"label":"Geuza kukufaa"},{"label":"Haijarekebishwa"}]},{"label":"Mipangilio ya Uwiano wa Kipengele","fields":[{"label":"Kipengele cha uwiano wa upana","description":"Ikiwa unatumia 4 hapa, na 3 kwa urefu uwiano wa kipengele utakuwa 4: 3"},{"label":"Kipengele cha uwiano wa urefu","description":"Ikiwa unatumia 3 hapa, na 4 kwa upana uwiano wa kipengele utakuwa 4: 3"}]},{"label":"Ufikiaji wa kitelezi cha picha","fields":[{"label":"Lebo ya vitufe vya slaidi vinavyofuata","default":"Picha inayofuata","description":"Hii hutumiwa tu kwa visoma maandishi. Haitaonyeshwa."},{"label":"Lebo kwa vitufe vya slaidi vilivyotangulia","default":"Picha iliyotangua","description":"Hii hutumiwa tu kwa visoma maandishi. Haitaonyeshwa."},{"label":"Lebo ya vitufe vya slaidi","default":"Nenda kwenye picha%slide","description":"Hii hutumiwa tu kwa visoma maandishi. Haitaonyeshwa. %slide ni kigezo na itabadilishwa na nambari ya picha."}]}]}'), JSON_PRETTY_PRINT|JSON_UNESCAPED_UNICODE)
        ]);

        DB::table('h5p_libraries_languages')->insert([
            'library_id' => $h5pImageSliderLibId,
            'language_code' => 'uk',
            'translation' => json_encode(json_decode('{"semantics":[{"label":"Зображення","field":{"label":"Слайд зображення","fields":[{"label":"Слайд зображення"}]}},{"label":"Співвідношення сторін","description":"Автоматичне означає фіксоване співвідношення сторін ґрунтуючись на зображенні","options":[{"label":"Автоматичне"},{"label":"Звичайне"},{"label":"Не фіксоване"}]},{"label":"Налаштування співвідношення сторін","fields":[{"label":"Ширина","description":"При значенні 4 на цьому місці та значенні 3 для висоти співвідношення сторін буде 4:3"},{"label":"Висота","description":"При значенні 3 на цьому місці та значенні 4 для ширини співвідношення сторін буде 4:3"}]},{"label":"Доступність до слайдера зображення","fields":[{"label":"Ярлики для кнопок наступних слайдів","default":"Наступне зображення","description":"Використовується тільки для асистуючих технологій. Не відображатиметься."},{"label":"Ярлик для кнопки попереднього слайду","default":"Попереднє зображення","description":"Використовується тільки для асистуючих технологій. Не відображатиметься."},{"label":"Ярлик для кнопки слайду","default":"Перейти до слайду %slide","description":"Використовується тільки для асистуючих технологій. Не відображатиметься. %slide це змінна та буде замінена номером слайда."}]}]}'), JSON_PRETTY_PRINT|JSON_UNESCAPED_UNICODE)
        ]);

        DB::table('h5p_libraries_languages')->insert([
            'library_id' => $h5pImageSliderLibId,
            'language_code' => 'zh-cn',
            'translation' => json_encode(json_decode('{"semantics":[{"label":"Images","field":{"label":"Image Slide","fields":[{"label":"Image Slide"}]}},{"label":"Aspect ratio","description":"Automatic means fixed aspect ratio automatically determined based on the images","options":[{"label":"Automatic"},{"label":"Custom"},{"label":"Not fixed"}]},{"label":"Aspect Ratio Settings","fields":[{"label":"Aspect ratio width","description":"If you use 4 here, and 3 for the height the aspect ratio will be 4:3"},{"label":"Aspect ratio height","description":"If you use 3 here, and 4 for the width the aspect ratio will be 4:3"}]},{"label":"Image slider accessibility","fields":[{"label":"Label for next slide buttons","default":"Next Image","description":"This is only used for read-speakers. It won\'t be displayed."},{"label":"Label for previous slide buttons","default":"Previous Image","description":"This is only used for read-speakers. It won\'t be displayed."},{"label":"Label for slide buttons","default":"Go to image %slide","description":"This is only used for read-speakers. It won\'t be displayed. %slide is a variable and will be replaced with the image number."}]}]}'), JSON_PRETTY_PRINT|JSON_UNESCAPED_UNICODE)
        ]);
    }
}
