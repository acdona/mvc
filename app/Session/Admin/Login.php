<?php

declare(strict_types=1);

namespace App\Session\Admin;

/**
 * ACD || Login 
 * Classe responsável por gerenciar o login do usuário dentro das sessões de admin
 * Class responsible for managing user login within admin sessions
 * 
 * @author Antonio Carlos Doná <contato@antoniocarlosdona.com.br>
 * @package App\Session\Admin
 */
class Login
{

    /**
     * init
     * Método resposável por iniciar a sessão
     */
    private static function init()
    {
        //VERIFICA SE A SESSÃO NÃO ESTÁ ATIVA
        if (session_status() != PHP_SESSION_ACTIVE) {
            session_start();
        }
    }

    /**
     * login
     * Método responsável porr criar o login do usuário
     *
     * @param  User $obUser
     * @return boolean
     */
    public static function login($obUser)
    {
        //INICIA SESSÃO
        self::init();

        //DEFINE A SESSÃO DO USUÁRO
        $_SESSION['admin']['user'] = [
            'id' => $obUser->id,
            'username' => $obUser->username,
            'email' => $obUser->email
        ];

        //SUCESSO
        return true;
    }

    /**
     * isLogged
     * Método responsável por verificar se o usuário está logado
     *
     * @return boolean
     */
    public static function isLogged()
    {
        //INICIA SESSÃO
        self::init();

        //RETORNA A VERIFICAÇÃO
        return isset($_SESSION['admin']['user']['id']);
    }

    /**
     * logout
     * Método responsável por executar o Logout do usuário
     *
     * @return boolean
     */
    public static function logout()
    {
        //INICIA SESSÃO
        self::init();

        //DESLOGAR O USUÁRIO
        unset($_SESSION['admin']['user']);

        //SUCESSO
        return true;
    }
}
