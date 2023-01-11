<?php

namespace App\Models\Customer\SignUp;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Carbon\Carbon;

use App\Models\Customer\Customer;
use App\Models\SignUp\Question;

class Answer extends Model
{
    use HasFactory;

    protected $table = 'customers_signups_answers';
    protected $primaryKey = 'id';
    protected $fillable = ['uuid', 'customer_id', 'signup_question_id'];

    public function customer()
    {
        return $this->belongsTo(Customer::class, 'customer_id');
    }

    public static function boot()
    {
        parent::boot();

        self::creating(function ($model) {
            $model->uuid = (string) Str::uuid();
        });
    }

    public function createOrUpdateAnswers($customer, $data)
    {
        if (!isset($data['answers']) || !count($data['answers'])) {
            return false;
        }

        foreach ($data['answers'] as $answer) {
            $question = Question::where('id', $answer['signup_question_id'])->first();

            $model = Answer::where('customer_id', $customer->id)->where('signup_question_id', $question->id)->first();

            if ($question && !$model) {
                $data = [
                    'customer_id' => $customer->id,
                    'signup_question_id' => $question->id,
                ];

                $this->createAnswer($data);
            }
        }

        return true;
    }

    public function createAnswer($data)
    {
        $model = new Answer;
        $model->customer_id = $data['customer_id'];
        $model->signup_question_id = $data['signup_question_id'];
        $model->save();

        return $model;
    }
}
