<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\AppBaseController;
use App\Models\Quiz;
use App\Repositories\QuizRepository;
use DB;
use Illuminate\Http\Request;

class QuizController extends AppBaseController
{
    public function __construct(QuizRepository $quizRepository){
        $this->quizRepository = $quizRepository;
    }

    /**
     * Swagger defination Get Order
     *
     * @OA\Post(
     *     tags={"Quiz"},
     *     path="/quiz",
     *     description="Get Quiz",
     *     summary="Get Quiz",
     *     operationId="getQuiz",
     * @OA\Parameter(
     *     name="Content-Language",
     *     in="header",
     *     description="Content-Language",
     *     required=false,@OA\Schema(type="string")
     *     ),
     * @OA\RequestBody(
     *     required=true,
     * @OA\MediaType(
     *     mediaType="multipart/form-data",
     * @OA\JsonContent(
     * @OA\Property(
     *     property="language_id",
     *     type="integer"
     *     ),
     *    )
     *   ),
     *  ),
     * @OA\Response(
     *     response=200,
     *     description="User response",@OA\JsonContent
     *     (ref="#/components/schemas/SuccessResponse")
     * ),
     * @OA\Response(
     *     response="400",
     *     description="Validation error",@OA\JsonContent
     *     (ref="#/components/schemas/ErrorResponse")
     * ),
     * @OA\Response(
     *     response="403",
     *     description="Not Authorized Invalid or missing Authorization header",@OA\
     *     JsonContent(ref="#/components/schemas/ErrorResponse")
     * ),
     * @OA\Response(
     *     response=500,
     *     description="Unexpected error",@OA\JsonContent
     *     (ref="#/components/schemas/ErrorResponse")
     * ),
     * security={
     *     {"API-Key": {}}
     * }
     * )
     */
    public function index(Request $request){
        $quiz = Quiz::where('language_id',$request->language_id)->first();
        $data[] = [
            'question'=>$quiz->question1,
            'A'=>$quiz->option1A,
            'B'=>$quiz->option1B,
            'C'=>$quiz->option1C,
            'D'=>$quiz->option1D,
            'answer'=>$quiz->answer1,
        ];
        $data[] = [
            'question'=>$quiz->question2,
            'A'=>$quiz->option2A,
            'B'=>$quiz->option2B,
            'C'=>$quiz->option2C,
            'D'=>$quiz->option2D,
            'answer'=>$quiz->answer2,
        ];
        $data[] = [
            'question'=>$quiz->question3,
            'A'=>$quiz->option3A,
            'B'=>$quiz->option3B,
            'C'=>$quiz->option3C,
            'D'=>$quiz->option3D,
            'answer'=>$quiz->answer3,
        ];
        $data[] = [
            'question'=>$quiz->question4,
            'A'=>$quiz->option4A,
            'B'=>$quiz->option4B,
            'C'=>$quiz->option4C,
            'D'=>$quiz->option4D,
            'answer'=>$quiz->answer4,
        ];
        $data[] = [
            'question'=>$quiz->question5,
            'A'=>$quiz->option5A,
            'B'=>$quiz->option5B,
            'C'=>$quiz->option5C,
            'D'=>$quiz->option5D,
            'answer'=>$quiz->answer5,
        ];
        if (is_null($quiz)) {
            return $this->sendError('Quiz not available');
        }
        return $this->sendResponse(
            $data, 'Quiz get Successfully.'
        );
    }

    public function quizResult(Request $request){
        $score = DB::table('quiz_user')->insert([
            'quiz_id'=>$request->quiz_id,
            'user_id'=>\Auth::id(),
            'is_translator'=>$request->is_translator,
            'score'=>$request->score,
        ]);
        if($score){
            return $this->sendSuccess('Quiz result stored.');
        }
        return $this->sendError('Quiz result not stored');
    }
}
