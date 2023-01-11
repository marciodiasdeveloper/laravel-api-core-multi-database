<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

use App\Models\SignUp\Question;

class SignUpQuestionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->createQuestion('Acompanhar minha empresa e funcionários 24hrs');
        $this->createQuestion('Melhorar meus agendamentos');
        $this->createQuestion('Ter mais tempo para dedicar ao meu negócio');
        $this->createQuestion('Organizar minha agenda atual');
        $this->createQuestion('Avisar os clientes via WhatsApp');
        $this->createQuestion('Avisar os clientes via SMS');
        $this->createQuestion('Avisar os clientes via E-mail');
        $this->createQuestion('Controlar meu fluxo de caixa');
        $this->createQuestion('Diminuir a taxa de desistência nos atendimentos');
        $this->createQuestion('Outro');
    }

    public function createQuestion($title)
    {
        $question = Question::where('title', $title)->first();

        if (!$question) {
            $question = new Question;
        }

        $question->title = $title;
        $question->status = 'enabled';
        $question->save();
    }
}
