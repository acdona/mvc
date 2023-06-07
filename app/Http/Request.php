<?php

declare(strict_types=1);

namespace App\http;

class Request
{
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

    public function __construct()
    {
        $this->queryParams = $_GET ?? [];
        $this->postVars = $_POST ?? [];
        $this->headers = getallheaders();
        $this->httpMethod = $_SERVER['REQUEST_METHOD'] ?? '';
        $this->uri = $_SERVER['REQUEST_URI'] ?? '';
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
     * @return void
     */
    public function getUri()
    {
        return $this->getUri();
    }
    
    /**
     * getQueryParams
     * Método responsável por retornar os parâmetros da requisição
     * Method responsible for returning the request parameters
     *
     * @return void
     */
    public function getQueryParams()
    {
        return $this->getQueryParams();
    }
    
    /**
     * getPostVars
     * Método resonsávelpor retornar as variáveis POST da requisição
     * Method responsible for returning the POST variables of the request
     *
     * @return void
     */
    public function getPostVars() 
    {
        return $this->getPostVars();
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
        return $this->getHeaders();
    }
}
