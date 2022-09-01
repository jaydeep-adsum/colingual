<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\AppBaseController;
use App\Mail\SignOtp;
use App\Models\Authenticator;
use App\Models\User;
use App\Repositories\UserRepository;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Mail;
use Validator;

class UserController extends AppBaseController
{
    /**
     * @var UserRepository
     */
    private $userRepository;
    /**
     * @var Authenticator
     */
    private $authenticator;

    /**
     * @param UserRepository $userRepository
     * @param Authenticator $authenticator
     */
    public function __construct(UserRepository $userRepository, Authenticator $authenticator)
    {
        $this->userRepository = $userRepository;
        $this->authenticator = $authenticator;
    }

    /**
     * Swagger defination got one all product
     *
     * @OA\Post(
     *     tags={"Authentication"},
     *     path="/emailVerify",
     *     description="Signup otp",
     *     summary="Signup otp",
     *     operationId="signupOtp",
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
     *     property="email",
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
     * )
     */
    public function signupOtp(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'email' => 'required|email:rfc,dns|unique:users',
            ]);
            $error = (object)[];
            if ($validator->fails()) {
                return response()->json(['status' => false, 'data' => $error, 'message' => implode(', ', $validator->errors()->all())]);
            }

            $detail['email'] = $request->email;
            $detail['otp'] = rand(111111,999999);
            Mail::to($request->email)->send(new SignOtp($detail));

            return $this->sendResponse($detail, 'Success');
        } catch (Exception $e) {
            return $this->sendError($e);
        }
    }

    /**
     * Swagger defination got one all product
     *
     * @OA\Post(
     *     tags={"Authentication"},
     *     path="/signup",
     *     description="Signup",
     *     summary="Signup",
     *     operationId="signup",
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
     *     property="name",
     *     type="string"
     *     ),
     * @OA\Property(
     *     property="last_name",
     *     type="string"
     *     ),
     * @OA\Property(
     *     property="email",
     *     type="string"
     *     ),
     * @OA\Property(
     *     property="country_code",
     *     type="string"
     *     ),
     * @OA\Property(
     *     property="mobile_no",
     *     type="string"
     *     ),
     * @OA\Property(
     *     property="login_by",
     *     type="string"
     *     ),
     * @OA\Property(
     *     property="card_number",
     *     type="string"
     *     ),
     * @OA\Property(
     *     property="exp_date",
     *     type="string"
     *     ),
     * @OA\Property(
     *     property="cvv",
     *     type="string"
     *     ),
     * @OA\Property(
     *     property="country",
     *     type="string"
     *     ),
     * @OA\Property(
     *     property="nickname",
     *     type="string"
     *     ),
     * @OA\Property(
     *     property="device_token",
     *     type="string"
     *     ),
     * @OA\Property(
     *     property="device_type",
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
     * )
     */
    public function signup(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'user_id' => 'required',
                'name' => 'required',
                'last_name' => 'required',
                'mobile_no' => 'required|numeric|unique:users',
            ]);

            $error = (object)[];
            if ($validator->fails()) {
                return response()->json(['status' => false, 'data' => $error, 'message' => implode(', ', $validator->errors()->all())]);
            }
            $user = $this->userRepository->create($request->all());
            if ($user) {
                $credentials['mobile_no'] = $user->mobile_no;
                $credentials['email'] = $user->email;
                if ($user = $this->authenticator->attemptSignUp($credentials)) {
                    $tokenResult = $user->createToken('colingual');
                    $token = $tokenResult->token;
                    $token->save();
                    $success['token'] = 'Bearer ' . $tokenResult->accessToken;
                    $success['expires_at'] = Carbon::parse(
                        $tokenResult->token->expires_at
                    )->toDateTimeString();
                    $success['user'] = $user;

                    return $this->sendResponse(
                        $success, 'You Have Successfully Signup in to Colingual.'
                    );
                } else {
                    return response()->json(['success' => false, 'data' => $error, 'message' => 'These credentials do not match our records']);
                }
            }
        } catch (Exception $e) {
            return $this->sendError($e);
        }
    }

    /**
     * Swagger defination Login
     *
     * @OA\Post(
     *     tags={"Authentication"},
     *     path="/login",
     *     description="Log In",
     *     summary="Log In",
     *     operationId="login",
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
     *     property="email_or_mobile",
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
     * )
     */
    public function login(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'email_or_mobile' => 'required',
            ]);

            $error = (object)[];
            if ($validator->fails()) {

                return response()->json(['status' => false, 'data' => $error, 'message' => implode(', ', $validator->errors()->all())]);
            }
            $credentials['email_or_mobile'] = $request->email_or_mobile;

            if ($user = $this->authenticator->attemptLogin($credentials)) {
                $users = User::find($user->id);
                $tokenResult = $user->createToken('colingual');
                $token = $tokenResult->token;
                $token->save();
                $success['token'] = 'Bearer ' . $tokenResult->accessToken;
                $success['expires_at'] = Carbon::parse(
                    $tokenResult->token->expires_at
                )->toDateTimeString();
                $success['user'] = $users;

                return $this->sendResponse(
                    $success, 'You Have Successfully Logged in to colingual.'
                );
            } else {
                return response()->json(['success' => false, 'data' => $error, 'message' => 'These credentials do not match our records']);
            }
        } catch (Exception $e) {
            return $this->sendError($e);
        }
    }
}
