<?php
 
 declare(strict_types=1);
 
 namespace App\Http\Middleware;
 
 class Api {
        
    /**
     * handle
     * Método responsável por executar o middleware
     *
     * @param  Request $request
     * @param  Closure $next
     * @return Response
     */
    public function handle($request, $next)
    {
        //ALTERA O CONTENT TYPE PARA JSON
        $request->getRouter()->setContentType('application/json');
       
       //EXECUTA O PRÓXIMO NÍVEL DO MIDDLEWARE
        return $next($request);
    }

 }

