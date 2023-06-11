<?php

declare(strict_types=1);

namespace App\Models\Entity;

use \WilliamCosta\DatabaseManager\Database;

class User
{    
    /**
     * id
     * ID do usuário
     *
     * @var int
     */
    public $id;
        
    /**
     * username
     * Nome do usuário
     *
     * @var string
     */
    public $username;
        
    /**
     * email
     * Email do usuário
     *
     * @var string
     */
    public $email;
        
    /**
     * password
     * Senha do usuário
     *
     * @var string
     */
    public $password;
    
    /**
     * getUserByEmail
     * Método responsável por retorna rusuário com base em seu email
     *
     * @param  string $email
     * @return User
     */
    public static function getUserByEmail($email)
    {
        return (new Database('users'))->select('email = "'.$email.'"')->fetchObject(self::class);
    }
}
