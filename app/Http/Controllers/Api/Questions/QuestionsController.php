<?php

namespace App\Http\Controllers\Api\Questions;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Cache;
use Illuminate\Http\Request;

use App\Http\Resources\Questions\QuestionResource;
use App\Models\SignUp\Question;

class QuestionsController extends Controller
{

    public function __construct()
    {
    }

    /**
     * @OA\Get(
     *      path="/questions",
     *      operationId="getSignUpQuestions",
     *      tags={"Questions"},
     *      summary="Get a list of available questions to select in the register",
     *      description="List of questions",
     *      @OA\Response(
     *          response=200,
     *          description="successful operation"
     *       ),
     *       @OA\Response(response=400, description="Bad request"),
     *     )
     *
     * Returns available domain
     */
    public function index()
    {
        $slug = 'signup-step3-questions';

        if (Cache::has($slug)) {
            return Cache::get($slug);
        }

        $questions = Question::where('status', 'enabled')->orderBy('title', 'ASC')->get();

        $questions_resource = QuestionResource::collection($questions);

        Cache::put($slug, $questions_resource, 60);

        return $questions_resource;
    }
}
