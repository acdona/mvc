<?php

declare(strict_types=1);

namespace App\Http\Middleware;

class Queue
{

    /**
     * map
     * Mapeamento de middlewares
     * 
     * @var array
     */
    private static $map = [];

    /**
     * Mapeamento de middlers que serão carregados em todas as rotas
     * 
     * @var array
     */
    private static $default = [];

    /**
     * middlewares
     * Fila de middlewares a serem executados
     *
     * @var array
     */
    private $middlewares = [];

    /**
     * controller
     * Função de execução do controlador
     *
     * @var Clousure
     */
    private $controller;

    /**
     * controllerArgs
     * Argumentos da função do controlador
     *
     * @var array
     */
    private $controllerArgs = [];

    /**
     * __construct
     * Método responsável por construir a classe de fila de middlewares
     *
     * @param  array $middlewares
     * @param  Clousure $controller
     * @param  array $controllerArgs
     */
    public function __construct($middlewares, $controller, $controllerArgs)
    {
        
        $this->middlewares = array_merge(self::$default, $middlewares);

        $this->controller = $controller;
        $this->controllerArgs = $controllerArgs;
    }

    /**
     * setMap
     * Método responsável por definir o mapeamento de middlewares
     * 
     * @param  array $map
     */
    public static function setMap($map)
    {
        self::$map = $map;
    }

    /**
     * setDefault
     * Método responsável por definir o mapeamento de middlewares padrões
     * 
     * @param  array $default
     */
    public static function setDefault($default)
    {
        self::$default = $default;
    }

    /**
     * next
     * Método responsável por executar o próximo nível da fila de middlewares
     * 
     * @param  Request $request
     * @return Response
     */
    public function next($request)
    {
        //Valida instancia de controller
        if (!is_callable($this->controller)) {
            throw new \Exception("Tipo esperado 'callable'. Mas veio  '...\Middleware\Closure'");
        }

        //VERIFICA SE A FILA ESTÁ VAZIA
        if (empty($this->middlewares)) return call_user_func_array($this->controller, $this->controllerArgs);

        //MIDDLEWARE
        $middleware = array_shift($this->middlewares);

        //VERIFICA O MAPEAMENTO
        if (!isset(self::$map[$middleware])) {
            throw new \Exception("Problemas ao processar o middleware da requisição", 500);
        }

        //NEXT
        $queue = $this;
        $next = function ($request) use ($queue) {
            return $queue->next($request);
        };

        //EXECUTA O MIDDLEWARE
        return (new self::$map[$middleware])->handle($request, $next);
    }
}
