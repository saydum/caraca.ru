<?php

namespace App\Http\Controllers;

use App\Models\LoginCode;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Auth;


class AuthController extends Controller
{
    public function showEmailForm()
    {
        return view('auth.index');
    }

    public function showCodeForm(Request $request)
    {
        return view('auth.code', ['email' => $request->email]);
    }

    public function sendCode(Request $request)
    {
        $request->validate(['email' => 'required|email']);

        $email = $request->input('email');

        $code = rand(1000, 9999);

        LoginCode::create([
            'email' => $email,
            'code' => $code,
            'expires_at' => now()->addMinutes(10),
        ]);

        $user = User::firstOrCreate(
            ['email' => $email],
            ['name' => 'Пользователь_' . rand(1000, 9999)]
        );

        Mail::raw("Ваш код для входа: {$code}", function ($message) use ($email) {
            $message->to($email)->subject('Код для входа');
        });

        return redirect()->route('auth.code.form', ['email' => $email])
            ->with('success', 'Код отправлен на email');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'code' => 'required|digits:4',
        ]);

        $loginCode = LoginCode::where('email', $request->email)
            ->where('code', $request->code)
            ->where('used', false)
            ->where('expires_at', '>', now())
            ->first();

        if (!$loginCode) {
            return back()->with('error', 'Неверный или просроченный код');
        }

        $user = User::firstOrCreate(
            ['email' => $request->email],
            ['name' => 'user_' . rand(1000, 9999)]
        );

        $loginCode->update(['used' => true]);

        Auth::login($user, true);

        return redirect('/')->with('success', 'Добро пожаловать!');
    }

    public function logout()
    {
        Auth::logout();
        return redirect('/')->with('success', 'Вы вышли из системы');
    }
}
