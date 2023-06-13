<?php
 
declare(strict_types=1);
 
use \App\Http\Response;
use \App\Controllers\Api;

//ROTA RAIZ DA API
$obRouter->get('/api/v1', [
    'middlewares' => [
        'api'
    ],
    function($request) {
        return new Response(200, API\Api::getDetails($request), 'application/json');
    }
]);
