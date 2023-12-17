<?php

declare(strict_types=1);

namespace App\Models\Entity;

use \App\Core\Database;

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
     * cadastrar
     * Método responsável por cadastrar a instância atial no banco de dados
     *
     * @return boolean
     */
    public function cadastrar()
    {
        //INSERE A INSTÂNCIA NO BANCO
        $this->id = (new Database('users'))->insert([
            'username' => $this->username,
            'email' => $this->email,
            'password' => $this->password
        ]);

        //SUCESSO
        return true;
    }

    /**
     * atualizar
     * Método responsável por atualizar os dados do banco
     *
     * @return boolean
     */
    public function atualizar()
    {
        return (new Database('users'))->update('id = ' . $this->id, [
            'username' => $this->username,
            'email' => $this->email,
            'password' => $this->password
        ]);
    }

    /**
     * excluir
     * Método responsável por excluir os dados do banco
     *
     * @return boolean
     */
    public function excluir()
    {
        return (new Database('users'))->delete('id = ' . $this->id);
    }

    /**
     * getUserById
     * Método responsável por retornar uma instência com base no ID
     *
     * @param int $id
     * @return User
     */
    public static function getUserById($id)
    {
        return self::getUsers('id = ' . $id)->fetchObject(self::class);
    }



    /**
     * getUserByEmail
     * Método responsável por retornar um usuário com base em seu e-mail
     *
     * @param  string $email
     * @return User
     */
    public static function getUserByEmail($email)
    {
        return self::getUsers('email = "' . $email . '"')->fetchObject(self::class);
    }

    /**
     * getUsers
     * Método responsável por retornar usuários
     *
     * @param  string $where
     * @param  string $order
     * @param  string $limit
     * @param  string $fields
     * @return PDOStatement
     */
    public static function getUsers($where = null, $order = null, $limit = null, $fields = '*')
    {
        return (new Database('users'))->select($where, $order, $limit, $fields);
    }
}
