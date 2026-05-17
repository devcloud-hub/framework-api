<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class H5PAddAgamottoOneSevenSeeder extends Seeder
{
    public function run()
    {
        $h5pAgamottoLibParams = ['name' => "H5P.Agamotto", "major_version" => 1, "minor_version" => 7];
        $h5pAgamottoLib = DB::table('h5p_libraries')->where($h5pAgamottoLibParams)->first();

        if (empty($h5pAgamottoLib)) {
            $h5pAgamottoLibId = DB::table('h5p_libraries')->insertGetId([
                'name' => 'H5P.Agamotto',
                'title' => 'Agamotto',
                'major_version' => 1,
                'minor_version' => 7,
                'patch_version' => 0,
                'embed_types' => 'iframe',
                'runnable' => 1,
                'restricted' => 0,
                'fullscreen' => 0,
                'preloaded_js' => 'dist/h5p-agamotto.js',
                'preloaded_css' => 'dist/h5p-agamotto.css',
                'drop_library_css' => '',
                'semantics' => $this->getSemantics(),
                'tutorial_url' => ' ',
                'has_icon' => 1
            ]);

            $this->insertDependentLibraries($h5pAgamottoLibId);
            $this->insertLibrariesLanguages($h5pAgamottoLibId);

            $agamottoImg = '5pOc7tnH4WJ13aoqxYt8BwJk5N518M7GosNFCdBM.png';
            $localURL = public_path('storage/activity-items/');
            $storageURL = '/storage/activity-items/';
            $organizations = DB::table('organizations')->pluck('id');
            $currentDate = now();

            foreach ($organizations as $organizationId) {
                $activityTypes = DB::table('activity_types')->whereOrganizationId($organizationId)->pluck('id', 'title');
                if (!isset($activityTypes['Photo / Images'])) {
                    continue;
                }
                $params = ['title' => 'Agamotto', 'organization_id' => $organizationId];
                DB::table('activity_items')->updateOrInsert($params, [
                    'title' => 'Agamotto',
                    'image' => $storageURL . $agamottoImg,
                    'description' => 'Learners compare and explore a sequence of images interactively',
                    'activity_type_id' => $activityTypes['Photo / Images'],
                    'h5pLib' => 'H5P.Agamotto 1.7',
                    'demo_activity_id' => '745',
                    'demo_video_id' => '',
                    'type' => 'h5p',
                    'created_at' => $currentDate,
                    'deleted_at' => null,
                    'organization_id' => $organizationId,
                ]);
            }
        }
    }

    private function insertDependentLibraries($h5pAgamottoLibId)
    {
        $h5pQuestionParams = ['name' => "H5P.Question", "major_version" => 1, "minor_version" => 5];
        $h5pQuestionLib = DB::table('h5p_libraries')->where($h5pQuestionParams)->first();
        $h5pQuestionLibId = $h5pQuestionLib->id;
        DB::table('h5p_libraries_libraries')->insert([
            'library_id' => $h5pAgamottoLibId,
            'required_library_id' => $h5pQuestionLibId,
            'dependency_type' => 'preloaded'
        ]);

        $h5pVerticalTabsParams = ['name' => "H5PEditor.VerticalTabs", "major_version" => 1, "minor_version" => 3];
        $h5pVerticalTabsLib = DB::table('h5p_libraries')->where($h5pVerticalTabsParams)->first();
        $h5pVerticalTabsLibId = $h5pVerticalTabsLib->id;
        DB::table('h5p_libraries_libraries')->insert([
            'library_id' => $h5pAgamottoLibId,
            'required_library_id' => $h5pVerticalTabsLibId,
            'dependency_type' => 'editor'
        ]);

        $h5pColorSelectorParams = ['name' => "H5PEditor.ColorSelector", "major_version" => 1, "minor_version" => 3];
        $h5pColorSelectorLib = DB::table('h5p_libraries')->where($h5pColorSelectorParams)->first();
        $h5pColorSelectorLibId = $h5pColorSelectorLib->id;
        DB::table('h5p_libraries_libraries')->insert([
            'library_id' => $h5pAgamottoLibId,
            'required_library_id' => $h5pColorSelectorLibId,
            'dependency_type' => 'editor'
        ]);

        $h5pAudioRecorderParams = ['name' => "H5PEditor.AudioRecorder", "major_version" => 1, "minor_version" => 0];
        $h5pAudioRecorderLib = DB::table('h5p_libraries')->where($h5pAudioRecorderParams)->first();
        $h5pAudioRecorderLibId = $h5pAudioRecorderLib->id;
        DB::table('h5p_libraries_libraries')->insert([
            'library_id' => $h5pAgamottoLibId,
            'required_library_id' => $h5pAudioRecorderLibId,
            'dependency_type' => 'editor'
        ]);
    }

    private function getSemantics()
    {
        return '[
  {
    "name": "title",
    "label": "Heading",
    "importance": "high",
    "type": "text",
    "optional": true,
    "placeholder": "Here you can add an optional heading.",
    "description": "The heading you\'d like to show above the image"
  },
  {
    "name": "items",
    "type": "list",
    "label": "Items",
    "entity": "item",
    "widgets": [
      {
        "name": "VerticalTabs",
        "label": "Default"
      }
    ],
    "importance": "medium",
    "min": 2,
    "max": 50,
    "field": {
      "name": "item",
      "type": "group",
      "label": "Item",
      "importance": "low",
      "expanded": true,
      "fields": [
        {
          "name": "image",
          "type": "library",
          "label": "Image",
          "importance": "low",
          "options": [
            "H5P.Image 1.1"
          ],
          "optional": false
        },
        {
          "name": "labelText",
          "label": "Label",
          "importance": "low",
          "type": "text",
          "optional": true,
          "description": "Optional label for a tick. Please make sure it\'s not too long, or it will be hidden."
        },
        {
          "name": "description",
          "type": "text",
          "importance": "low",
          "widget": "html",
          "label": "Description",
          "optional": true,
          "placeholder": "My image description ...",
          "description": "Optional description for the image",
          "enterMode": "p",
          "tags": [
            "strong",
            "em",
            "sub",
            "sup",
            "h3",
            "h4",
            "ul",
            "ol",
            "a",
            "pre",
            "code"
          ]
        },
        {
          "name": "audio",
          "type": "audio",
          "importance": "low",
          "label": "Audio",
          "description": "Optional audio that plays when an image is shown.",
          "optional": true,
          "widgetExtensions": [
            "AudioRecorder"
          ]
        }
      ]
    }
  },
  {
    "name": "behaviour",
    "type": "group",
    "label": "Behavioural settings",
    "importance": "low",
    "description": "These options will let you control how the task behaves.",
    "fields": [
      {
        "name": "startImage",
        "importance": "medium",
        "type": "number",
        "label": "Start image",
        "description": "Set the number of the image to start with.",
        "default": 1,
        "min": 1,
        "max": 50
      },
      {
        "name": "snap",
        "importance": "medium",
        "type": "boolean",
        "label": "Snap slider",
        "description": "If activated, the slider will snap to an image\'s position.",
        "default": true
      },
      {
        "name": "ticks",
        "importance": "medium",
        "type": "boolean",
        "label": "Display tick marks",
        "description": "If activated, the slider bar will display a tick mark for each image.",
        "default": false
      },
      {
        "name": "labels",
        "importance": "medium",
        "type": "boolean",
        "label": "Display labels",
        "description": "If activated, the slider bar will display a label instead of/in addition to tick marks.",
        "default": false
      },
      {
        "name": "transparencyReplacementColor",
        "importance": "medium",
        "type": "text",
        "label": "Transparency Replacement Color",
        "description": "Set the color that will replace transparent areas of the images.",
        "optional": true,
        "default": "#000000",
        "widget": "colorSelector",
        "spectrum": {
          "showInput": true
        }
      },
      {
        "name": "imagesDescriptionsRatio",
        "importance": "medium",
        "type": "number",
        "label": "Image space in fullscreen mode",
        "description": "If you have descriptions in addition to the images, set the the percentage of space that the images should use in fullscreen mode.",
        "default": 70,
        "min": 50,
        "max": 100
      }
    ]
  },
  {
    "name": "a11y",
    "type": "group",
    "common": true,
    "label": "Readspeaker",
    "importance": "low",
    "fields": [
      {
        "name": "image",
        "type": "text",
        "label": "Image",
        "importance": "low",
        "default": "Image"
      },
      {
        "name": "imageSlider",
        "type": "text",
        "label": "Image Slider",
        "importance": "low",
        "default": "Image Slider"
      },
      {
        "name": "mute",
        "type": "text",
        "label": "Mute title",
        "importance": "low",
        "default": "Mute, currently unmuted"
      },
      {
        "name": "unmute",
        "type": "text",
        "label": "Unmute title",
        "importance": "low",
        "default": "Unmute, currently muted"
      },
      {
        "name": "buttonFullscreenEnter",
        "type": "text",
        "label": "Title for fullscreen button (enter)",
        "importance": "low",
        "default": "Enter fullscreen mode"
      },
      {
        "name": "buttonFullscreenExit",
        "type": "text",
        "label": "Title for fullscreen button (exit)",
        "importance": "low",
        "default": "Exit fullscreen mode"
      }
    ]
  }
]';
    }

    private function insertLibrariesLanguages(int $h5pAgamottoLibId)
    {
        DB::table('h5p_libraries_languages')->insert([
            'library_id' => $h5pAgamottoLibId,
            'language_code' => 'bg',
            'translation' => json_encode(json_decode('{"semantics":[{"label":"Заглавие","placeholder":"Тук можете да добавите незадължително заглавие.","description":"Заглавието, което искате да покажете над изображението"},{"label":"Елементи","entity":"елемент","widgets":[{"label":"По подразбиране"}],"field":{"label":"Елемент","fields":[{"label":"Изображение"},{"label":"Етикет","description":"Незадължителен етикет за отметка. Моля, уверете се, че не е много дълъг, или ще бъде скрит."},{"label":"Описание","placeholder":"Описание на моето изображение ...","description":"Незадължително описание на изображението"},{"label":"Audio","description":"Допълнителен звук, който се възпроизвежда, когато се показва изображението."}]}},{"label":"Настройки за поведение","description":"Тези опции ще ви позволят да контролирате как се изпълнява задачата.","fields":[{"label":"Начално изображение","description":"Задайте номера на изображението, с което да се започне."},{"label":"Прикрепена плъзгаща лента","description":"Ако е активиран, плъзгачът ще се прикрепи до позицията на изображението."},{"label":"Показване на отметки","description":"Ако е активирана, плъзгащата лента ще показва отметка за всяко изображение."},{"label":"Показване на етикети","description":"Ако е активирана, плъзгащата лента ще показва етикет вместо / в допълнение към отметки."},{"label":"Цвят, който заменя прозрачната област","description":"Задайте цвят, който ще замени прозрачните области на изображенията."},{"label":"Image space in fullscreen mode","description":"If you have descriptions in addition to the images, set the the percentage of space that the images should use in fullscreen mode."}]},{"label":"Икона за Четец на текст","fields":[{"label":"Изображение","default":"Изображение"},{"label":"Плъзгаща лента с изображения","default":"Плъзгаща лента с изображения"},{"label":"Без звук","default":"Без звук"},{"label":"Включване на звука","default":"Включване на звука"},{"label":"Title for fullscreen button (enter)","default":"Enter fullscreen mode"},{"label":"Title for fullscreen button (exit)","default":"Exit fullscreen mode"}]}]}'), JSON_PRETTY_PRINT|JSON_UNESCAPED_UNICODE)
        ]);

        DB::table('h5p_libraries_languages')->insert([
            'library_id' => $h5pAgamottoLibId,
            'language_code' => 'cs',
            'translation' => json_encode(json_decode('{"semantics":[{"label":"Nadpis","placeholder":"Zde můžete přidat volitelný nadpis.","description":"Nadpis, který chcete zobrazit nad obrázkem"},{"label":"Položky","entity":"položka","widgets":[{"label":"Výchozí"}],"field":{"label":"Položka","fields":[{"label":"Obrázek"},{"label":"Popisek","description":"Volitelné označení pozice obrazu. Ujistěte se, že to není příliš dlouhé, nebo bude skryté."},{"label":"Popis","placeholder":"Můj popis obrázku ...","description":"Volitelný popis obrázku"},{"label":"Zvuk","description":"Když se zobrazí obrázek přehraje se volitelný zvuk."}]}},{"label":"Nastavení chování","description":"Tyto možnosti vám umožní řídit, jak se bude úloha chovat.","fields":[{"label":"Počáteční obrázek","description":"Nastavte číslo obrázku, který má začít."},{"label":"Posuvník snímků","description":"Pokud je aktivováno, posuvník se zachytí na pozici obrázku."},{"label":"Zobrazit pozici obrázku","description":"Pokud je aktivována, posuvná lišta zobrazí pozici každého obrázku."},{"label":"Zobrazit popisky","description":"Pokud je aktivována, posuvná lišta zobrazí popisek namísto/vedle pozice."},{"label":"Barva na výměnu průhlednosti","description":"Nastavte barvu, která nahradí průhledné oblasti obrázků."},{"label":"Prostor obrázku v režimu celé obrazovky","description":"Pokud kromě obrázků máte i popisy, nastavte procento prostoru, které mají obrázky v režimu celé obrazovky využívat."}]},{"label":"Čtecí zařízení","fields":[{"label":"Obrázek","default":"Obrázek"},{"label":"Posuvník obrázku","default":"Posuvník obrázku"},{"label":"Nadpis ztlumit","default":"Ztlumit, momentálně zapnuto"},{"label":"Nadpis zesílit","default":"Zesílit, momentálně ztlumeno"},{"label":"Nadpis tlačítka na celou obrazovku (zahájit)","default":"Zahájit režim celé obrazovky"},{"label":"Název tlačítka pro celou obrazovku (ukončení)","default":"Ukončit režim celé obrazovky"}]}]}'), JSON_PRETTY_PRINT|JSON_UNESCAPED_UNICODE)
        ]);

        DB::table('h5p_libraries_languages')->insert([
            'library_id' => $h5pAgamottoLibId,
            'language_code' => 'de',
            'translation' => json_encode(json_decode('{"semantics":[{"label":"Überschrift","placeholder":"Hier kannst du optional einen Titel angeben.","description":"Der Titel, der über dem Bild angezeigt werden soll"},{"label":"Elemente","entity":"Element","widgets":[{"label":"Eingabemaske"}],"field":{"label":"Element","fields":[{"label":"Bild"},{"label":"Beschriftung","description":"Optionale Beschriftung für eine Bildposition. Bitte stelle sicher, dass sie nicht zu lang ist, sonst wird sie nicht angezeigt."},{"label":"Beschreibung","placeholder":"Meine Bildbeschreibung ...","description":"Optionale Beschreibung für das Bild"},{"label":"Tondatei","description":"Optionale Tondatei, die abgespielt wird, wenn ein Bild angezeigt wird."}]}},{"label":"Verhaltenseinstellungen","description":"Diese Optionen kontrollieren, wie sich die Aufgabe verhält.","fields":[{"label":"Startbild","description":"Setzte hier die Nummer des Startbilds."},{"label":"Schieberegler einrasten","description":"Wenn diese Option aktiviert ist, wird der Schieberegler an den Bildpositionen einrasten."},{"label":"Bildpositionen anzeigen","description":"Wenn diese Option aktiviert ist, werden die Bildpositionen am Schieberegler markiert."},{"label":"Beschriftungen anzeigen","description":"Wenn diese Option aktiviert ist, werden beim Schieberegler Beschriftungen zusätzlich/alternativ zu den Bildpositionen angezeigt."},{"label":"Ersatzfarbe für Transparenz","description":"Setze hier die Farbe, durch die transparente Bereiche in den Bildern ersetzt werden."},{"label":"Bildanteil im Vollbildmodus","description":"Falls du Beschreibungen zu den Bildern hinzugefügt hast, setze hier den Prozentsatz des Platzes, den Bilder im Vollbildmodus einnehmen sollen."}]},{"label":"Vorlesewerkzeug (Barrierefreiheit)","fields":[{"label":"Bild","default":"Bild"},{"label":"Schieberegler für Bilder","default":"Schieberegler für Bilder"},{"label":"Beschriftung des \"Stummschalten\"-Buttons","default":"Stummschalten, ist laut"},{"label":"Beschriftung des \"Lautschalten\"-Buttons","default":"Lautschalten, ist stumm"},{"label":"Titel des Vollbild-Buttons (aktivieren)","default":"Gehe in den Vollbildmodus"},{"label":"Titel des Vollbild-Buttons (deaktivieren)","default":"Verlasse den Vollbildmodus"}]}]}'), JSON_PRETTY_PRINT|JSON_UNESCAPED_UNICODE)
        ]);

        DB::table('h5p_libraries_languages')->insert([
            'library_id' => $h5pAgamottoLibId,
            'language_code' => 'el',
            'translation' => json_encode(json_decode('{"semantics":[{"label":"Τίτλος","placeholder":"Εδώ μπορείτε να προσθέσετε έναν τίτλο (προαιρετικό).","description":"Ο τίτλος που θα θέλατε να εμφανίζεται πάνω από την εικόνα"},{"label":"Στοιχεία","entity":"στοιχειου","widgets":[{"label":"Βασικό"}],"field":{"label":"Στοιχείο","fields":[{"label":"Εικόνα"},{"label":"Ετικέτα","description":"Προαιρετική ετικέτα σημείου επιλογής. Βεβαιωθείτε ότι δεν είναι εκτενής ειδάλλως δεν θα εμφανίζεται."},{"label":"Περιγραφή","placeholder":"Η περιγραφή της εικόνας μου...","description":"Περιγραφή της εικόνας (προαιρετικό)"},{"label":"Ήχος","description":"Προαιρετικός ήχος που αναπαράγεται όταν εμφανίζεται μια εικόνα."}]}},{"label":"Ρυθμίσεις άσκησης","description":"Αυτές οι ρυθμίσεις σας επιτρέπουν να καθορίσετε τον τρόπο λειτουργίας της άσκησης.","fields":[{"label":"Εικόνα εκκίνησης","description":"Ορίστε τον αριθμό της εικόνας εκκίνησης."},{"label":"Σταθεροποίηση μπάρας εναλλαγής εικόνων","description":"Αν ενεργοποιηθεί, η μπάρα εναλλαγής εικόνων θα σταθεροποιηθεί στη θέση μιας εικόνας."},{"label":"Εμφάνιση σημείων επιλογής","description":"Αν είναι ενεργοποιημένη, η μπάρα εναλλαγής εικόνων θα εμφανίσει ένα σημείο επιλογής για κάθε εικόνα."},{"label":"Εμφάνιση ετικετών","description":"Αν ενεργοποιηθεί, η μπάρα εναλλαγής εικόνων θα εμφανίσει μια ετικέτα αντί για/εκτός από τα σημάδια επιλογής."},{"label":"Χρώμα αντί για διαφάνεια","description":"Επιλέξτε το χρώμα που θα αντικαταστήσει τα διάφανα τμήματα των εικόνων."},{"label":"Μέγεθος εικόνας σε λειτουργία πλήρους οθόνης","description":"Εάν έχετε περιγραφές εκτός από τις εικόνες, ορίστε το ποσοστό του χώρου που θα πρέπει να χρησιμοποιούν οι εικόνες στη λειτουργία πλήρους οθόνης."}]},{"label":"Ακουστική υποβοήθηση","fields":[{"label":"Εικόνα","default":"Εικόνα"},{"label":"Slider εικόνας","default":"Slider εικόνας"},{"label":"Κείμενο για σίγαση","default":"Σίγαση, για την ώρα χωρίς σίγαση"},{"label":"Κείμενο για κατάργηση σίγασης","default":"Κατάργηση σίγασης, προς το παρόν σε σίγαση"},{"label":"Κείμενο για κουμπί προβολής πλήρους οθόνης (είσοδος)","default":"Είσοδος σε προβολή πλήρους οθόνης"},{"label":"Κείμενο για κουμπί προβολής πλήρους οθόνης (έξοδος)","default":"Έξοδος από την προβολή πλήρους οθόνης"}]}]}'), JSON_PRETTY_PRINT|JSON_UNESCAPED_UNICODE)
        ]);

        DB::table('h5p_libraries_languages')->insert([
            'library_id' => $h5pAgamottoLibId,
            'language_code' => 'es-mx',
            'translation' => json_encode(json_decode('{"semantics":[{"label":"Encabezado","placeholder":"Aquí puede añadir un encabezado opcional.","description":"El encabezado que le gustaría mostrar encima de la imagen"},{"label":"Elementos","entity":"elemento","widgets":[{"label":"Predeterminado"}],"field":{"label":"Elemento","fields":[{"label":"Imagen"},{"label":"Etiqueta","description":"Etiqueta opcional para una casilla. Por favor, asegúrese que no sea demasiado larga, o de lo contrario se ocultará."},{"label":"Descripción","placeholder":"Descripción de mi imagen...","description":"Descripción opcional para la imagen"},{"label":"Audio","description":"Audio opcional que se reproduce cuando se muestra una imagen."}]}},{"label":"Configuraciones del comportamiento","description":"Estas opciones le permitirán controlar como se comporta el trabajo.","fields":[{"label":"Imagen inicial","description":"Configurar el número de la imagen con la cual iniciar."},{"label":"Deslizador ajustado a la imagen","description":"Si esta opción está activada, el deslizador se ajustará a la posición de la imagen."},{"label":"Mostrar marcas de verificación","description":"Si esta opción está activada, la barra deslizante mostrará una marca de verificación para cada imagen."},{"label":"Mostrar etiquetas","description":"Si esta opción está activada, la barra deslizante muestra una etiqueta en lugar de/además de las marcas de verificación."},{"label":"Color de Reemplazo de Transparencia","description":"Configurar el color que remplazará las áreas transparentes de las imágenes."},{"label":"Espacio de la imagen en modo de pantalla completa","description":"Si tiene descripciones además de las imágenes, configurar el porcentaje del espacio que debería usar la imagen en modo de pantalla completa."}]},{"label":"Lector de texto en voz alta","fields":[{"label":"Imagen","default":"Imagen"},{"label":"Control deslizante de imagen","default":"Control deslizante de imagen"},{"label":"Título Mudo","default":"Mudo, actualmente sonoro"},{"label":"Activar sonido del título","default":"Activar sonido, actualmente silenciado"},{"label":"Título para botón de pantalla completa (introducir)","default":"Entrar a modo de pantalla completa"},{"label":"Título para botón de pantalla completa (salir)","default":"Salir del modo de PantallaCompleta"}]}]}'), JSON_PRETTY_PRINT|JSON_UNESCAPED_UNICODE)
        ]);

        DB::table('h5p_libraries_languages')->insert([
            'library_id' => $h5pAgamottoLibId,
            'language_code' => 'es',
            'translation' => json_encode(json_decode('{"semantics":[{"label":"Encabezado","placeholder":"Aquí puedes añadir un encabezado opcional.","description":"El encabezado que te gustaría mostrar encima de la imagen"},{"label":"Elementos","entity":"elemento","widgets":[{"label":"Por defecto"}],"field":{"label":"Elemento","fields":[{"label":"Imagen"},{"label":"Etiqueta","description":"Etiqueta opcional para una casilla. Por favor, asegúrese que no sea demasiado larga o de lo contrario se ocultará."},{"label":"Descripción","placeholder":"Descripción de mi imagen...","description":"Descripción opcional para la imagen"},{"label":"Audio","description":"Audio opcional que se reproduce cuando se muestra una imagen."}]}},{"label":"Configuración del comportamiento","description":"Estas opciones le permitirán controlar como se comporta la tarea.","fields":[{"label":"Imagen inicial","description":"Configurar el número de la imagen con la que iniciar."},{"label":"Deslizador ajustado a la imagen","description":"Si esta opción está activada, el deslizador se ajustará a la posición de la imagen."},{"label":"Mostrar marcas de verificación","description":"Si esta opción está activada, la barra deslizante mostrará una marca de verificación para cada imagen."},{"label":"Mostrar etiquetas","description":"Si esta opción está activada, la barra deslizante muestra una etiqueta en lugar de/además de las marcas de verificación."},{"label":"Color de Reemplazo de Transparencia","description":"Configurar el color que reemplazará las áreas transparentes de las imágenes."},{"label":"Espacio de la imagen en modo de pantalla completa","description":"Si tiene descripciones además de imágenes, configure el porcentaje de espacio que debería usar la imagen en modo de pantalla completa."}]},{"label":"Lector de pantalla","fields":[{"label":"Imagen","default":"Imagen"},{"label":"Control deslizante de imagen","default":"Control deslizante de imagen"},{"label":"Título para Silenciar","default":"Silenciar, sonido activado en este momento"},{"label":"Título para Activar sonido","default":"Activar sonido, actualmente silenciado"},{"label":"Título para botón de pantalla completa (entrar)","default":"Modo de pantalla completa"},{"label":"Título para botón de pantalla completa (salir)","default":"Salir de Pantalla Completa"}]}]}'), JSON_PRETTY_PRINT|JSON_UNESCAPED_UNICODE)
        ]);

        DB::table('h5p_libraries_languages')->insert([
            'library_id' => $h5pAgamottoLibId,
            'language_code' => 'et',
            'translation' => json_encode(json_decode('{"semantics":[{"label":"Pealkiri","placeholder":"Siin saad lisada valikulise pealkirja.","description":"Pealkiri, mida sa tahaksid pildi kohal näidata"},{"label":"Objektid","entity":"objekt","widgets":[{"label":"Vaikimisi"}],"field":{"label":"Objekt","fields":[{"label":"Pilt"},{"label":"Silt","description":"Valikuline silt klõpsu jaoks. Vaata üle, et see ei oleks liiga pikk, muidu pole seda näha."},{"label":"Kirjeldus","placeholder":"Minu pildi kirjeldus ...","description":"Valikuline kirjeldus pildi kohta"},{"label":"Audio","description":"Optional audio that plays when an image is shown."}]}},{"label":"Käitumise seaded","description":"Need seaded lasevad sul juhtida, kuidas ülesanne käitub.","fields":[{"label":"Alguspilt","description":"Seadista alguspildi number."},{"label":"Klõpsuga liugur","description":"Kui aktiveeritud, siis liugur klõpsatab pildi asukohale."},{"label":"Näita klõpsukohti","description":"Kui aktiveeritud, siis liuguri riba kuvab klõpsukoha iga pildi kohta."},{"label":"Näita silte","description":"Kui aktiveeritud, siis liuguri riba näitab silte klõpsukohtade asemel / lisaks klõpsukohtadele."},{"label":"Nähtamatuse asendamise värv","description":"Seadista värv, mis asendab piltide nähtamatud alad."},{"label":"Image space in fullscreen mode","description":"If you have descriptions in addition to the images, set the the percentage of space that the images should use in fullscreen mode."}]},{"label":"Lugeja","fields":[{"label":"Pilt","default":"Pilt"},{"label":"Image Slider","default":"Image Slider"},{"label":"Mute title","default":"Vaigista, praegu heli aktiivne"},{"label":"Unmute title","default":"Aktiveeri heli, praegu vaigistatud"},{"label":"Title for fullscreen button (enter)","default":"Enter fullscreen mode"},{"label":"Title for fullscreen button (exit)","default":"Exit fullscreen mode"}]}]}'), JSON_PRETTY_PRINT|JSON_UNESCAPED_UNICODE)
        ]);

        DB::table('h5p_libraries_languages')->insert([
            'library_id' => $h5pAgamottoLibId,
            'language_code' => 'it',
            'translation' => json_encode(json_decode('{"semantics":[{"label":"Intestazione","placeholder":"Qui puoi aggiungere un\'intestazione aggiuntiva","description":"L\'intestazione che ti piacerebbe mostrare sopra l\'immagine"},{"label":"Item","entity":"item","widgets":[{"label":"Predefinito"}],"field":{"label":"Item","fields":[{"label":"Immagine"},{"label":"Etichetta","description":"Etichetta facoltativa per un segno di spunta. Assicurati che non sia troppo lunga o verrà nascosta"},{"label":"Descrizione","placeholder":"La descrizione della mia immagine...","description":"Descrizione facoltativa per l\'immagine"},{"label":"Audio","description":"Optional audio that plays when an image is shown."}]}},{"label":"Impostazioni di esecuzione","description":"Queste opzioni ti permettono di controllare il comportamento del compito","fields":[{"label":"Immagine di avvio","description":"Imposta il numero dell\'immagine con cui iniziare"},{"label":"Cursore a scatto","description":"Se attivato, il cursore salterà alla posizione di un\'immagine"},{"label":"Visualizza i segni di spunta","description":"Se attivata, la barra del cursore visualizzerà un segno di spunta per ogni immagine"},{"label":"Visualizza etichette","description":"Se attivata, la barra del cursore visualizzerà un\'etichetta invece o in aggiunta ai segni di spunta"},{"label":"Colore di sostituzione della trasparenza","description":"Imposta il colore che sostituirà le aree di trasparenza delle immagini"},{"label":"Image space in fullscreen mode","description":"If you have descriptions in addition to the images, set the the percentage of space that the images should use in fullscreen mode."}]},{"label":"Lettore vocale","fields":[{"label":"Immagine","default":"Immagine"},{"label":"Image Slider","default":"Image Slider"},{"label":"Mute title","default":"Mute"},{"label":"Unmute title","default":"Unmute"},{"label":"Title for fullscreen button (enter)","default":"Enter fullscreen mode"},{"label":"Title for fullscreen button (exit)","default":"Exit fullscreen mode"}]}]}'), JSON_PRETTY_PRINT|JSON_UNESCAPED_UNICODE)
        ]);

        DB::table('h5p_libraries_languages')->insert([
            'library_id' => $h5pAgamottoLibId,
            'language_code' => 'nb',
            'translation' => json_encode(json_decode('{"semantics":[{"label":"Overskrift","placeholder":"Du kan legge til en valgfri overskrift her.","description":"Overskriften til å vise over bildet"},{"label":"Elementer","entity":"element","widgets":[{"label":"Standard"}],"field":{"label":"Element","fields":[{"label":"Bilde"},{"label":"Merking","description":"Optional label for a tick. Please make sure it\'s not too long, or it will be hidden."},{"label":"Description","placeholder":"My image description ...","description":"Optional description for the image"},{"label":"Audio","description":"Optional audio that plays when an image is shown."}]}},{"label":"Behavioural settings","description":"These options will let you control how the task behaves.","fields":[{"label":"Start image","description":"Set the number of the image to start with."},{"label":"Snap slider","description":"If activated, the slider will snap to an image\'s position."},{"label":"Display tick marks","description":"If activated, the slider bar will display a tick mark for each image."},{"label":"Display labels","description":"If activated, the slider bar will display a label instead of/in addition to tick marks."},{"label":"Transparency Replacement Color","description":"Set the color that will replace transparent areas of the images."},{"label":"Image space in fullscreen mode","description":"If you have descriptions in addition to the images, set the the percentage of space that the images should use in fullscreen mode."}]},{"label":"Readspeaker","fields":[{"label":"Image","default":"Image"},{"label":"Image Slider","default":"Image Slider"},{"label":"Mute title","default":"Demp, for tiden ikke dempet"},{"label":"Unmute title","default":"Slå på demp, for tiden dempet"},{"label":"Title for fullscreen button (enter)","default":"Enter fullscreen mode"},{"label":"Title for fullscreen button (exit)","default":"Exit fullscreen mode"}]}]}'), JSON_PRETTY_PRINT|JSON_UNESCAPED_UNICODE)
        ]);

        DB::table('h5p_libraries_languages')->insert([
            'library_id' => $h5pAgamottoLibId,
            'language_code' => 'nl',
            'translation' => json_encode(json_decode('{"semantics":[{"label":"Koptekst","placeholder":"Hier kunt u een optionele koptekst toevoegen.","description":"De koptekst die u wilt tonen boven de afbeelding"},{"label":"Items","entity":"item","widgets":[{"label":"Standaard"}],"field":{"label":"Item","fields":[{"label":"Afbeelding"},{"label":"Label","description":"Optioneel label voor een afbeeldingspositie. Let op, maak deze niet te lang, want anders wordt deze niet getoond."},{"label":"Beschrijving","placeholder":"Mijn afbeeldingsbeschrijving ...","description":"Optionele beschrijving van de afbeelding"},{"label":"Audio","description":"Optionele audio die speelt wanneer een afbeelding wordt getoond."}]}},{"label":"Gedragsinstellingen","description":"Met deze opties kun je bepalen hoe de opgave zich gedraagt.","fields":[{"label":"Startafbeelding","description":"Stel het nummer in van de afbeelding om mee te starten."},{"label":"Uitlijnen schuifregelaar","description":"Indien geactiveerd, zal de schuifregelaar naar een afbeeldingspositie glijden."},{"label":"Toon afbeeldingsposities","description":"Indien geactiveerd, zal de schuifregelaar voor elke afbeelding de positie markeren."},{"label":"Toon labels","description":"Indien geactiveerd, zal de schuifregelaar de labels tonen in plaats van/of als aanvulling op de afbeeldingposities."},{"label":"Vervangende kleur voor transparant","description":"Stel de kleur in die de transparante gebieden van de afbeeldingen vervangt."},{"label":"Afbeeldingsruimte in volledig scherm modus","description":"Als je beschrijvingen hebt bij de afbeeldingen, stel dan het percentage van de ruimte voor de afbeeldingen in volledige scherm modus in."}]},{"label":"Schermlezer","fields":[{"label":"Afbeelding","default":"Afbeelding"},{"label":"Afbeeldingsschuifregelaar","default":"Afbeeldingsschuifregelaar"},{"label":"Titel voor \"Dempen aan\"-knop","default":"Dempen aan, is nu uit"},{"label":"Titel voor \"Dempen uit\"-knop","default":"Dempen uit, is nu aan"},{"label":"Titel voor volledig scherm knop (enter)","default":"Start volledig scherm modus"},{"label":"Titel voor volledig scherm knop (afsluiten)","default":"Sluit volledig scherm modus"}]}]}'), JSON_PRETTY_PRINT|JSON_UNESCAPED_UNICODE)
        ]);

        DB::table('h5p_libraries_languages')->insert([
            'library_id' => $h5pAgamottoLibId,
            'language_code' => 'ru',
            'translation' => json_encode(json_decode('{"semantics":[{"label":"Заголовок","placeholder":"По желанию напишите сюда заголовок.","description":"Заголовок, отображающийся над изображением"},{"label":"Пункты","entity":"пункт","widgets":[{"label":"По умолчанию"}],"field":{"label":"Пункт","fields":[{"label":"Изображение"},{"label":"Метка","description":"По желанию метка для галочки. Чтобы она была видна, пишите коротко"},{"label":"Описание","placeholder":"Описание изображения...","description":"Описание изображения по желанию"},{"label":"Audio","description":"Optional audio that plays when an image is shown."}]}},{"label":"Настройки поведения","description":"Настройте обратную связь при выполнении задания","fields":[{"label":"Первичное изображение","description":"Установите количество первичных изображений"},{"label":"Кнопка слайда","description":"Если активировано, кнопка переместиться на позицию изображения"},{"label":"Показать галочку","description":"Если активировано, кнопка слайдера будет отображать галочку у каждого изобажения."},{"label":"Показать метки","description":"Если активировано, слайдер будет отображать метки вместо или вместе с галочкой."},{"label":"Цвет фона при смене изображения","description":"Выберите цвет, который будет отображаться на прозрачной части фона при смене изображений."},{"label":"Image space in fullscreen mode","description":"If you have descriptions in addition to the images, set the the percentage of space that the images should use in fullscreen mode."}]},{"label":"Ассистирующие технологии","fields":[{"label":"Изображение","default":"Изображение"},{"label":"Слайдер изображения","default":"Слайдер изображения"},{"label":"Mute title","default":"Mute"},{"label":"Unmute title","default":"Unmute"},{"label":"Title for fullscreen button (enter)","default":"Enter fullscreen mode"},{"label":"Title for fullscreen button (exit)","default":"Exit fullscreen mode"}]}]}'), JSON_PRETTY_PRINT|JSON_UNESCAPED_UNICODE)
        ]);

        DB::table('h5p_libraries_languages')->insert([
            'library_id' => $h5pAgamottoLibId,
            'language_code' => 'sma',
            'translation' => json_encode(json_decode('{"semantics":[{"label":"Heading","placeholder":"Here you can add an optional heading.","description":"The heading you\'d like to show above the image"},{"label":"Items","entity":"item","widgets":[{"label":"Default"}],"field":{"label":"Item","fields":[{"label":"Image"},{"label":"Label","description":"Optional label for a tick. Please make sure it\'s not too long, or it will be hidden."},{"label":"Description","placeholder":"My image description ...","description":"Optional description for the image"},{"label":"Audio","description":"Optional audio that plays when an image is shown."}]}},{"label":"Behavioural settings","description":"These options will let you control how the task behaves.","fields":[{"label":"Start image","description":"Set the number of the image to start with."},{"label":"Snap slider","description":"If activated, the slider will snap to an image\'s position."},{"label":"Display tick marks","description":"If activated, the slider bar will display a tick mark for each image."},{"label":"Display labels","description":"If activated, the slider bar will display a label instead of/in addition to tick marks."},{"label":"Transparency Replacement Color","description":"Set the color that will replace transparent areas of the images."},{"label":"Image space in fullscreen mode","description":"If you have descriptions in addition to the images, set the the percentage of space that the images should use in fullscreen mode."}]},{"label":"Readspeaker","fields":[{"label":"Image","default":"Image"},{"label":"Image Slider","default":"Image Slider"},{"label":"Mute title","default":"Mute"},{"label":"Unmute title","default":"Unmute"},{"label":"Title for fullscreen button (enter)","default":"Enter fullscreen mode"},{"label":"Title for fullscreen button (exit)","default":"Exit fullscreen mode"}]}]}'), JSON_PRETTY_PRINT|JSON_UNESCAPED_UNICODE)
        ]);

        DB::table('h5p_libraries_languages')->insert([
            'library_id' => $h5pAgamottoLibId,
            'language_code' => 'sme',
            'translation' => json_encode(json_decode('{"semantics":[{"label":"Heading","placeholder":"Here you can add an optional heading.","description":"The heading you\'d like to show above the image"},{"label":"Items","entity":"item","widgets":[{"label":"Default"}],"field":{"label":"Item","fields":[{"label":"Image"},{"label":"Label","description":"Optional label for a tick. Please make sure it\'s not too long, or it will be hidden."},{"label":"Description","placeholder":"My image description ...","description":"Optional description for the image"},{"label":"Audio","description":"Optional audio that plays when an image is shown."}]}},{"label":"Behavioural settings","description":"These options will let you control how the task behaves.","fields":[{"label":"Start image","description":"Set the number of the image to start with."},{"label":"Snap slider","description":"If activated, the slider will snap to an image\'s position."},{"label":"Display tick marks","description":"If activated, the slider bar will display a tick mark for each image."},{"label":"Display labels","description":"If activated, the slider bar will display a label instead of/in addition to tick marks."},{"label":"Transparency Replacement Color","description":"Set the color that will replace transparent areas of the images."},{"label":"Image space in fullscreen mode","description":"If you have descriptions in addition to the images, set the the percentage of space that the images should use in fullscreen mode."}]},{"label":"Readspeaker","fields":[{"label":"Image","default":"Image"},{"label":"Image Slider","default":"Image Slider"},{"label":"Mute title","default":"Mute"},{"label":"Unmute title","default":"Unmute"},{"label":"Title for fullscreen button (enter)","default":"Enter fullscreen mode"},{"label":"Title for fullscreen button (exit)","default":"Exit fullscreen mode"}]}]}'), JSON_PRETTY_PRINT|JSON_UNESCAPED_UNICODE)
        ]);

        DB::table('h5p_libraries_languages')->insert([
            'library_id' => $h5pAgamottoLibId,
            'language_code' => 'smj',
            'translation' => json_encode(json_decode('{"semantics":[{"label":"Heading","placeholder":"Here you can add an optional heading.","description":"The heading you\'d like to show above the image"},{"label":"Items","entity":"item","widgets":[{"label":"Default"}],"field":{"label":"Item","fields":[{"label":"Image"},{"label":"Label","description":"Optional label for a tick. Please make sure it\'s not too long, or it will be hidden."},{"label":"Description","placeholder":"My image description ...","description":"Optional description for the image"},{"label":"Audio","description":"Optional audio that plays when an image is shown."}]}},{"label":"Behavioural settings","description":"These options will let you control how the task behaves.","fields":[{"label":"Start image","description":"Set the number of the image to start with."},{"label":"Snap slider","description":"If activated, the slider will snap to an image\'s position."},{"label":"Display tick marks","description":"If activated, the slider bar will display a tick mark for each image."},{"label":"Display labels","description":"If activated, the slider bar will display a label instead of/in addition to tick marks."},{"label":"Transparency Replacement Color","description":"Set the color that will replace transparent areas of the images."},{"label":"Image space in fullscreen mode","description":"If you have descriptions in addition to the images, set the the percentage of space that the images should use in fullscreen mode."}]},{"label":"Readspeaker","fields":[{"label":"Image","default":"Image"},{"label":"Image Slider","default":"Image Slider"},{"label":"Mute title","default":"Mute"},{"label":"Unmute title","default":"Unmute"},{"label":"Title for fullscreen button (enter)","default":"Enter fullscreen mode"},{"label":"Title for fullscreen button (exit)","default":"Exit fullscreen mode"}]}]}'), JSON_PRETTY_PRINT|JSON_UNESCAPED_UNICODE)
        ]);
    }
}
