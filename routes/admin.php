<?php

declare(strict_types=1);

use \App\Http\Response;
use App\Controllers\Admin;

//ROTA ADMIN
$obRouter->get('/admin', [
    'middlewares' => [
        'require-admin-login'
    ],
    function () {
        return new Response(200, 'Admin :)');
    }
]);

//ROTA DE LOGIN
$obRouter->get('/admin/login', [
    'middlewares' => [
        'require-admin-logout'
    ],
    function ($request) {
        return new Response(200, Admin\Login::getLogin($request));
    }
]);

//ROTA DE LOGIN (POST)
$obRouter->post('/admin/login', [
    'middlewares' => [
        'require-admin-logout'
    ],
    function ($request) {

        return new Response(200, Admin\Login::setLogin($request));
    }
]);

//ROTA DE LOGOUT
$obRouter->get('/admin/logout', [
    'middlewares' => [
        'require-admin-login'
    ],
    function ($request) {
        return new Response(200, Admin\Login::setLogout($request));
    }
]);
