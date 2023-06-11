<?php
 
 declare(strict_types=1);
 
 namespace App\Http\Middleware;

 use \App\Session\Admin\Login as SessionAdminLogin;

 class RequireAdminLogin {
    
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

        //VERIFICA SE O USUÁRIO ESTÁ LOGADO
        if(!SessionAdminLogin::isLogged()){
            $request->getRouter()->redirect('/admin/login');
        }

        //CONTINUA A EXECUÇÃO
        return $next($request);
    }
 }
