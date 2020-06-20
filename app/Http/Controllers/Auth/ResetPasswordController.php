<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ResetsPasswords;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\ResetPasswordRequest;


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

    public function resetPassword(ResetPasswordRequest $request) {
        $user = Auth::user();
        if ($this->guard()->attempt(['email' => $user->email, 'password' => $request->old_password])) {
            $user->password = bcrypt($request->password);
            $user->save();
            return redirect(route('home'));
        } else {
            return back()->withErrors(['old_password' => 'Неверно введен старый пароль']);
        }
    }
}
