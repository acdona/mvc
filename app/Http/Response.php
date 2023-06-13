<?php

declare(strict_types=1);

namespace App\Http;

class Response
{
    /**
     * httpCode
     * Código do status HTTP
     * HTTP status code
     *
     * @var integer
     */
    private $httpCode = 200;

    /**
     * headers
     * Cabeçalho do Response
     * Response Header
     *
     * @var array
     */
    private $headers = [];

    /**
     * contentType
     * Tipo de conteúdo que está sendo retornado
     * Type of content being returned
     *
     * @var string
     */
    private $contentType = 'text/html';

    /**
     * content
     * Conteúdo do Response
     *
     * @var mixed
     */
    private $content;
    
    /**
     * __construct
     * Método responsável por iniciar a classe e definir os valores
     * Method responsible for starting the class and setting the values
     *
     * @param  integer $httpCode
     * @param  mixed $content
     * @param  string $contentType
     */
    public function __construct($httpCode, $content, $contentType = 'text/html')
    {
        $this->httpCode = $httpCode;
        $this->content = $content; 
        $this->setContentType($contentType);
    }
    
    /**
     * setContentType
     * Método responsável por alterar o content do response
     * Method responsible for changing the content of the response
     *
     * @param  mixed $contentType
     * @return string
     */
    public function setContentType($contentType)
    {
        $this->contentType = $contentType;  
        $this->addHeader('ContentType', $contentType);
    }
    
    /**
     * addHeader
     * Método responsével para adicionar um registro no cabeçalho response
     * Responsible method to add a record in the response header
     *
     * @param  string $key
     * @param  string $value
     */
    public function addHeader($key, $value)
    {
        $this->headers[$key] = $value;
    }
    
    /**
     * sendHeaders
     * Método responsável por enviar os headers para o navegador
     * @return void
     */
    private function sendHeaders()
    {
        //STATUS
        http_response_code($this->httpCode);

        //ENVIAR HEADERS
        foreach($this->headers as $key=>$value)
        {
            header($key. ': ' . $value);
        }
    }
    
    /**
     * sendResponse
     * Método responsável por enviar a resposta para o usuário
     * Method responsible for sending the response to the user
     *
     */
    public function sendResponse()
    {
        //ENVIA OS HEADERS
        $this->sendHeaders();

        //IMPRIME O CONTEÚDO
        switch ($this->contentType) {
            case 'text/html':
                echo $this->content;
                exit;
            case 'application/json':
                echo json_encode($this->content, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
                exit;
        }
    }
}
