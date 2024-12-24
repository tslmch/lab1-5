<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    // Показать форму для входа
    public function showLoginForm()
    {
        return view('login');
    }

    // Обработка авторизации
    public function login(Request $request)
    {
        // Валидация входных данных
        $validated = $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:8',
        ]);

        // Попытка авторизации пользователя
        if (Auth::attempt($validated)) {
            // Авторизация успешна, редирект на главную страницу
            return redirect()->intended('/');
        }

        // Если авторизация не удалась, вернуть ошибку
        return back()->withErrors([
            'email' => 'Неверные данные для входа.',
        ]);
    }

    // Показать форму для регистрации
    public function showRegistrationForm()
    {
        return view('register');
    }

    public function logout(Request $request)
    {
        Auth::logout(); // Логируем пользователя

        $request->session()->invalidate(); // Очищаем сессию
        $request->session()->regenerateToken(); // Обновляем CSRF токен

        return redirect('/'); // Перенаправляем на главную страницу (или любую другую)
    }

    // Обработка регистрации
    public function register(Request $request)
    {
        // Валидация входных данных
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);

        // Создание нового пользователя
        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
        ]);

        // Авторизация нового пользователя
        Auth::login($user);

        // Перенаправление на главную страницу
        return redirect('/');
    }
}

