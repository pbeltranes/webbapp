<?php

namespace App\Http\Controllers\Auth;

use App\User;
use Validator;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;
use App\UsersProfile;
use Illuminate\Support\Facades\Auth;
use Illuminate\Contracts\Auth\Authenticatable;
class AuthController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Registration & Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users, as well as the
    | authentication of existing users. By default, this controller uses
    | a simple trait to add these behaviors. Why don't you explore it?
    |
    */
    use AuthenticatesAndRegistersUsers, ThrottlesLogins;

    /**
     * Create a new authentication controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest', ['except' => 'getLogout']);
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => 'required|max:255',
            'email' => 'required|email|max:255|unique:users',
            'password' => 'required|confirmed|min:6',
            'bio' => 'max:120',
            'user_name' => 'max:8',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return User
     */

     public function uploading_image($file){
       if($file != NULL)
      $ext = $file->getClientOriginalExtension();
      else
      return 'DEFAULT_AVATAR_URL.png';
        if($ext =! 'jpg' & $ext != 'jpeg' & $ext != 'bmp' & $ext != 'gif' & $ext != 'png')
             return 'DEFAULT_AVATAR_URL.png';
           else{
             $nombre = $file->getClientOriginalName();
             $hash_name = md5($nombre. time()).'.'. $file->getClientOriginalExtension();
             \Storage::disk('local')->put($hash_name,  \File::get($file));
               return $hash_name;
             }
           }

    protected function create(array $data)
    {
        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
        ]);

        $hash_name = array_key_exists('avatar_url',$data) ? uploading_image($data['avatar_url']) : 'DEFAULT_AVATAR_URL.png';
        $user_profile = $user->profile()->save(UsersProfile::create([
            'user_id' => $user->id,
            'bio' => $data['bio'],
            'user_name' => $user->name,
            'growing_since' => $data['growing_since'],
            'birthdate' => $data['birthdate'],
            'avatar_url' => $hash_name,
            'comment_rep' => 0,
            'review_rep' => 0,
        ]));
        return $user;
    }
}
