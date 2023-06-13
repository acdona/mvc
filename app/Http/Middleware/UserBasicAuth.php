<?php
 
 declare(strict_types=1);
 
 namespace App\Http\Middleware;

 use \App\Models\Entity\User;
 
 class UserBasicAuth {
    
    /**
     * getBasicaAuthUser
     * Método responsável por reornar uma instência de usuário autenticado
     *
     * @return User
     */
    private function getBasicAuthUser()
    {
        //VERIFICA A EXISTENCIA DOS DADOS DE ACESSO
        if(!isset($_SERVER['PHP_AUTH_USER']) || !isset($_SERVER['PHP_AUTH_PW'])){
            return false;
        }

        //BUSCAR USUÁRIO POR EMAIL
        $obUser = User::getUserByEmail($_SERVER['PHP_AUTH_USER']);

        //VERIFICA A INSTANCIA
        if(!$obUser instanceof User){
            return false;
        }

        //VALIDA SENHA E RETORNA O USUÁRIO
        return password_verify($_SERVER['PHP_AUTH_PW'], $obUser->password) ? $obUser : false;
    }
    
    /**
     * basicAuth
     * Método responsável por validar o acesso via HTTP VASIC AUTH
     *
     * @param  Request $request
     */
    private function basicAuth($request)
    {
        //VERIFICA O USUÁRIO RECEBIDO
        if($obUser = $this->getBasicAuthUser())
        {
                       
            $request->user = $obUser;
         
            return true;
        }

        //EMITE O ERRO DE SENHA INVÁLIDA
        throw new \Exception("Usuário ou senha inválidos", 403);
    }
        
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
      //REALIZA A VALIDAÇÃO DO ACESSO VIA BASIC AUTH
      $this->basicAuth($request);
       
       //EXECUTA O PRÓXIMO NÍVEL DO MIDDLEWARE
        return $next($request);
    }

 }

