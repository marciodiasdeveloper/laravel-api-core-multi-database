<?php

namespace Tests\Unit\Models;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Illuminate\Support\Facades\Schema;

use App\Models\Customer\Customer;
use App\Models\Catalog\Catalog;
use App\Models\Customer\SignUp\Answer;
use App\Models\SignUp\Question;

class AnswerTest extends TestCase
{
    use RefreshDatabase;

    public function test_database_has_expected_columns()
    {
        $schema = Schema::hasColumns('customers_signups_answers', [
            'id', 'uuid', 'customer_id', 'signup_question_id'
        ]);

        $this->assertTrue($schema, 1);
    }

    public function test_database_create_register()
    {
        $answer = Answer::factory()->create();
        $this->assertModelExists($answer);
    }

    public function test_model_missing()
    {
        $answer = Answer::factory()->create();
        $answer->delete();
        $this->assertModelMissing($answer);
    }

    public function test_model_count()
    {
        Answer::factory()->create();
        $this->assertDatabaseCount('customers_signups_answers', 1);
    }

    public function test_models_can_be_persisted()
    {
        Answer::factory()->count(10)->create();
        $this->assertDatabaseCount('customers_signups_answers', 10);
    }

    public function test_model_belongs_to_customer()
    {
        $catalog = Catalog::factory()->create();
        $this->assertModelExists($catalog);

        $data = [
            'catalog_id' => $catalog->id,
            'email' => 'test@planeasy.com.br',
            'branch_name' => 'Planeasy Test',
            'company_name' => 'Planeasy Test',
            'occupation_area' => 'Administrador',
            'employees_number' => 1,
            'observations' => 'Observações',
            'status' => 'enabled'
        ];

        $customer = Customer::factory()->create($data);
        $this->assertModelExists($customer);
        $this->assertEquals(1, $customer->catalog->count());
        $this->assertInstanceOf(Catalog::class, $customer->catalog);

        $signup_question = Question::factory()->create();

        $answer_model = Answer::factory()->create([
            'customer_id' => $customer->id,
            'signup_question_id' => $signup_question->id,
        ]);

        $this->assertModelExists($answer_model);
        $this->assertEquals(1, $answer_model->customer->count());
        $this->assertInstanceOf(Customer::class, $answer_model->customer);
    }

    public function test_model_method_create_answers()
    {
        $catalog = Catalog::factory()->create();
        $this->assertModelExists($catalog);

        $data = [
            'catalog_id' => $catalog->id,
            'email' => 'test@planeasy.com.br',
            'branch_name' => 'Planeasy Test',
            'company_name' => 'Planeasy Test',
            'occupation_area' => 'Administrador',
            'employees_number' => 1,
            'observations' => 'Observações',
            'status' => 'enabled'
        ];

        $customer = Customer::factory()->create($data);
        $this->assertModelExists($customer);
        $this->assertEquals(1, $customer->catalog->count());
        $this->assertInstanceOf(Catalog::class, $customer->catalog);

        $signup_questions = Question::factory()->count(10)->create()->toArray();

        $answers = collect();

        foreach ($signup_questions as $sq) {
            $data = [
                'customer_id' => $customer->id,
                'signup_question_id' => $sq['id'],
            ];
            $answers->push($data);
        }

        $data = [
            'answers' => $answers
        ];

        $answers = app(Answer::class)->createOrUpdateAnswers($customer, $data);

        $this->assertTrue($answers);
    }

    public function test_model_method_update_answers()
    {
        $catalog = Catalog::factory()->create();
        $this->assertModelExists($catalog);

        $data = [
            'catalog_id' => $catalog->id,
            'email' => 'test@planeasy.com.br',
            'branch_name' => 'Planeasy Test',
            'company_name' => 'Planeasy Test',
            'occupation_area' => 'Administrador',
            'employees_number' => 1,
            'observations' => 'Observações',
            'status' => 'enabled'
        ];

        $customer = Customer::factory()->create($data);
        $this->assertModelExists($customer);
        $this->assertEquals(1, $customer->catalog->count());
        $this->assertInstanceOf(Catalog::class, $customer->catalog);

        $signup_questions = Question::factory()->count(10)->create()->toArray();

        $answers = collect();

        foreach ($signup_questions as $sq) {
            $data = [
                'customer_id' => $customer->id,
                'signup_question_id' => $sq['id'],
            ];
            $answers->push($data);
            Answer::factory()->create($data);
        }

        $data = [
            'answers' => $answers
        ];

        $answers = app(Answer::class)->createOrUpdateAnswers($customer, $data);

        $this->assertTrue($answers);
    }

    public function test_model_method_create_or_update_answers_not_send_answers()
    {
        $catalog = Catalog::factory()->create();
        $this->assertModelExists($catalog);

        $data = [
            'catalog_id' => $catalog->id,
            'email' => 'test@planeasy.com.br',
            'branch_name' => 'Planeasy Test',
            'company_name' => 'Planeasy Test',
            'occupation_area' => 'Administrador',
            'employees_number' => 1,
            'observations' => 'Observações',
            'status' => 'enabled'
        ];

        $customer = Customer::factory()->create($data);
        $this->assertModelExists($customer);
        $this->assertEquals(1, $customer->catalog->count());
        $this->assertInstanceOf(Catalog::class, $customer->catalog);

        $answers = app(Answer::class)->createOrUpdateAnswers($customer, []);

        $this->assertFalse($answers);
    }
}
