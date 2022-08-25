<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\AppBaseController;
use App\Models\Authenticator;
use App\Models\User;
use App\Repositories\UserRepository;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
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
    public function __construct(UserRepository $userRepository,Authenticator $authenticator){
        $this->userRepository = $userRepository;
        $this->authenticator =$authenticator;
    }

    /**
     * @param Request $request
     * @return JsonResponse|void
     */
    public function signup(Request $request){
        try {
            $validator = Validator::make($request->all(), [
                'mobile_no' => 'required|numeric|unique:users',
                'email' => 'required|email|unique:users',
                'name' => 'required',
                'last_name' => 'required',
            ]);

            $error = (object)[];
            if ($validator->fails()) {
                return response()->json(['status' => false, 'data' => $error, 'message' => implode(', ', $validator->errors()->all())]);
            }
            $user = User::create($request->all());
            if ($user) {
                $credentials['mobile'] = $user->mobile_no;
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
                }else {
                    return response()->json(['success' => false, 'data' => $error, 'message' => 'These credentials do not match our records']);
                }
            }
        } catch (Exception $e) {
            return $this->sendError($e);
        }
    }
}
