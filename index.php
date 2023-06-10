<?php

// ativa a checagem de tipo
declare(strict_types=1);
 
// Ativa todos os tipo de erros e aviso do php
// Deve ser retirado no deploy do projeto

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Ativa o buffer de saída
ob_start();

require __DIR__ . '/includes/app.php';

use \App\Http\Router;

//INICIA O ROUTER
$obRouter  = new Router(URL);

//INCLUI AS ROTAS DE PÁGINAS
include __DIR__ . '/routes/pages.php';

// //IMPRIME O REPONSE DA ROTA
$obRouter->run()->sendResponse();







// Descarrega e desativa o buffer de saída
ob_end_flush();
