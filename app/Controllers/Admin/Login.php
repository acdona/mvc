<?php

declare(strict_types=1);

namespace App\Controllers\Admin;

use app\Core\View;
use \App\Models\Entity\User;

class Login extends Template {
    
    /**
     * getLogin
     * Método responsável por retornar a renderização da página de login
     *
     * @param  Request $request
     * @param string $errorMessage
     * @return string
     */
    public static function getLogin($request, $errorMessage = null)
    {
        //STATUS
        $status = !is_null($errorMessage) ? View::render('admin/login/status',[
            'message' => $errorMessage
        ]) : '';


        //CONTEÚDO DA PÁGINA DE LOGIN
        $content = View::render('admin/login', [
            'status' => $status
        ]);

        //RETORNA A PÁGINA COMPLETA
        return parent::getTemplate('Login > ACD WEBDEV', $content);
    }
    
    /**
     * setLogin
     * Método responsável por definir o login di usuário
     * 
     * @param  Request $request
     * @return void
     */
    public static function setLogin($request)
    {
        //POST VAR
        $postVars = $request->getPostVars();
        $email = $postVars['email'] ?? '';
        $password = $postVars['password'] ?? '';

        // BUSCA USUARIO PELO EMAIL
        $obUser = User::getUserByEmail($email);

        if(!$obUser instanceof User){
            return self::getLogin($request, 'E-mail ou senha inválidos');
        }    
        
        //VERIFICA A SENHA DO USUÁRIO
        if(!password_verify($password, $obUser->password)){
            return self::getLogin($request, 'E-mail ou senha inválidos');
        }
    }
}
