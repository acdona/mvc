<?php
 
declare(strict_types=1);
 
use \App\Http\Response;
use App\Controllers\Admin;

//ROTA DE LISTAGEM DE DEPOIMENTOS
$obRouter->get('/admin/testimonies', [
    'middlewares' => [
        'require-admin-login'
    ],
    function ($request) {
        return new Response(200, Admin\Testimony::getTestimonies($request));
    }
]);

