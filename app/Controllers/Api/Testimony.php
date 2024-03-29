<?php

declare(strict_types=1);

namespace App\Controllers\Api;

use \App\Models\Entity\Testimony as EntityTestimony;
use \App\Core\Pagination;

class Testimony extends Api
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
        $itens = [];

        //QUANTIDADE TOTAL DE REGISTROS
        $totalAmount = EntityTestimony::getTestimonies(null, null, null, 'COUNT(*) as qtd')->fetchObject()->qtd;

        //PAGINA ATUAL
        $queryParams = $request->getQueryParams();
        $currentPage = $queryParams['page'] ?? 1;

        //INSTÂNCIA DE PAGINAÇÃO
        $obPagination = new Pagination($totalAmount, $currentPage, 3);


        //RESULTADOS DA PÁGINA
        $results = EntityTestimony::getTestimonies(null, 'id DESC', $obPagination->getLimit());

        //RENDERIZA O ITEM
        while ($obTestimony = $results->fetchObject(EntityTestimony::class)) {
            // VIEW DE DEPOIMENTOS
            $itens[] = [
                'id' => (int)$obTestimony->id,
                'username'  => $obTestimony->username,
                'message'  => $obTestimony->message,
                'date'     => $obTestimony->date
            ];
        }

        //RETORNA OS DEPOIMENTOS
        return $itens;
    }

    /**
     * getDetails
     * Método responsável por retornar os depoimentos cadastrados
     *
     * @param  Request $request
     * @return array
     */
    public static function getTestimonies($request)
    {
        return [
            'testimonies' => self::getTestimonyItems($request, $obPagination),
            'pagination' => parent::getPagination($request, $obPagination)
        ];
    }

    /**
     * getTestimony
     * Método responsável por retornar os detalhes de um depoimento
     *
     * @param  Request $request
     * @param  int $id
     * @return array
     */
    public static function getTestimony($request, $id)
    {
        //VALIDA O ID DO DEPOIMENTO
        if (!is_numeric($id)) {
            throw new \Exception("O id '" .  $id  . "'  não é válido", 400);
        }


        //BUSCA DEPOIMENTO
        $obTestimony = EntityTestimony::getTestimonyById(($id));


        //VALIDA SE O DEPOIMENTO EXISTE
        if (!$obTestimony instanceof EntityTestimony) {
            throw new \Exception("O depoimento " . $id . " não foi encontrado", 404);
        }
        //RETORNA OS DETALHES DO DEPOIMENTO
        return  [
            'id' => (int)$obTestimony->id,
            'username'  => $obTestimony->username,
            'message'  => $obTestimony->message,
            'date'     => $obTestimony->date
        ];
    }

    /**
     * setNewTestimony
     * Método responsável por cadastrar um novo depoimento
     *
     * @param  Request $request
     */
    public static function setNewTestimony($request)
    {
        $postVars = $request->getPostVars();

        //VALIDA OS CAMPOS OBRIGATÓRIOS
        if (!isset($postVars['username']) || !isset($postVars['message'])) {
            throw new \Exception("Os campos 'nome' e 'mansagem' são obrigatórios", 400);
        }

        //NOVO DEPOIMENTO
        $obTestimony = new EntityTestimony;
        $obTestimony->username = $postVars['username'];
        $obTestimony->message = $postVars['message'];
        $obTestimony->cadastrar();

        //RETORNA OS DETALHES DO DEPOIMENTO CADASTRADO
        return [
            'id' => (int)$obTestimony->id,
            'username'  => $obTestimony->username,
            'message'  => $obTestimony->message,
            'date'     => $obTestimony->date
        ];
    }

    /**
     * setNewTestimony
     * Método responsável por atualizar um depoimento
     *
     * @param  Request $request
     */
    public static function setEditTestimony($request, $id)
    {
        $postVars = $request->getPostVars();

        //VALIDA OS CAMPOS OBRIGATÓRIOS
        if (!isset($postVars['username']) || !isset($postVars['message'])) {
            throw new \Exception("Os campos 'nome' e 'mansagem' são obrigatórios", 400);
        }

        //BUSCA O DEPOIMENTO NO BANCO
        $obTestimony = EntityTestimony::getTestimonyById($id);

        //VALIDA INSTANCIA
        if (!$obTestimony instanceof EntityTestimony) {
            throw new \Exception("O depoimento " . $id . " não foi encontrado", 404);
        }

        //ATUALIZAR DEPOIMENTO
        $obTestimony->username = $postVars['username'];
        $obTestimony->message = $postVars['message'];
        $obTestimony->atualizar();

        //RETORNA OS DETALHES DO DEPOIMENTO ATUALIZADO
        return [
            'id' => (int)$obTestimony->id,
            'username'  => $obTestimony->username,
            'message'  => $obTestimony->message,
            'date'     => $obTestimony->date
        ];
    }

    /**
     * setDeleteTestimony
     * Método responsável por excluir um depoimento
     *
     * @param  Request $request
     */
    public static function setDeleteTestimony($request, $id)
    {       
        //BUSCA O DEPOIMENTO NO BANCO
        $obTestimony = EntityTestimony::getTestimonyById($id);

        //VALIDA INSTANCIA
        if (!$obTestimony instanceof EntityTestimony) {
            throw new \Exception("O depoimento " . $id . " não foi encontrado", 404);
        }

        //EXCLUIR DEPOIMENTO
        $obTestimony->excluir();

        //RETORNA O SUCESSO DA EXCLUSÃO
        return [
            'sucesso' => true
        ];
    }
}
