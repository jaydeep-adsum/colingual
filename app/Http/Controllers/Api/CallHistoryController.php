<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\AppBaseController;
use App\Models\CallHistory;
use App\Repositories\CallHistoryRepository;
use Auth;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Validator;

class CallHistoryController extends AppBaseController
{
    /**
     * @var CallHistoryRepository
     */
    private $callHistoryRepository;

    /**
     * @param CallHistoryRepository $callHistoryRepository
     */
    public function __construct(CallHistoryRepository $callHistoryRepository){
        $this->callHistoryRepository = $callHistoryRepository;
    }

    /**
     * Swagger defination got one all product
     *
     * @OA\Post(
     *     tags={"Call History"},
     *     path="/call_history",
     *     description="
     *   call_type : 1 = video
     *               2 = audio
     *               3 = chat",
     *     summary="Signup",
     *     operationId="callhsitory",
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
     *     property="call_user_id",
     *     type="string"
     *     ),
     * @OA\Property(
     *     property="duration",
     *     type="string"
     *     ),
     * @OA\Property(
     *     property="call_type",
     *     type="string"
     *     ),
     * @OA\Property(
     *     property="tip",
     *     type="string"
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
    public function create(Request $request){
        try {
            $validator = Validator::make($request->all(), [
                'call_user_id' => 'required',
                'duration' => 'required',
                'call_type' => 'required',
            ]);
            $error = (object)[];
            if ($validator->fails()) {
                return response()->json(['status' => false, 'data' => $error, 'message' => implode(', ', $validator->errors()->all())]);
            }
            $input = $request->all();
            $input['user_id'] = Auth::id();

            $callUser = $this->callHistoryRepository->create($input);

            if ($callUser) {
                    return $this->sendResponse(
                        $callUser, 'Successfully'
                    );
                }
        } catch (Exception $e) {
            return $this->sendError($e);
        }
    }

    /**
     * Swagger definition for Products
     *
     * @OA\Get(
     *     tags={"Call History"},
     *     path="/call_history",
     *     description="Call History List",
     *     summary="Call History List",
     *     operationId="call_history",
     * @OA\Parameter(
     *     name="Content-Language",
     *     in="header",
     *     description="Content-Language",
     *     required=false,@OA\Schema(type="string")
     *     ),
     * @OA\Response(
     *     response=200,
     *     description="Succuess response"
     *     ,@OA\JsonContent(ref="#/components/schemas/SuccessResponse")
     *     ),
     * @OA\Response(
     *     response="400",
     *     description="Validation error"
     *     ,@OA\JsonContent(ref="#/components/schemas/ErrorResponse")
     * ),
     * @OA\Response(
     *     response="401",
     *     description="Not Authorized Invalid or missing Authorization header"
     *     ,@OA\JsonContent
     *     (ref="#/components/schemas/ErrorResponse")
     * ),
     * @OA\Response(
     *     response=500,
     *     description="Unexpected error"
     *     ,@OA\JsonContent(ref="#/components/schemas/ErrorResponse")
     *  ),
     * security={
     *     {"API-Key": {}}
     * }
     * )
     */
    public function show(){
        $callHistoryArr = CallHistory::where('user_id',Auth::id())->with('call_user.likeUsers')->get();
        $data= [];
        foreach ($callHistoryArr as $callHistory) {
            $star_1 = 0;
            $star_2 = 0;
            $star_3 = 0;
            $star_4 = 0;
            $star_5 = 0;
            $i = 0;
            foreach ($callHistory->call_user->likeUsers as $likeUser) {
                if ($likeUser->pivot->rating == 1) {
                    $i++;
                    $star_1 += 1;
                }
                if ($likeUser->pivot->rating == 2) {
                    $i++;
                    $star_2 += 1;
                }
                if ($likeUser->pivot->rating == 3) {
                    $i++;
                    $star_3 += 1;
                }
                if ($likeUser->pivot->rating == 4) {
                    $i++;
                    $star_4 += 1;
                }
                if ($likeUser->pivot->rating == 5) {
                    $i++;
                    $star_5 += 1;
                }
            }
            $average_rating = 0;
            if ($i > 0) {
                $average_rating = (1 * $star_1 + 2 * $star_2 + 3 * $star_3 + 4 * $star_4 + 5 * $star_5) / $i;
            }
            $data[] = [
              'id'=> $callHistory->id,
              'user_id'=> $callHistory->user_id,
              'call_user_id'=> $callHistory->call_user_id,
              'duration'=> $callHistory->duration,
              'call_type'=> $callHistory->call_type,
              'tip'=> $callHistory->tip,
              'created_at'=> $callHistory->created_at,
              'updated_at'=> $callHistory->updated_at,
              'first_name'=> $callHistory->call_user->name,
              'last_name'=> $callHistory->call_user->last_name,
              'rating'=> (string)$average_rating,
            ];
        }


        if ($data) {
            return $this->sendResponse(
                $data, 'Successfully'
            );
        }
    }


}
