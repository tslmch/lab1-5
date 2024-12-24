<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        // Проверяем, является ли пользователь администратором
        if (Auth::check() && Auth::user()->is_admin) {
            return $next($request);
        }

        // Если нет — перенаправляем на страницу с ошибкой или на главную страницу
        return redirect('/');
    }
}
