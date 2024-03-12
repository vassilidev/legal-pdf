<?php

namespace Database\Seeders;

use App\Models\EditorUi;
use Illuminate\Database\Seeder;

class EditorUiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        EditorUi::query()->insert([
            [
                'name'    => 'answers php',
                'content' => '{{ $answers[\'\'] }}'
            ],
            [
                'name'    => '[answers]',
                'content' => '[answers->]'
            ],
            [
                'name'    => '[values]',
                'content' => '[values->]'
            ],
            [
                'name'    => 'Next Article Number',
                'content' => '[nextArticleNumber]'
            ],
            [
                'name'    => 'Article Number',
                'content' => '[articleNumber]'
            ],
            [
                'name'    => 'Start Blur',
                'content' => '[startBlur]',
            ],
            [
                'name'    => 'End blur',
                'content' => '[endBlur]',
            ],
            [
                'name'    => 'Loop',
                'content' => '@foreach($answers[\'\'] ?? [] as $answer)<br>
                    {{ $answer }}<br>
                    @endforeach'
            ],
            [
                'name'    => 'Signature',
                'content' => '[signature]'
            ],
            [
                'name'    => 'New PDF Page',
                'content' => '<pre>[pageBreak]</pre>'
            ],
            [
                'name' => '@if',
                'content' => '@if("" == "")<br>
                    text<br>
                @endif',
            ]
        ]);
    }
}
