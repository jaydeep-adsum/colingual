<?php

namespace App\Models;

use RuntimeException;
use Illuminate\Hashing\HashManager;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Carbon\Carbon;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class Authenticator
{
    /**
     * The hasher implementation.
     *
     * @var \Illuminate\Hashing\HashManager
     */
    protected $hasher;

    /**
     * Create a new repository instance.
     *
     * @param  \Illuminate\Hashing\HashManager  $hasher
     * @return void
     */
    public function __construct(HashManager $hasher)
    {
        $this->hasher = $hasher->driver();
    }

    /**
     * This will attempt for sign up
     *
     * @param array $credentialscredentials credentials
     *
     * @return Authenticatable|null
     */
    public function attemptSignUp(
       array $credentials
    ): ?Authenticatable {
        if (! $model = config('auth.providers.'.'users'.'.model')) {
            throw new RuntimeException('Unable to determine authentication model from configuration.');
        }
        /** @var Authenticatable $user */
        if (!$user = (new $model)->Where([['mobile_no', $credentials['mobile_no']], ['email', $credentials['email']]])->first())
        {
            return null;
        }
        $user->save();
        return $user;
    }

    /**
     * This will attempt for login
     *
     * @param array $credentialscredentials credentials
     *
     * @return Authenticatable|null
     */
    public function attemptLogin(
        array $credentials
     ): ?Authenticatable {
         if (! $model = config('auth.providers.'.'users'.'.model')) {
             throw new RuntimeException('Unable to determine authentication model from configuration.');
         }
         /** @var Authenticatable $user */
         if (!$user = (new $model)->Where('email', $credentials['email_or_mobile'])->orWhere('mobile_no', $credentials['email_or_mobile'])->first())
         {
             return null;
         }

         $user->save();
         return $user;
     }
}
