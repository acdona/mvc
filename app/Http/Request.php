<?php

declare(strict_types=1);

namespace App\http;

class Request
{

    /**
     * router
     * Instância do router
     *
     * @var Router
     */
    private $router;

    /**
     * httpMethod
     * Método HTTP da requisição 
     * HTTP method of the request
     * 
     * @var string
     */
    private $httpMethod;

    /**
     * uri
     * URI da página
     * Page uri
     *
     * @var string
     */
    private $uri;

    /**
     * queryParams
     * Parâmetros da URL ($_GET)
     * URL parameters ($_GET)
     * 
     * @var array
     */
    private $queryParams = [];

    /**
     * postVars
     * Variáveis recebidas no POST da página ($_POST)
     * Variables received in the POST of the page ($_POST)
     *
     * @var array
     */
    private $postVars = [];

    /**
     * headers
     * Cabeçalho da requisição
     * Request header
     *
     * @var array
     */
    private $headers = [];

    public $user = [];

    public function __construct($router)
    {
        $this->router = $router;
        $this->queryParams = $_GET ?? [];
        $this->headers = getallheaders();
        $this->httpMethod = $_SERVER['REQUEST_METHOD'] ?? '';
        $this->setUri();
        $this->setPostVars(); 
    }
    
    
    /**
     * setPostVars
     * Método responsável por definir as variáveis do POST
     */
    private function setPostVars()
    {
        //VERIFICA O MÉTODO DA REQUISIÇÃO
        if($this->httpMethod == 'GET') return false;

        //POST PADRÃO
        $this->postVars = $_POST ?? [];

        //POST JSON
        $inputRaw = file_get_contents('php://input');
        $this->postVars = (strlen($inputRaw) && empty($_POST)) ? json_decode($inputRaw, true) : $this->postVars;

        
    }

    /**
     * getRouter
     * Método responsével por retornar a instância de Router
     *
     * @return Router
     */
    public function getRouter()
    {
        return $this->router;
    }

    /**
     * setUri
     * Método responsável por definir a URI
     *
     * @return void
     */
    private function setUri()
    {
        //URI COMPLETA (COM GETS)
        $this->uri = $_SERVER['REQUEST_URI'] ?? '';

        //REMOVE GETS DA URI
        $xURI = explode('?', $this->uri);
        $this->uri = $xURI[0];
    }

    /**
     * getHttpMethod
     * Método responsável por retornar o método HTTP da requisição
     * Method responsible for returning the HTTP method of the request
     *
     * @return string
     */
    public function getHttpMethod()
    {
        return $this->httpMethod;
    }

    /**
     * getUri
     * Método responsável por retornar a URI da requisição
     * Method responsible for returning the request URI
     *
     */
    public function getUri()
    {
        return $this->uri;
    }

    /**
     * getQueryParams
     * Método responsável por retornar os parâmetros da requisição
     * Method responsible for returning the request parameters
     */
    public function getQueryParams()
    {
        return $this->queryParams;
    }

    /**
     * getPostVars
     * Método resonsável por retornar as variáveis POST da requisição
     * Method responsible for returning the POST variables of the request
     *
     * @return void
     */
    public function getPostVars()
    {
        return $this->postVars;
    }

    /**
     * getHeaders
     * Método responsável por retornar os headers da requisição
     * Method responsible for returning the request headers
     *
     * @return void
     */
    public function getHeaders()
    {
        return $this->headers;
    }

}
