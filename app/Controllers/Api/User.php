<?php

declare(strict_types=1);

namespace App\Controllers\Api;

use \App\Models\Entity\User as EntityUser;
use \WilliamCosta\DatabaseManager\Pagination;

class User extends Api
{
    /**
     * getUserItems
     * Método responsável por obter a renderização dos itens de usuários para a página
     * 
     * @param Request $request
     * @param Pagination $obPagination
     * @return string
     */
    private static function getUserItems($request, &$obPagination)
    {
        //USUÁRIOS
        $itens = [];

        //QUANTIDADE TOTAL DE REGISTROS
        $totalAmount = EntityUser::getUsers(null, null, null, 'COUNT(*) as qtd')->fetchObject()->qtd;

        //PAGINA ATUAL
        $queryParams = $request->getQueryParams();
        $currentPage = $queryParams['page'] ?? 1;

        //INSTÂNCIA DE PAGINAÇÃO
        $obPagination = new Pagination($totalAmount, $currentPage, 3);


        //RESULTADOS DA PÁGINA
        $results = EntityUser::getUsers(null, 'id DESC', $obPagination->getLimit());

        //RENDERIZA O ITEM
        while ($obUser = $results->fetchObject(EntityUser::class)) {

            // VIEW DE USUÁRIOS
            $itens[] = [
                'id' => (int)$obUser->id,
                'username'  => $obUser->username,
                'email'  => $obUser->email
            ];
        }

        //RETORNA OS USUÁRIOS
        return $itens;
    }

    /**
     * getDetails
     * Método responsável por retornar os usuários cadastrados
     *
     * @param  Request $request
     * @return array
     */
    public static function getUsers($request)
    {
        return [
            'users' => self::getUserItems($request, $obPagination),
            'pagination' => parent::getPagination($request, $obPagination)
        ];
    }

    /**
     * getUser
     * Método responsável por retornar os detalhes de um usuário
     *
     * @param  Request $request
     * @param  int $id
     * @return array
     */
    public static function getUser($request, $id)
    {
        //VALIDA O ID DO USUÁRIO
        if (!is_numeric($id)) {
            throw new \Exception("O id '" .  $id  . "'  não é válido", 400);
        }


        //BUSCA USUÁRIO
        $obUser = EntityUser::getUserById(($id));


        //VALIDA SE O USUÁRIO EXISTE
        if (!$obUser instanceof EntityUser) {
            throw new \Exception("O usuário " . $id . " não foi encontrado", 404);
        }
        //RETORNA OS DETALHES DO USUÁRIO
        return  [
            'id' => (int)$obUser->id,
            'username'  => $obUser->username,
            'email'  => $obUser->email
        ];
    }

    /**
     * setNewUser
     * Método responsável por cadastrar um novo usuário
     *
     * @param  Request $request
     */
    public static function setNewUser($request)
    {
        //POSTVARS
        $postVars = $request->getPostVars();

        //VALIDA OS CAMPOS OBRIGATÓRIOS
        if (!isset($postVars['username']) || !isset($postVars['email']) || !isset($postVars['password'])) {
            throw new \Exception("Os campos 'nome', 'email' e 'senha' são obrigatórios", 400);
        }

        //VALIDA A DUPLICAÇÃO DE USUÁRIOS
        $obUserEmail = EntityUser::getUserByEmail($postVars['email']);
        if ($obUserEmail instanceof EntityUser){
            throw new \Exception("O e-mail '" . $postVars['email'] . "' já está em uso.", 400);
        }

        //NOVO USUÁRIO
        $obUser = new EntityUser;
        $obUser->username = $postVars['username'];
        $obUser->email = $postVars['email'];
        $obUser->password = password_hash($postVars['password'], PASSWORD_DEFAULT);        
        $obUser->cadastrar();

        //RETORNA OS DETALHES DO USUÁRIO CADASTRADO
        return [
            'id' => (int)$obUser->id,
            'username'  => $obUser->username,
            'email'  => $obUser->email
            
        ];
    }

    /**
     * setNewUser
     * Método responsável por atualizar um usuário
     *
     * @param  Request $request
     */
    public static function setEditUser($request, $id)
    {
        //POSTVARS
        $postVars = $request->getPostVars();

        //VALIDA OS CAMPOS OBRIGATÓRIOS
        if (!isset($postVars['username']) || !isset($postVars['email']) || !isset($postVars['password'])) {
            throw new \Exception("Os campos 'nome', 'email' e 'senha' são obrigatórios", 400);
        }

        //BUSCA O USUÁRIO NO BANCO
        $obUser = EntityUser::getUserById($id);
        
        //VALIDA SE O USUÁRIO EXISTE
        if (!$obUser instanceof EntityUser) {
            throw new \Exception("O usuário " . $id . " não foi encontrado", 404);
        }

        //VALIDA A DUPLICAÇÃO DE USUÁRIOS
        $obUserEmail = EntityUser::getUserByEmail($postVars['email']);
        if ($obUserEmail instanceof EntityUser && $obUserEmail->id != $obUser->id){
            throw new \Exception("O e-mail '" . $postVars['email'] . "' já está em uso.", 400);
        }

        //ATUALIZAR USUÁRIO
        $obUser->username = $postVars['username'];
        $obUser->email = $postVars['email'];
        $obUser->password = password_hash($postVars['password'], PASSWORD_DEFAULT);
        $obUser->atualizar();

        //RETORNA OS DETALHES DO USUÁRIO ATUALIZADO
        return [
            'id' => (int)$obUser->id,
            'username'  => $obUser->username,
            'email'  => $obUser->email
        ];
    }

    /**
     * setDeleteUser
     * Método responsável por excluir um usuário
     *
     * @param  Request $request
     */
    public static function setDeleteUser($request, $id)
    {
        //BUSCA O USUÁRIO NO BANCO
        $obUser = EntityUser::getUserById($id);

        //VALIDA SE USUÁRIO EXISTE
        if (!$obUser instanceof EntityUser) {
            throw new \Exception("O usuário " . $id . " não foi encontrado", 404);
        }

        //IMPEDE A EXCLUSÃO DO PRÓPRIO CADASTRO
        if($obUser->id == $request->user->id) {
            throw new \Exception ("Não é possível excluir o cadastro atualmente conectado", 400);
        }

        //EXCLUIR USUÁRIO
        $obUser->excluir();

        //RETORNA O SUCESSO DA EXCLUSÃO
        return [
            'sucesso' => true
        ];
    }
}
