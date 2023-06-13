<?php
 
 declare(strict_types=1);
 
 namespace App\Controllers\Api;

 class Api
 {    
    /**
     * getDetails
     *
     * @param  Request $request
     * @return array
     */
    public static function getDetails($request)
    {
        return [
            'nome'=> 'API - ACD WDEV',
            'versao' => 'v1.0.0',
            'autor' => 'Tony Doná',
            'email' => 'acdona@hotmail.com'
        ];
    }
    
    /**
     * getPagination
     * Método responsável por retornar os detalhes da paginação
     *
     * @param  Request $request
     * @param  Pagination $obPagination
     * @return array
     */
    protected static function getPagination($request, $obPagination){
        //QUERY PARAMS
        $queryParams = $request->getQueryParams();

        //PÁGINA
        $pages = $obPagination->getPages();
  
        //RETORNO
        return [
            'paginaAtual' => (isset($queryParams['page']) ? (int)$queryParams['page'] :1),
            'quantidadePaginas' => (!empty($pages) ? count($pages) : 1)
        ];
    }
 }

