<?php

declare(strict_types=1);

use \App\Http\Response;
use App\Controllers\Admin;

//ROTA ADMIN
$obRouter->get('/admin', [
    function () {
        return new Response(200, 'Admin :)');
    }
]);

//ROTA DE LOGIN
$obRouter->get('/admin/login', [
    function ($request) {
        return new Response(200, Admin\Login::getLogin($request));
    }
]);

//ROTA DE LOGIN (POST)
$obRouter->post('/admin/login', [
    function ($request) {

        return new Response(200, Admin\Login::setLogin($request));
    }
]);
