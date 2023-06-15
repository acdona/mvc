<?php

declare(strict_types=1);

namespace App\Http;

use \Closure;
use \Exception;
use \ReflectionFunction;
use \App\Http\Middleware\Queue as MiddlewareQueue;

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
     * contentType
     * Content type padrão do response
     *
     * @var string
     */
    private $contentType = 'text/html';

    /**
     * __construct
     * Método responsável por iniciar a classe
     * Method responsible for starting the class
     *
     * @param  string $url
     */
    public function __construct($url)
    {
        $this->request = new Request($this);
        $this->url = $url;
        $this->setPrefix();
    }

    /**
     * setContentType
     * Método responsável por alterar o valor da contenttype
     * 
     * @param  string $contentType
     */
    public function setContentType($contentType)
    {
        $this->contentType = $contentType;
    }

    /**
     * setPrefix
     * Método responsável por definir p prefixo das rotas
     * Method responsible for defining the route prefix
     */
    private function setPrefix()
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
     */
    private function addRoute($method, $route, $params = [])
    {
        //VALIDAÇÃO DOS PARÂMETROS
        foreach ($params as $key => $value) {
            if ($value instanceof Closure) {
                $params['controller'] = $value;
                unset($params[$key]);
                continue;
            }
        }

        //MIDDLEWARES DA ROTA
        $params['middlewares'] = $params['middlewares'] ?? [];

        //VARIÁVEIS DA ROTA
        $params['variables'] = [];

        //PADRÃO DE VALIDAÇÃO DAS VARIÁVEIS DAS ROTAS
        $patternVariable = '/{(.*?)}/';

        if (preg_match_all($patternVariable, $route, $matches)) {
            $route = preg_replace($patternVariable, '(.*?)', $route);
            $params['variables'] = $matches[1];
        }

        //PADRÃO DE VALIDAÇÃO DA URL        
        $patternRoute = '/^' . str_replace('/', '\/', $route) . '$/';

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
     * post
     * Método responsável por definir uma rota de POST
     * Method responsible for defining a POST route
     *
     * @param  string $route
     * @param  array $params
     */
    public function post($route, $params = [])
    {
        return $this->addRoute('POST', $route, $params);
    }

    /**
     * put
     * Método responsável por definir uma rota de PUT
     * Method responsible for defining a PUT route
     *
     * @param  string $route
     * @param  array $params
     */
    public function put($route, $params = [])
    {
        return $this->addRoute('PUT', $route, $params);
    }

    /**
     * delete
     * Método responsável por definir uma rota de DELETE
     * Method responsible for defining a DELETE route
     *
     * @param  string $route
     * @param  array $params
     */
    public function delete($route, $params = [])
    {
        return $this->addRoute('DELETE', $route, $params);
    }

    public function catch($route, $params = [])
    {

        $this->addRoute('CATCH', $route, $params);
    }

    /**
     * getUri
     * Método responsável por retornar a URI desconsideranto o prefixo
     * Method responsible for returning the URI disregarding the prefix
     *
     * @return string
     */
    public function getUri()
    {
        //URI DA REQUEST
        $uri = $this->request->getUri();

        //FATIA A URL COM O PREFIXO
        $xUri = strlen($this->prefix) ? explode($this->prefix, $uri) : [$uri];
        
        //RETORNA A URI SEM PREFIXO
        return rtrim(end($xUri),'/');
    }

    /**
     * getRoute
     * Método responsável por retornar os dados da rota atual
     * Method responsible for returning the current route data
     * 
     * @return array
     */
    private function getRoute()
    {
        //URI
        $uri = $this->getUri();

        //METODO
        $httpMethod = $this->request->getHttpMethod();

        //VALIDA AS ROTAS
        foreach ($this->routes as $patternRoute => $methods) {
            //VERIFICA SE URI BATE COM O PADRAO
            if (preg_match($patternRoute, $uri, $matches)) {
                //VERIFICA O MÉTODO
                if (isset($methods[$httpMethod])) {

                    //REMOVE A PRIMEIRA POSIÇÃO
                    unset($matches[0]);

                    //VARIÁVEIS PROCESSADAS
                    $keys = $methods[$httpMethod]['variables'];
                    $methods[$httpMethod]['variables'] = array_combine($keys, $matches);
                    $methods[$httpMethod]['variables']['request'] = $this->request;

                    //RETORNO DOS PARÂMETROS DA ROTA
                    return $methods[$httpMethod];
                }
                //MÉTODO NÃO PERMITIDO
                throw new Exception("Método não permitido", 405);
            }
        }

        //URL NÃO ENCONTRADA
        throw new Exception("URL não encontrada", 404);
    }

    /**
     * run
     * Método responsável por executar a rota atual
     * Method responsible for executing the current route
     *
     * @return Response
     */
    public function run()
    {
        try {
            //OBTEM A ROTA ATUAL
            $route = $this->getRoute();

            //VERIFICA O CONTROLADOR
            if (!isset($route['controller'])) {
                throw new Exception("A URL não pode ser processada", 500);
            }

            //ARGUMENTOS DA FUNÇÃO
            $args = [];

            //REFLECTION
            $reflection = new ReflectionFunction($route['controller']);

            foreach ($reflection->getParameters() as $parameter) {
                $name = $parameter->getName();
                $args[$name] = $route['variables'][$name] ?? '';
            }

            //RETORNA E EXECUÇÃO DA FILA DE MIDDLEWARES
            return (new MiddlewareQueue($route['middlewares'], $route['controller'], $args))->next($this->request);
        } catch (Exception $e) {
            return new Response($e->getCode(), $this->getErrorMessage($e->getMessage()), $this->contentType);
        }
    }

    /**
     * getErrorMessage
     * Método responsável por retornar a mensagem de erro de acordo com o content type
     * 
     * #param string $message
     *
     * @return mixed
     */
    private function getErrorMessage($message)
    {
        switch ($this->contentType) {
            case 'application/json':
                return [
                    'error' => $message
                ];
                break;

            default:
                return $message;
                break;
        }
    }

    /**
     * getCurrentUrl
     * Método responsável por retornar a URL atual
     *
     * @return string
     */
    public function getCurrentUrl()
    {
        return $this->url . $this->getUri();
    }

    /**
     * redirect
     * Método responsável por redirecionar a URL
     *
     * @param string $route
     */
    public function redirect($route)
    {
        //URL
        $url = $this->url . $route;

        //EXECUTA O REDIRECT
        header('location: ' . $url);
        exit;
    }
}
