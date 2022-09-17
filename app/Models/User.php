<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;


class User extends Authenticatable implements HasMedia
{
    use HasApiTokens,HasFactory, Notifiable, InteractsWithMedia;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'last_name',
        'mobile_no',
        'email',
        'password',
        'country_code',
        'role',
        'colingual',
        'login_by',
        'image_url',
        'card_number',
        'exp_date',
        'cvv',
        'country',
        'nickname',
        'primary_language',
        'device_token',
        'device_type',
    ];

    protected $with = ['language','primary_language'];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

//    public function getImageUrlAttribute()
//    {
//        $media = $this->user;
//        if (! empty($media)) {
//            return $media->;
//        }
//
//        return asset('assets/img/employer-image.png');
//    }

    public function language(){
        return $this->belongsToMany(Language::class);
    }

    public function primary_language(){
        return $this->belongsTo(Language::class,'primary_language');
    }
}
