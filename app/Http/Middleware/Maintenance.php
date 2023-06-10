<?php
 
 declare(strict_types=1);
 
 namespace App\Http\Middleware;
 
 class Maintenance {
        
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
        //VERIFICA O ESTADO DE MANUTENÇÃO DA PÁGINA
       if(getenv('MAINTENANCE') == 'true') {
        throw new \Exception("Página de manutenção. Tente novamente mais tarde.", 200);
       }
       //EXECUTA O PRÓXIMO NÍVEL DO MIDDLEWARE
        return $next($request);
    }

 }

