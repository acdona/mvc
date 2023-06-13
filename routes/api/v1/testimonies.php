<?php
 
declare(strict_types=1);
 
use \App\Http\Response;
use \App\Controllers\Api;

//ROTA DE LISTAGEM DE DEPOIMENTOS
$obRouter->get('/api/v1/testimonies', [
    'middlewares' => [
        'api'
    ],
    function($request) {
        return new Response(200, API\Testimony::getTestimonies($request), 'application/json');
    }
]);

//ROTA DE CONSULTA INDIVIDUAL DE DEPOIMENTOS
$obRouter->get('/api/v1/testimonies/{id}', [
    'middlewares' => [
        'api'
    ],
    function($request, $id){
        return new Response(200, Api\Testimony::getTestimony($request, $id), 'application/json');
    }
]);
