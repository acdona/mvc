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
        $obPagination = new Pagination($totalAmount, $currentPage, 5);


        //RESULTADOS DA PÁGINA
        $results = EntityTestimony::getTestimonies(null, 'id DESC', $obPagination->getLimit());

        //RENDERIZA O ITEM
        while ($obTestimony = $results->fetchObject(EntityTestimony::class)) {
            // VIEW DE DEPOIMENTOS
            $itens .= View::render('admin/modules/testimonies/item', [
                'id' => $obTestimony->id,
                'nome'  => $obTestimony->username,
                'mensagem'  => $obTestimony->message,
                'data'     => date('d/m/Y H:i:s', strtotime($obTestimony->date))
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
            'itens' => self::getTestimonyItems($request, $obPagination)
        ]);

        //RETORNA A PÁGINA COMPLETA
        return parent::getPanel('Depoimentos - ACD WEB DEV', $content, 'testimonies');
    }
}
