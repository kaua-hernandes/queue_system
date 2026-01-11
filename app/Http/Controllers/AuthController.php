<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        return view('auth.login_frm');
    }

    public function loginSubmit(Request $request)
    {
        // form validation
        $request->validate(
            // rules for validation
            [
                'username' => 'required|email',
                'password' => 'required|regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)[A-Za-z\d]{6,16}$/',
            ],
            // error mesagges
            [
                'username.required' => 'O usuário é obrigatório.',
                'username.email' => 'O usuário deve ser um endereço de e-mail válido.',
                'password.required' => 'A senha é obrigatória.',
                'password.regex' => 'A senha deve ter entre 6 e 16 caracteres, conter pelo menos uma letra maiúscula, uma minúscula e um dígito.',
            ],
        );

        // user authentication
        $user = User::where('email', trim($request->username))
              ->where('active', true)
              ->whereNull('deleted_at')
              ->where(function($query){
                   $query->whereNull('blocked_until')
                         ->orWhere('blocked_until', '<', now());
              })->first();

        // check if user exists and password matches
        if ($user && Hash::check(trim($request->password), $user->password)) {
            // login user
            $this->loginUser($user);
            // redirect to home page
            return redirect()->route('home');
        } else {
            // login failed
            return redirect()->back()
                ->withInput()
                ->with('server_error', 'Login inválido. Verifique suas credenciais e tente novamente.');
        }
    }

    public function logout(Request $request)
    {
        // logout user
        auth()->logout();

        // invalidate session - clear all session data
        session()->invalidate();

        // regenerate session token
        session()->regenerateToken();

        return redirect()->route('login');
    }

    public function loginUser($user)
    {
        // update last login and reset other fields
        $user->last_login = now();
        $user->code = null;
        $user->code_expiration = null;
        $user->blocked_until = null;
        $user->save();

        // play user in session
        auth()->login($user);
    }

    public function changePassword(Request $request)
    {
        return view('auth.change_password_frm', [
            'subtitle' => 'Alterar Senha',
        ]);
    }

    public function changePasswordSubmit(Request $request)
    {
        // form validation
        $request->validate(
            [
                'current_password' => 'required',
                'new_password' => 'required|regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)[A-Za-z\d]{6,16}$/|confirmed',


            ],
            [
                'current_password.required' => 'A senha atual é obrigatória.',
                'new_password.required' => 'A nova senha é obrigatória.',
                'new_password.regex' => 'A nova senha deve ter entre 6 e 16 caracteres, conter pelo menos uma letra maiúscula, uma minúscula e um dígito.',
                'new_password.confirmed' => 'A confirmação da nova senha não corresponde.',
            ],
        );

        // get authenticated user
        $user = auth()->user();

        // check if current password matches
        if (Hash::check($request->current_password, $user->password)) {
            // update password
            $user->password = Hash::make($request->new_password);
            $user->save();

            // redirect to home with success message
            return redirect()->route('home')
                ->with('message', 'Senha alterada com sucesso.');
        } else {
            //dd('teste');
            // current password does not match
            return redirect()->back()
                ->with('server_error', 'A senha atual está incorreta. Por favor, tente novamente.');
        }
    }
}
