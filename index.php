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

require __DIR__ . "/vendor/autoload.php";

use \App\Controllers\Pages\Home;

$obResponse = new \App\Http\Response(500, "Olá mundo");

$obResponse->sendResponse();
exit;
echo Home::getHome();


// Descarrega e desativa o buffer de saída
ob_end_flush();
