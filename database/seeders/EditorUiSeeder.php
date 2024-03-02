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
                'name'    => '#answers#',
                'content' => '#answers->#'
            ],
            [
                'name'    => 'Next Article Number',
                'content' => '#nextArticleNumber#'
            ],
            [
                'name'    => 'Article Number',
                'content' => '#articleNumber#'
            ],
            [
                'name'    => 'Loop',
                'content' => '@foreach($answers[\'\'] ?? [] as $answer)<br>
                    {{ $answer }}<br>
                    @endforeach'
            ],
            [
                'name'    => 'New PDF Page',
                'content' => '<pre>#pageBreak#</pre>'
            ]
        ]);
    }
}
