<?php

declare(strict_types=1);

namespace App\Controllers\Admin;

use \App\Core\View;
use \App\Models\Entity\User as EntityUser;
use \WilliamCosta\DatabaseManager\Pagination;

class User extends Page
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
        $itens = '';

        //QUANTIDADE TOTAL DE REGISTROS
        $totalAmount = EntityUser::getUsers(null, null, null, 'COUNT(*) as qtd')->fetchObject()->qtd;

        //PAGINA ATUAL
        $queryParams = $request->getQueryParams();
        $currentPage = $queryParams['page'] ?? 1;

        //INSTÂNCIA DE PAGINAÇÃO
        $obPagination = new Pagination($totalAmount, $currentPage, 5);


        //RESULTADOS DA PÁGINA
        $results = EntityUser::getUsers(null, 'id DESC', $obPagination->getLimit());

        //RENDERIZA O ITEM
        while ($obUser = $results->fetchObject(EntityUser::class)) {
            // VIEW DE USUÁRIOS
            $itens .= View::render('admin/modules/users/item', [
                'id' => $obUser->id,
                'username'  => $obUser->username,
                'email'  => $obUser->email
            ]);
        }

        //RETORNA OS USUÁRIOS
        return $itens;
    }

    /**
     * getuSERS
     * Método responsável por renderizar a view de listagem de usuários
     *
     * @param  Request $request
     * @return string
     */
    public static function getUsers($request)
    {
        //CONTEÚDO DO USUÁRIO
        $content = View::render('admin/modules/users/index', [
            'itens' => self::getUserItems($request, $obPagination),
            'pagination' => parent::getPagination($request, $obPagination),
            'status' => self::getStatus($request)
        ]);

        //RETORNA A PÁGINA COMPLETA
        return parent::getPanel('Usuários - ACD WEB DEV', $content, 'users');
    }

    /**
     * getNewUser
     * Método responsável por retornar o formulário de cadastro de um novo usuário
     *
     * @param  Request $request
     * @return string
     */
    public static function getNewUser($request)
    {
        //CONTEÚDO DO FORMULÁRIO
        $content = View::render('admin/modules/users/form', [
            'title' => 'Cadastrar usuário',
            'username' => '',
            'email' => '',
            'status' => self::getStatus($request)
        ]);

        //RETORNA A PÁGINA COMPLETA
        return parent::getPanel('Cadastrar Usuário - ACD WEB DEV', $content, 'users');
    }

    /**
     * setNewUser
     * Método responsável por cadastrar um novo usuário
     *
     * @param  Request $request
     * @return string
     */
    public static function setNewUser($request)
    {
        //POST VARS
        $postVars = $request->getPostVars();
        $username = $postVars['username'] ?? '';
        $email = $postVars['email'] ?? '';
        $password = $postVars['password'] ?? '';

        //VALIDA O EMAIL DO USUÁRIO
        $obUser = EntityUser::getUserByEmail($email);
        if ($obUser instanceof EntityUser) {
            //REDIRECIONA O USUÁRIO
            $request->getRouter()->redirect('/admin/users/new?status=duplicated');
        }


        //NOVA INSTANCIA DE USUÁRIO
        $obUser = new EntityUser;
        $obUser->username = $username;
        $obUser->email = $email;
        $obUser->password = password_hash($password, PASSWORD_DEFAULT);
        $obUser->cadastrar();

        //REDIRECIONA O USUÁRIO
        $request->getRouter()->redirect('/admin/users/' . $obUser->id . '/edit?status=created');
    }

    /**
     * getStatus
     * Método responsável por retornar a mensagem de status
     *
     * @param  Request $request
     * @return string
     */
    private static function getStatus($request)
    {
        //QUERY PARAMS
        $queryParams = $request->getQueryParams();

        //STATUS
        if (!isset($queryParams['status'])) return '';

        //MENSAGENS DE STATUS
        switch ($queryParams['status']) {
            case 'created':
                return Alert::getSuccess('Usuário criado com sucesso!');
                break;
            case 'updated':
                return Alert::getSuccess('Usuário atualizado com sucesso!');
                break;
            case 'deleted':
                return Alert::getSuccess('Usuário excluido com sucesso!');
                break;
            case 'duplicated':
                return Alert::getError('O e-mail digitado já está sendo utilizado por outro usuário!');
                break;
        }
    }

    /**
     * getEditUser
     * Método responsável por retornar o formulário de edição de um usuário
     *
     * @param Request $request
     * @param int $id
     * @return string
     */
    public static function getEditUser($request, $id)
    {
        //OBTEM O USUÁRIO DO BANCO DE DADOS
        $obUser = EntityUser::getUserById($id);

        //VALIDA A INSTANCIA
        if (!$obUser instanceof EntityUser) {
            $request->getRouter()->redirect('/admin/users');
        }

        //CONTEÚDO DO FORMULÁRIO
        $content = View::render('admin/modules/users/form', [
            'title' => 'Editar usuário',
            'username' => $obUser->username,
            'email' => $obUser->email,
            'status' => self::getStatus($request)
        ]);

        //RETORNA A PÁGINA COMPLETA
        return parent::getPanel('Editar Usuário - ACD WEB DEV', $content, 'users');
    }

    /**
     * setEditUser
     * Método responsável por gravar a atualização de um usuário
     *
     * @param Request $request
     * @param int $id
     * @return string
     */
    public static function setEditUser($request, $id)
    {
        //OBTEM O USUÁRIO DO BANCO DE DADOS
        $obUser = EntityUser::getUserById($id);

        //VALIDA A INSTANCIA
        if (!$obUser instanceof EntityUser) {
            $request->getRouter()->redirect('/admin/users');
        }

        //POST VARS
        $postVars = $request->getPostVars();
        $username = $postVars['username'] ?? '';
        $email = $postVars['email'] ?? '';
        $password = $postVars['password'] ?? '';

        //VALIDA O EMAIL DO USUÁRIO
        $obUserEmail = EntityUser::getUserByEmail($email);
        if ($obUserEmail instanceof EntityUser && $obUserEmail->id != $id) {
            //REDIRECIONA O USUÁRIO
            $request->getRouter()->redirect('/admin/users/' . $id . '/edit?status=duplicated');
        }

        //ATUALIZA A INSTANCIA
        $obUser->username = $username;
        $obUser->email = $email;
        $obUser->password = password_hash($password, PASSWORD_DEFAULT);
        $obUser->atualizar();

        //REDIRECIONA O USUÁRIO
        $request->getRouter()->redirect('/admin/users/' . $obUser->id . '/edit?status=updated');
    }

    /**
     * getDeleteUser
     * Método responsável por retornar o formulário de exclusão de um usuário
     *
     * @param Request $request
     * @param int $id
     * @return string
     */
    public static function getDeleteUser($request, $id)
    {
        //OBTEM O USUÁRIO DO BANCO DE DADOS
        $obUser = EntityUser::getUserById($id);

        //VALIDA A INSTANCIA
        if (!$obUser instanceof EntityUser) {
            $request->getRouter()->redirect('/admin/users');
        }

        //CONTEÚDO DO FORMULÁRIO
        $content = View::render('admin/modules/users/delete', [
            'username' => $obUser->username,
            'email' => $obUser->email
        ]);

        //RETORNA A PÁGINA COMPLETA
        return parent::getPanel('Excluir Usuário - ACD WEB DEV', $content, 'users');
    }

    /**
     * setDeleteUser
     * Método responsável por excluir um usuário
     *
     * @param Request $request
     * @param int $id
     * @return string
     */
    public static function setDeleteUser($request, $id)
    {
        //OBTEM O USUÁRIO DO BANCO DE DADOS
        $obUser = EntityUser::getUserById($id);

        //VALIDA A INSTANCIA
        if (!$obUser instanceof EntityUser) {
            $request->getRouter()->redirect('/admin/users');
        }

        //EXCLUI O USUÁRIO
        $obUser->excluir();

        //REDIRECIONA O USUÁRIO
        $request->getRouter()->redirect('/admin/users?status=deleted');
    }
}
