<?php

namespace App\Http\Controllers\Auth\Frontend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\ParentUser;
use App\Traits\ResetsPasswords;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;

class ResetPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset requests
    | and uses a simple trait to include this behavior. You're free to
    | explore this trait and override any methods you wish to tweak.
    |
    */

    use ResetsPasswords;

    /**
     * Where to redirect users after resetting their password.
     *
     * @var string
     */
    protected $redirectTo = '/';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    //Show form to seller where they can reset password
    public function showResetForm(Request $request, $token = null)
    {
        return view('newfrontend.parent.reset')->with(
            ['token' => $token, 'email' => $request->email]
        );
    }

    /**
     * Get the password reset validation rules.
     *
     * @return array
     */
    protected function rules()
    {
        return [
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|confirmed|min:6',
        ];
    }

    //returns Password broker of admins
    public function broker()
    {
        return Password::broker('parents');
    }

    //returns authentication guard of admin
    protected function guard()
    {
        return Auth::guard('parent');
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:parents',
            'password' => 'required|string|min:6|confirmed',
            'password_confirmation' => 'required',

        ]);

        $updatePassword = DB::table('parents_password_resets')
                            ->where(['email' => $request->email, 'token' => $request->token])
                            ->first();

        if(!$updatePassword)
            return back()->withInput()->with('error', 'Invalid token!');

          $user = ParentUser::where('email', $request->email)
                      ->update(['password' => Hash::make($request->password)]);

          DB::table('parents_password_resets')->where(['email'=> $request->email])->delete();

          return redirect('/')->with('message', 'Your password has been changed!');

    }
}
