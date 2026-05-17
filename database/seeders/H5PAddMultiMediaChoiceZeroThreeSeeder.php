<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class H5PAddMultiMediaChoiceZeroThreeSeeder extends Seeder
{
    public function run()
    {
        $params = ['name' => "H5P.MultiMediaChoice", "major_version" => 0, "minor_version" => 3];
        $lib = DB::table('h5p_libraries')->where($params)->first();

        if (empty($lib)) {
            $libId = DB::table('h5p_libraries')->insertGetId([
                'name' => 'H5P.MultiMediaChoice',
                'title' => 'Multimedia Choice',
                'major_version' => 0,
                'minor_version' => 3,
                'patch_version' => 77,
                'embed_types' => 'iframe',
                'runnable' => 1,
                'restricted' => 0,
                'fullscreen' => 0,
                'preloaded_js' => 'dist/h5p-multi-media-choice.js',
                'preloaded_css' => 'dist/h5p-multi-media-choice.css',
                'drop_library_css' => '',
                'semantics' => $this->getSemantics(),
                'tutorial_url' => ' ',
                'has_icon' => 1
            ]);

            $this->insertDependentLibraries($libId);
            $this->insertLibrariesLanguages($libId);
        }
    }

    private function insertDependentLibraries($libId)
    {
        $h5pQuestionParams = ['name' => "H5P.Question", "major_version" => 1, "minor_version" => 5];
        $h5pQuestionLib = DB::table('h5p_libraries')->where($h5pQuestionParams)->first();
        $h5pQuestionLibId = $h5pQuestionLib->id;
        DB::table('h5p_libraries_libraries')->insert(['library_id' => $libId, 'required_library_id' => $h5pQuestionLibId, 'dependency_type' => 'preloaded']);

        $h5pJoubelUIParams = ['name' => "H5P.JoubelUI", "major_version" => 1, "minor_version" => 3];
        $h5pJoubelUILib = DB::table('h5p_libraries')->where($h5pJoubelUIParams)->first();
        $h5pJoubelUILibId = $h5pJoubelUILib->id;
        DB::table('h5p_libraries_libraries')->insert(['library_id' => $libId, 'required_library_id' => $h5pJoubelUILibId, 'dependency_type' => 'preloaded']);

        $h5pImageParams = ['name' => "H5P.Image", "major_version" => 1, "minor_version" => 1];
        $h5pImageLib = DB::table('h5p_libraries')->where($h5pImageParams)->first();
        $h5pImageLibId = $h5pImageLib->id;
        DB::table('h5p_libraries_libraries')->insert(['library_id' => $libId, 'required_library_id' => $h5pImageLibId, 'dependency_type' => 'preloaded']);

        $h5pMDIconsParams = ['name' => "H5P.MaterialDesignIcons", "major_version" => 1, "minor_version" => 0];
        $h5pMDIconsLib = DB::table('h5p_libraries')->where($h5pMDIconsParams)->first();
        $h5pMDIconsLibId = $h5pMDIconsLib->id;
        DB::table('h5p_libraries_libraries')->insert(['library_id' => $libId, 'required_library_id' => $h5pMDIconsLibId, 'dependency_type' => 'preloaded']);

        $h5pComponentsParams = ['name' => "H5P.Components", "major_version" => 1, "minor_version" => 0];
        $h5pComponentsLib = DB::table('h5p_libraries')->where($h5pComponentsParams)->first();
        $h5pComponentsLibId = $h5pComponentsLib->id;
        DB::table('h5p_libraries_libraries')->insert(['library_id' => $libId, 'required_library_id' => $h5pComponentsLibId, 'dependency_type' => 'preloaded']);

        $h5pRangeListParams = ['name' => "H5PEditor.RangeList", "major_version" => 1, "minor_version" => 0];
        $h5pRangeListLib = DB::table('h5p_libraries')->where($h5pRangeListParams)->first();
        $h5pRangeListLibId = $h5pRangeListLib->id;
        DB::table('h5p_libraries_libraries')->insert(['library_id' => $libId, 'required_library_id' => $h5pRangeListLibId, 'dependency_type' => 'editor']);

        $h5pShowWhenParams = ['name' => "H5PEditor.ShowWhen", "major_version" => 1, "minor_version" => 0];
        $h5pShowWhenLib = DB::table('h5p_libraries')->where($h5pShowWhenParams)->first();
        $h5pShowWhenLibId = $h5pShowWhenLib->id;
        DB::table('h5p_libraries_libraries')->insert(['library_id' => $libId, 'required_library_id' => $h5pShowWhenLibId, 'dependency_type' => 'editor']);
    }

    private function getSemantics()
    {
        return '[
  {
    "name": "media",
    "type": "group",
    "label": "Media",
    "importance": "medium",
    "fields": [
      {
        "name": "type",
        "type": "library",
        "label": "Type",
        "importance": "medium",
        "options": [
          "H5P.Image 1.1",
          "H5P.Video 1.6",
          "H5P.Audio 1.5"
        ],
        "optional": true,
        "description": "Optional media to display above the question."
      },
      {
        "name": "disableImageZooming",
        "type": "boolean",
        "label": "Disable image zooming",
        "importance": "low",
        "default": false,
        "optional": true,
        "widget": "showWhen",
        "showWhen": {
          "rules": [
            {
              "field": "type",
              "equals": "H5P.Image 1.1"
            }
          ]
        }
      }
    ]
  },
  {
    "name": "question",
    "type": "text",
    "importance": "high",
    "widget": "html",
    "label": "Question",
    "enterMode": "p",
    "tags": [
      "strong",
      "em",
      "sub",
      "sup",
      "h2",
      "h3",
      "pre",
      "code"
    ]
  },
  {
    "name": "options",
    "type": "list",
    "importance": "high",
    "label": "Available options",
    "entity": "option",
    "min": 2,
    "max": 20,
    "defaultNum": 2,
    "field": {
      "name": "option",
      "type": "group",
      "label": "Option",
      "importance": "high",
      "fields": [
        {
          "name": "media",
          "type": "library",
          "label": "Media",
          "optional": false,
          "description": "Media to display as a choice.",
          "options": [
            "H5P.Image 1.1",
            "H5P.Video 1.6",
            "H5P.Audio 1.5"
          ]
        },
        {
          "name": "poster",
          "type": "image",
          "label": "Poster image",
          "importance": "low",
          "widget": "showWhen",
          "showWhen": {
            "rules": [
              {
                "field": "media",
                "equals": "H5P.Audio 1.5"
              }
            ]
          }
        },
        {
          "name": "correct",
          "type": "boolean",
          "label": "Correct",
          "importance": "low"
        }
      ]
    }
  },
  {
    "name": "overallFeedback",
    "type": "group",
    "label": "Overall Feedback",
    "importance": "low",
    "expanded": true,
    "fields": [
      {
        "name": "overallFeedback",
        "type": "list",
        "widgets": [
          {
            "name": "RangeList",
            "label": "Default"
          }
        ],
        "importance": "high",
        "label": "Define custom feedback for any score range",
        "description": "Click the \\"Add range\\" button to add as many ranges as you need. Example: 0-20% Bad score, 21-91% Average Score, 91-100% Great Score!",
        "entity": "range",
        "min": 1,
        "defaultNum": 1,
        "optional": true,
        "field": {
          "name": "overallFeedback",
          "type": "group",
          "importance": "low",
          "fields": [
            {
              "name": "from",
              "type": "number",
              "label": "Score Range",
              "min": 0,
              "max": 100,
              "default": 0,
              "unit": "%"
            },
            {
              "name": "to",
              "type": "number",
              "min": 0,
              "max": 100,
              "default": 100,
              "unit": "%"
            },
            {
              "name": "feedback",
              "type": "text",
              "label": "Feedback for defined score range",
              "importance": "low",
              "placeholder": "Fill in the feedback",
              "optional": true
            }
          ]
        }
      }
    ]
  },
  {
    "name": "behaviour",
    "type": "group",
    "label": "Behavioural settings",
    "importance": "low",
    "description": "These options will let you control how the task behaves.",
    "fields": [
      {
        "name": "enableRetry",
        "label": "Enable \\"Retry\\" button",
        "type": "boolean",
        "importance": "low",
        "default": true,
        "optional": true
      },
      {
        "name": "enableSolutionsButton",
        "label": "Enable \\"Show Solution\\" button",
        "type": "boolean",
        "importance": "low",
        "default": true,
        "optional": true
      },
      {
        "name": "confirmCheckDialog",
        "label": "Show confirmation dialog on \\"Check\\"",
        "importance": "low",
        "type": "boolean",
        "default": false,
        "optional": true
      },
      {
        "name": "confirmRetryDialog",
        "label": "Show confirmation dialog on \\"Retry\\"",
        "importance": "low",
        "type": "boolean",
        "default": false,
        "optional": true
      },
      {
        "name": "singlePoint",
        "type": "boolean",
        "label": "Give one point for the whole question",
        "importance": "low",
        "description": "Awards one point to the question if the percentage score is higher than the pass percentage",
        "default": false
      },
      {
        "label": "Require answer before the solution can be viewed",
        "importance": "low",
        "name": "showSolutionsRequiresInput",
        "type": "boolean",
        "default": true,
        "optional": true
      },
      {
        "name": "questionType",
        "type": "select",
        "label": "Question Type",
        "importance": "low",
        "description": "Select the look and behaviour of the question.",
        "default": "auto",
        "options": [
          {
            "value": "auto",
            "label": "Automatic"
          },
          {
            "value": "multi",
            "label": "Multiple Choice (Checkboxes)"
          },
          {
            "value": "single",
            "label": "Single Choice (Radio Buttons)"
          }
        ]
      },
      {
        "name": "aspectRatio",
        "type": "select",
        "label": "Aspect ratio",
        "importance": "low",
        "description": "Select the aspect ratio of the alternatives",
        "default": "auto",
        "options": [
          {
            "value": "auto",
            "label": "Automatic"
          },
          {
            "value": "16to9",
            "label": "16:9"
          },
          {
            "value": "4to3",
            "label": "4:3"
          },
          {
            "value": "3to2",
            "label": "3:2"
          },
          {
            "value": "1to1",
            "label": "1:1"
          }
        ]
      },
      {
        "name": "maxAlternativesPerRow",
        "type": "select",
        "label": "Maximum alternatives per row",
        "description": "Set the maximum number of alternatives per row to ensure the questions look alright.",
        "default": "4",
        "options": [
          {
            "value": "1",
            "label": "1"
          },
          {
            "value": "2",
            "label": "2"
          },
          {
            "value": "3",
            "label": "3"
          },
          {
            "value": "4",
            "label": "4"
          }
        ]
      },
      {
        "label": "Pass percentage",
        "name": "passPercentage",
        "type": "number",
        "description": "This setting often won\'t have any effect. It is the percentage of the total score required for getting 1 point when one point for the entire task is enabled, and for getting result.success in xAPI statements.",
        "min": 0,
        "max": 100,
        "step": 1,
        "default": 100
      }
    ]
  },
  {
    "name": "l10n",
    "type": "group",
    "common": true,
    "label": "User interface",
    "importance": "low",
    "fields": [
      {
        "name": "checkAnswerButtonText",
        "type": "text",
        "label": "Text for \\"Check\\" button",
        "importance": "low",
        "default": "Check"
      },
      {
        "name": "submitAnswerButtonText",
        "type": "text",
        "label": "Text for \\"Submit\\" button",
        "importance": "low",
        "default": "Submit"
      },
      {
        "name": "checkAnswer",
        "type": "text",
        "label": "Assistive technology description for \\"Check\\" button",
        "importance": "low",
        "default": "Check the answers. The responses will be marked as correct, incorrect, or unanswered."
      },
      {
        "name": "showSolutionButtonText",
        "type": "text",
        "label": "Text for \\"Show solution\\" button",
        "importance": "low",
        "default": "Show solution"
      },
      {
        "name": "showSolution",
        "type": "text",
        "label": "Assistive technology description for \\"Show Solution\\" button",
        "importance": "low",
        "default": "Show the solution. The correct options will be marked."
      },
      {
        "name": "correctAnswer",
        "type": "text",
        "label": "Correct Answer (not displayed)",
        "importance": "low",
        "default": "Correct answer"
      },
      {
        "name": "wrongAnswer",
        "type": "text",
        "label": "Wrong Answer (not displayed)",
        "importance": "low",
        "default": "Wrong answer"
      },
      {
        "name": "shouldCheck",
        "type": "text",
        "label": "Option should have been checked",
        "importance": "low",
        "default": "Should have been checked",
        "optional": true
      },
      {
        "name": "shouldNotCheck",
        "type": "text",
        "label": "Option should not have been checked",
        "importance": "low",
        "default": "Should not have been checked",
        "optional": true
      },
      {
        "label": "Text for \\"Requires answer\\" message",
        "importance": "low",
        "name": "noAnswer",
        "type": "text",
        "default": "Please answer before viewing the solution",
        "optional": true
      },
      {
        "name": "retryText",
        "type": "text",
        "label": "Text for \\"Retry\\" button",
        "importance": "low",
        "default": "Retry"
      },
      {
        "name": "retry",
        "type": "text",
        "label": "Assistive technology description for \\"Retry\\" button",
        "importance": "low",
        "default": "Retry the task. Reset all responses and start the task over again."
      },
      {
        "name": "result",
        "type": "text",
        "label": "Your result",
        "description": ":num and :total are variables and will be replaced by their respective values.",
        "importance": "low",
        "default": "You got :num out of :total points"
      },
      {
        "label": "Check confirmation dialog",
        "importance": "low",
        "name": "confirmCheck",
        "type": "group",
        "common": true,
        "fields": [
          {
            "label": "Header text",
            "importance": "low",
            "name": "header",
            "type": "text",
            "default": "Finish?"
          },
          {
            "label": "Body text",
            "importance": "low",
            "name": "body",
            "type": "text",
            "default": "Are you sure you want to finish?",
            "widget": "html",
            "enterMode": "p",
            "tags": [
              "strong",
              "em",
              "del",
              "u",
              "code"
            ]
          },
          {
            "label": "Cancel button label",
            "importance": "low",
            "name": "cancelLabel",
            "type": "text",
            "default": "Cancel"
          },
          {
            "label": "Confirm button label",
            "importance": "low",
            "name": "confirmLabel",
            "type": "text",
            "default": "Finish"
          }
        ]
      },
      {
        "label": "Retry confirmation dialog",
        "importance": "low",
        "name": "confirmRetry",
        "type": "group",
        "common": true,
        "fields": [
          {
            "label": "Header text",
            "importance": "low",
            "name": "header",
            "type": "text",
            "default": "Retry?"
          },
          {
            "label": "Body text",
            "importance": "low",
            "name": "body",
            "type": "text",
            "default": "Are you sure you wish to retry?",
            "widget": "html",
            "enterMode": "p",
            "tags": [
              "strong",
              "em",
              "del",
              "u",
              "code"
            ]
          },
          {
            "label": "Cancel button label",
            "importance": "low",
            "name": "cancelLabel",
            "type": "text",
            "default": "Cancel"
          },
          {
            "label": "Confirm button label",
            "importance": "low",
            "name": "confirmLabel",
            "type": "text",
            "default": "Retry"
          }
        ]
      },
      {
        "label": "Text if alt text is missing for an image",
        "importance": "low",
        "name": "missingAltText",
        "type": "text",
        "default": "Alt text missing"
      },
      {
        "label": "Close modal button label",
        "importance": "low",
        "name": "closeModalText",
        "type": "text",
        "default": "Close modal"
      }
    ]
  }
]';
    }

    private function insertLibrariesLanguages(int $libId)
    {
        DB::table('h5p_libraries_languages')->insert([
            'library_id' => $libId,
            'language_code' => 'en',
            'translation' => json_encode(json_decode('{"semantics":[{"label":"Media","fields":[{"label":"Type","description":"Optional media to display above the question."},{"label":"Disable image zooming"}]},{"label":"Question"},{"label":"Available options","entity":"option","field":{"label":"Option","fields":[{"label":"Media","description":"Media to display as a choice."},{"label":"Poster image"},{"label":"Correct"}]}},{"label":"Overall Feedback","fields":[{"widgets":[{"label":"Default"}],"label":"Define custom feedback for any score range","description":"Click the \"Add range\" button to add as many ranges as you need. Example: 0-20% Bad score, 21-91% Average Score, 91-100% Great Score!","entity":"range","field":{"fields":[{"label":"Score Range"},{},{"label":"Feedback for defined score range","placeholder":"Fill in the feedback"}]}}]},{"label":"Behavioural settings","description":"These options will let you control how the task behaves.","fields":[{"label":"Enable \"Retry\" button"},{"label":"Enable \"Show Solution\" button"},{"label":"Show confirmation dialog on \"Check\""},{"label":"Show confirmation dialog on \"Retry\""},{"label":"Give one point for the whole question","description":"Awards one point to the question if the percentage score is higher than the pass percentage"},{"label":"Require answer before the solution can be viewed"},{"label":"Question Type","description":"Select the look and behaviour of the question.","options":[{"label":"Automatic"},{"label":"Multiple Choice (Checkboxes)"},{"label":"Single Choice (Radio Buttons)"}]},{"label":"Aspect ratio","description":"Select the aspect ratio of the alternatives","options":[{"label":"Automatic"},{"label":"16:9"},{"label":"4:3"},{"label":"3:2"},{"label":"1:1"}]},{"label":"Maximum alternatives per row","description":"Set the maximum number of alternatives per row to ensure the questions look alright.","options":[{"label":"1"},{"label":"2"},{"label":"3"},{"label":"4"}]},{"label":"Pass percentage","description":"This setting often won\'t have any effect. It is the percentage of the total score required for getting 1 point when one point for the entire task is enabled, and for getting result.success in xAPI statements."}]},{"label":"User interface","fields":[{"label":"Text for \"Check\" button","default":"Check"},{"label":"Text for \"Submit\" button","default":"Submit"},{"label":"Assistive technology description for \"Check\" button","default":"Check the answers. The responses will be marked as correct, incorrect, or unanswered."},{"label":"Text for \"Show solution\" button","default":"Show solution"},{"label":"Assistive technology description for \"Show Solution\" button","default":"Show the solution. The correct options will be marked."},{"label":"Correct Answer (not displayed)","default":"Correct answer"},{"label":"Wrong Answer (not displayed)","default":"Wrong answer"},{"label":"Option should have been checked","default":"Should have been checked"},{"label":"Option should not have been checked","default":"Should not have been checked"},{"label":"Text for \"Requires answer\" message","default":"Please answer before viewing the solution"},{"label":"Text for \"Retry\" button","default":"Retry"},{"label":"Assistive technology description for \"Retry\" button","default":"Retry the task. Reset all responses and start the task over again."},{"label":"Your result","description":":num and :total are variables and will be replaced by their respective values.","default":"You got :num out of :total points"},{"label":"Check confirmation dialog","fields":[{"label":"Header text","default":"Finish?"},{"label":"Body text","default":"Are you sure you want to finish?"},{"label":"Cancel button label","default":"Cancel"},{"label":"Confirm button label","default":"Finish"}]},{"label":"Retry confirmation dialog","fields":[{"label":"Header text","default":"Retry?"},{"label":"Body text","default":"Are you sure you wish to retry?"},{"label":"Cancel button label","default":"Cancel"},{"label":"Confirm button label","default":"Retry"}]},{"label":"Text if alt text is missing for an image","default":"Alt text missing"},{"label":"Close modal button label","default":"Close modal"}]}]}'), JSON_PRETTY_PRINT|JSON_UNESCAPED_UNICODE)
        ]);

        DB::table('h5p_libraries_languages')->insert([
            'library_id' => $libId,
            'language_code' => 'de',
            'translation' => json_encode(json_decode('{"semantics":[{"label":"Medium","fields":[{"label":"Typ","description":"Medium, das wahlweise oberhalb der Aufgabe angezeigt wird."},{"label":"Bild-Zoom deaktivieren"}]},{"label":"Frage"},{"label":"Verfügbare Optionen","entity":"Option","field":{"label":"Option","fields":[{"label":"Medium","description":"Media to display as a choice."},{"label":"Poster image"},{"label":"Richtig"}]}},{"label":"Gesamtrückmeldung","fields":[{"widgets":[{"label":"Voreinstellung"}],"label":"Lege Rückmeldungen für einzelne Punktebereiche fest","description":"Klicke auf den \"Bereich hinzufügen\"-Button, um so viele Bereiche hinzuzufügen, wie du brauchst. Beispiel: 0-20% Schlechte Punktzahl, 21-91% Durchschnittliche Punktzahl, 91-100% Großartige Punktzahl!","entity":"Bereich","field":{"fields":[{"label":"Punktebereich"},{},{"label":"Rückmeldung für jeweiligen Punktebereich","placeholder":"Trage die Rückmeldung ein"}]}}]},{"label":"Verhaltenseinstellungen","description":"Diese Optionen kontrollieren, wie sich die Aufgabe verhält.","fields":[{"label":"\"Wiederholen\"-Button anzeigen"},{"label":"\"Lösung zeigen\"-Button anzeigen"},{"label":"Zeige Bestätigungsdialog bei \"Überprüfen\""},{"label":"Zeige Bestätigungsdialog bei \"Wiederholen\""},{"label":"Gib einen Punkt für die ganze Aufgabe","description":"Vergibt einen Punkt für die Aufgabe, falls der prozentuale Punktestand größer ist als der zum Bestehen benötigte"},{"label":"Lösung wird erst angezeigt, wenn eine Antwort eingegeben wurde"},{"label":"Frageart","description":"Wähle Aussehen und Verhalten der Frage.","options":[{"label":"Automatisch"},{"label":"Multiple Choice (Checkboxen)"},{"label":"Single Choice (Radio Buttons)"}]},{"label":"Seitenverhältnis","description":"Wähle das Seitenverhältnis der Alternativen","options":[{"label":"Automatisch"},{"label":"16:9"},{"label":"4:3"},{"label":"3:2"},{"label":"1:1"}]},{"label":"Maximale Zahl der Alternativen pro Zeile","description":"Setze die maximale Zahl der Alternativen pro Zeile, um eine gute Optik zu gewährleisten.","options":[{"label":"1"},{"label":"2"},{"label":"3"},{"label":"4"}]},{"label":"Prozentsatz zum Bestehen","description":"Diese Einstellung hat oft keinen Effekt. Wenn aktiviert ist, dass es nur einen einzigen Punkt für die ganze Aufgabe gibt, dann beschreibt die Einstellung den Prozentsatz der Gesamtpunktzahl, die zum Erhalt eines Punktes nötig ist und für \"result.success\" in xAPI-Statements."}]},{"label":"Bedienoberfläche","fields":[{"label":"Beschriftung des \"Überprüfen\"-Buttons","default":"Prüfen"},{"label":"Beschriftung des \"Absenden\"-Buttons","default":"Submit"},{"label":"Beschreibung des \"Überprüfen\"-Buttons (für Hilfsmittel zur Barrierefreiheit)","default":"Die Antworten überprüfen. Die Eingaben werden als richtig, falsch oder unbeantwortet markiert."},{"label":"Beschriftung des \"Lösung anzeigen\"-Buttons","default":"Lösung anzeigen"},{"label":"Beschreibung des \"Lösung anzeigen\"-Buttons (für Hilfsmittel zur Barrierefreiheit)","default":"Zeige die Lösung. Die korrekten Optionen werden markiert."},{"label":"Richtige Antwort (nicht dargestellt)","default":"Richtige Antwort"},{"label":"Falsche Antwort (nicht dargestellt)","default":"Falsche Antwort"},{"label":"Option hätte gewählt werden müssen","default":"Hätte gewählt werden müssen"},{"label":"Option hätte nicht gewählt werden sollen","default":"Hätte nicht gewählt werden sollen"},{"label":"Text für \"Erfordert Antwort\"-Hinweis","default":"Bitte antworte, bevor du die Lösung ansiehst"},{"label":"Beschriftung des \"Wiederholen\"-Buttons","default":"Wiederholen"},{"label":"Beschreibung des \"Wiederholen\"-Buttons (für Hilfsmittel zur Barrierefreiheit)","default":"Die Aufgabe wiederholen. Alle Versuche werden zurückgesetzt und die Aufgabe wird erneut gestartet."},{"label":"Dein Ergebnis","description":":num und :total sind Platzhalter und werden durch die entsprechenden Werte ersetzt.","default":"Du hast :num von :total Punkten erreicht"},{"label":"Bestätigungsdialog beim Überprüfen","fields":[{"label":"Text der Überschrift","default":"Beenden?"},{"label":"Text des Hauptteils","default":"Bist du sicher, dass du die Aufgabe beenden möchtest?"},{"label":"Beschriftung des \"Abbrechen\"-Buttons","default":"Abbrechen"},{"label":"Beschriftung des \"Bestätigen\"-Buttons","default":"Beenden"}]},{"label":"Bestätigungsdialog beim Wiederholen","fields":[{"label":"Text der Überschrift","default":"Wiederholen?"},{"label":"Text des Hauptteils","default":"Ganz sicher wiederholen?"},{"label":"Beschriftung des \"Abbrechen\"-Buttons","default":"Abbrechen"},{"label":"Beschriftung des \"Bestätigen\"-Buttons","default":"Wiederholen"}]},{"label":"Text, der benutzt wird, falls kein Alternativtext für ein Bild angegeben wird","default":"Kein Alternativtext angegeben"},{"label":"Close modal button label","default":"Close modal"}]}]}'), JSON_PRETTY_PRINT|JSON_UNESCAPED_UNICODE)
        ]);

        DB::table('h5p_libraries_languages')->insert([
            'library_id' => $libId,
            'language_code' => 'el',
            'translation' => json_encode(json_decode('{"semantics":[{"label":"Μέσα","fields":[{"label":"Τύπος","description":"Προαιρετικά μέσα που θα εμφανίζονται πάνω από την ερώτηση."},{"label":"Απενεργοποίηση της μεγέθυνσης εικόνας"}]},{"label":"Ερώτηση"},{"label":"Διαθέσιμες επιλογές","entity":"επιλογή","field":{"label":"Επιλογή","fields":[{"label":"Μέσα","description":"Μέσα που θα εμφανίζονται ως επιλογή."},{"label":"Εικόνα Poster"},{"label":"Σωστό"}]}},{"label":"Συνολική ανατροφοδότηση","fields":[{"widgets":[{"label":"Προεπιλογή"}],"label":"Ορισμός προσαρμοσμένης ανατροφοδότησης για οποιοδήποτε εύρος βαθμολογίας","description":"Κάντε κλικ στο κουμπί \"Προσθήκη εύρους\" για να προσθέσετε όσα εύρη χρειάζεστε. Παράδειγμα: 0-20% Κακή βαθμολογία, 21-91% Μέση βαθμολογία, 91-100% Άριστη βαθμολογία!","entity":"Εύρος","field":{"fields":[{"label":"Εύρος βαθμολογίας"},{},{"label":"Ανατροφοδότηση για το καθορισμένο εύρος βαθμολογίας","placeholder":"Εισάγετε την ανατροφοδότηση"}]}}]},{"label":"Ρυθμίσεις συμπεριφοράς","description":"Αυτές οι επιλογές θα σας επιτρέψουν να ελέγξετε τον τρόπο συμπεριφοράς της εργασίας","fields":[{"label":"Ενεργοποίηση του κουμπιού \"Επανάληψη\""},{"label":"Ενεργοποίηση του κουμπιού \"Εμφάνιση απάντησης\""},{"label":"Εμφάνιση διαλόγου επιβεβαίωσης κατά τον έλεγχο"},{"label":"Εμφάνιση διαλόγου επιβεβαίωσης κατά την επανάληψη"},{"label":"Δώστε έναν βαθμό για το σύνολο της ερώτησης","description":"Δίνει έναν βαθμό για την ερώτηση εάν το ποσοστό βαθμολογίας είναι υψηλότερο από το ποσοστό επιτυχίας"},{"label":"Απαιτείται απάντηση πριν από την προβολή της λύσης"},{"label":"Τύπος ερώτησης","description":"Επιλέξτε την εμφάνιση και τη συμπεριφορά της ερώτησης.","options":[{"label":"Αυτόματο"},{"label":"Πολλαπλής επιλογής (Checkboxes)"},{"label":"Επιλογής (Radio Buttons)"}]},{"label":"Αναλογία διαστάσεων","description":"Επιλέξτε την αναλογία διαστάσεων των εναλλακτικών λύσεων","options":[{"label":"Αυτόματο"},{"label":"16:9"},{"label":"4:3"},{"label":"3:2"},{"label":"1:1"}]},{"label":"Μεγίστες εναλλακτικές ανά γραμμή","description":"Ορίστε τον μέγιστο αριθμό εναλλακτικών επιλογών ανά γραμμή για να διασφαλίσετε ότι οι ερωτήσεις φαίνονται εντάξει.","options":[{"label":"1"},{"label":"2"},{"label":"3"},{"label":"4"}]},{"label":"Ποσοστό επιτυχίας","description":"Αυτή η ρύθμιση συχνά δεν θα έχει κανένα αποτέλεσμα. Είναι το ποσοστό της συνολικής βαθμολογίας που απαιτείται για τη λήψη ενός βαθμού όταν είναι ενεργοποιημένη η λήψης ενός βαθμού για ολόκληρη την εργασία και για τη λήψη result.success κατά την χρήση xAPI."}]},{"label":"Διεπαφή χρήστη","fields":[{"label":" Κείμενο για το κουμπί \"Έλεγχος\"","default":"Έλεγχος"},{"label":"Κείμενο για το κουμπί \"Υποβολή\"","default":"Υποβολή"},{"label":"Περιγραφή υποστηρικτικής τεχνολογίας για το κουμπί \" Έλεγχος\"","default":"Ελέγξτε τις απαντήσεις. Οι απαντήσεις θα επισημαίνονται ως σωστές, λανθασμένες ή απαντημένες."},{"label":"Κείμενο για το κουμπί \"Εμφάνιση Απάντησης\"","default":"Εμφάνιση απάντησης"},{"label":"Περιγραφή υποστηρικτικής τεχνολογίας για το κουμπί \"Εμφάνιση Απάντησης\"","default":"Εμφάνιση της απάντησης. Οι σωστές επιλογές θα επισημαίνονται."},{"label":"Σωστή απάντηση (δεν εμφανίζεται)","default":"Σωστή απάντηση"},{"label":"Λάθος απάντηση (δεν εμφανίζεται)","default":"Λάθος απάντηση"},{"label":"Επιλογή που έπρεπε να έχει επιλεγεί","default":"Έπρεπε να έχει επιλεγεί"},{"label":"Επιλογή που δεν έπρεπε να έχει επιλεγεί","default":"Δεν έπρεπε να έχει επιλεγεί"},{"label":"Κείμενο μηνύματος \"Απαιτείται απάντηση\"","default":"Παρακαλούμε απαντήστε πριν προβάλετε τη λύση"},{"label":"Κείμενο για το κουμπί \"Επανάληψη\"","default":"Επανάληψη"},{"label":"Περιγραφή υποστηρικτικής τεχνολογίας για το κουμπί \"Επανάληψη\"","default":"Επανάληψη της εργασίας. Επαναφέρετε όλες τις απαντήσεις και ξεκινήστε την εργασία από την αρχή."},{"label":"Το αποτέλεσμά σας","description":":num και :total είναι μεταβλητές και θα αντικατασταθούν από τις αντίστοιχες τιμές τους.","default":"Πήρατε :num από :total βαθμούς"},{"label":"Διάλογος επιβεβαίωσης ελέγχου","fields":[{"label":"Κείμενο επικεφαλίδας","default":"Ολοκλήρωση;"},{"label":"Κείμενο σώματος","default":"Θέλετε σίγουρα να ολοκληρώσετε την προσπάθεια;"},{"label":"Ετικέτα κουμπιού ακύρωσης","default":"Άκυρο"},{"label":"Ετικέτα κουμπιού επιβεβαίωσης","default":"Εντάξει"}]},{"label":"Διάλογος επιβεβαίωσης επανάληψης","fields":[{"label":"Κείμενο επικεφαλίδας","default":"Επανάληψη;"},{"label":"Κείμενο σώματος","default":"Θέλετε σίγουρα να ξαναπροσπαθήσετε;"},{"label":"Ετικέτα κουμπιού ακύρωσης","default":"Άκυρο"},{"label":"Ετικέτα κουμπιού επανάληψης","default":"Επανάληψη"}]},{"label":"Κείμενο εάν λείπει το εναλλακτικό κείμενο για μια εικόνα","default":"Λείπει το εναλλακτικό κείμενο"},{"label":"Ετικέτα κουμπιού κλεισίματος παραθύρου","default":"Κλείσιμο παραθύρου"}]}]}'), JSON_PRETTY_PRINT|JSON_UNESCAPED_UNICODE)
        ]);

        DB::table('h5p_libraries_languages')->insert([
            'library_id' => $libId,
            'language_code' => 'es-mx',
            'translation' => json_encode(json_decode('{"semantics":[{"label":"Medios","fields":[{"label":"Tipo","description":"Medios opcionales mostrados encima de la pregunta."},{"label":"Deshabilitar acercamiento de imagen"}]},{"label":"Pregunta"},{"label":"Opciones disponibles","entity":"opción","field":{"label":"Opción","fields":[{"label":"Medio","description":"Medio a mostrar como una opción."},{"label":"Imagen del poster"},{"label":"Correcto"}]}},{"label":"Retroalimentación Global","fields":[{"widgets":[{"label":"Predeterminado"}],"label":"Definir retroalimentación personalizada para cualquier rango de puntaje","description":"Haga clic en el botón \"Añadir rango\" para añadir cuantos rangos necesite. Ejemplo: 0-20% Mal puntaje, 21-91% Puntaje Promedio, 91-100% ¡Magnífico Puntaje!","entity":"rango","field":{"fields":[{"label":"Rango del Puntaje"},{},{"label":"Retroalimentación para rango de puntaje definido","placeholder":"Complete la retroalimentación"}]}}]},{"label":"Configuraciones del comportamiento","description":"Estas opciones le permitirán controlar como se comporta el trabajo.","fields":[{"label":"Habilitar botón \"Reintentar\""},{"label":"Habilitar botón \"Mostrar Solución\""},{"label":"Mostrar diálogo de confirmación en \"Comprobar\""},{"label":"Mostrar el diálogo de confirmación en \"Reintentar\""},{"label":"Dar un punto para la pregunta completa","description":"Otorga un punto a la pregunta si el puntaje en porcentaje es mayor que el porcentaje aprobatorio"},{"label":"Requerir respuesta antes de que se pueda ver la solución"},{"label":"Tipo de Pregunta","description":"Seleccione el aspecto y comportamiento de la pregunta.","options":[{"label":"Automático"},{"label":"Opción Múltiple (Casillas de Verificación)"},{"label":"Selección Única (Botones)"}]},{"label":"Proporción de aspecto","description":"Seleccionar la proporción de aspecto de las alternativas","options":[{"label":"Automático"},{"label":"16:9"},{"label":"4:3"},{"label":"3:2"},{"label":"1:1"}]},{"label":"Alternativas máximas por fila","description":"Configurar el número máximo de alternativas por fila para asegurar que la pregunta se vea bien.","options":[{"label":"1"},{"label":"2"},{"label":"3"},{"label":"4"}]},{"label":"Porcentaje aprobatorio","description":"Esta configuración a menudo no tendrá ningún efecto. Es el porcentaje del puntaje total requerido para obtener 1 punto cuando se habilita un punto para todo el trabajo, y para obtener un result.success en declaraciones xAPI."}]},{"label":"Interfaz del usuario","fields":[{"label":"Texto para botón \"Comprobar\"","default":"Comprobar"},{"label":"Texto para botón \"Enviar\"","default":"Submit"},{"label":"Descripción de tecnología asistiva para botón \"Comprobar\"","default":"Comprobar las respuestas. Las respuestas serán marcadas como correcta, incorrecta, o sin contestar."},{"label":"Texto para botón \"Mostrar solución\"","default":"Mostrar solución"},{"label":"Descripción de tecnología asistiva para botón \"Mostrar Solución\"","default":"Mostrar la solución. Las opciones correctas serán marcadas."},{"label":"Respuesta Correcta (no se muestra)","default":"Respuesta correcta"},{"label":"Respuesta Incorrecta (no mostrada)","default":"Respuesta incorrecta"},{"label":"La opción debería de haberse seleccionado","default":"Debería de haberse seleccionado"},{"label":"La opción no debería de haberse seleccionado","default":"No debería haber sido seleccionada"},{"label":"Texto para mensaje \"Requiere respuesta\"","default":"Por favor responda antes de ver la solución"},{"label":"Texto para botón \"Reintentar\"","default":"Reintentar"},{"label":"Descripción de tecnología asistiva para botón \"Reintentar\"","default":"Reintentar el trabajo. Reiniciar todas las respuestas e iniciar el trabajo de nuevo."},{"label":"Su resultado","description":":num y :total son variables y serán remplazadas por sus respectivos valores.","default":"Obtuvo :num de un total de :total puntos"},{"label":"Diálogo de confirmación para Comprobar","fields":[{"label":"Texto del encabezado","default":"¿Terminado?"},{"label":"Texto del cuerpo","default":"¿Está seguro de querer termina?"},{"label":"Etiqueta botón Cancelar","default":"Cancelar"},{"label":"Etiqueta del botón Confirmar","default":"Terminar"}]},{"label":"Diálogo de confirmación Reintentar","fields":[{"label":"Texto del encabezado","default":"¿Reintentar?"},{"label":"Texto del cuerpo","default":"¿Seguro que desea reintentar?"},{"label":"Etiqueta botón Cancelar","default":"Cancelar"},{"label":"Etiqueta del botón Confirmar","default":"Reintentar"}]},{"label":"Texto si faltara el texto alterno para una imagen","default":"Falta el texto alterno"},{"label":"Etiqueta de cierre de botón modal","default":"Cerrar modal"}]}]}'), JSON_PRETTY_PRINT|JSON_UNESCAPED_UNICODE)
        ]);

        DB::table('h5p_libraries_languages')->insert([
            'library_id' => $libId,
            'language_code' => 'es',
            'translation' => json_encode(json_decode('{"semantics":[{"label":"Medios","fields":[{"label":"Tipo","description":"Medios opcionales mostrados encima de la pregunta."},{"label":"Deshabilitar acercamiento de imagen"}]},{"label":"Pregunta"},{"label":"Opciones disponibles","entity":"opción","field":{"label":"Opción","fields":[{"label":"Medios","description":"Medio a mostrar como una opción."},{"label":"Imagen del poster"},{"label":"Correcto"}]}},{"label":"Retroalimentación Global","fields":[{"widgets":[{"label":"Por defecto"}],"label":"Definir retroalimentación personalizada para cualquier rango de puntuación","description":"Haz clic en el botón \"Añadir rango\" para añadir los rangos que necesites. Ejemplo: 0-20% Mala puntuación, 21-91% Puntuación Media, 91-100% ¡Puntuación Estupenda!","entity":"rango","field":{"fields":[{"label":"Rango de puntuación"},{},{"label":"Realimentación para rango de puntuación definido","placeholder":"Escribe tu retroalimentación"}]}}]},{"label":"Configuración del comportamiento","description":"Estas opciones te permitirán controlar como se comporta la tarea.","fields":[{"label":"Habilitar botón \"Intentar de nuevo\""},{"label":"Habilitar botón \"Mostrar Solución\""},{"label":"Mostrar diálogo de confirmación para \"Comprobar\""},{"label":"Mostrar diálogo de confirmación para \"Intentar de nuevo\""},{"label":"Dar un punto a la pregunta completa","description":"Da un punto a la pregunta si el porcentaje de la puntuación es mayor que el porcentaje para aprobar"},{"label":"Requerir respuesta antes de que se pueda ver la solución"},{"label":"Tipo de Pregunta","description":"Selecciona el aspecto y comportamiento de la pregunta.","options":[{"label":"Automático"},{"label":"Opción Múltiple (Casillas de Verificación)"},{"label":"Selección Única (Botones)"}]},{"label":"Proporción de aspecto","description":"Selecciona la proporción de aspecto de las alternativas","options":[{"label":"Automático"},{"label":"16:9"},{"label":"4:3"},{"label":"3:2"},{"label":"1:1"}]},{"label":"Alternativas máximas por fila","description":"Configurar el número máximo de alternativas por fila para asegurar que la pregunta se vea bien.","options":[{"label":"1"},{"label":"2"},{"label":"3"},{"label":"4"}]},{"label":"Porcentaje para aprobar","description":"Esta configuración probablemente no tendrá ningún efecto. Es el porcentaje de la puntuación total requerida para obtener 1 punto cuando se habilita la opción de dar un punto a toda la tarea, y para obtener un result.success en declaraciones xAPI."}]},{"label":"Interfaz de usuario","fields":[{"label":"Texto para botón \"Comprobar\"","default":"Comprobar"},{"label":"Texto para botón \"Enviar\"","default":"Enviar"},{"label":"Descripción para las tecnologías de asistencia del botón \"Comprobar\"","default":"Revisa tus respuestas. Las respuestas se marcarán como correcta, incorrecta o sin contestar."},{"label":"Texto para botón \"Mostrar solución\"","default":"Mostrar solución"},{"label":"Descripción para las tecnologías de asistencia del botón \"Mostrar solución\"","default":"Mostrar la solución. Se marcarán las opciones correctas."},{"label":"Respuesta Correcta (no se muestra)","default":"Respuesta correcta"},{"label":"Respuesta Incorrecta (no mostrada)","default":"Respuesta incorrecta"},{"label":"Deberías haber marcado la opción","default":"Debería haberse marcado"},{"label":"La opción no debería haberse marcado","default":"No debería haber sido marcada"},{"label":"Texto para mensaje \"Requiere respuesta\"","default":"Por favor, responde antes de poder ver la solución"},{"label":"Texto para el botón \"Intentar de nuevo\"","default":"Intentar de nuevo"},{"label":"Descripción para las tecnologías de asistencia del botón \"Intentar de nuevo\"","default":"Vuelve a intentar la tarea. Borra todas tus respuestas y empieza de nuevo."},{"label":"Tu resultado","description":":num y :total son variables y serán remplazadas por sus respectivos valores.","default":"Has conseguido :num de un total de :total puntos"},{"label":"Diálogo de confirmación para Comprobar","fields":[{"label":"Texto del encabezado","default":"¿Has terminado?"},{"label":"Texto del cuerpo","default":"¿Seguro que quieres termina?"},{"label":"Etiqueta botón Cancelar","default":"Cancelar"},{"label":"Etiqueta del botón Confirmar","default":"Terminar"}]},{"label":"Diálogo de confirmación para Intentar de nuevo","fields":[{"label":"Texto del encabezado","default":"¿Intentar de nuevo?"},{"label":"Texto del cuerpo","default":"¿Seguro que quieres volver a intentarlo?"},{"label":"Etiqueta botón Cancelar","default":"Cancelar"},{"label":"Etiqueta del botón Confirmar","default":"Intentar de nuevo"}]},{"label":"Texto si falta el texto alternativo para una imagen","default":"Falta el texto alternativo"},{"label":"Etiqueta de cierre de botón modal","default":"Cerrar botón modal"}]}]}'), JSON_PRETTY_PRINT|JSON_UNESCAPED_UNICODE)
        ]);

        DB::table('h5p_libraries_languages')->insert([
            'library_id' => $libId,
            'language_code' => 'eu',
            'translation' => json_encode(json_decode('{"semantics":[{"label":"Multimedia","fields":[{"label":"Mota","description":"Galderaren gainean bistaratzeko aukerako multimedia."},{"label":"Desgaitu irudien zooma"}]},{"label":"Galdera"},{"label":"Eskuragarri dauden aukerak","entity":"aukera","field":{"label":"Aukera","fields":[{"label":"Multimedia","description":"Media to display as a choice."},{"label":"Poster image"},{"label":"Zuzena"}]}},{"label":"Feedback Orokorra","fields":[{"widgets":[{"label":"Lehenetsitakoa"}],"label":"Zehaztu ezazu edozein puntuazio-tarterako feedback pertsonalizatua","description":"Egin klik \"Gehitu tartea\" botoian behar dituzun tarte guztiak gehitzeko. Adibidez: 0-20% Puntuazio eskasa, 21-91% Batez besteko puntuazioa, 91-100% Puntuazio bikaina!","entity":"tartea","field":{"fields":[{"label":"Puntuazio tartea"},{},{"label":"Zehaztutako tartearentzako feedbacka","placeholder":"Idatzi ezazu feedbacka"}]}}]},{"label":"Portaera ezarpenak","description":"Aukera hauek portaera kontrolatzea ahalbidetzen dizute.","fields":[{"label":"Gaitu \"Saiatu berriro\" botoia"},{"label":"Gaitu \"Erakutsi emaitza\" botoia"},{"label":"Erakutsi \"Egiaztatu\" botoirako baieztapen-mezua"},{"label":"Erakutsi \"Saiatu berriro\" botoirako baieztapen-mezua"},{"label":"Eman puntu bat galdera guztiarengatik","description":"Galdera guztiarengatik puntu bat ematen du lortutako ehunekoa gainditzeko ehunekoa baino altuagoa bada"},{"label":"Behartu erantzutera emaitza ikusi ahal izan aurretik"},{"label":"Galdera-mota","description":"Aukeratu ezazu galderaren itxura eta portaera.","options":[{"label":"Automatikoa"},{"label":"Aukera Anitza (Laukitxoak)"},{"label":"Aukera Bakarra (aukera bakarreko botoiak)"}]},{"label":"Itxura-proportzioa","description":"Aukeratu ezazu ordezkoen itxura-proportzioa","options":[{"label":"Automatikoa"},{"label":"16:9"},{"label":"4:3"},{"label":"3:2"},{"label":"1:1"}]},{"label":"Gehienezko aukerak errenkadako","description":"Errenkada bakoitzeko gehienezko aukerak zehazten ditu galderak txukun erakutsi daitezen.","options":[{"label":"1"},{"label":"2"},{"label":"3"},{"label":"4"}]},{"label":"Gainditzeko ehunekoa","description":"Ezarpen honek maiz ez du inongo eraginik. Eman puntu bat galdera guztiarengatik gaituta dagoenean hau puntua eskuratzeko lortu beharreko ehunekoa da, baita xAPI eskaeretan result.success itzultzeko ere."}]},{"label":"Erabiltzaile-interfazea","fields":[{"label":"\"Egiaztatu\" botoiarentzako testua","default":"Egiaztatu"},{"label":"\"Bidali\" botoiarentzako testua","default":"Submit"},{"label":"\"Egiaztatu\" botoiaren laguntza-teknologientzako etiketa","default":"Egiaztatu erantzunak. Erantzunak zuzen, oker edo erantzun gabe gisa markatuko dira."},{"label":"\"Erakutsi emaitza\" botoiaren testua","default":"Erakutsi emaitza"},{"label":"\"Erakutsi emaitza\" botoiaren laguntza-teknologientzako etiketa","default":"Erakutsi emaitza. Aukera zuzenak markatuko dira."},{"label":"Erantzun zuzena (erakutsi gabe)","default":"Erantzun zuzena"},{"label":"Erantzun Okerra (ez da erakusten)","default":"Erantzun okerra"},{"label":"Aukerak markatuta egon beharko litzateke","default":"Markatuta egon beharko litzateke"},{"label":"Aukera markatu gabe egon beharko litzateke","default":"Markatu gabe egon beharko litzateke"},{"label":"\"Erantzuna behar du\" mezuarentzako testua","default":"Erantzun ezazu mesedez erantzuna ikusi aurretik"},{"label":"\"Saiatu berriro\" botoiarentzako testua","default":"Saiatu berriro"},{"label":"\"Saiatu berriro\" botoiaren laguntza-teknologientzako etiketa","default":"Zeregina berriz egiten saiatu. Berrabiarazi erantzun guztiak eta hasi zeregina berriz."},{"label":"Zure emaitza","description":":num eta :total euren balioekin ordezkatuko diren aldagaiak dira.","default":":total puntutik :num puntu lortu duzu"},{"label":"Egiaztatzeko baieztapen-mezua","fields":[{"label":"Goiburuko testua","default":"Amaituta?"},{"label":"Gorputzaren testua","default":"Ziur zaude amaitu nahi duzula?"},{"label":"Utzi botoiaren etiketa","default":"Utzi"},{"label":"Berretsi botoiaren etiketa","default":"Amaitu"}]},{"label":"Berriz saiatzeko baieztapen-testua","fields":[{"label":"Goiburuko testua","default":"Saiatu berriro?"},{"label":"Gorputzaren testua","default":"Ziur zaude berriz saiatu nahi duzula?"},{"label":"Utzi botoiaren etiketa","default":"Utzi"},{"label":"Berretsi botoiaren etiketa","default":"Saiatu berriro"}]},{"label":"Testua irudiaren ordezko testua falta bada","default":"Ordezko testua falta da"},{"label":"Close modal button label","default":"Close modal"}]}]}'), JSON_PRETTY_PRINT|JSON_UNESCAPED_UNICODE)
        ]);

        DB::table('h5p_libraries_languages')->insert([
            'library_id' => $libId,
            'language_code' => 'fr',
            'translation' => json_encode(json_decode('{"semantics":[{"label":"Média","fields":[{"label":"Type","description":"Média facultatif pour afficher au-dessus de la question."},{"label":"Bloquer le zoom d’image"}]},{"label":"Question"},{"label":"Options disponibles","entity":"option","field":{"label":"Option","fields":[{"label":"Média","description":"Media to display as a choice."},{"label":"Poster image"},{"label":"Correcte"}]}},{"label":"Feedback général","fields":[{"widgets":[{"label":"Par défaut"}],"label":"Définir un feedback personnalisé pour n\'importe quelle gamme de note","description":"Cliquez sur la touche « Ajouter une gamme » pour ajouter autant de gammes que nécessaire. Exemple : 0-20 % mauvaise note, 21-91 % note moyenne, 91-100 % excellente note !","entity":"gamme","field":{"fields":[{"label":"Gamme de notes"},{},{"label":"Feedback pour une gamme de notes définie","placeholder":"Compléter le feedback"}]}}]},{"label":"Paramètres comportementaux","description":"Ces options vous permettront de contrôler le déroulement de la tâche.","fields":[{"label":"Activer la touche « Réessayer »"},{"label":"Activer la touche « Afficher la solution »"},{"label":"Afficher la boîte de dialogue de confirmation sur « Vérifier »"},{"label":"Afficher la boîte de dialogue de confirmation sur « Réessayer »"},{"label":"Donner un point pour l\'ensemble de la question","description":"Attribue un point à la question si la note en pourcentage est supérieure au pourcentage de réussite"},{"label":"Une réponse est requise avant de pouvoir consulter la solution"},{"label":"Type de question","description":"Sélectionner l\'aspect et le comportement de la question.","options":[{"label":"Automatique"},{"label":"Questions à choix multiples (cases à cocher)"},{"label":"Choix uniques (touches radio)"}]},{"label":"Rapport hauteur/largeur","description":"Sélectionner le rapport hauteur/largeur des alternatives","options":[{"label":"Automatique"},{"label":"16:9"},{"label":"4:3"},{"label":"3:2"},{"label":"1:1"}]},{"label":"Nombre maximum d\'alternatives par ligne","description":"Déterminer le nombre maximum d\'alternatives par ligne afin d\'assurer une bonne présentation des questions.","options":[{"label":"1"},{"label":"2"},{"label":"3"},{"label":"4"}]},{"label":"Pourcentage de réussite","description":"Ce paramètre est souvent sans incidence. Il s\'agit du pourcentage de la note totale requise pour obtenir 1 point lorsqu\'un point pour l\'ensemble de la tâche est activé et pour obtenir result.success dans les déclarations Expérience API."}]},{"label":"Interface utilisateur","fields":[{"label":"Texte pour la touche « Vérifier »","default":"Vérifier"},{"label":"Texte pour la touche « Soumettre »","default":"Soumettre"},{"label":"Description de la technologie fonctionnelle pour la touche « Vérifier »","default":"Vérifier les réponses. Les réponses seront marquées comme correcte, incorrecte ou sans réponse."},{"label":"Texte pour la touche « Afficher la solution »","default":"Afficher la solution"},{"label":"Description de la technologie fonctionnelle pour la touche « Afficher la solution »","default":"Afficher la solution. Les options correctes seront marquées."},{"label":"Réponse correcte (non affichée)","default":"Réponse correcte"},{"label":"Mauvaise réponse (non affichée)","default":"Mauvaise réponse"},{"label":"L\'option aurait due être cochée","default":"Aurait due être cochée"},{"label":"L\'option n\'aurait pas due être cochée","default":"N\'aurait pas due être cochée"},{"label":"Texte pour le message « Requiert une réponse »","default":"Veuillez répondre avant de voir la solution"},{"label":"Texte pour la touche « Réessayer »","default":"Réessayer"},{"label":"Description de la technologie fonctionnelle pour la touche « Réessayer »","default":"Réessayer la tâche. Réinitialiser toutes les réponses et recommencer la tâche."},{"label":"Votre résultat","description":":num et :total sont des variables et seront remplacées par leurs valeurs respectives.","default":"Vous avez obtenu :num sur :total points"},{"label":"Vérifier la boîte de dialogue de confirmation","fields":[{"label":"Texte d’en-tête","default":"Fini ?"},{"label":"Corps du texte","default":"Êtes-vous sûr de vouloir finir ?"},{"label":"Vignette de la touche Annuler","default":"Annuler"},{"label":"Vignette de la touche confirmer","default":"Fini"}]},{"label":"Réessayer la boîte de dialogue de confirmation","fields":[{"label":"Texte d’en-tête","default":"Réessayer ?"},{"label":"Corps du texte","default":"Êtes-vous sûr de vouloir réessayer ?"},{"label":"Vignette de la touche Annuler","default":"Annuler"},{"label":"Vignette de la touche confirmer","default":"Réessayer"}]},{"label":"Texte si le texte alternatif est manquant pour une image","default":"Texte Alt manquant"},{"label":"Close modal button label","default":"Close modal"}]}]}'), JSON_PRETTY_PRINT|JSON_UNESCAPED_UNICODE)
        ]);

        DB::table('h5p_libraries_languages')->insert([
            'library_id' => $libId,
            'language_code' => 'gl',
            'translation' => json_encode(json_decode('{"semantics":[{"label":"Medios","fields":[{"label":"Tipo","description":"Medios adicionais amosados enriba da pregunta."},{"label":"Desactivar zoom da imaxe"}]},{"label":"Pregunta"},{"label":"Opcións dispoñibles","entity":"opción","field":{"label":"Opción","fields":[{"label":"Medios","description":"Media to display as a choice."},{"label":"Poster image"},{"label":"Correcto"}]}},{"label":"Retroalimentación xeral","fields":[{"widgets":[{"label":"Por defecto"}],"label":"Define a retroalimentación por defecto para calquera rango de puntuación","description":"Preme o botón \"Engadir rango\" para engadir tantos rangos como precises. Exemplo: 0-20% Mala Puntuación, 21-91% Puntuación Media, 91-100% Puntuación Xenial!","entity":"rango","field":{"fields":[{"label":"Rango de Puntuación"},{},{"label":"Retroalimentación para rango de puntuación definido","placeholder":"Escribe a retroalimentación"}]}}]},{"label":"Configuración de comportamento","description":"Estas opcións permitiranche controlar o comportamento da tarefa.","fields":[{"label":"Activar o botón \"Tentar de novo\""},{"label":"Activar o botón \"Amosar Solución\""},{"label":"Amosar diálogo de confirmación ao premer en \"Comprobar\""},{"label":"Amosar diálogo de confirmación para \"Tentar de novo\""},{"label":"Dá un punto para toda a pregunta","description":"Concede un punto á pregunta se a puntuación porcentual é superior á porcentaxe de aprobado"},{"label":"Requirir unha resposta antes de poder ver a solución"},{"label":"Tipo de Pregunta","description":"Selecciona o aspecto e comportamento da pregunta.","options":[{"label":"Automático"},{"label":"Escolla Múltiple (Caixas de selección)"},{"label":"Escolla Simple (Botóns de Radio)"}]},{"label":"Relación de aspecto","description":"Selecciona a relación de aspecto das alternativas","options":[{"label":"Automático"},{"label":"16:9"},{"label":"4:3"},{"label":"3:2"},{"label":"1:1"}]},{"label":"Máximo de alternativas por fila","description":"Establece o número máximo de alternativas por fila para garantir que as preguntas teñan a aparencia axeitada.","options":[{"label":"1"},{"label":"2"},{"label":"3"},{"label":"4"}]},{"label":"Porcentaxe para aprobar","description":"Esta opción non ten efecto a miúdo. É a porcentaxe da puntuación total requirida para obter 1 punto cando se activa a opción de obter 1 punto pola tarefa completa, e para obter result.success en sentenzas xAPI."}]},{"label":"Interface de usuario","fields":[{"label":"Texto para o botón \"Comprobar\"","default":"Comprobar"},{"label":"Texto para o botón \"Enviar\"","default":"Enviar"},{"label":"Descrición do botón \"Comprobar\" para as tecnoloxías de asistencia","default":"Comproba as túas respostas. As respostas marcaranse como correctas, incorrectas ou non contestadas."},{"label":"Texto para o botón \"Amosar solución\"","default":"Amosar Resposta"},{"label":"Descrición para as tecnoloxías de asistencia para o botón \"Amosar solución\"","default":"Amosar a solución. Marcaranse as opcións correctas."},{"label":"Resposta Correcta (non amosada)","default":"Resposta Correcta"},{"label":"Resposta Incorrecta (non amosada)","default":"Resposta Incorrecta"},{"label":"Deberíase ter marcado a opción","default":"Deberíase ter marcado"},{"label":"A opción non se debería ter marcado","default":"Non se debería ter marcado"},{"label":"Texto para a mensaxe \"Resposta requirida\"","default":"Por favor, responde antes de ver a solución"},{"label":"Texto para o botón \"Tentar de novo\"","default":"Tentar de novo"},{"label":"Descrición para as tecnoloxías de asistencia do botón \"Tentar de novo\"","default":"Tenta de novo a tarefa. Borra todas as respostas e comeza a tarefa de novo."},{"label":"O teu resultado","description":":num e :total son variables e serán substituídas polos seus respectivos valores.","default":"Conseguiches :num dun total de :total puntos"},{"label":"Diálogo de confirmación de comprobación","fields":[{"label":"Texto de cabeceira","default":"Remataches?"},{"label":"Texto do corpo","default":"Seguro que queres rematar?"},{"label":"Etiqueta para o botón cancelar","default":"Cancelar"},{"label":"Etiqueta para o botón confirmar","default":"Rematar"}]},{"label":"Diálogo de confirmación para tentar de novo","fields":[{"label":"Texto de cabeceira","default":"Tentar de novo?"},{"label":"Texto do corpo","default":"Seguro que queres tentar de novo?"},{"label":"Etiqueta para o botón cancelar","default":"Cancelar"},{"label":"Etiqueta para o botón confirmar","default":"Tentar de novo"}]},{"label":"Texto se falta o texto alternativo para unha imaxe","default":"Falta o texto alternativo"},{"label":"Etiqueta para pechar botón modal","default":"Pechar botón modal"}]}]}'), JSON_PRETTY_PRINT|JSON_UNESCAPED_UNICODE)
        ]);

        DB::table('h5p_libraries_languages')->insert([
            'library_id' => $libId,
            'language_code' => 'ka',
            'translation' => json_encode(json_decode('{"semantics":[{"label":"მედია","fields":[{"label":"ტიპი","description":"არასავალდებული მედია, რომელიც შეკითხვის თავზე გამოჩნდება."},{"label":"სურათის დაზუმების გამორთვა"}]},{"label":"შეკითხვა"},{"label":"ხელმისაწვდომი ვარიანტები","entity":"ვარიანტი","field":{"label":"ვარიანტი","fields":[{"label":"მედია","description":"Media to display as a choice."},{"label":"Poster image"},{"label":"სწორია"}]}},{"label":"საერთო გამოხმაურება","fields":[{"widgets":[{"label":"სტანდარტული"}],"label":"განსაზღვრე უკუკავშირი ქულების ნებისმიერი დიაპაზონისთვის","description":"დააჭირე \"დიაპაზონის დამატების\" ღილაკს, ნებისმიერი რაოდენობის დიაპაზონის დასამატებლად. მაგალითად: 0-20% ცუდი ქულა, 21-91% საშუალო ქულა, 91-100% საუკეთესო ქულა!","entity":"დიაპაზონი","field":{"fields":[{"label":"ქულების დიაპაზონი"},{},{"label":"უკუკავშირი განსაზღვრული შეფასების დიაპაზონისთვის","placeholder":"უკუკავშირის შევსება"}]}}]},{"label":"ქცევის პარამეტრები","description":"ეს პარამეტრები მოგცემთ დავალების ქცევის კონტროლის საშუალებას.","fields":[{"label":"დაუშვი \"თავიდან ცდის\" ღილაკი"},{"label":"დაუშვი \"აჩვენე ამოხსნის\" ღილაკი"},{"label":"დადასტურების დიალოგის ჩვენება \"შემოწმებაზე\""},{"label":"აჩვენე დადასტურების დიალოგი \"თავიდან ცდისას\""},{"label":"მიეცით ერთი ქულა მთელ კითხვაზე","description":"ანიჭებს 1 ქულას კითხვას, თუ პროცენტული ქულა უფრო მაღალია, ვიდრე გადასალახი პროცენტი"},{"label":"მოითხოვე პასუხის დაფიქსირება, სანამ ამოხსნა გამოჩნდება"},{"label":"შეკითხვის ტიპი","description":"აირჩიე შეკითხვის შესახედაობა და ქცევა.","options":[{"label":"ავტომატური"},{"label":"არჩევითბოლოიანი შეკითხვა (მოსანიშნები)"},{"label":"ერთი არჩევანი (რადიო ღილაკები)"}]},{"label":"ასპექტის თანაფარდობა","description":"აირჩიეთ ალტერნატივების ასპექტის თანაფარდობა","options":[{"label":"ავტომატური"},{"label":"16:9"},{"label":"4:3"},{"label":"3:2"},{"label":"1:1"}]},{"label":"მაქსიმალური ალტერნატივები რიგზე","description":"დააყენეთ ალტერნატივების მაქსიმალური რაოდენობა მწკრივზე, რათა უზრუნველყოთ კითხვები კარგად გამოიყურებოდეს.","options":[{"label":"1"},{"label":"2"},{"label":"3"},{"label":"4"}]},{"label":"გადალახვის პროცენტი","description":"ამ პარამეტრს ხშირად არანაირი ეფექტი არ ექნება. ეს არის მთლიანი ქულის პროცენტი, რომელიც საჭიროა 1 ქულის მისაღებად, როდესაც ჩართულია ერთი ქულა მთელი დავალების შესრულებისთვის და xAPI განცხადებებში result.success-ის მისაღებად."}]},{"label":"მომხმარებლის ინტერფეისი","fields":[{"label":"ტექსტი \"შემოწმების\" ღილაკისთვის","default":"შემოწმება"},{"label":"ტექსტი \"წარდგენის\" ღილაკისთვის","default":"წარდგენა"},{"label":"დამხმარე ტექნოლოგიის აღწერა \"შეამოწმე\" ღილაკისთვის","default":"შეამოწმე პასუხები. პასუხები მოინიშნება როგორც სწორი, არასწორი და პასუხგაუცემელი."},{"label":"ტექსტი \"ამოხსნის ჩვენება\" ღილაკისთვის","default":"პასუხის ჩვენება"},{"label":"დამხმარე ტექნოლოგიის აღწერა \"ამოხსნის ჩვენების\" ღილაკისთვის","default":"აჩვენე გამოსავალი. სწორი ვარიანტები მონიშნული იქნება."},{"label":"სწორი პასუხი (არ გამოჩნდება)","default":"სწორი პასუხი"},{"label":"არასწორი პასუხი (არ გამოჩნდება)","default":"არასწორი პასუხი"},{"label":"ოფცია უნდა ყოფილიყო მონიშნული","default":"უნდა ყოფილიყო მონიშნული"},{"label":"ოფცია არ უნდა ყოფილიყო მონიშნული","default":"არ უნდა ყოფილიყო მონიშნული"},{"label":"ტექსტი \"მოითხოვს პასუხს\" შეტყობინებისთვის","default":"გთხოვთ უპასუხოთ, სანამ ამოხსნას ნახავთ"},{"label":"ტექსტი \"თავიდან ცდის\" ღილაკისთვის","default":"თავიდან ცდა"},{"label":"დამხმარე ტექნოლოგიის აღწერა \"გამეორების\" ღილაკისთვის","default":"თავიდან სცადეთ დავალება. წაშალე ყველა პასუხი და თავიდან სცადე დავალების შესრულება."},{"label":"შენი შედეგი","description":":num და :total არის ცვლადები და შეიცვლება მათი შესაბამისი მნიშვნელობებით.","default":"თქვენ მიიღეთ :num :total ქულიდან"},{"label":"დადასტურების დიალოგის შემოწმება","fields":[{"label":"სათაურის ტექსტი","default":"დასრულება ?"},{"label":"ძირითადი ტექსტი","default":"დარწმუნებული ხართ, რომ გსურთ დასრულება?"},{"label":"გაუქმების ღილაკის წარწერა","default":"გაუქმება"},{"label":"დადასტურების ღილაკის წარწერა","default":"დასრულება"}]},{"label":"თავიდან სცადე კონფირმაციის დიალოგი","fields":[{"label":"სათაურის ტექსტი","default":"თავიდან ცდა ?"},{"label":"ძირითადი ტექსტი","default":"დარწმუნებული ხართ, რომ გსურთ ხელახლა ცდა?"},{"label":"გაუქმების ღილაკის წარწერა","default":"გაუქმება"},{"label":"დადასტურების ღილაკის წარწერა","default":"თავიდან ცდა"}]},{"label":"ტექსტი, თუ ალტერნატიული ტექსტი აკლია სურათს","default":"ალტერნატიული ტექსტი აკლია"},{"label":"Close modal button label","default":"Close modal"}]}]}'), JSON_PRETTY_PRINT|JSON_UNESCAPED_UNICODE)
        ]);

        DB::table('h5p_libraries_languages')->insert([
            'library_id' => $libId,
            'language_code' => 'ko',
            'translation' => json_encode(json_decode('{"semantics":[{"label":"미디어","fields":[{"label":"유형","description":"(선택사항)문제 위에 표시할 미디어"},{"label":"이미지 확대/축소 사용 안 함"}]},{"label":"문제"},{"label":"사용 가능한 옵션","entity":"옵션","field":{"label":"옵션","fields":[{"label":"미디어","description":"Media to display as a choice."},{"label":"Poster image"},{"label":"정답"}]}},{"label":"전체 피드백","fields":[{"widgets":[{"label":"기본값"}],"label":"모든 점수 범위에 대한 사용자 지정 피드백 정의","description":"\"범위 추가\" 버튼을 클릭하여 필요한 만큼 범위를 추가합니다. 예: 0-20% 낮은 점수, 21-91% 평균 점수, 91-100% 높은 점수!","entity":"범위","field":{"fields":[{"label":"점수 범위"},{},{"label":"정의된 점수 범위에 대한 피드백","placeholder":"피드백을 작성하세요."}]}}]},{"label":"과제수행 환경설정","description":"이 옵션을 사용하면 과제가 수행되는 방식을 제어할 수 있습니다","fields":[{"label":"\"재시도\" 버튼 활성화"},{"label":"\"해답 보이기\" 버튼 활성화"},{"label":"\"정답확인\"에서 확인 대화창 보이기"},{"label":"\"재시도\"에서 확인 대화창 보이기"},{"label":"전체 질문에 대해 1점 부여","description":"통과 백분율보다 높은 경우 질문에 대해 1점 추가"},{"label":"해답을 보기 전에 답변 필요"},{"label":"문제유형","description":"문제의 모양과 동작을 선택하십시오","options":[{"label":"자동 설정"},{"label":"다중 선택(체크박스)"},{"label":"단일 선택(라디오 버튼)"}]},{"label":"가로세로 비율","description":"가로 세로 비율 선택","options":[{"label":"자동 설정"},{"label":"16:9"},{"label":"4:3"},{"label":"3:2"},{"label":"1:1"}]},{"label":"행당 최대 대체 항목","description":"문제가 바르게 보이도록 행당 최대 대체 항목 수를 설정하세요","options":[{"label":"1"},{"label":"2"},{"label":"3"},{"label":"4"}]},{"label":"통과 백분율","description":"이 설정은 종종 아무런 영향을 미치지 않습니다. 전체 과제에 대해 1점 부여가 활성화되었을 때, 1점과 xAPI 진술문에 성공 결과를 얻기 위해 필요한 총 점수의 백분율입니다."}]},{"label":"사용자 인터페이스","fields":[{"label":"\"정답 확인\" 버튼 텍스트","default":"정답 확인"},{"label":"\"제출하기\" 버튼 텍스트","default":"제출하기"},{"label":"\"Check\" (정답 확인) 버튼에 대한 보조 기술 레이블","default":"정답을 확인하세요. 답변은 정답, 오답, 미답변으로 표기가 됩니다."},{"label":"\"Show Solution\"(해답 보이기) 버튼 텍스트","default":"해답 보이기"},{"label":"\"Show Solution\"(해답 보이기) 버튼에 대한 보조 기술 설명","default":"해답 보이기. 올바른 해답과 함께 표기될 것입니다."},{"label":"정답 (표시되지 않음)","default":"정답"},{"label":"오답 (표시되지 않음)","default":"오답"},{"label":"선택사항이 체크되었어야 함","default":"체크되었어야 함"},{"label":"선택사항이 체크되지 않았어야 함","default":"체크되지 않았어야 함"},{"label":"\"응답 필요\" 메시지에 대한 텍스트","default":"해법을 보기 전에 응답하십시오"},{"label":"\"재시도\" 버튼에 대한 텍스트","default":"재시도"},{"label":"\"Retry\"(재시도) 버튼의 보조 기술 레이블","default":"재시도하세요. 모든 답변을 초기화하고 새로 시작하세요."},{"label":"결과","description":":num 과 :total 가 변수이고 각각 값에 의해 대체됩니다.","default":"총 :total 점 중 :num 점을 획득하였습니다."},{"label":"확인 대화창","fields":[{"label":"머릿말 텍스트","default":"종료하겠습니까?"},{"label":"본문 텍스트","default":"종료가 확실합니까?"},{"label":"취소 버튼 라벨","default":"취소"},{"label":"확인 버튼 라벨","default":"종료"}]},{"label":"재시도 확인 대화창","fields":[{"label":"머릿말 텍스트","default":"재시도하겠습니까?"},{"label":"본문 텍스트","default":"재시도가 확실합니까?"},{"label":"취소 버튼 라벨","default":"취소"},{"label":"확인 버튼 라벨","default":"재시도"}]},{"label":"이미지에 대한 대체 텍스트가 누락된 경우의 텍스트","default":"대체 텍스트가 누락되었습니다."},{"label":"Close modal button label","default":"Close modal"}]}]}'), JSON_PRETTY_PRINT|JSON_UNESCAPED_UNICODE)
        ]);

        DB::table('h5p_libraries_languages')->insert([
            'library_id' => $libId,
            'language_code' => 'lt',
            'translation' => json_encode(json_decode('{"semantics":[{"label":"Medija","fields":[{"label":"Tipas","description":"Pasirenkama medija, rodoma virš klausimo."},{"label":"Išjungti paveikslėlio mastelio keitimą"}]},{"label":"Klausimas"},{"label":"Galimos parinktys","entity":"parinktis","field":{"label":"Parinktis","fields":[{"label":"Medija","description":"Media to display as a choice."},{"label":"Poster image"},{"label":"Teisingai"}]}},{"label":"Bendras atsiliepimas","fields":[{"widgets":[{"label":"Numatytasis"}],"label":"Define custom feedback for any score range","description":"Spustelėkite mygtuką „Pridėti diapazoną“, kad pridėtumėte tiek diapazonų, kiek jums reikia. Pavyzdys: 0–20 % blogas balas, 21–91 % vidutinis balas, 91–100 % puikus rezultatas!","entity":"diapazonas","field":{"fields":[{"label":"Score Range"},{},{"label":"Atsiliepimas apibrėžtam balų diapazonui","placeholder":"Užpildykite atsiliepimą"}]}}]},{"label":"Veikimo nustatymai","description":"Šios parinktys leis jums valdyti, kaip veikia užduotis.","fields":[{"label":"Įjungti mygtuką „Bandyti dar kartą“"},{"label":"Įjungti mygtuką „Rodyti sprendimą“"},{"label":"Show confirmation dialog on \"Check\""},{"label":"Show confirmation dialog on \"Retry\""},{"label":"Už visą klausimą skirti vieną balą","description":"Awards one point to the question if the percentage score is higher than the pass percentage"},{"label":"Require answer before the solution can be viewed"},{"label":"Klausimo tipas","description":"Pasirinkite klausimo išvaizdą ir veikimą.","options":[{"label":"Automatinis"},{"label":"Keli pasirinkimai (žymimieji langeliai)"},{"label":"Vienas pasirinkimas (apvalūs mygtukai)"}]},{"label":"Kraštinių santykis","description":"Select the aspect ratio of the alternatives","options":[{"label":"Automatinis"},{"label":"16:9"},{"label":"4:3"},{"label":"3:2"},{"label":"1:1"}]},{"label":"Maximum alternatives per row","description":"Set the maximum number of alternatives per row to ensure the questions look alright.","options":[{"label":"1"},{"label":"2"},{"label":"3"},{"label":"4"}]},{"label":"Išlaikymo procentas","description":"This setting often won\'t have any effect. It is the percentage of the total score required for getting 1 point when one point for the entire task is enabled, and for getting result.success in xAPI statements."}]},{"label":"User interface","fields":[{"label":"Tekstas mygtukui „Tikrinti“","default":"Tikrinti"},{"label":"Tekstas mygtukui „Pateikti“","default":"Pateikti"},{"label":"Mygtuko „Tikrinti“ pagalbinės technologijos aprašymas","default":"Tikrinti atsakymus. Atsakymai bus pažymėti kaip teisingi, neteisingi arba neatsakyti."},{"label":"Mygtuko „Rodyti sprendimą“ tekstas","default":"Rodyti sprendimą"},{"label":"Mygtuko „Rodyti sprendimą“ pagalbinės technologijos aprašymas","default":"Show the solution. The correct options will be marked."},{"label":"Teisingas atsakymas (nerodomas)","default":"Teisingas atsakymas"},{"label":"Neteisingas atsakymas (nerodomas)","default":"Neteisingas atsakymas"},{"label":"Variantas turėjo būti patikrintas","default":"Should have been checked"},{"label":"Option should not have been checked","default":"Should not have been checked"},{"label":"Text for \"Requires answer\" message","default":"Prieš peržiūrėdami sprendimą, atsakykite"},{"label":"Tekstas mygtukui „Bandyti dar kartą“","default":"Bandyti dar kartą"},{"label":"Assistive technology description for \"Retry\" button","default":"Retry the task. Reset all responses and start the task over again."},{"label":"Your result","description":":num and :total are variables and will be replaced by their respective values.","default":"You got :num out of :total points"},{"label":"Check confirmation dialog","fields":[{"label":"Antraštės tekstas","default":"Baigti?"},{"label":"Turinio tekstas","default":"Are you sure you want to finish?"},{"label":"Cancel button label","default":"Cancel"},{"label":"Confirm button label","default":"Baigti"}]},{"label":"„Bandyti dar kartą“ patvirtinimo dialogo langas","fields":[{"label":"Antraštės tekstas","default":"Bandyti dar kartą?"},{"label":"Turinio tekstas","default":"Ar tikrai norite bandyti dar kartą?"},{"label":"Atšaukimo mygtuko pavadinimas","default":"Atšaukti"},{"label":"Confirm button label","default":"Bandyti dar kartą"}]},{"label":"Text if alt text is missing for an image","default":"Alt text missing"},{"label":"Close modal button label","default":"Close modal"}]}]}'), JSON_PRETTY_PRINT|JSON_UNESCAPED_UNICODE)
        ]);

        DB::table('h5p_libraries_languages')->insert([
            'library_id' => $libId,
            'language_code' => 'lv',
            'translation' => json_encode(json_decode('{"semantics":[{"label":"Multivide","fields":[{"label":"Tips","description":"Papildu multimedijs, kuru atspoguļot virs jautājuma."},{"label":"Atspējot attēla tālummaiņu"}]},{"label":"Jautājums"},{"label":"Pieejamās izvēles","entity":"izvēle","field":{"label":"Izvēle","fields":[{"label":"Multivide","description":"Media to display as a choice."},{"label":"Poster image"},{"label":"Pareizi"}]}},{"label":"Kopējā atgriezeniskā saite","fields":[{"widgets":[{"label":"Pēc noklusējuma"}],"label":"Iestatiet pielāgotu atgriezenisko saiti katram rezultātu diapazonam","description":"Klikšķiniet pogu \"Pievienot diapazonu\", lai pievienotu tik diapazonus cik vēlaties. Piemēram, 0-20% Slikts rezultāts, 21-91% Viduvējs rezultāts, 91-100% Lielisks rezultāts!","entity":"diapazons","field":{"fields":[{"label":"Rezultātu diapazons"},{},{"label":"Norādītā diapazona atgriezeniskā saite","placeholder":"Aizpildiet atgriezenisko saiti"}]}}]},{"label":"Uzvedības iestatītījumi","description":"Šie iestatījumi ļaus jums kontrolēt uzdevuma uzvedību.","fields":[{"label":"Atļaut pogu \"Mēģināt vēlreiz\""},{"label":"Atļaut pogu \"Rādīt risinājumu\""},{"label":"Rādīt apstiprinājuma dialogu pēc \"Pārbaudīt\""},{"label":"Rādīt apstiprinājuma dialogu pēc \"Mēģināt vēlreiz\""},{"label":"Piešķirt vienu punktu par visu jautājumu","description":"Piešķir vienu punktu jautājumam, ja rezultātu procents ir lielāks par nokārtošanas procentu"},{"label":"Pieprasīt atbildi pirms atļauts skatīt risinājumu"},{"label":"Jautājuma veids","description":"Izvēlieties jautājuma izskatu un uzvedību.","options":[{"label":"Automātiski"},{"label":"Vairākas izvēles iespējas (izvēles rūtiņas)"},{"label":"Viena izvēle (radiopogas)"}]},{"label":"Malu attiecība","description":"Izvēlieties malu attiecību atbilžu variantiem","options":[{"label":"Automātiski"},{"label":"16:9"},{"label":"4:3"},{"label":"3:2"},{"label":"1:1"}]},{"label":"Maksimālais izvēļu skaits rindā","description":"Iestatiet maksimālo izvēļu skaitu rindā, lai nodrošinātu, ka jautājumi izskatās pareizi.","options":[{"label":"1"},{"label":"2"},{"label":"3"},{"label":"4"}]},{"label":"Nokārtošanas procents","description":"Šim iestatījumam bieži nebūs nekādas ietekmes. Tā ir procentuālā daļa no kopējā rezultāta, kas nepieciešams, lai iegūtu 1 punktu, ja ir iespējota viena punkta piešķiršana par visu uzdevumu. Tiek izmantots arī lai iegūtu result.success xAPI ziņojumos."}]},{"label":"Lietotāja saskarne","fields":[{"label":"Pogas \"Pārbaudīt\" teksts","default":"Pārbaudīt"},{"label":"Pogas \"Iesniegt\" teksts","default":"Iesniegt"},{"label":"Pogas \"Pārbaudīt\" apraksts asistīvajām tehnoloģijām","default":"Pārbaudīt atbildes. Atbildes tiks atzīmētas kā pareizas, nepareizas, vai neatbildētas."},{"label":"Pogas \"Parādīt risinājumu\" teksts","default":"Rādīt risinājumu"},{"label":"Asistīvo tehnoloģiju apraksts pogai \"Rādīt risinājumu\"","default":"Rādīt risinājumu. Tiks atzīmētas pareizās izvēles."},{"label":"Pareiza atbilde (netiek rādīts)","default":"Pareiza atbilde"},{"label":"Nepareiza atbilde (netiek rādīts)","default":"Nepareiza atbilde"},{"label":"Izvēli vajadzēja atzīmēt","default":"Vajadzēja atzīmēt"},{"label":"Izvēli nevajadzēja atzīmēt","default":"Nevajadzēja atzīmēt"},{"label":"Teksts ziņojumam “Nepieciešama atbilde”","default":"Lūdzu, atbildiet pirms risinājuma skatīšanas"},{"label":"Pogas \"Mēģināt vēlreiz\" teksts","default":"Atkārtot"},{"label":"Asistīvo tehnoloģiju apraksts pogai \"Mēģināt vēlreiz\"","default":"Mēģināt uzdevumu vēlreiz. Atiestatīt visas sniegtās atbildes un sākt uzdevumu vēlreiz."},{"label":"Tavs rezultāts","description":"@score un @total ir mainīgie, un tie tiks aizstāti ar to attiecīgajām vērtībām.","default":"Tu saņēmi :num no :total punktiem"},{"label":"Pārbaudīšanas apstiprinājuma dialogs","fields":[{"label":"Galvenes teksts","default":"Beigt?"},{"label":"Pamata teksts","default":"Vai esat pārliecināts, ka vēlaties beigt ?"},{"label":"Atcelšanas pogas etiķete","default":"Atcelt"},{"label":"Apstiprinājuma pogas etiķete","default":"Beigt"}]},{"label":"Pārbaudīšanas apstiprinājuma dialogs","fields":[{"label":"Galvenes teksts","default":"Beigt?"},{"label":"Pamatteksts","default":"Vai esat pārliecināts, ka vēlaties mēģināt vēlreiz?"},{"label":"Atcelšanas pogas etiķete","default":"Atcelt"},{"label":"Apstiprinājuma pogas etiķete","default":"Beigt"}]},{"label":"Teksts, ja attēlam trūkst alternatīvā teksta","default":"Trūkst alternatīvā teksta"},{"label":"Close modal button label","default":"Close modal"}]}]}'), JSON_PRETTY_PRINT|JSON_UNESCAPED_UNICODE)
        ]);

        DB::table('h5p_libraries_languages')->insert([
            'library_id' => $libId,
            'language_code' => 'mn',
            'translation' => json_encode(json_decode('{"semantics":[{"label":"Медиа","fields":[{"label":"Төрөл","description":"Асуултын дээр харуулах нэмэлт медиа."},{"label":"Зургийн томруулагчийг идэвхгүй болгох"}]},{"label":"Асуулт"},{"label":"Боломжтой сонголтууд","entity":"сонголт","field":{"label":"Сонголт","fields":[{"label":"Медиа","description":"Media to display as a choice."},{"label":"Poster image"},{"label":"Зөв"}]}},{"label":"Ерөнхий санал хүсэлт","fields":[{"widgets":[{"label":"Өгөгдмөл"}],"label":"Аль ч онооны хүрээнд захиалгат санал хүсэлтийг тодорхойлох","description":"\"Хүрээ нэмэх\" товчийг дарж шаардлагатай бол олон муж нэмнэ. Жишээ: 0-20% муу оноо, 21-91% дундаж оноо, 91-100% сайн оноо!","entity":"хүрээ","field":{"fields":[{"label":"Онооны хүрээ"},{},{"label":"Тодорхойлогдсон онооны хүрээний санал хүсэлт","placeholder":"Санал хүсэлтийг бөглөнө үү"}]}}]},{"label":"Зан үйлийн тохиргоо","description":"Эдгээр сонголтууд нь даалгавар хэрхэн ажиллахыг хянах боломжийг танд олгоно.","fields":[{"label":"\"Дахин оролдох\" товчийг идэвхжүүлнэ үү"},{"label":"\"Шийдэл харуулах\" товчийг идэвхжүүлнэ үү"},{"label":"\"Шалгах\" дээр баталгаажуулах харилцах цонхыг харуулах"},{"label":"\"Дахин оролдох\" дээр баталгаажуулах харилцах цонхыг харуулах"},{"label":"Бүх асуултанд нэг оноо өг","description":"Оноо тэнцсэн хувиас өндөр байгаа эсэх асуултад нэг оноо өгнө"},{"label":"Шийдвэрийг харахын өмнө хариултыг шаардана уу"},{"label":"Асуултын төрөл","description":"Асуултын харагдах байдал, зан төлөвийг сонгоно уу.","options":[{"label":"Автомат"},{"label":"Олон сонголттой (шалгах хайрцаг)"},{"label":"Ганц сонголт (Радио товчлуурууд)"}]},{"label":"Хэсгийн харьцаа","description":"Хувилбаруудын харьцааг сонгоно уу","options":[{"label":"Автомат"},{"label":"16:9"},{"label":"4:3"},{"label":"3:2"},{"label":"1:1"}]},{"label":"Мөр бүрт хамгийн их хувилбарууд","description":"Асуултууд зөв харагдахын тулд нэг мөрөнд альтернатив хувилбаруудын хамгийн их тоог тохируулна уу.","options":[{"label":"1"},{"label":"2"},{"label":"3"},{"label":"4"}]},{"label":"Дамжуулах хувь","description":"Энэ тохиргоо нь ихэвчлэн ямар ч нөлөө үзүүлэхгүй. Энэ нь даалгаврыг бүхэлд нь идэвхжүүлсэн үед 1 оноо авах, мөн xAPI хэллэгт үр дүн.амжилт авахад шаардагдах нийт онооны хувь юм."}]},{"label":"Хэрэглэгчийн интерфэйс","fields":[{"label":"\"Шалгах\" товчлуурын текст","default":"Шалгах"},{"label":"\"Илгээх\" товчлуурын текст","default":"Илгээх"},{"label":"\"Шалгах\" товчлуурын туслах технологийн тайлбар","default":"Хариултуудыг шалгана уу. Хариултуудыг зөв, буруу, хариултгүй гэж тэмдэглэнэ."},{"label":"\"Шийдвэрийг харуулах\" товчлуурын текст","default":"Шийдлийг харуулах"},{"label":"\"Шийдэл харуулах\" товчлуурын туслах технологийн тайлбар","default":"Шийдлийг харуул. Зөв сонголтуудыг тэмдэглэнэ."},{"label":"Зөв хариулт (харагдахгүй)","default":"Зөв хариулт"},{"label":"Буруу хариулт (харагдахгүй)","default":"Буруу хариулт"},{"label":"Сонголтыг шалгах ёстой байсан","default":"Шалгах ёстой байсан"},{"label":"Сонголтыг шалгах ёсгүй байсан","default":"Шалгах ёсгүй байсан"},{"label":"\"Хариулах шаардлагатай\" мессежийн текст","default":"Шийдвэрийг үзэхийн өмнө хариулна уу"},{"label":"\"Дахин оролдох\" товчлуурын текст","default":"Дахин оролдох"},{"label":"\"Дахин оролдох\" товчлуурын туслах технологийн тайлбар","default":"Даалгаврыг дахин оролдоно уу. Бүх хариултыг дахин тохируулаад даалгаврыг дахин эхлүүлнэ үү."},{"label":"Таны үр дүн","description":":num болон :total нь хувьсагч бөгөөд тус тусын утгуудаар солигдоно.","default":"Та нийт :total онооноос :num авсан"},{"label":"Баталгаажуулах харилцах цонхыг шалгана уу","fields":[{"label":"Толгойн текст","default":"Дуусгах уу?"},{"label":"Үндсэн текст","default":"Та дуусгахдаа итгэлтэй байна уу?"},{"label":"цуцлах товчлуурын шошго","default":"цуцлах"},{"label":"Баталгаажуулах товчлуурын шошго","default":"Баталгаажуулах"}]},{"label":"Баталгаажуулах харилцах цонхыг дахин оролдоно уу","fields":[{"label":"Толгойн текст","default":"Дахин оролдох уу?"},{"label":"Үндсэн текст","default":"Та дахин оролдохдоо итгэлтэй байна уу?"},{"label":"Цуцлах товчлуурын шошго","default":"Цуцлах"},{"label":"Баталгаажуулах товчлуурын шошго","default":"Дахин оролдох уу?"}]},{"label":"Зураггүй тохиолдолд харуулах Өөр текст","default":"Өөр текст дутуу байна"},{"label":"Close modal button label","default":"Close modal"}]}]}'), JSON_PRETTY_PRINT|JSON_UNESCAPED_UNICODE)
        ]);

        DB::table('h5p_libraries_languages')->insert([
            'library_id' => $libId,
            'language_code' => 'nb',
            'translation' => json_encode(json_decode('{"semantics":[{"label":"Medieelement","fields":[{"label":"Type","description":"Valgfritt medieelement. Elementet vil bli plassert over spørsmålet."},{"label":"Deaktiver zoomingfunksjon."}]},{"label":"Spørsmål"},{"label":"Tilgjengelige valg","entity":"option","field":{"label":"Option","fields":[{"label":"Media","description":"Media to display as a choice."},{"label":"Poster image"},{"label":"Correct"}]}},{"label":"Tilbakemelding på hele oppgava","fields":[{"widgets":[{"label":"Forhandsinnstilling"}],"label":"Opprett poengområder og legg inn tilbakemeldinger.","description":"Klikk på knappen \"Legg til poengområde\" og legg til så mange poengområder du trenger. Eksempel: 0–40 % Svakt resultat, 41–80 % Gjennomsnittlig resultat, 81–100 % Flott resultat!","entity":"Område","field":{"fields":[{"label":"Poengområde"},{},{"label":"Tilbakemelding for definert poengområde","placeholder":"Skriv inn tilbakemelding."}]}}]},{"label":"Oppgaveinnstillinger","description":"Disse valga lar deg styre ulike funksjoner i oppgava.","fields":[{"label":"Enable \"Retry\" button"},{"label":"Enable \"Show Solution\" button"},{"label":"Show confirmation dialog on \"Check\""},{"label":"Show confirmation dialog on \"Retry\""},{"label":"Give one point for the whole question","description":"Awards one point to the question if the percentage score is higher than the pass percentage"},{"label":"Require answer before the solution can be viewed"},{"label":"Question Type","description":"Select the look and behaviour of the question.","options":[{"label":"Automatic"},{"label":"Multiple Choice (Checkboxes)"},{"label":"Single Choice (Radio Buttons)"}]},{"label":"Aspect ratio","description":"Select the aspect ratio of the alternatives","options":[{"label":"Automatic"},{"label":"16:9"},{"label":"4:3"},{"label":"3:2"},{"label":"1:1"}]},{"label":"Maximum alternatives per row","description":"Set the maximum number of alternatives per row to ensure the questions look alright.","options":[{"label":"1"},{"label":"2"},{"label":"3"},{"label":"4"}]},{"label":"Pass percentage","description":"This setting often won\'t have any effect. It is the percentage of the total score required for getting 1 point when one point for the entire task is enabled, and for getting result.success in xAPI statements."}]},{"label":"Brukergrensesnitt","fields":[{"label":"Tekst for \"Sjekk svar\"-knapp","default":"Sjekk"},{"label":"Tekst for \"Send inn\"-knapp","default":"Send inn"},{"label":"Assistive technology description for \"Check\" button","default":"Check the answers. The responses will be marked as correct, incorrect, or unanswered."},{"label":"Tekst for \"Vis svar\"-knapp","default":"Vis svar"},{"label":"Assistive technology description for \"Show Solution\" button","default":"Show the solution. The correct options will be marked."},{"label":"Correct Answer (not displayed)","default":"Correct answer"},{"label":"Wrong Answer (not displayed)","default":"Wrong answer"},{"label":"Option should have been checked","default":"Should have been checked"},{"label":"Option should not have been checked","default":"Should not have been checked"},{"label":"Text for \"Requires answer\" message","default":"Please answer before viewing the solution"},{"label":"Text for \"Retry\" button","default":"Retry"},{"label":"Assistive technology description for \"Retry\" button","default":"Retry the task. Reset all responses and start the task over again."},{"label":"Your result","description":":num and :total are variables and will be replaced by their respective values.","default":"You got :num out of :total points"},{"label":"Check confirmation dialog","fields":[{"label":"Header text","default":"Finish?"},{"label":"Body text","default":"Are you sure you want to finish?"},{"label":"Cancel button label","default":"Cancel"},{"label":"Confirm button label","default":"Finish"}]},{"label":"Retry confirmation dialog","fields":[{"label":"Header text","default":"Retry?"},{"label":"Body text","default":"Are you sure you wish to retry?"},{"label":"Cancel button label","default":"Cancel"},{"label":"Confirm button label","default":"Retry"}]},{"label":"Text if alt text is missing for an image","default":"Alt text missing"},{"label":"Close modal button label","default":"Close modal"}]}]}'), JSON_PRETTY_PRINT|JSON_UNESCAPED_UNICODE)
        ]);

        DB::table('h5p_libraries_languages')->insert([
            'library_id' => $libId,
            'language_code' => 'nl',
            'translation' => json_encode(json_decode('{"semantics":[{"label":"Media","fields":[{"label":"Type","description":"Optionele media, die boven de vraag wordt getoond."},{"label":"Beeld zoomen uitschakelen"}]},{"label":"Vraag"},{"label":"Beschikbare opties","entity":"optie","field":{"label":"Optie","fields":[{"label":"Media","description":"Media to display as a choice."},{"label":"Poster image"},{"label":"Juist"}]}},{"label":"Algehele feedback","fields":[{"widgets":[{"label":"Standaard"}],"label":"Definieer aangepaste feedback voor elke scorereeks","description":"Druk op de \"Voeg scorereeks\"-knop om zoveel reeksen toe te voegen als nodig. Voorbeeld: 0-20% Onvoldoende, 21-91% Gemiddelde score, 91-100% Uitstekende score!","entity":"reeks","field":{"fields":[{"label":"Scorereeks"},{},{"label":"Feedback voor de gedefinieerde scorereeks","placeholder":"Vul de feedback in"}]}}]},{"label":"Gedragsinstelllingen","description":"Met deze opties kun je bepalen hoe de taak zich gedraagt.","fields":[{"label":"Schakel \"Opnieuw\"-knop in"},{"label":"Schakel \"Toon oplossing\"-knop in"},{"label":"Toon bevestigingsdialoog bij \"Controleer\""},{"label":"Toon bevestigingsdialoog bij \"Opnieuw\""},{"label":"Geef één punt voor de hele vraag","description":"Beloont de vraag met één punt als de percentage score hoger is dan het slagingspercentage"},{"label":"Antwoord is vereist voordat de oplossing kan worden getoond"},{"label":"Vraagtype","description":"Selecteer het uiterlijk en het gedrag van de vraag.","options":[{"label":"Automatisch"},{"label":"Meerkeuze (aanvinkvakjes)"},{"label":"Enkele keuze (Radio-knoppen)"}]},{"label":"Beeldverhouding","description":"Kies de beeldverhouding van de alternatieven","options":[{"label":"Automatisch"},{"label":"16:9"},{"label":"4:3"},{"label":"3:2"},{"label":"1:1"}]},{"label":"Maximaal aantal alternatieven per rij","description":"Stel het maximumaantal alternatieven per rij in, om zeker te stellen dat vragen er goed uitzien.","options":[{"label":"1"},{"label":"2"},{"label":"3"},{"label":"4"}]},{"label":"Slagingspercentage","description":"Deze instelling heeft vaak geen effect. Dit is het percentage van de totale score die vereist is om 1 punt te krijgen voor een hele taak wanneer dit is ingeschakeld alsook om een result.success te krijgen in de xAPI statements."}]},{"label":"Gebruikersinterface","fields":[{"label":"Tekst voor \"Controleer\"-knop","default":"Controleer"},{"label":"Tekst voor \"Verzend\"-knop","default":"Verzend"},{"label":"Ondersteunende technologie beschrijving voor \"Controleer\"-knop","default":"Controleer de antwoorden. De antwoorden worden gemarkeerd als juist, onjuist, of niet-beantwoord."},{"label":"Tekst voor \"Toon oplossing\"-knop","default":"Toon oplossing"},{"label":"Ondersteunende technologie beschrijving voor \"Toon oplossing\"-knop","default":"Toon de oplossing. De juiste opties worden gemarkeerd."},{"label":"Juist antwoord (niet weergegeven)","default":"Juist antwoord"},{"label":"Onjuist antwoord (niet getoond)","default":"Onjuist antwoord"},{"label":"Optie zou gekozen moeten zijn","default":"Zou niet gekozen mogen zijn"},{"label":"Optie zou niet gekozen moeten zijn","default":"Zou niet gekozen mogen zijn"},{"label":"Tekst van \"Antwoord vereist\"-bericht","default":"Beantwoord voor je de oplossing bekijkt"},{"label":"Tekst voor \"Opnieuw\"-knop","default":"Opnieuw"},{"label":"Assistive technology description for \"Retry\" button","default":"Retry the task. Reset all responses and start the task over again."},{"label":"Your result","description":":num and :total are variables and will be replaced by their respective values.","default":"You got :num out of :total points"},{"label":"Bevestigingsdialoog voor Controleer","fields":[{"label":"Koptekst","default":"Klaar?"},{"label":"Hoofdtekst","default":"Weet je zeker dat je wilt stoppen?"},{"label":"Label van \"Annuleer\"-knop","default":"Annuleer"},{"label":"Label van \"Bevestig\"-knop","default":"Stoppen"}]},{"label":"Bevestigingsdialoog voor \"Opnieuw\"","fields":[{"label":"Koptekst","default":"Opnieuw?"},{"label":"Hoofdtekst","default":"Weet je zeker dat je het opnieuw wilt proberen?"},{"label":"Label van \"Annuleer\"-knop","default":"Annuleer"},{"label":"Label van \"Bevestig\"-knop","default":"Opnieuw"}]},{"label":"Tekst als alternatieve tekst voor afbeelding ontbreekt","default":"Alternatieve tekst ontbreekt"},{"label":"Close modal button label","default":"Close modal"}]}]}'), JSON_PRETTY_PRINT|JSON_UNESCAPED_UNICODE)
        ]);

        DB::table('h5p_libraries_languages')->insert([
            'library_id' => $libId,
            'language_code' => 'nn',
            'translation' => json_encode(json_decode('{"semantics":[{"label":"Medieelement","fields":[{"label":"Type","description":"Valfritt medieelement. Elementet vil bli plassert over spørsmålet."},{"label":"Deaktiver zoomingfunksjon."}]},{"label":"Question"},{"label":"Available options","entity":"option","field":{"label":"Option","fields":[{"label":"Media","description":"Media to display as a choice."},{"label":"Poster image"},{"label":"Correct"}]}},{"label":"Tilbakemelding på heile oppgåva","fields":[{"widgets":[{"label":"Førehandsinnstilling"}],"label":"Opprett poengområde og legg inn tilbakemeldingar.","description":"Klikk på knappen \"Legg til poengområde\" og legg til så mange poengområde du treng. Døme: 0–40 % Svakt resultat, 41–80 % Gjennomsnittleg resultat, 81–100 % Flott resultat!","entity":"Område","field":{"fields":[{"label":"Poengområde"},{},{"label":"Tilbakemelding for definert poengområde","placeholder":"Skriv inn tilbakemelding."}]}}]},{"label":"Oppgåveinnstillingar","description":"Desse vala lar deg styre ulike funksjonar i oppgåva.","fields":[{"label":"Enable \"Retry\" button"},{"label":"Enable \"Show Solution\" button"},{"label":"Show confirmation dialog on \"Check\""},{"label":"Show confirmation dialog on \"Retry\""},{"label":"Give one point for the whole question","description":"Awards one point to the question if the percentage score is higher than the pass percentage"},{"label":"Require answer before the solution can be viewed"},{"label":"Question Type","description":"Select the look and behaviour of the question.","options":[{"label":"Automatic"},{"label":"Multiple Choice (Checkboxes)"},{"label":"Single Choice (Radio Buttons)"}]},{"label":"Aspect ratio","description":"Select the aspect ratio of the alternatives","options":[{"label":"Automatic"},{"label":"16:9"},{"label":"4:3"},{"label":"3:2"},{"label":"1:1"}]},{"label":"Maximum alternatives per row","description":"Set the maximum number of alternatives per row to ensure the questions look alright.","options":[{"label":"1"},{"label":"2"},{"label":"3"},{"label":"4"}]},{"label":"Pass percentage","description":"This setting often won\'t have any effect. It is the percentage of the total score required for getting 1 point when one point for the entire task is enabled, and for getting result.success in xAPI statements."}]},{"label":"Brukargrensesnitt","fields":[{"label":"Tekst for \"Sjekk svar\"-knapp","default":"Sjekk"},{"label":"Tekst for \"Send inn\"-knapp","default":"Send inn"},{"label":"Assistive technology description for \"Check\" button","default":"Check the answers. The responses will be marked as correct, incorrect, or unanswered."},{"label":"Tekst for \"Vis svar\"-knapp","default":"Vis svar"},{"label":"Assistive technology description for \"Show Solution\" button","default":"Show the solution. The correct options will be marked."},{"label":"Correct Answer (not displayed)","default":"Correct answer"},{"label":"Wrong Answer (not displayed)","default":"Wrong answer"},{"label":"Option should have been checked","default":"Should have been checked"},{"label":"Option should not have been checked","default":"Should not have been checked"},{"label":"Text for \"Requires answer\" message","default":"Please answer before viewing the solution"},{"label":"Text for \"Retry\" button","default":"Retry"},{"label":"Assistive technology description for \"Retry\" button","default":"Retry the task. Reset all responses and start the task over again."},{"label":"Your result","description":":num and :total are variables and will be replaced by their respective values.","default":"You got :num out of :total points"},{"label":"Check confirmation dialog","fields":[{"label":"Header text","default":"Finish?"},{"label":"Body text","default":"Are you sure you want to finish?"},{"label":"Cancel button label","default":"Cancel"},{"label":"Confirm button label","default":"Finish"}]},{"label":"Retry confirmation dialog","fields":[{"label":"Header text","default":"Retry?"},{"label":"Body text","default":"Are you sure you wish to retry?"},{"label":"Cancel button label","default":"Cancel"},{"label":"Confirm button label","default":"Retry"}]},{"label":"Text if alt text is missing for an image","default":"Alt text missing"},{"label":"Close modal button label","default":"Close modal"}]}]}'), JSON_PRETTY_PRINT|JSON_UNESCAPED_UNICODE)
        ]);

        DB::table('h5p_libraries_languages')->insert([
            'library_id' => $libId,
            'language_code' => 'pt-br',
            'translation' => json_encode(json_decode('{"semantics":[{"label":"Mídia","fields":[{"label":"Tipo","description":"Mídia opcional para exibir acima da pergunta."},{"label":"Desativar o zoom da imagem"}]},{"label":"Questão"},{"label":"Opções disponíveis","entity":"opção","field":{"label":"Opção","fields":[{"label":"Mídia","description":"Media to display as a choice."},{"label":"Poster image"},{"label":"Correto"}]}},{"label":"Feedback Geral","fields":[{"widgets":[{"label":"Padrão"}],"label":"Definir feedback personalizado para qualquer faixa de pontuação","description":"Clique no botão \"Adicionar faixa\" para adicionar quantos intervalos você precisar. Exemplo: 0-20% Pontuação Ruim, 21-91% Pontuação Média, 91-100% Pontuação Ótima!","entity":"faixa","field":{"fields":[{"label":"Faixa de Pontuação"},{},{"label":"Feedback para a faixa de pontuação definida","placeholder":"Preencha o feedback"}]}}]},{"label":"Configurações comportamentais","description":"Estas opções lhe permitirão controlar como a tarefa se comporta.","fields":[{"label":"Ativar o botão \"Tentar Novamente\""},{"label":"Ativar o botão \"Mostrar Solução\""},{"label":"Mostrar caixa de diálogo de confirmação em \"Verificar\""},{"label":"Mostrar caixa de diálogo de confirmação em \"Tentar Novamente\""},{"label":"Dê um ponto para toda a questão","description":"Atribui um ponto à questão se a pontuação percentual for maior que a porcentagem de aprovação"},{"label":"Exigir resposta antes que a solução possa ser visualizada"},{"label":"Tipo de Questão","description":"Selecione a aparência e o comportamento da questão.","options":[{"label":"Automático"},{"label":"Múltipla escolha (caixas de seleção)"},{"label":"Escolha única (botões de rádio)"}]},{"label":"Proporção de aspecto","description":"Selecione a proporção de aspecto das alternativas","options":[{"label":"Automático"},{"label":"16:9"},{"label":"4:3"},{"label":"3:2"},{"label":"1:1"}]},{"label":"Alternativas máximas por linha","description":"Defina o número máximo de alternativas por linha para garantir que as questões pareçam corretas.","options":[{"label":"1"},{"label":"2"},{"label":"3"},{"label":"4"}]},{"label":"Porcentagem para aprovação","description":"Este cenário muitas vezes não terá qualquer efeito. Isto é a porcentagem da pontuação total necessária para obter 1 ponto quando um ponto para toda a tarefa é habilitado, e para obter resultado.sucesso nas declarações xAPI."}]},{"label":"Interface de usuário","fields":[{"label":"Texto do botão \"Verificar\"","default":"Verificar"},{"label":"Texto do botão \"Enviar\"","default":"Enviar"},{"label":"Descrição da tecnologia de assistência para o botão \"Verificar\"","default":"Verifique as respostas. As respostas serão marcadas como corretas, incorretas, ou sem resposta."},{"label":"Texto do botão \"Mostrar solução\"","default":"Mostrar solução"},{"label":"Descrição da tecnologia de assistência para o botão \"Mostrar solução\"","default":"Mostrar a solução. As opções corretas serão verificadas."},{"label":"Resposta Correta (não exibida)","default":"Resposta correta"},{"label":"Resposta incorreta (não exibida)","default":"Resposta incorreta"},{"label":"A opção deveria ter sido verificada","default":"Deveria ter sido verificado"},{"label":"A opção não deveria ter sido verificada","default":"Não deveria ter sido verificado"},{"label":"Texto para a mensagem \"Resposta obrigatória\"","default":"Por favor, responda antes de ver a solução"},{"label":"Texto do botão \"Tentar Novamente\"","default":"Tentar Novamente"},{"label":"Descrição da tecnologia de assistência para o botão \"Tentar Novamente\"","default":"Tente realizar a tarefa novamente. Reinicialize todas as respostas e recomece."},{"label":"Seu resultado","description":":num e :total são variáveis e serão substituídas por seus respectivos valores.","default":"Você conseguiu :num de :pontos totais possíveis"},{"label":"Verificar diálogo de confirmação","fields":[{"label":"Texto do cabeçalho","default":"Finalizar?"},{"label":"Texto do corpo","default":"Você tem certeza que quer finalizar?"},{"label":"Rótulo do botão Cancelar","default":"Cancelar"},{"label":"Rótulo do botão Confirmar","default":"Finalizar"}]},{"label":"Diálogo de confirmação de nova tentativa","fields":[{"label":"Texto do cabeçalho","default":"Tentar Novamente?"},{"label":"Texto do corpo","default":"Você tem certeza que deseja tentar novamente?"},{"label":"Rótulo do botão Cancelar","default":"Cancelar"},{"label":"Rótulo do botão Confirmar","default":"Tentar Novamente"}]},{"label":"Texto utilizado se faltar texto alternativo para uma imagem","default":"Texto alternativo ausente"},{"label":"Close modal button label","default":"Close modal"}]}]}'), JSON_PRETTY_PRINT|JSON_UNESCAPED_UNICODE)
        ]);

        DB::table('h5p_libraries_languages')->insert([
            'library_id' => $libId,
            'language_code' => 'pt',
            'translation' => json_encode(json_decode('{"semantics":[{"label":"Media","fields":[{"label":"Type","description":"Optional media to display above the question."},{"label":"Disable image zooming"}]},{"label":"Question"},{"label":"Available options","entity":"option","field":{"label":"Option","fields":[{"label":"Media","description":"Media to display as a choice."},{"label":"Poster image"},{"label":"Correct"}]}},{"label":"Overall Feedback","fields":[{"widgets":[{"label":"Default"}],"label":"Define custom feedback for any score range","description":"Click the \"Add range\" button to add as many ranges as you need. Example: 0-20% Bad score, 21-91% Average Score, 91-100% Great Score!","entity":"range","field":{"fields":[{"label":"Score Range"},{},{"label":"Feedback for defined score range","placeholder":"Fill in the feedback"}]}}]},{"label":"Behavioural settings","description":"These options will let you control how the task behaves.","fields":[{"label":"Enable \"Retry\" button"},{"label":"Enable \"Show Solution\" button"},{"label":"Show confirmation dialog on \"Check\""},{"label":"Show confirmation dialog on \"Retry\""},{"label":"Give one point for the whole question","description":"Awards one point to the question if the percentage score is higher than the pass percentage"},{"label":"Require answer before the solution can be viewed"},{"label":"Question Type","description":"Select the look and behaviour of the question.","options":[{"label":"Automatic"},{"label":"Multiple Choice (Checkboxes)"},{"label":"Single Choice (Radio Buttons)"}]},{"label":"Aspect ratio","description":"Select the aspect ratio of the alternatives","options":[{"label":"Automatic"},{"label":"16:9"},{"label":"4:3"},{"label":"3:2"},{"label":"1:1"}]},{"label":"Maximum alternatives per row","description":"Set the maximum number of alternatives per row to ensure the questions look alright.","options":[{"label":"1"},{"label":"2"},{"label":"3"},{"label":"4"}]},{"label":"Pass percentage","description":"This setting often won\'t have any effect. It is the percentage of the total score required for getting 1 point when one point for the entire task is enabled, and for getting result.success in xAPI statements."}]},{"label":"User interface","fields":[{"label":"Text for \"Check\" button","default":"Check"},{"label":"Text for \"Submit\" button","default":"Submit"},{"label":"Assistive technology description for \"Check\" button","default":"Check the answers. The responses will be marked as correct, incorrect, or unanswered."},{"label":"Text for \"Show solution\" button","default":"Show solution"},{"label":"Assistive technology description for \"Show Solution\" button","default":"Show the solution. The correct options will be marked."},{"label":"Correct Answer (not displayed)","default":"Correct answer"},{"label":"Wrong Answer (not displayed)","default":"Wrong answer"},{"label":"Option should have been checked","default":"Should have been checked"},{"label":"Option should not have been checked","default":"Should not have been checked"},{"label":"Text for \"Requires answer\" message","default":"Please answer before viewing the solution"},{"label":"Text for \"Retry\" button","default":"Retry"},{"label":"Assistive technology description for \"Retry\" button","default":"Retry the task. Reset all responses and start the task over again."},{"label":"Your result","description":":num and :total are variables and will be replaced by their respective values.","default":"You got :num out of :total points"},{"label":"Check confirmation dialog","fields":[{"label":"Header text","default":"Finish?"},{"label":"Body text","default":"Are you sure you want to finish?"},{"label":"Cancel button label","default":"Cancel"},{"label":"Confirm button label","default":"Finish"}]},{"label":"Retry confirmation dialog","fields":[{"label":"Header text","default":"Retry?"},{"label":"Body text","default":"Are you sure you wish to retry?"},{"label":"Cancel button label","default":"Cancel"},{"label":"Confirm button label","default":"Retry"}]},{"label":"Text if alt text is missing for an image","default":"Alt text missing"},{"label":"Close modal button label","default":"Close modal"}]}]}'), JSON_PRETTY_PRINT|JSON_UNESCAPED_UNICODE)
        ]);

        DB::table('h5p_libraries_languages')->insert([
            'library_id' => $libId,
            'language_code' => 'ro',
            'translation' => json_encode(json_decode('{"semantics":[{"label":"Media","fields":[{"label":"Tip","description":"Conținut media opțional de afișat deasupra întrebării."},{"label":"Dezactivați mărirea imaginii"}]},{"label":"Întrebare"},{"label":"Opțiuni disponibile","entity":"opțiune","field":{"label":"Opțiune","fields":[{"label":"Media","description":"Conținut media de afișat ca opțiune."},{"label":"Imagine poster"},{"label":"Corect"}]}},{"label":"Feedback general","fields":[{"widgets":[{"label":"Implicit"}],"label":"Definiți feedback personalizat pentru orice interval de scor","description":"Apăsați butonul \"Adaugă interval\" pentru a adăuga oricâte intervale aveți nevoie. Exemplu: 0-20% Scor slab, 21-91% Scor mediu, 91-100% Scor excelent!","entity":"interval","field":{"fields":[{"label":"Interval scor"},{},{"label":"Feedback pentru intervalul de scor definit","placeholder":"Completați feedback-ul"}]}}]},{"label":"Setări de comportament","description":"Aceste opțiuni vă vor permite să controlați cum se comportă sarcina.","fields":[{"label":"Activați butonul \"Încearcă din nou\""},{"label":"Activați butonul \"Arată soluția\""},{"label":"Afișați dialogul de confirmare la \"Verifică\""},{"label":"Afișați dialogul de confirmare la \"Încearcă din nou\""},{"label":"Acordați un punct pentru întreaga întrebare","description":"Acordă un punct întrebării dacă scorul procentual este mai mare decât procentajul de trecere"},{"label":"Solicitați un răspuns înainte ca soluția să poată fi vizualizată"},{"label":"Tipul întrebării","description":"Selectați aspectul și comportamentul întrebării.","options":[{"label":"Automat"},{"label":"Alegere multiplă (Căsuțe de bifat)"},{"label":"Alegere unică (Butoane radio)"}]},{"label":"Raport de aspect","description":"Selectați raportul de aspect al alternativelor","options":[{"label":"Automat"},{"label":"16:9"},{"label":"4:3"},{"label":"3:2"},{"label":"1:1"}]},{"label":"Număr maxim de alternative pe rând","description":"Setați numărul maxim de alternative pe rând pentru a vă asigura că întrebările arată bine.","options":[{"label":"1"},{"label":"2"},{"label":"3"},{"label":"4"}]},{"label":"Procentaj de trecere","description":"Această setare adesea nu va avea niciun efect. Este procentajul din scorul total necesar pentru a obține 1 punct atunci când este activat un punct pentru întreaga sarcină și pentru a obține result.success în declarațiile xAPI."}]},{"label":"Interfață utilizator","fields":[{"label":"Text pentru butonul \"Verifică\"","default":"Verifică"},{"label":"Text pentru butonul \"Trimite\"","default":"Trimite"},{"label":"Descriere pentru tehnologia asistivă a butonului \"Verifică\"","default":"Verifică răspunsurile. Răspunsurile vor fi marcate ca fiind corecte, incorecte sau fără răspuns."},{"label":"Text pentru butonul \"Arată soluția\"","default":"Arată soluția"},{"label":"Descriere pentru tehnologia asistivă a butonului \"Arată soluția\"","default":"Arată soluția. Opțiunile corecte vor fi marcate."},{"label":"Răspuns corect (nu se afișează)","default":"Răspuns corect"},{"label":"Răspuns greșit (nu se afișează)","default":"Răspuns greșit"},{"label":"Opțiunea ar fi trebuit bifată","default":"Ar fi trebuit bifat"},{"label":"Opțiunea nu ar fi trebuit bifată","default":"Nu ar fi trebuit bifat"},{"label":"Text pentru mesajul \"Necesită răspuns\"","default":"Vă rugăm să răspundeți înainte de a vizualiza soluția"},{"label":"Text pentru butonul \"Încearcă din nou\"","default":"Încearcă din nou"},{"label":"Descriere pentru tehnologia asistivă a butonului \"Încearcă din nou\"","default":"Reîncercați sarcina. Resetați toate răspunsurile și începeți sarcina din nou."},{"label":"Rezultatul dumneavoastră","description":":num și :total sunt variabile și vor fi înlocuite cu valorile lor respective.","default":"Ați obținut :num din :total puncte"},{"label":"Dialog de confirmare la verificare","fields":[{"label":"Text antet","default":"Finalizați?"},{"label":"Text corp","default":"Sunteți sigur că doriți să finalizați?"},{"label":"Etichetă buton Anulare","default":"Anulează"},{"label":"Etichetă buton Confirmare","default":"Finalizează"}]},{"label":"Dialog de confirmare la reîncercare","fields":[{"label":"Text antet","default":"Reîncercați?"},{"label":"Text corp","default":"Sunteți sigur că doriți să reîncercați?"},{"label":"Etichetă buton Anulare","default":"Anulează"},{"label":"Etichetă buton Confirmare","default":"Reîncearcă"}]},{"label":"Text dacă textul alternativ lipsește pentru o imagine","default":"Text alternativ lipsește"},{"label":"Etichetă buton închidere fereastră modală","default":"Închide fereastra modală"}]}]}'), JSON_PRETTY_PRINT|JSON_UNESCAPED_UNICODE)
        ]);

        DB::table('h5p_libraries_languages')->insert([
            'library_id' => $libId,
            'language_code' => 'ru',
            'translation' => json_encode(json_decode('{"semantics":[{"label":"Медиа","fields":[{"label":"Тип","description":"Необязательный носитель для отображения над вопросом."},{"label":"Отключить масштабирование изображения"}]},{"label":"Вопрос"},{"label":"Доступные параметры","entity":"опция","field":{"label":"Опция","fields":[{"label":"Медиа","description":"Media to display as a choice."},{"label":"Poster image"},{"label":"Правильно"}]}},{"label":"Общая обратная связь","fields":[{"widgets":[{"label":"По умолчанию"}],"label":"Определить пользовательский отзыв для любого диапазона баллов","description":"Нажмите кнопку \"Добавить диапазон\", чтобы добавить столько диапазонов, сколько вам нужно. Пример: 0-20% Плохая оценка, 21-91% Средняя оценка, 91-100% Отличная оценка!","entity":"диапазон","field":{"fields":[{"label":"Диапазон очков"},{},{"label":"Отзыв для определенного диапазона баллов","placeholder":"Заполните отзыв"}]}}]},{"label":"Поведенческие настройки","description":"Эти параметры позволят вам контролировать поведение задачи.","fields":[{"label":"Включить кнопку \"Повторить\""},{"label":"Включить кнопку \"Показать решение\""},{"label":"Показать диалоговое окно подтверждения при \"Проверке\""},{"label":"Показать диалоговое окно подтверждения при \"Повторной попытке\""},{"label":"Поставьте один балл за весь вопрос","description":"Присуждается один балл за вопрос, если процентная оценка выше, чем процент прохождения"},{"label":"Требуется ответ перед просмотром решения"},{"label":"Тип вопроса","description":"Выберите внешний вид и поведение вопроса.","options":[{"label":"Автоматически"},{"label":"Множественный выбор (флажки)"},{"label":"Единственный выбор (радио-кнопки)"}]},{"label":"Соотношение сторон","description":"Выберите соотношение сторон альтернатив","options":[{"label":"Автоматически"},{"label":"16:9"},{"label":"4:3"},{"label":"3:2"},{"label":"1:1"}]},{"label":"Максимальное количество альтернатив в строке","description":"Установите максимальное количество вариантов в строке, чтобы вопросы выглядели правильно.","options":[{"label":"1"},{"label":"2"},{"label":"3"},{"label":"4"}]},{"label":"Процент прохождения","description":"Эта настройка часто не имеет никакого эффекта. Это процент от общего балла, необходимый для получения 1 балла, когда включен один балл за всю задачу, и для получения результата. успех в операторах xAPI."}]},{"label":"Пользовательский интерфейс","fields":[{"label":"Текст для кнопки \"Проверить\"","default":"Проверить"},{"label":"Текст для кнопки \"Отправить\"","default":"Отправить"},{"label":"Описание вспомогательной технологии для кнопки \"Проверить\"","default":"Проверьте ответы. Ответы будут помечены как правильные, неправильные или оставшиеся без ответа."},{"label":"Текст для кнопки \"Показать решение\"","default":"Показать решение"},{"label":"Описание вспомогательной технологии для кнопки \"Показать решение\"","default":"Показать решение. Правильные варианты будут отмечены."},{"label":"Правильный ответ (не отображается)","default":"Правильный ответ"},{"label":"Неверный ответ (не отображается)","default":"Неверный ответ"},{"label":"Опция должна быть проверена","default":"Должно быть проверено"},{"label":"Опция не должна быть отмечена","default":"Не должен был проверяться"},{"label":"Текст сообщения \"Требуется ответ\"","default":"Пожалуйста, ответьте перед просмотром решения"},{"label":"Текст для кнопки \"Повторить\"","default":"Повторить попытку"},{"label":"Описание вспомогательной технологии для кнопки \"Повторить\"","default":"Повторите попытку. Сбросьте все ответы и запустите задачу заново."},{"label":"Ваш результат","description":":num и :total являются переменными и будут заменены соответствующими значениями.","default":"Вы получили :num из :total очков"},{"label":"Диалог подтверждения проверки","fields":[{"label":"Текст заголовка","default":"Готово?"},{"label":"Основной текст","default":"Вы уверены, что хотите закончить?"},{"label":"Название кнопки \"Отменить\"","default":"Отмена"},{"label":"Подтвердить метку кнопки","default":"Готово"}]},{"label":"Повторить диалоговое окно подтверждения","fields":[{"label":"Текст заголовка","default":"Повторить попытку?"},{"label":"Основной текст","default":"Вы уверены, что хотите повторить попытку?"},{"label":"Название кнопки \"Отменить\"","default":"Отмена"},{"label":"Подтвердить метку кнопки","default":"Повторить попытку"}]},{"label":"Текст, если для изображения отсутствует замещающий текст","default":"Отсутствует альтернативный текст"},{"label":"Close modal button label","default":"Close modal"}]}]}'), JSON_PRETTY_PRINT|JSON_UNESCAPED_UNICODE)
        ]);

        DB::table('h5p_libraries_languages')->insert([
            'library_id' => $libId,
            'language_code' => 'sl',
            'translation' => json_encode(json_decode('{"semantics":[{"label":"Mediji","fields":[{"label":"Tip","description":"Neobvezna nastavitev dodatnega medija za prikaz nad vprašanjem."},{"label":"Onemogoči povečavo slike"}]},{"label":"Vprašanje"},{"label":"Razpoložljive možnosti","entity":"možnost","field":{"label":"Možnost","fields":[{"label":"Medij","description":"Media to display as a choice."},{"label":"Poster image"},{"label":"Pravilen odgovor"}]}},{"label":"Splošna povratna informacija","fields":[{"widgets":[{"label":"Privzeto"}],"label":"Določi ločeno povratno informacijo za vsak razpon rezultatov","description":"Kliknite gumb \"Dodaj razpon\" za dodajanje dodatnih razponov. Primer: 0-20 % Slab rezultat, 21-91 % Povprečen rezultat, 91-100 % Odličen rezultat!","entity":"razpon","field":{"fields":[{"label":"Razpon rezultatov"},{},{"label":"Povratna informacija za definiran razpon rezultatov","placeholder":"Vnesite povratno informacijo"}]}}]},{"label":"Nastavitve interakcije","description":"Nastavitve omogočajo nadzor nad interakcijo aktivnosti za udeležence.","fields":[{"label":"Omogoči gumb \"Poskusi ponovno\""},{"label":"Omogoči gumb \"Prikaži rešitev\""},{"label":"Pred oddajo odgovora z gumbom \"Preveri\" zahtevaj potrditev"},{"label":"Pred ponovitvijo aktivnosti z gumbom \"Poskusi ponovno\" zahtevaj potrditev"},{"label":"Nalogo oceni z 1 točko kot celoto","description":"Točka je podeljena, ko je odstotek uspešnosti pri nalogi višji od zastavljenega odstotka za prag napredovanja."},{"label":"Pred ogledom rešitve je potrebno podati odgovor"},{"label":"Tip vprašanja","description":"Ureditev videza in vedenja vprašanja.","options":[{"label":"Določi samodejno"},{"label":"Več odgovorov (Checkboxes)"},{"label":"En odgovor (Radio Buttons)"}]},{"label":"Razmerje stranic","description":"Določitev razmerja stranic pri prikazu slik z možnimi odgovori","options":[{"label":"Samodejno"},{"label":"16:9"},{"label":"4:3"},{"label":"3:2"},{"label":"1:1"}]},{"label":"Dovoljeno število slik na vrstico","description":"Določitev najvišjega dovoljenega števila slik z odgovori na vrstico. Vpliva na izgled aktivnosti.","options":[{"label":"1"},{"label":"2"},{"label":"3"},{"label":"4"}]},{"label":"Prag za napredovanje","description":"Odstotek, ki je potreben za uspešen zaključek naloge oz. prejeto 1 točko. Nastavitev ima učinek zgolj pri izbiri \"Nalogo oceni z 1 točko kot celoto\" in beleženjem dosežka kot stavka xAPI."}]},{"label":"Preglasitve besedil in prevodov","fields":[{"label":"Besedilo za gumb \"Preveri\"","default":"Preveri"},{"label":"Text for \"Submit\" button","default":"Submit"},{"label":"Opis gumba \"Preveri\" za bralnike zaslona","default":"Preveri pravilnost. Odgovori bodo označeni kot pravilni, napačni ali brez odgovorov."},{"label":"Besedilo za gumb \"Prikaži rešitev\"","default":"Prikaži rešitev"},{"label":"Opis gumba \"Prikaži rešitev\" za bralnike zaslona","default":"Prikaže rešitev. Pravilni odgovori bodo označeni."},{"label":"Pravilen odgovor (ni prikazan)","default":"Pravilen odgovor"},{"label":"Nepravilen odgovor (ni prikazan)","default":"Nepravilen odgovor"},{"label":"Možnost bi morala biti izbrana","default":"Možnost bi morala biti izbrana"},{"label":"Možnost ne bi smela biti izbrana","default":"Možnost ne bi smela biti izbrana"},{"label":"Besedilo za sporočilo o manjkajočem odgovoru","default":"Pred ogledom rešitve podajte odgovor"},{"label":"Besedilo za gumb \"Poskusi ponovno\"","default":"Poskusi ponovno"},{"label":"Opis gumba \"Poskusi ponovno\" za bralnike zaslona","default":"Omogoči ponoven poskus. Ponastavi vse odzive in znova zažene nalogo."},{"label":"Rezultat reševanja","description":"Spremenljivki sta :num in :total.","default":"Seštevek točk: :num od :total"},{"label":"Pogovorno okno pred oddajo odgovora","fields":[{"label":"Naslov","default":"Zaključi?"},{"label":"Besedilo telesa pogovornega okna","default":"Ste prepričani, da želite zaključiti?"},{"label":"Besedilo gumba Prekliči","default":"Prekliči"},{"label":"Besedilo gumba Potrdi","default":"Potrdi"}]},{"label":"Pogovorno okno pred ponovitvijo aktivnosti","fields":[{"label":"Naslov","default":"Poskusi ponovno?"},{"label":"Besedilo telesa pogovornega okna","default":"Ste prepričani, da želite poskusiti ponovno?"},{"label":"Besedilo gumba Prekliči","default":"Prekliči"},{"label":"Besedilo gumba Potrdi","default":"Potrdi"}]},{"label":"Besedilo, če za sliko manjka nadomestno besedilo","default":"Nadomestno besedilo manjka"},{"label":"Close modal button label","default":"Close modal"}]}]}'), JSON_PRETTY_PRINT|JSON_UNESCAPED_UNICODE)
        ]);

        DB::table('h5p_libraries_languages')->insert([
            'library_id' => $libId,
            'language_code' => 'sr',
            'translation' => json_encode(json_decode('{"semantics":[{"label":"Медија","fields":[{"label":"Тип","description":"Опциони медији за приказ изнад питања."},{"label":"Онемогући увеличавање слике"}]},{"label":"Питање"},{"label":"Доступне опције","entity":"опција","field":{"label":"Опција","fields":[{"label":"Медија","description":"Media to display as a choice."},{"label":"Poster image"},{"label":"Тачно"}]}},{"label":"Општа повратна информација","fields":[{"widgets":[{"label":"Уобичајено"}],"label":"Дефинишите прилагођене повратне информације за било који опсег резултата","description":"Кликните на \"Додај опсег\" дугме да додате онолико распона колико вам је потребно. Пример: 0-20% Лош резултат, 21-91% Просечан резултат, 91-100% Одличан резултат!","entity":"опсег","field":{"fields":[{"label":"Распон бодова"},{},{"label":"Повратне информације за дефинисани распон бодова","placeholder":"Попуните повратне информације"}]}}]},{"label":"Поставке понашања","description":"Ове опције ће вам омогућити да контролишете како се задатак понаша.","fields":[{"label":"Омогући \"Прикажи поново\" дугме"},{"label":"Омогући \"Прикажи решења\" дугме"},{"label":"Прикажи дијалог за потврду за \"Провери\""},{"label":"Прикажи дијалог за потврду за \"Покушај поново\""},{"label":"Дајте један поен за цело питање","description":"Додељује један поен на питање да ли је процентуални резултат већи од пролазног процента."},{"label":"Захтевајте одговор пре него што се решење види"},{"label":"Тип питања","description":"Одаберите изглед и понашање питања.","options":[{"label":"Аутоматски"},{"label":"Више избора (Checkboxes)"},{"label":"Један избор (Radio Buttons)"}]},{"label":"Размера","description":"Изаберите однос ширине и висине","options":[{"label":"Аутоматска"},{"label":"16:9"},{"label":"4:3"},{"label":"3:2"},{"label":"1:1"}]},{"label":"Максималне алтернативе по реду","description":"Подесите максималан број алтернатива по реду како бисте осигурали да питања изгледају у реду.","options":[{"label":"1"},{"label":"2"},{"label":"3"},{"label":"4"}]},{"label":"Проценат пролаза","description":"Ова поставка често неће имати ефекта. То је проценат укупног резултата потребног за добијање 1 бода када је омогућен један поен за цео задатак и за постизање result.success у xAPI изразима."}]},{"label":"Кориснички интерфејс","fields":[{"label":"Текст за \"Провери\" дугме","default":"Провери"},{"label":"Text for \"Submit\" button","default":"Submit"},{"label":"Опис помоћне технологије за \"Провери\" дугме","default":"Проверите одговоре. Одговори ће бити означени као тачни, нетачни или без одговора."},{"label":"Текст за \"Прикажи решења\" дугме","default":"Прикажи решења"},{"label":"Опис помоћне технологије за \"Прикажи решења\" дугме","default":"Покажите решење. Тачне опције ће бити означене."},{"label":"Тачан одговор (није приказано)","default":"Тачан  одговор"},{"label":"Погрешан одговор (није приказано)","default":"Погрешан одговор"},{"label":"Опцију је требало проверити","default":"Требало је проверити"},{"label":"Опцију није требало проверавати","default":"Није требало проверавати"},{"label":"Текст за \"Захтева одговор\" поруку","default":"Одговорите пре него што погледате решење."},{"label":"Текст за \"Покушајте поново\" дугме","default":"Покушај поново"},{"label":"Опис помоћне технологије за \"Покушај поново\" дугме","default":"Покушајте поново задатак. Ресетујте све одговоре и започните задатак изнова."},{"label":"Ваш резултат","description":":num и :total су променљиве и биће замењене одговарајућим вредностима.","default":"Освојили сте :num од :total поена"},{"label":"Проверите дијалог за потврду","fields":[{"label":"Текст заглавља","default":"Готово?"},{"label":"Текст тела","default":"Јесте ли сигурни да желите да завршите?"},{"label":"Ознака дугмета Откажи","default":"Откажи"},{"label":"Ознака дугмета за потврду","default":"Заврши"}]},{"label":"Дијалог за потврду поновног покушаја","fields":[{"label":"Текст заглавља","default":"Покушај поново?"},{"label":"Текст тела","default":"Да ли сте сигурни да желите да покушате поново?"},{"label":"Ознака дугмета Откажи","default":"Откажи"},{"label":"Ознака дугмета за потврду","default":"Покушај поново"}]},{"label":"Текст ако за слику недостаје алтернативни текст","default":"Недостаје алтернативни текст."},{"label":"Close modal button label","default":"Close modal"}]}]}'), JSON_PRETTY_PRINT|JSON_UNESCAPED_UNICODE)
        ]);

        DB::table('h5p_libraries_languages')->insert([
            'library_id' => $libId,
            'language_code' => 'sw',
            'translation' => json_encode(json_decode('{"semantics":[{"label":"Vyombo vya habari","fields":[{"label":"Aina","description":"Vyombo vya habari vya hiari vya kuonyesha juu ya swali."},{"label":"Zima ukuzaji wa picha"}]},{"label":"Swali"},{"label":"Chaguzi zinazopatikana","entity":"chaguo","field":{"label":"Chaguo","fields":[{"label":"Vyombo vya habari","description":"Media to display as a choice."},{"label":"Poster image"},{"label":"Sahihi"}]}},{"label":"Maoni ya Jumla","fields":[{"widgets":[{"label":"Chaguo-msingi"}],"label":"Bainisha maoni maalum kwa masafa yoyote ya alama","description":"Bofya kitufe cha \"Ongeza masafa\" ili kuongeza masafa mengi unavyohitaji. Mfano: 0-20% Alama mbaya, 21-91% Alama ya Wastani, 91-100% Alama Nzuri!","entity":"masafa","field":{"fields":[{"label":"Masafa ya Alama"},{},{"label":"Maoni kwa masafa ya alama yaliyofafanuliwa","placeholder":"Jaza maoni"}]}}]},{"label":"Mipangilio ya tabia","description":"Chaguzi hizi zitakuwezesha kudhibiti jinsi kazi inavyofanya.","fields":[{"label":"Washa kitufe cha \"Jaribu tena\""},{"label":"Washa kitufe cha \"Onesha Suluhisho\""},{"label":"Onyesha mazungumzo ya uthibitisho kwenye \"Weka alama\""},{"label":"Onyesha mazungumzo ya uthibitisho kwenye \"Jaribu tena\""},{"label":"Toa pointi moja kwa swali zima","description":"Hutoa pointi moja kwa swali ikiwa alama ya asilimia ni kubwa kuliko asilimia ya ufaulu"},{"label":"Hitaji jibu kabla ya suluhisho kutazamwa"},{"label":"Aina ya Swali","description":"Chagua mwonekano na tabia ya swali.","options":[{"label":"Otomatiki"},{"label":"Chaguo nyingi (Visanduku vya kuteua)"},{"label":"Chaguo Moja (Vitufe vya Redio)"}]},{"label":"Uwiano wa vipengele","description":"Chagua uwiano wa vipengele vya mbadala","options":[{"label":"Otomatiki"},{"label":"16:9"},{"label":"4:3"},{"label":"3:2"},{"label":"1:1"}]},{"label":"Njia mbadala za juu kwa kila safu mlalo","description":"Weka idadi ya juu ya mbadala kwa kila safu mlalo ili kuhakikisha kuwa maswali yanaonekana sawa.","options":[{"label":"1"},{"label":"2"},{"label":"3"},{"label":"4"}]},{"label":"Asilimia ya ufaulu","description":"Mpangilio huu mara nyingi hautakuwa na athari yoyote. Ni asilimia ya jumla ya alama inayohitajika kwa kupata pointi 1 wakati pointi moja kwa kazi nzima imewashwa, na kwa kupata mafanikio ya matokeo katika taarifa za Kiolesura cha Programu ya Uzoefu."}]},{"label":"Kiolesura cha mtumiaji","fields":[{"label":"Maandishi ya kitufe cha \"Weka alama\"","default":"Weka alama"},{"label":"Maandishi ya kitufe cha \"Wasilisha\"","default":"Wasilisha"},{"label":"Maelezo ya teknolojia ya usaidizi kwa kitufe cha \"Weka alama\"","default":"Weka alama majibu. Majibu yatatiwa alama kuwa sahihi, siyo sahihi au haijajibiwa."},{"label":"Maandishi kwa kitufe cha \"Onyesha suluhisho\"","default":"Onyesha suluhisho"},{"label":"Maelezo ya teknolojia ya usaidizi kwa kitufe cha \"Onyesha Suluhisho\"","default":"Onyesha suluhisho hilo. Chaguzi sahihi zitawekwa alama."},{"label":"Jibu Sahihi (halijaonyeshwa)","default":"Jibu sahihi"},{"label":"Jibu lisilo sahihi (halijaonyeshwa)","default":"Jibu lisilo sahihi"},{"label":"Chaguo lilipaswa kuwekwa alama","default":"Lilipaswa kuwekwa alama"},{"label":"Chaguo halikupaswa kuwekwa alama","default":"Halikupaswa kuwekwa alama"},{"label":"Maandishi ya ujumbe wa \"Inahitaji jibu\"","default":"Tafadhali jibu kabla ya kutazama suluhisho"},{"label":"Maandishi kwa kitufe cha \"Jaribu tena\"","default":"Jaribu tena"},{"label":"Maelezo ya teknolojia ya usaidizi kwa kitufe cha \"Jaribu tena\"","default":"Jaribu tena kazi hiyo. Weka upya majibu yote na uanze kazi tena."},{"label":"Matokeo yako","description":":numna :total ni vigezo na vitabadilishwa na thamani yao husika.","default":"Umepata :num kati ya alama:total"},{"label":"Weka alama mazungumzo ya uthibitisho","fields":[{"label":"Maandishi ya kichwa","default":"Umemaliza?"},{"label":"Maandishi ya kiini","default":"Una uhakika unataka kumaliza?"},{"label":"Ghairi lebo ya kitufe","default":"Ghairi"},{"label":"Lebo ya kitufe cha kuthibitisha","default":"Maliza"}]},{"label":"Jaribu tena mazungumzo ya uthibitisho","fields":[{"label":"Maandishi ya kichwa","default":"Jaribu tena?"},{"label":"Maandishi ya kiini","default":"Una uhakika unataka kujaribu tena?"},{"label":"Ghairi lebo ya kitufe","default":"Ghairi"},{"label":"Lebo ya kitufe cha kuthibitisha","default":"Jaribu tena"}]},{"label":"Maandishi ikiwa maandishi mbadala hayapo kwa picha","default":"Maandishi mbadala hayapo"},{"label":"Close modal button label","default":"Close modal"}]}]}'), JSON_PRETTY_PRINT|JSON_UNESCAPED_UNICODE)
        ]);

        DB::table('h5p_libraries_languages')->insert([
            'library_id' => $libId,
            'language_code' => 'th',
            'translation' => json_encode(json_decode('{"semantics":[{"label":"สื่อ","fields":[{"label":"ประเภท","description":"สื่อทางเลือกที่จะแสดงเหนือคำถาม (ถ้ามี)"},{"label":"ปิดฟังก์ชั่นการซูมรูปภาพ"}]},{"label":"คำถาม"},{"label":"ตัวเลือกที่มีอยู่","entity":"option","field":{"label":"ตัวเลือก","fields":[{"label":"สื่อ","description":"Media to display as a choice."},{"label":"Poster image"},{"label":"ถูกต้อง"}]}},{"label":"คำติชมโดยรวม","fields":[{"widgets":[{"label":"ค่าเริ่มต้น"}],"label":"กำหนดคำติชมแบบกำหนดเองสำหรับช่วงคะแนนใดๆ","description":"คลิกที่ปุ่ม \"เพิ่มช่วง\" เพื่อเพิ่มช่วงคะแนนตามที่คุณต้องการ เช่น 0-20% คะแนนแย่ 21-91% คะแนนปานกลาง 91-100% คะแนนดีมาก!","entity":"range","field":{"fields":[{"label":"ช่วงคะแนน"},{},{"label":"คำติชมสำหรับช่วงคะแนนที่กำหนด","placeholder":"ใส่คำติชม"}]}}]},{"label":"การตั้งค่าพฤติกรรม","description":"ตัวเลือกเหล่านี้จะช่วยคุณควบคุมพฤติกรรมการทำงานของงาน","fields":[{"label":"เปิดใช้งานปุ่ม \"ลองอีกครั้ง\""},{"label":"เปิดใช้งานปุ่ม \"แสดงคำตอบ\""},{"label":"แสดงกล่องสนทนายืนยันเมื่อกด \"ตรวจสอบ\""},{"label":"แสดงกล่องสนทนายืนยันเมื่อกด \"ลองอีกครั้ง\""},{"label":"ให้คะแนน 1 คะแนนสำหรับคำถามทั้งหมด","description":"ให้คะแนน 1 คะแนนสำหรับคำถามเมื่อร้อยละของคะแนนสูงกว่าร้อยละที่ตั้งค่าไว้ในการผ่าน"},{"label":"ต้องการคำตอบก่อนที่จะดูคำตอบที่ถูกต้อง"},{"label":"ประเภทคำถาม","description":"เลือกลักษณะและพฤติกรรมของคำถาม","options":[{"label":"อัตโนมัติ"},{"label":"เลือกหลายตัวเลือก (ช่องเลือก)"},{"label":"เลือกเดียว (ปุ่มวิทยุ)"}]},{"label":"อัตราส่วนของด้าน","description":"เลือกอัตราส่วนของตัวเลือกที่แสดง","options":[{"label":"อัตโนมัติ"},{"label":"16:9"},{"label":"4:3"},{"label":"3:2"},{"label":"1:1"}]},{"label":"จำนวนตัวเลือกสูงสุดต่อแถว","description":"ตั้งค่าจำนวนตัวเลือกสูงสุดต่อแถวเพื่อให้คำถามดูถูกต้อง","options":[{"label":"1"},{"label":"2"},{"label":"3"},{"label":"4"}]},{"label":"ร้อยละการผ่าน","description":"การตั้งค่านี้มักจะไม่มีผลใด ๆ กับการให้คะแนนครึ่งหนึ่งสำหรับงานทั้งหมดเมื่อใช้คะแนนการผ่านร้อยละในรายงาน xAPI"}]},{"label":"อินเตอร์เฟซผู้ใช้","fields":[{"label":"ข้อความสำหรับปุ่ม \"ตรวจสอบ\"","default":"ตรวจสอบ"},{"label":"ข้อความสำหรับปุ่ม \"ส่ง\"","default":"ส่ง"},{"label":"คำอธิบายเทคโนโลยีช่วยให้เข้าใจได้สำหรับปุ่ม \"ตรวจสอบ\"","default":"ตรวจสอบคำตอบ การตอบรับจะถูกทำเครื่องหมายว่าถูกต้อง ไม่ถูกต้อง หรือไม่ได้ตอบ"},{"label":"ข้อความสำหรับปุ่ม \"แสดงคำตอบ\"","default":"แสดงคำตอบ"},{"label":"คำอธิบายเทคโนโลยีช่วยให้เข้าใจได้สำหรับปุ่ม \"แสดงคำตอบ\"","default":"แสดงคำตอบที่ถูกต้อง"},{"label":"คำตอบที่ถูกต้อง (ไม่แสดง)","default":"คำตอบที่ถูกต้อง"},{"label":"คำตอบผิด (ไม่แสดง)","default":"คำตอบผิด"},{"label":"ตัวเลือกควรถูกต้อง","default":"ควรถูกต้อง"},{"label":"ตัวเลือกไม่ควรถูกต้อง","default":"ไม่ควรถูกต้อง"},{"label":"ข้อความสำหรับข้อความ \"ต้องมีคำตอบ\"","default":"กรุณาตอบก่อนที่จะดูคำตอบ"},{"label":"ข้อความสำหรับปุ่ม \"ลองอีกครั้ง\"","default":"ลองอีกครั้ง"},{"label":"คำอธิบายเทคโนโลยีช่วยให้เข้าใจได้สำหรับปุ่ม \"ลองอีกครั้ง\"","default":"ลองทำงานอีกครั้งโดยไม่ต้องเริ่มต้นใหม่"},{"label":"ข้อความสำหรับปุ่ม \"ยกเลิก\"","description":":num and :total are variables and will be replaced by their respective values.","default":"You got :num out of :total points"},{"label":"Check confirmation dialog","fields":[{"label":"Header text","default":"Finish?"},{"label":"Body text","default":"Are you sure you want to finish?"},{"label":"Cancel button label","default":"Cancel"},{"label":"Confirm button label","default":"Finish"}]},{"label":"Retry confirmation dialog","fields":[{"label":"Header text","default":"Retry?"},{"label":"Body text","default":"Are you sure you wish to retry?"},{"label":"Cancel button label","default":"Cancel"},{"label":"Confirm button label","default":"Retry"}]},{"label":"Text if alt text is missing for an image","default":"Alt text missing"},{"label":"Close modal button label","default":"Close modal"}]}]}'), JSON_PRETTY_PRINT|JSON_UNESCAPED_UNICODE)
        ]);

        DB::table('h5p_libraries_languages')->insert([
            'library_id' => $libId,
            'language_code' => 'tr',
            'translation' => json_encode(json_decode('{"semantics":[{"label":"Medya","fields":[{"label":"Tip","description":"Sorunun üzerinde görüntülenecek isteğe bağlı medya."},{"label":"Görüntü yakınlaştırmayı devre dışı bırak"}]},{"label":"Soru"},{"label":"Mevcut seçenekler","entity":"seçenek","field":{"label":"Seçenek","fields":[{"label":"Medya","description":"Media to display as a choice."},{"label":"Poster image"},{"label":"Doğru"}]}},{"label":"Toplam Geribildirim","fields":[{"widgets":[{"label":"Varsayılan"}],"label":"Herhangi bir puan aralığı için özel geri bildirim tanımlayın","description":"İstediğiniz kadar aralık eklemek için \"Aralık ekle\" düğmesini tıklayın. Örnek: %0-20 Kötü puan, %21-91 Ortalama Puan, %91-100 Büyük Puan!","entity":"aralık","field":{"fields":[{"label":"Puan Aralığı"},{},{"label":"Tanımlanmış puan aralığı için geri bildirim","placeholder":"Geri bildirimi doldurun"}]}}]},{"label":"Davranış yarları","description":"Bu seçenekler görevin nasıl davranması gerektiğini kontrol etmenizi sağlar.","fields":[{"label":"\"Yeniden dene\" düğmesini devreye al"},{"label":"\"Çözüm göster\" düğmesini devreye al"},{"label":"\"Kontrol Et\" onay iletişim kutusunu göster"},{"label":"\"Yeniden Dene\" onay iletişim kutusunu göster"},{"label":"Tüm soru için bir puan verin","description":"Yüzde puanı, geçme yüzdesinden yüksekse soruya bir puan verir"},{"label":"Çözümü görüntülenmesi için cevap verilmesini zorunlu tut"},{"label":"Soru Türü","description":"Sorunun görünüş ve davranışını seçin.","options":[{"label":"Otomatik"},{"label":"Çoktan Seçmeli (Onay kutuları)"},{"label":"Tek Seçim (Radyo Düğmeleri)"}]},{"label":"En boy oranı","description":"Alternatiflerin en boy oranını seçin","options":[{"label":"Otomatik"},{"label":"16:9"},{"label":"4:3"},{"label":"3:2"},{"label":"1:1"}]},{"label":"Satır başına maksimum seçenek","description":"Soruların iyi görünmesini sağlamak için satır başına maksimum seçenek sayısını ayarlayın.","options":[{"label":"1"},{"label":"2"},{"label":"3"},{"label":"4"}]},{"label":"Geçme notu (%)","description":"Bu ayarın çoğu zaman herhangi bir etkisi olmaz. Tüm görev için bir puan etkinleştirildiğinde 1 puan almak ve eğitim yönetim sisteminde (Ör: EBA) sonucun başarılı olması için gereken toplam puanın yüzdesidir."}]},{"label":"Kullanıcı arayüzü","fields":[{"label":"\"Kontrol Et\" düğmesi için metin","default":"Kontrol Et"},{"label":"Text for \"Submit\" button","default":"Submit"},{"label":"\"Kontrol Et\" düğmesi için yardımcı teknoloji açıklaması","default":"Cevapları kontrol edin. Cevaplar doğru, yanlış veya cevapsız olarak işaretlenecektir."},{"label":"\"Çözümü göster\" düğmesi için metin","default":"Çözümü göster"},{"label":"\"Çözümü Göster\" düğmesi için yardımcı teknoloji açıklaması","default":"Çözümü göster. Doğru seçenekler işaretlenecektir."},{"label":"Doğru Cevap (görüntülenmiyor)","default":"Doğru cevap"},{"label":"Yanlış Cevap (görüntülenmiyor)","default":"Yanlış cevap"},{"label":"Seçenek işaretlenmeliydi","default":"İşaretlenmeliydi"},{"label":"Seçenek işaretlenmemeliydi","default":"İşaretlenmemeliydi"},{"label":"\"Cevap gerekiyor\" mesajı için metin","default":"Lütfen çözümü görmeden önce cevaplayın"},{"label":"\"Yeniden Dene\" düğmesi metni","default":"Yeniden Dene"},{"label":"\"Yeniden Dene\" düğmesi için yardımcı teknoloji açıklaması","default":"Görevi yeniden deneyin. Tüm yanıtları sıfırlayın ve görevi yeniden başlatın."},{"label":"Sonucun","description":":num ve :total değişkenlerdir ve ilgili değerleriyle değiştirilecektir.","default":":total puandan :num puan aldın"},{"label":"Onay iletişim kutusunu kontrol edin","fields":[{"label":"Başlık metni","default":"Bitir"},{"label":"Gövde metni","default":"Bitirmek istediğinize emin misiniz?"},{"label":"İptal düğmesi etiketi","default":"Hayır"},{"label":"Onaylama düğmesi etiketi","default":"Evet"}]},{"label":"Yeniden dene iletişim kutusunun kontrolü","fields":[{"label":"Başlık metni","default":"Yeniden Dene"},{"label":"Gövde metni","default":"Yeniden denemek istediğinizden emin misiniz?"},{"label":"İptal düğmesi etiketi","default":"Hayır"},{"label":"Onaylama düğmesi etiketi","default":"Evet"}]},{"label":"Bir resim için alternatif metin eksikse metin","default":"Alternatif metin eksik"},{"label":"Close modal button label","default":"Close modal"}]}]}'), JSON_PRETTY_PRINT|JSON_UNESCAPED_UNICODE)
        ]);

        DB::table('h5p_libraries_languages')->insert([
            'library_id' => $libId,
            'language_code' => 'uk',
            'translation' => json_encode(json_decode('{"semantics":[{"label":"Медіа","fields":[{"label":"Тип","description":"Необов\'язковий носій для відображення питання."},{"label":"Вимкнути масштабування зображення"}]},{"label":"Питання"},{"label":"Доступні параметри","entity":"опція","field":{"label":"Опція","fields":[{"label":"Медіа","description":"Media to display as a choice."},{"label":"Poster image"},{"label":"Правильно"}]}},{"label":"Загальний зворотний зв\'язок","fields":[{"widgets":[{"label":"За замовчуванням"}],"label":"Визначити відгук користувача для будь-якого діапазону балів","description":"Натисніть кнопку \"Додати діапазон\", щоб додати стільки діапазонів, скільки вам потрібно. Приклад: 0-20% Погана оцінка, 21-91% Середня оцінка, 91-100% Відмінна оцінка!","entity":"діапазон","field":{"fields":[{"label":"Діапазон очок"},{},{"label":"Відгук для певного діапазону балів","placeholder":"Заповніть відгук"}]}}]},{"label":"Налаштування поведінки","description":"Ці параметри дозволять вам контролювати поведінку завдання.","fields":[{"label":"Увімкнути кнопку \"Повторити\""},{"label":"Включити кнопку \"Показати рішення\""},{"label":"Показати діалогове вікно підтвердження під час \"Перевірки\""},{"label":"Показати діалогове вікно підтвердження при \"Повторній спробі\""},{"label":"Поставте один бал за все питання","description":"Присуджується один бал за питання, якщо відсоткова оцінка вища, ніж відсоток проходження"},{"label":"Потрібна відповідь перед переглядом рішення"},{"label":"Тип питання","description":"Виберіть зовнішній вигляд та поведінку питання.","options":[{"label":"Автоматично"},{"label":"Множинний вибір (прапорці)"},{"label":"Єдиний вибір (радіо-кнопки)"}]},{"label":"Співвідношення сторін","description":"Виберіть співвідношення сторін альтернатив","options":[{"label":"Автоматично"},{"label":"16:9"},{"label":"4:3"},{"label":"3:2"},{"label":"1:1"}]},{"label":"Максимальна кількість альтернатив у рядку","description":"Встановіть максимальну кількість варіантів у рядку, щоб питання виглядали правильно.","options":[{"label":"1"},{"label":"2"},{"label":"3"},{"label":"4"}]},{"label":"Відсоток проходження","description":"Це налаштування часто не має жодного ефекту. Це відсоток від загального балу, необхідний для отримання 1 бала, коли включено один бал за все завдання, і для отримання результату. успіх в операторах xAPI."}]},{"label":"Інтерфейс користувача","fields":[{"label":"Текст для кнопки \"Перевірити\"","default":"Перевірити"},{"label":"Текст для кнопки \"Відправити\"","default":"Надіслати"},{"label":"Опис допоміжної технології для кнопки \"Перевірити\"","default":"Перевірте відповіді. Відповіді будуть позначені як правильні, неправильні або без відповіді."},{"label":"Текст для кнопки \"Показати рішення\"","default":"Показати рішення"},{"label":"Опис допоміжної технології для кнопки \"Показати рішення\"","default":"Показати рішення. Правильні варіанти будуть позначені."},{"label":"Правильна відповідь (не відображається)","default":"Правильна відповідь"},{"label":"Неправильна відповідь (не відображається)","default":"Неправильна відповідь"},{"label":"Опція має бути перевірена","default":"Повинно бути перевірено"},{"label":"Опція не повинна бути відзначена","default":"Не повинен був перевірятися"},{"label":"Текст повідомлення \"Потрібна відповідь\"","default":"Будь ласка, дайте відповідь перед переглядом рішення"},{"label":"Текст для кнопки \"Повторити\"","default":"Повторити спробу"},{"label":"Опис допоміжної технології для кнопки \"Повторити\"","default":"Повторіть спробу. Скиньте всі відповіді та запустіть завдання знову."},{"label":"Ваш результат","description":":num і :total є змінними і будуть замінені відповідними значеннями.","default":"Ви отримали :num з :total очок"},{"label":"Діалог підтвердження перевірки","fields":[{"label":"Текст заголовка","default":"Готово?"},{"label":"Основний текст","default":"Ви впевнені, що хочете закінчити?"},{"label":"Назва кнопки \"Скасувати\"","default":"Скасувати"},{"label":"Підтвердити мітку кнопки","default":"Готово"}]},{"label":"Повторити діалогове вікно підтвердження","fields":[{"label":"Текст заголовка","default":"Повторити спробу?"},{"label":"Основний текст","default":"Ви впевнені, що хочете повторити спробу?"},{"label":"Назва кнопки \"Скасувати\"","default":"Скасувати"},{"label":"Підтвердити мітку кнопки","default":"Повторити спробу"}]},{"label":"Текст, якщо для зображення відсутній текст, що заміщає","default":"Відсутній альтернативний текст"},{"label":"Close modal button label","default":"Close modal"}]}]}'), JSON_PRETTY_PRINT|JSON_UNESCAPED_UNICODE)
        ]);

        DB::table('h5p_libraries_languages')->insert([
            'library_id' => $libId,
            'language_code' => 'zh-hant',
            'translation' => json_encode(json_decode('{"semantics":[{"label":"Media","fields":[{"label":"Type","description":"Optional media to display above the question."},{"label":"Disable image zooming"}]},{"label":"Question"},{"label":"Available options","entity":"option","field":{"label":"Option","fields":[{"label":"Media","description":"Media to display as a choice."},{"label":"Poster image"},{"label":"Correct"}]}},{"label":"Overall Feedback","fields":[{"widgets":[{"label":"Default"}],"label":"Define custom feedback for any score range","description":"Click the \"Add range\" button to add as many ranges as you need. Example: 0-20% Bad score, 21-91% Average Score, 91-100% Great Score!","entity":"range","field":{"fields":[{"label":"Score Range"},{},{"label":"Feedback for defined score range","placeholder":"Fill in the feedback"}]}}]},{"label":"Behavioural settings","description":"These options will let you control how the task behaves.","fields":[{"label":"Enable \"Retry\" button"},{"label":"Enable \"Show Solution\" button"},{"label":"Show confirmation dialog on \"Check\""},{"label":"Show confirmation dialog on \"Retry\""},{"label":"Give one point for the whole question","description":"Awards one point to the question if the percentage score is higher than the pass percentage"},{"label":"Require answer before the solution can be viewed"},{"label":"Question Type","description":"Select the look and behaviour of the question.","options":[{"label":"Automatic"},{"label":"Multiple Choice (Checkboxes)"},{"label":"Single Choice (Radio Buttons)"}]},{"label":"Aspect ratio","description":"Select the aspect ratio of the alternatives","options":[{"label":"Automatic"},{"label":"16:9"},{"label":"4:3"},{"label":"3:2"},{"label":"1:1"}]},{"label":"Maximum alternatives per row","description":"Set the maximum number of alternatives per row to ensure the questions look alright.","options":[{"label":"1"},{"label":"2"},{"label":"3"},{"label":"4"}]},{"label":"Pass percentage","description":"This setting often won\'t have any effect. It is the percentage of the total score required for getting 1 point when one point for the entire task is enabled, and for getting result.success in xAPI statements."}]},{"label":"User interface","fields":[{"label":"Text for \"Check\" button","default":"查看"},{"label":"Text for \"Submit\" button","default":"提交"},{"label":"Assistive technology description for \"Check\" button","default":"查看答案。回答會評為正確、錯誤或未回答。"},{"label":"Text for \"Show solution\" button","default":"顯示解答"},{"label":"Assistive technology description for \"Show Solution\" button","default":"顯示解答。此測試會以正解評分。"},{"label":"Correct Answer (not displayed)","default":"Correct answer"},{"label":"Wrong Answer (not displayed)","default":"Wrong answer"},{"label":"Option should have been checked","default":"Should have been checked"},{"label":"Option should not have been checked","default":"Should not have been checked"},{"label":"Text for \"Requires answer\" message","default":"Please answer before viewing the solution"},{"label":"Text for \"Retry\" button","default":"重試"},{"label":"Assistive technology description for \"Retry\" button","default":"重新嘗試。重置所有回答，重新開始測試。"},{"label":"Your result","description":":num and :total are variables and will be replaced by their respective values.","default":"You got :num out of :total points"},{"label":"Check confirmation dialog","fields":[{"label":"Header text","default":"完成嗎?"},{"label":"Body text","default":"你確定要完成嗎？"},{"label":"Cancel button label","default":"取消"},{"label":"Confirm button label","default":"完成嗎"}]},{"label":"Retry confirmation dialog","fields":[{"label":"Header text","default":"重試?"},{"label":"Body text","default":"Are you sure you wish to retry?"},{"label":"Cancel button label","default":"取消"},{"label":"Confirm button label","default":"重試"}]},{"label":"Text if alt text is missing for an image","default":"Alt text missing"},{"label":"Close modal button label","default":"Close modal"}]}]}'), JSON_PRETTY_PRINT|JSON_UNESCAPED_UNICODE)
        ]);
    }
}
