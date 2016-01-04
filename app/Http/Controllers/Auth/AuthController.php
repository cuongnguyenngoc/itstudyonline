<?php

namespace App\Http\Controllers\Auth;

use App\User;
use App\Image;
use Validator;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;
use Illuminate\Http\Request;
use Input;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;
use Response;

class AuthController extends Controller {
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

    protected $redirectPath = '/';

    use AuthenticatesAndRegistersUsers, ThrottlesLogins;

    /**
     * Create a new authentication controller instance.
     *
     * @return void
     */
    public function __construct() {
        $this->middleware('guest', ['except' => 'getLogout']);
    }

    public function checkEmailExisted(Request $request) {

        $input['email'] = $request->get('email');

        if ($request->ajax()) {

            $validator = Validator::make($input, [
                        'email' => 'unique:users'
            ]);
            if ($validator->fails())
                return Response::json(FALSE);
            else
                return Response::json(TRUE);
        }
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data) {
        return Validator::make($data, [
                    'fullname' => 'required|max:255',
                    'email' => 'required|email|max:255|unique:users',
                    'password' => 'required|confirmed|min:6',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return User
     */
    protected function create(array $data) {
        return User::create([
                    'fullname' => $data['fullname'],
                    'email' => $data['email'],
                    'password' => bcrypt($data['password']),
                    'role_id' => 3,
        ]);
    }

    protected function createImageDefault($user_id, $img = '/images/user.png') {
        Image::create([
            'user_id' => $user_id,
            'img_name' => 'avatar',
            'path' => $img
        ]);
    }

    public function redirectToProviderFb() {
        return Socialite::driver('facebook')->redirect();
    }

    public function redirectToProviderGg() {
        return Socialite::driver('google')->redirect();
    }

    public function handleProviderCallbackFb() {
        try {
            $user = Socialite::driver('facebook')->user();
            $users = User::where("email", "=", $user->id);
            if ($users->count() == 0) {
                $data = [];
                $data['fullname'] = $user->name;
                $data['email'] = $user->id;
                $data['password'] = '';
                $authUser = $this->create($data);
                Auth::login($authUser, true);
                $this->createImageDefault(Auth::user()->id, $user->avatar);
                return redirect($this->redirectPath());
            } else {
                Auth::login($users->first(), true);
                return redirect($this->redirectPath());
            }
        } catch (Exception $e) {
            return redirect('auth/facebook');
        }
        return redirect('/');
    }

    public function handleProviderCallbackGg() {
        try {
            $user = Socialite::driver('google')->user();
            $users = User::where("email", "=", $user->id);
            if ($users->count() == 0) {
                $data = [];
                $data['fullname'] = $user->name;
                $data['email'] = $user->id;
                $data['password'] = '';
                $authUser = $this->create($data);
                Auth::login($authUser, true);
                $this->createImageDefault(Auth::user()->id, $user->avatar);
                return redirect($this->redirectPath());
            } else {
                Auth::login($users->first(), true);
                return redirect($this->redirectPath());
            }
        } catch (Exception $e) {
            return redirect('auth/google');
        }
        return redirect('/');
    }

}
