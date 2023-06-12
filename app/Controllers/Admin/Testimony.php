<?php

declare(strict_types=1);

namespace App\Controllers\Admin;

use \App\Core\View;
use \App\Models\Entity\Testimony as EntityTestimony;
use \WilliamCosta\DatabaseManager\Pagination;

class Testimony extends Page
{
    /**
     * getTestimonyItems
     * Método responsável por obter a renderização dos itens de depoimentos para a página
     * 
     * @param Request $request
     * @param Pagination $obPagination
     * @return string
     */
    private static function getTestimonyItems($request, &$obPagination)
    {
        //DEPOIMENTOS
        $itens = '';

        //QUANTIDADE TOTAL DE REGISTROS
        $totalAmount = EntityTestimony::getTestimonies(null, null, null, 'COUNT(*) as qtd')->fetchObject()->qtd;

        //PAGINA ATUAL
        $queryParams = $request->getQueryParams();
        $currentPage = $queryParams['page'] ?? 1;

        //INSTÂNCIA DE PAGINAÇÃO
        $obPagination = new Pagination($totalAmount, $currentPage, 10);


        //RESULTADOS DA PÁGINA
        $results = EntityTestimony::getTestimonies(null, 'id DESC', $obPagination->getLimit());

        //RENDERIZA O ITEM
        while ($obTestimony = $results->fetchObject(EntityTestimony::class)) {
            // VIEW DE DEPOIMENTOS
            $itens .= View::render('admin/modules/testimonies/item', [
                'id' => $obTestimony->id,
                'username'  => $obTestimony->username,
                'message'  => $obTestimony->message,
                'date'     => date('d/m/Y H:i:s', strtotime($obTestimony->date))
            ]);
        }

        //RETORNA OS DEPOIMENTOS
        return $itens;
    }

    /**
     * getTestemony
     * Método responsável por renderizar a view de listagem de depoimentos
     *
     * @param  Request $request
     * @return string
     */
    public static function getTestimonies($request)
    {
        //CONTEÚDO DA Testemony
        $content = View::render('admin/modules/testimonies/index', [
            'itens' => self::getTestimonyItems($request, $obPagination),
            'pagination' => parent::getPagination($request, $obPagination),
            'status' => self::getStatus($request)
        ]);

        //RETORNA A PÁGINA COMPLETA
        return parent::getPanel('Depoimentos - ACD WEB DEV', $content, 'testimonies');
    }

    /**
     * getNewTestimony
     * Método responsável por retornar o formulário de cadastro de um novo depoimento
     *
     * @param  Request $request
     * @return string
     */
    public static function getNewTestimony($request)
    {
        //CONTEÚDO DO FORMULÁRIO
        $content = View::render('admin/modules/testimonies/form', [
            'title' => 'Cadastrar depoimento',
            'username' => '',
            'message' => '',
            'status' => ''
        ]);

        //RETORNA A PÁGINA COMPLETA
        return parent::getPanel('Cadastrar Depoimento - ACD WEB DEV', $content, 'testimonies');
    }

    /**
     * setNewTestimony
     * Método responsável por cadastrar um novo depoimento
     *
     * @param  Request $request
     * @return string
     */
    public static function setNewTestimony($request)
    {
        //POST VARS
        $postVars = $request->getPostVars();

        //NOVA INSTANCIA DE DEPOIMENTO
        $obTestimony = new EntityTestimony;
        $obTestimony->username = $postVars['username'] ?? '';
        $obTestimony->message = $postVars['message'] ?? '';
        $obTestimony->cadastrar();

        //REDIRECIONA O USUÁRIO
        $request->getRouter()->redirect('/admin/testimonies/' . $obTestimony->id . '/edit?status=created');
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
        if(!isset($queryParams['status'])) return '';

        //MENSAGENS DE STATUS
        switch ($queryParams['status']) {
            case 'created':
                return Alert::getSuccess('Depoimento criado com sucesso!');
                break;
            case 'updated':
                return Alert::getSuccess('Depoimento atualizado com sucesso!');
                break;
            case 'deleted':
                return Alert::getSuccess('Depoimento excluido com sucesso!');
                break;
    }
    }

    /**
     * getEditTestimony
     * Método responsável por retornar o formulário de edição de um depoimento
     *
     * @param Request $request
     * @param int $id
     * @return string
     */
    public static function getEditTestimony($request, $id)
    {
        //OBTEM O DEPOIMENTO DO BANCO DE DADOS
        $obTestimony = EntityTestimony::getTestimonyById($id);

        //VALIDA A INSTANCIA
        if (!$obTestimony instanceof EntityTestimony) {
            $request->getRouter()->redirect('/admin/testimonies');
        }

        //CONTEÚDO DO FORMULÁRIO
        $content = View::render('admin/modules/testimonies/form', [
            'title' => 'Editar depoimento',
            'username' => $obTestimony->username,
            'message' => $obTestimony->message,
            'status' => self::getStatus($request)
        ]);

        //RETORNA A PÁGINA COMPLETA
        return parent::getPanel('Editar Depoimento - ACD WEB DEV', $content, 'testimonies');
    }

    /**
     * setEditTestimony
     * Método responsável por gravar a atualização de um depoimento
     *
     * @param Request $request
     * @param int $id
     * @return string
     */
    public static function setEditTestimony($request, $id)
    {
        //OBTEM O DEPOIMENTO DO BANCO DE DADOS
        $obTestimony = EntityTestimony::getTestimonyById($id);

        //VALIDA A INSTANCIA
        if (!$obTestimony instanceof EntityTestimony) {
            $request->getRouter()->redirect('/admin/testimonies');
        }

        //POST VARS
        $postVars = $request->getPostVars();

        //ATUALIZA A INSTANCIA
        $obTestimony->username = $postVars['username'] ?? $obTestimony->username;
        $obTestimony->message = $postVars['message'] ?? $obTestimony->message;
        $obTestimony->atualizar();

        //REDIRECIONA O USUÁRIO
        $request->getRouter()->redirect('/admin/testimonies/' . $obTestimony->id . '/edit?status=updated');
    }

    /**
     * getDeleteTestimony
     * Método responsável por retornar o formulário de exclusão de um depoimento
     *
     * @param Request $request
     * @param int $id
     * @return string
     */
    public static function getDeleteTestimony($request, $id)
    {
        //OBTEM O DEPOIMENTO DO BANCO DE DADOS
        $obTestimony = EntityTestimony::getTestimonyById($id);

        //VALIDA A INSTANCIA
        if (!$obTestimony instanceof EntityTestimony) {
            $request->getRouter()->redirect('/admin/testimonies');
        }

        //CONTEÚDO DO FORMULÁRIO
        $content = View::render('admin/modules/testimonies/delete', [
            'username' => $obTestimony->username,
            'message' => $obTestimony->message
        ]);

        //RETORNA A PÁGINA COMPLETA
        return parent::getPanel('Excluir Depoimento - ACD WEB DEV', $content, 'testimonies');
    }

    /**
     * setDeleteTestimony
     * Método responsável por excluir um depoimento
     *
     * @param Request $request
     * @param int $id
     * @return string
     */
    public static function setDeleteTestimony($request, $id)
    {
        //OBTEM O DEPOIMENTO DO BANCO DE DADOS
        $obTestimony = EntityTestimony::getTestimonyById($id);

        //VALIDA A INSTANCIA
        if (!$obTestimony instanceof EntityTestimony) {
            $request->getRouter()->redirect('/admin/testimonies');
        }

        //EXCLUI O DEPOIMENTO
        $obTestimony->excluir();

        //REDIRECIONA O USUÁRIO
        $request->getRouter()->redirect('/admin/testimonies?status=deleted');
    }
}
