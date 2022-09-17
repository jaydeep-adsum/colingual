<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\AppBaseController;
use App\Models\Quiz;
use App\Repositories\QuizRepository;
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
        $quiz = Quiz::where('language_id',$request->language_id)->get();
        if (is_null($quiz)) {
            return $this->sendError('Quiz not available');
        }
        return $this->sendResponse(
            $quiz, 'Quiz get Successfully.'
        );
    }
}
