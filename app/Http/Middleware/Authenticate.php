<?php

namespace App\Http\Middleware;

use Illuminate\Support\Facades\Auth;
use Illuminate\Auth\Middleware\Authenticate as Middleware;

class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return string|null
     */
    // セッションタイムアウトでログイン画面に遷移する。
    // route('○○○')はweb.php内のname属性から使用。
    protected function redirectTo($request)
    {
        if (!$request->expectsJson()) {
            return route('loginView');
        }
        // session.phpでタイムアウト時間を短くして確認したいが、上手くその画面を確認できてないので、後々確認。
    }
}
