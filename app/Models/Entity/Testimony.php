<?php

declare(strict_types=1);

namespace App\Models\Entity;

use \WilliamCosta\DatabaseManager\Database;

/**
 * ACD || Testimony . Responsible for  Testimony page
 *
 */
class Testimony
{
    
    /**
     * id
     * ID do depoimento
     *
     * @var int
     */
    public $id;
    
    /**
     * username
     * Nome do usuário que fez o depoimento
     *
     * @var string
     */
    public $username;

    
    /**
     * message
     * Mensagem do depoimento
     *
     * @var string
     */
    public $message;
    
    /**
     * date
     * Data de publicação do depoimento
     *
     * @var string
     */
    public $date;
    
    /**
     * cadastrar
     * Método responsável por cadastrar a instância atual no banco de dados
     *
     * @return boolean
     */
    public function cadastrar() {
        //DEFINE A DATA
        $this->date = date('Y-m-d H:i:s');

        //INSERE DEPOIMENTO NO BANCO DE DADOS
        $this->id = (new Database('testimonies'))->insert([
            'username' => $this->username,
            'message' => $this->message,
            'date' => $this->date
        ]);
        
        //SUCESSO
        return true;
    }
    
    /**
     * getTestimonies
     * Método responsável por retornar depoimentos
     *
     * @param  string $where
     * @param  string $order
     * @param  string $limit
     * @param  string $fields
     * @return PDOStatement
     */
    public static function getTestimonies($where = null, $order = null, $limit = null, $fields = '*')
    {
        return (new Database('testimonies'))->select($where, $order, $limit, $fields);
        
    }
}
