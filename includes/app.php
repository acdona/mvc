<?php

declare(strict_types=1);

// Ativa todos os tipo de erros e aviso do php
// Deve ser retirado no deploy do projeto

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

date_default_timezone_set('America/Sao_Paulo');

require __DIR__ . "/../vendor/autoload.php";

use \App\Core\View;
use \WilliamCosta\DotEnv\Environment;
use \WilliamCosta\DatabaseManager\Database;

//CARREGA VARIÁVEIS DE AMBIENTE
Environment::load(__DIR__ . '/../');

//DEFINE AS CONFIGURAÇÕES DE BANCO DE DADOS
Database::config(
    getenv('DB_HOST'), 
    getenv('DB_NAME'),
    getenv('DB_USER'),
    getenv('DB_PASS'),
    getenv('DB_PORT')
);

//DEFINE A CONSTANTE DE URL
define('URL', getenv('URL'));

//DEFINE O VALOR PADRÃO DAS VARIÁVEIS
View::init([
    'URL' => URL
]);