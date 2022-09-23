<?php

namespace App\Http\Controllers;

use App\Models\User;
use Auth;
use DB;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $users = DB::select("SELECT *,users.id as userID,
       (SELECT count(rating) from user_likes where user_likes.liked_user_id = users.id AND `rating`=1) as total_rate_1,
       (SELECT count(rating) from user_likes where user_likes.liked_user_id = users.id AND `rating`=2) as total_rate_2,
       (SELECT count(rating) from user_likes where user_likes.liked_user_id = users.id AND `rating`=3) as total_rate_3,
       (SELECT count(rating) from user_likes where user_likes.liked_user_id = users.id AND `rating`=4) as total_rate_4,
       (SELECT count(rating) from user_likes where user_likes.liked_user_id = users.id AND `rating`=5) as total_rate_5,
       (SELECT COUNT(`like`) as total_like from user_likes where user_likes.liked_user_id = users.id AND `like`='1') as total_like
        FROM `users`
        LEFT JOIN `user_likes` on `users`.`id` = `user_likes`.`user_id`
        WHERE `role`='0'");
//        dd($users);
        $data = [];
        foreach($users as $user){
                $is_like = false;
                $i = 0;
                if($user->total_rate_1>0){
                        $i++;
                }
                if($user->total_rate_2>0){
                    $i++;
                }
                if($user->total_rate_3>0){
                    $i++;
                }
                if($user->total_rate_4>0){
                    $i++;
                }
                if($user->total_rate_5>0){
                    $i++;
                }
                if ($user->user_id === Auth::id() && $user->like == "1") {
                            $is_like = true;
                }
                $average_rating = 0;
                if ($i>0) {
                    $average_rating = (1 * $user->total_rate_1 + 2 * $user->total_rate_2 + 3 * $user->total_rate_3 + 4 * $user->total_rate_4 + 5 * $user->total_rate_5) / $i;
                }
                $language = DB::select("SELECT * FROM `language_user` JOIN languages on language_user.language_id=languages.id where user_id='.$user->userID.'");
                $data[] = [
                    'id' => $user->userID,
                    'name' => $user->name,
                    'last_name' => $user->last_name,
                    'image_url' => $user->image_url,
                    'is_like' => $is_like,
                    'rating' => (string)$average_rating,
                    'colingual' => $user->colingual,
                    'video' => $user->video,
                    'audio' => $user->audio,
                    'chat' => $user->chat,
                    'like_users_count' => $user->total_like,
                    'language' => $language,
                ];
            }
        $data['users'] = User::where('role','0')->get()->count();

        return view('dashboard',compact('data'));
    }
}
