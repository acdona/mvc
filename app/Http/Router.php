<?php

declare(strict_types=1);

namespace App\Http;

use Closure;
use Exception;

class Router
{
    /**
     * url
     * URL completa do projeto (raiz)
     * Full project URL (root)
     *
     * @var string
     */
    private $url = '';

    /**
     * prefix
     * Prefixo de todas as rotas
     *
     * @var string
     */
    private $prefix = '';

    /**
     * routes
     * Índice de rotas
     * Route index
     *
     * @var array
     */
    private $routes = [];

    /**
     * request
     * Instância de Request
     * Request instance
     *
     * @var Request
     */
    private $request;

    /**
     * __construct
     * Método responsável por iniciar a classe
     * Method responsible for starting the class
     *
     * @param  string $url
     */
    public function __construct($url)
    {
        $this->request = new Request();
        $this->url = $url;
        $this->setPrefix();
    }

    /**
     * setPrefix
     * Método responsável por definir p prefixo das rotas
     * Method responsible for defining the route prefix
     * @return void
     */
    private function setPrefix(): void
    {
        //INFORMAÇÕES DA URL ATUAL
        $parseUrl = parse_url($this->url);

        //DEFINE O PREFIXO
        $this->prefix = $parseUrl['path'] ?? '';
    }

    /**
     * addRoute
     * Método responsável por adicionar uma rota na classe
     * Method responsible for adding a route in the class
     *
     * @param  string $method
     * @param  string $route
     * @param  array $params
     * @return void
     */
    private function addRoute($method, $route, $params)
    {        
        //VALIDAÇÃO DOS PARÂMETROS
        foreach($params as $key=>$value) {
            if($value instanceof Closure){
                $params['controller'] = $value;
                unset($params[$key]);
                continue;
            }
        }

        //PADRÃO DE VALIDAÇÃO DA URL
        $patternRoute = '/^' . str_replace('/','\/', $route) . '$/';
        
        //ADICIONA A ROTA DENRO DA CLASSE
        $this->routes[$patternRoute][$method] = $params;
    }

    /**
     * get
     * Método responsável por definir uma rota de GET
     * Method responsible for defining a GET route
     *
     * @param  string $route
     * @param  array $params
     */
    public function get($route, $params = [])
    {
        return $this->addRoute('GET', $route, $params);
    }
    
    /**
     * run
     * Método responsável por executar a rota atual
     * Method responsible for executing the current route
     *
     * @return Response
     */
    public function run(): Response
    {
        try{
            throw new Exception("Página não encontrada", 404);
            //CONTINUA...................
        }catch(Exception $e){
            return new Response($e->getCode(), $e->getMessage());
        }
    }
}
