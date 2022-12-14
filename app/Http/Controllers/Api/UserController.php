<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\AppBaseController;
use App\Mail\SignOtp;
use App\Models\Authenticator;
use App\Models\User;
use App\Repositories\UserRepository;
use Auth;
use Carbon\Carbon;
use DB;
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
            $detail['otp'] = rand(111111, 999999);
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
     *     description="
     *  Signup
     *   languages : pass comma seprated like 1,2,3",
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
     *     property="languages",
     *     type="string"
     *     ),
     * @OA\Property(
     *     property="colingual",
     *     type="string"
     *     ),
     * @OA\Property(
     *     property="image_url",
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
                'email' => 'required|email:rfc,dns|unique:users',
            ]);
            $error = (object)[];
            if ($validator->fails()) {
                return response()->json(['status' => false, 'data' => $error, 'message' => implode(', ', $validator->errors()->all())]);
            }
            $input = $request->all();

            $user = $this->userRepository->create($input);
            $language = explode(',', $request->languages);
            $user->language()->attach($language[0]);
            $user->language()->updateExistingPivot($language[0], ['is_primary' => '1']);
            array_shift($language);
            $user->language()->attach($language);
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
     * Swagger defination got one all product
     *
     * @OA\Post(
     *     tags={"Authentication"},
     *     path="/loginEmailVerify",
     *     description="Login otp",
     *     summary="Login otp",
     *     operationId="loginOtp",
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
    public function loginOtp(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'email' => 'required|email:rfc,dns',
            ]);
            $error = (object)[];
            if ($validator->fails()) {
                return response()->json(['status' => false, 'data' => $error, 'message' => implode(', ', $validator->errors()->all())]);
            }
            $users = User::where('email', $request->email)->first();
            if (is_null($users)) {
                return $this->sendError('unauthorized');
            }
            $detail['email'] = $request->email;
            $detail['otp'] = rand(111111, 999999);
            Mail::to($request->email)->send(new SignOtp($detail));

            return $this->sendResponse($detail, 'Success');
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
    public function login(Request $request)
    {
        try {
            if (filter_var($request->email_or_mobile, FILTER_VALIDATE_EMAIL)) {
                $validator = Validator::make($request->all(), [
                    'email_or_mobile' => 'required|email:rfc,dns',
                ]);
            } else {
                $validator = Validator::make($request->all(), [
                    'email_or_mobile' => 'required',
                ]);
            }
            $error = (object)[];
            if ($validator->fails()) {

                return response()->json(['status' => false, 'data' => $error, 'message' => implode(', ', $validator->errors()->all())]);
            }
            $credentials['email_or_mobile'] = $request->email_or_mobile;

            if ($user = $this->authenticator->attemptLogin($credentials)) {
                $update = User::where('id', $user->id)->update(['device_token' => $request->device_token, 'device_type' => $request->device_type]);
                $user = User::where('role', '0')->where('id', $user->id)->with('likeUsers')->withcount(['likeUsers' => function ($query) {
                    $query->where('like', '1');
                }])->first();
                $is_like = false;
                $star_1 = 0;
                $star_2 = 0;
                $star_3 = 0;
                $star_4 = 0;
                $star_5 = 0;
                $i = 0;
                foreach ($user->likeUsers as $likeUser) {
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
                    if ($likeUser->pivot->user_id === Auth::id() && $likeUser->pivot->like == "1") {
                        $is_like = true;
                    }
                }
                $average_rating = 0;
                if ($i > 0) {
                    $average_rating = (1 * $star_1 + 2 * $star_2 + 3 * $star_3 + 4 * $star_4 + 5 * $star_5) / $i;
                }
                $languages = DB::select("SELECT * FROM `language_user` JOIN languages on language_user.language_id=languages.id where user_id='.$user->id.'");

                $j = 0;
                foreach ($languages as $language) {
                    if ($language->translator == '1') {
                        $j++;
                    }
                }
                $is_verified = "";
                if ($j == count($languages)) {
                    $is_verified = "1";
                }
                $data = [
                    'id' => $user->id,
                    'name' => $user->name,
                    'last_name' => $user->last_name,
                    'image_url' => $user->image_url,
                    'is_like' => $is_like,
                    'rating' => (string)$average_rating,
                    'colingual' => $user->colingual,
                    'video' => $user->video,
                    'audio' => $user->audio,
                    'chat' => $user->chat,
                    'is_available' => $user->is_available,
                    'is_verified' => $is_verified,
                    'like_users_count' => $user->like_users_count,
                    'device_token' => $user->device_token,
                    'device_type' => $user->device_type,
                    'language' => $user->language,
                ];
                $tokenResult = $user->createToken('colingual');
                $token = $tokenResult->token;
                $token->save();
                $success['token'] = 'Bearer ' . $tokenResult->accessToken;
                $success['expires_at'] = Carbon::parse(
                    $tokenResult->token->expires_at
                )->toDateTimeString();
                $success['user'] = $data;

                return $this->sendResponse(
                    $success, 'You Have Successfully Logged in to colingual.'
                );
            } else {
                return response()->json(['status' => false, 'data' => $error, 'message' => 'These credentials do not match our records']);
            }
        } catch (Exception $e) {
            return $this->sendError($e);
        }
    }

    /**
     * Swagger defination Customer profile edit
     *
     * @OA\Post(
     *     tags={"User"},
     *     path="/edit",
     *     description="
     *  Edit Profile
     *   languages : pass comma seprated like 1,2,3",
     *     summary="Edit Profile",
     *     operationId="edit",
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
     *     property="mobile_no",
     *     type="string"
     *     ),
     * @OA\Property(
     *     property="email",
     *     type="string"
     *     ),
     * @OA\Property(
     *     property="image",
     *     type="file"
     *     ),
     * @OA\Property(
     *     property="languages",
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
    public function edit(Request $request)
    {
        $user = Auth::user();
        if (is_null($user)) {
            return $this->sendError('unauthorized');
        }
        if (isset($request->name) && $request->name != '') {
            $user->name = $request->name;
        }
        if (isset($request->last_name) && $request->last_name != '') {
            $user->last_name = $request->last_name;
        }
        if (isset($request->mobile_no) && $request->mobile_no != '') {
            $user->mobile_no = $request->mobile_no;
        }
        if (isset($request->email) && $request->email != '') {
            $user->email = $request->email;
        }
        if (isset($request->languages) && $request->languages != '') {
            $language = explode(',', $request->languages);
            $language_arr = explode(',', $request->languages);
            $languages = $user->language()->get();
            $user->language()->detach();
            $user->language()->attach($language[0]);
            $user->language()->updateExistingPivot($language[0], ['is_primary' => '1']);
            array_shift($language);
            $user->language()->attach($language);
            $user->language()->updateExistingPivot($language, ['is_primary' => '0']);
            foreach ($languages as $lang){
                if(in_array($lang->id,$language_arr)){
                    $user->language()->updateExistingPivot($lang->id, ['translator' => $lang->pivot->translator]);
                }
            }
//            $user->language()->updateExistingPivot($request->language_id, ['translator' => $request->translator]);
        }
        if ($request->file('image') !== null) {
            $file = $request->file('image');
            $image_name = $file->getClientOriginalName();
            $file->move(public_path('images'), $image_name);
            $user->image_url = config('app.url') . 'public/images/' . $image_name;
        }
        if (isset($request->card_number) && $request->card_number != '') {
            $user->card_number = $request->card_number;
        }
        if (isset($request->exp_date) && $request->exp_date != '') {
            $user->exp_date = $request->exp_date;
        }
        if (isset($request->cvv) && $request->cvv != '') {
            $user->cvv = $request->cvv;
        }
        if (isset($request->country) && $request->country != '') {
            $user->country = $request->country;
        }
        if (isset($request->nickname) && $request->nickname != '') {
            $user->nickname = $request->nickname;
        }
        $user->save();
        $userData = User::find($user->id);

        return $this->sendResponse(
            $userData, 'User profile updated Successfully.'
        );
    }

    /**
     * Swagger definition for Products
     *
     * @OA\Get(
     *     tags={"User"},
     *     path="/getUser",
     *     description="Get User",
     *     summary="Get User",
     *     operationId="getUser",
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
    public function getUser()
    {
        $user = User::where('role', '0')->where('id', Auth::id())->with('likeUsers')->withcount(['likeUsers' => function ($query) {
            $query->where('like', '1');
        }])->first();

        if (is_null($user)) {
            return $this->sendError('User Not Found.');
        }
        $is_like = false;
        $star_1 = 0;
        $star_2 = 0;
        $star_3 = 0;
        $star_4 = 0;
        $star_5 = 0;
        $i = 0;
        foreach ($user->likeUsers as $likeUser) {
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
            if ($likeUser->pivot->user_id === Auth::id() && $likeUser->pivot->like == "1") {
                $is_like = true;
            }
        }
        $average_rating = 0;
        if ($i > 0) {
            $average_rating = (1 * $star_1 + 2 * $star_2 + 3 * $star_3 + 4 * $star_4 + 5 * $star_5) / $i;
        }
        $languages = DB::select("SELECT * FROM `language_user` JOIN languages on language_user.language_id=languages.id where user_id='.$user->id.'");

        $j = 0;
        foreach ($languages as $language) {
            if ($language->translator == '1') {
                $j++;
            }
        }
        $is_verified = "";
        if ($j == count($languages)) {
            $is_verified = "1";
        }
        $data = [
            'id' => $user->id,
            'name' => $user->name,
            'last_name' => $user->last_name,
            'image_url' => $user->image_url,
            'is_like' => $is_like,
            'rating' => (string)$average_rating,
            'colingual' => $user->colingual,
            'video' => $user->video,
            'audio' => $user->audio,
            'chat' => $user->chat,
            'is_available' => $user->is_available,
            'is_verified' => $is_verified,
            'like_users_count' => $user->like_users_count,
            'device_token' => $user->device_token,
            'device_type' => $user->device_type,
            'language' => $user->language,
        ];

        return $this->sendResponse(
            $data, 'User get Successfully.'
        );
    }

    /**
     * Swagger definition for Products
     *
     * @OA\Get(
     *     tags={"User"},
     *     path="/isColingual",
     *     description="Service as Colingual",
     *     summary="Service as Colingual",
     *     operationId="isColingual",
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
    public function isColingual()
    {
        $user = Auth::user();
        if ($user->colingual == '0') {
            $user->colingual = '1';
        } else {
            $user->colingual = '0';
        }
        $user->save();

        return $this->sendResponse(
            $user, 'User profile updated Successfully.'
        );
    }

    /**
     * Swagger definition for Products
     *
     * @OA\Get(
     *     tags={"User"},
     *     path="/isVideo",
     *     description="Available for Video",
     *     summary="Available for Video",
     *     operationId="isVideo",
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
    public function isVideo()
    {
        $user = Auth::user();
        if ($user->video == '0') {
            $user->video = '1';
        } else {
            $user->video = '0';
        }
        $user->save();

        return $this->sendResponse(
            $user, 'User profile updated Successfully.'
        );
    }

    /**
     * Swagger definition for Products
     *
     * @OA\Get(
     *     tags={"User"},
     *     path="/isAudio",
     *     description="Available for Audio",
     *     summary="Available for Audio",
     *     operationId="isAudio",
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
    public function isAudio()
    {
        $user = Auth::user();
        if ($user->audio == '0') {
            $user->audio = '1';
        } else {
            $user->audio = '0';
        }
        $user->save();

        return $this->sendResponse(
            $user, 'User profile updated Successfully.'
        );
    }

    /**
     * Swagger definition for Products
     *
     * @OA\Get(
     *     tags={"User"},
     *     path="/isChat",
     *     description="Available for Chat",
     *     summary="Available for Chat",
     *     operationId="isChat",
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
    public function isChat()
    {
        $user = Auth::user();
        if ($user->chat == '0') {
            $user->chat = '1';
        } else {
            $user->chat = '0';
        }
        $user->save();

        return $this->sendResponse(
            $user, 'User profile updated Successfully.'
        );
    }

    /**
     * Swagger defination Get Order
     *
     * @OA\Post(
     *     tags={"User"},
     *     path="/isAvailable",
     *     description="Available",
     *     summary="Available",
     *     operationId="isAvailable",
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
     *     property="is_available",
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
    public function isAvailable(Request $request)
    {
        $user = Auth::user();
        $user->is_available = $request->is_available;
        $user->save();

        return $this->sendResponse(
            $user, 'User profile updated Successfully.'
        );
    }

    /**
     * Swagger defination Get Order
     *
     * @OA\Post(
     *     tags={"User"},
     *     path="/isTranslator",
     *     description="Make Translator",
     *     summary="Make Translator",
     *     operationId="makeTranslator",
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
     * @OA\Property(
     *     property="translator",
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
    public function isTranslator(Request $request)
    {
        $user = Auth::user();
        $user->language()->updateExistingPivot($request->language_id, ['translator' => $request->translator]);

        return $this->sendResponse($user, 'User makes translator Successfully.'
        );
    }

    /**
     * Swagger defination Get Order
     *
     * @OA\Post(
     *     tags={"User"},
     *     path="/add_remove_favourite_rating",
     *     description="
    user_id = not logged in user
    like = 0 or 1",
     *     summary="Add or remove to favourite",
     *     operationId="addRemoveFavourite",
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
     *     property="user_id",
     *     type="integer"
     *     ),
     * @OA\Property(
     *     property="like",
     *     type="integer"
     *     ),
     * @OA\Property(
     *     property="rating",
     *     type="number"
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
    public function addToFavourite(Request $request)
    {
        $user = Auth::user();
        if ($user->likedUsers()->where('liked_user_id', $request->user_id)->doesntExist()) {
            $user->likedUsers()->attach($request->user_id);
        }
        if ($request->like == 1 || $request->like == 0) {
            $user->likedUsers()->updateExistingPivot($request->user_id, ['like' => $request->like]);
        }
        if ($request->rating) {
            $user->likedUsers()->updateExistingPivot($request->user_id, ['rating' => $request->rating]);
        }
        $user = User::find(Auth::id());

        return $this->sendResponse($user, 'User Success.');
    }

    /**
     * Swagger definition for Products
     *
     * @OA\Get(
     *     tags={"User"},
     *     path="/getUserList",
     *     description="Get all Users",
     *     summary="Get all User",
     *     operationId="getAllUser",
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
    public function getUsers()
    {
        $users = User::where('role', '0')->with('likeUsers')->withcount(['likeUsers' => function ($query) {
            $query->where('like', '1');
        }])->get();
        $data = [];
        foreach ($users as $user) {
            if ($user->id != Auth::id()) {
                $is_like = false;
                $star_1 = 0;
                $star_2 = 0;
                $star_3 = 0;
                $star_4 = 0;
                $star_5 = 0;
                $i = 0;
                foreach ($user->likeUsers as $likeUser) {
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
                    if ($likeUser->pivot->user_id === Auth::id() && $likeUser->pivot->like == "1") {
                        $is_like = true;
                    }
                }
                $average_rating = 0;
                if ($i > 0) {
                    $average_rating = (1 * $star_1 + 2 * $star_2 + 3 * $star_3 + 4 * $star_4 + 5 * $star_5) / $i;
                }
                $data[] = [
                    'id' => $user->id,
                    'name' => $user->name,
                    'last_name' => $user->last_name,
                    'image_url' => $user->image_url,
                    'is_like' => $is_like,
                    'rating' => (string)$average_rating,
                    'colingual' => $user->colingual,
                    'video' => $user->video,
                    'audio' => $user->audio,
                    'chat' => $user->chat,
                    'is_available' => $user->is_available,
                    'like_users_count' => $user->like_users_count,
                    'device_token' => $user->device_token,
                    'device_type' => $user->device_type,
                    'language' => $user->language,
                ];
            }
        }
        if ($data) {
            return $this->sendResponse($data, 'Users get Successfully.');
        }
        return $this->sendError('User not found.');
    }

    /**
     * Swagger definition for Products
     *
     * @OA\Get(
     *     tags={"User"},
     *     path="/getTranslatorList",
     *     description="Get Translator Users",
     *     summary="Get Translator User",
     *     operationId="getTranslatorUser",
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
    public function getTranslatorUser()
    {
//        $users = DB::select("SELECT *,users.id as userID,
//       (SELECT count(rating) from user_likes where user_likes.liked_user_id = users.id AND `rating`=1) as total_rate_1,
//       (SELECT count(rating) from user_likes where user_likes.liked_user_id = users.id AND `rating`=2) as total_rate_2,
//       (SELECT count(rating) from user_likes where user_likes.liked_user_id = users.id AND `rating`=3) as total_rate_3,
//       (SELECT count(rating) from user_likes where user_likes.liked_user_id = users.id AND `rating`=4) as total_rate_4,
//       (SELECT count(rating) from user_likes where user_likes.liked_user_id = users.id AND `rating`=5) as total_rate_5,
//       (SELECT COUNT(`like`) as total_like from user_likes where user_likes.liked_user_id = users.id AND `like`='1') as total_like
//        FROM `users`
//        LEFT JOIN `user_likes` on `users`.`id` = `user_likes`.`user_id`
//        WHERE `role`='0'
//        GROUP BY `user_likes`.`user_id`
//        order by total_like desc");
//
//        $data = [];
//        $is_like = false;
//        foreach ($users as $user) {
//            if ($user->userID != Auth::id()) {
//                $i = 0;
//                if ($user->total_rate_1 > 0) {
//                    $i++;
//                }
//                if ($user->total_rate_2 > 0) {
//                    $i++;
//                }
//                if ($user->total_rate_3 > 0) {
//                    $i++;
//                }
//                if ($user->total_rate_4 > 0) {
//                    $i++;
//                }
//                if ($user->total_rate_5 > 0) {
//                    $i++;
//                }
//                $is_like = false;
//                $average_rating = 0;
//                if ($i > 0) {
//                    $average_rating = (1 * $user->total_rate_1 + 2 * $user->total_rate_2 + 3 * $user->total_rate_3 + 4 * $user->total_rate_4 + 5 * $user->total_rate_5) / $i;
//                }
//                $languages = DB::select("SELECT * FROM `language_user` JOIN languages on language_user.language_id=languages.id where user_id='.$user->userID.'");
//                $j = 0;
//                foreach ($languages as $language) {
//                    if ($language->translator == '1') {
//                        $j++;
//                    }
//                }
//
//                if ($j == count($languages)) {
//                    if ($user->user_id == Auth::id() && $user->like == "1") {
//                        $is_like = true;
//                    }
//                    $data[] = [
//                        'id' => $user->userID,
//                        'name' => $user->name,
//                        'last_name' => $user->last_name,
//                        'image_url' => $user->image_url,
//                        'is_like' => $is_like,
//                        'rating' => (string)$average_rating,
//                        'colingual' => $user->colingual,
//                        'video' => $user->video,
//                        'is_verified'=> "1",
//                        'audio' => $user->audio,
//                        'chat' => $user->chat,
//                        'is_available' => $user->is_available,
//                        'like_users_count' => $user->total_like,
//                        'device_token' => $user->device_token,
//                        'device_type' => $user->device_type,
//                    ];
//                }
//            }
//        }
        $users = User::where('role', '0')->with('likeUsers')->withcount(['likeUsers' => function ($query) {
            $query->where('like', '1');
        },'language'])->get();

        foreach ($users as $user) {
            if ($user->id != \Illuminate\Support\Facades\Auth::id()) {
                $is_like = false;
                $star_1 = 0;
                $star_2 = 0;
                $star_3 = 0;
                $star_4 = 0;
                $star_5 = 0;
                $i = 0;
                foreach ($user->likeUsers as $likeUser) {
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
                    if ($likeUser->pivot->user_id === Auth::id() && $likeUser->pivot->like == "1") {
                        $is_like = true;
                    }
                }
                $average_rating = 0;
                if ($i > 0) {
                    $average_rating = (1 * $star_1 + 2 * $star_2 + 3 * $star_3 + 4 * $star_4 + 5 * $star_5) / $i;
                }
                $j = 0;
                foreach ($user->language as $language) {
                    if ($language->pivot->translator == '1') {
                        $j++;
                    }
                }
                if ($j == $user->language_count) {
                    $data[] = [
                        'id' => $user->id,
                        'name' => $user->name,
                        'last_name' => $user->last_name,
                        'image_url' => $user->image_url,
                        'is_like' => $is_like,
                        'rating' => (string)$average_rating,
                        'colingual' => $user->colingual,
                        'video' => $user->video,
                        'audio' => $user->audio,
                        'chat' => $user->chat,
                        'is_available' => $user->is_available,
                        'like_users_count' => $user->like_users_count,
                        'device_token' => $user->device_token,
                        'device_type' => $user->device_type,
                        'language' => $user->language,
                    ];
                }
            }
        }

        usort($data, fn($a, $b) => $a['like_users_count'] <=> $b['like_users_count']);
        $data = array_reverse($data);

        if ($data) {
            return $this->sendResponse($data, 'Translators Successfully.');
        }
        return $this->sendError('Translator not found.');
    }

    /**
     * Swagger definition for Products
     *
     * @OA\Get(
     *     tags={"User"},
     *     path="/logout",
     *     description="Logout user",
     *     summary="Logout user",
     *     operationId="logout",
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
    public function logout()
    {
        $user = Auth::user();
        $user->device_token = null;
        $user->device_type = null;
        $user->save();

        return $this->sendResponse(
            $user, 'User profile updated Successfully.'
        );
    }
}
