<?php

declare(strict_types=1);

namespace App\Controllers\Pages;

use \App\Core\View;
use \App\Models\Entity\Testimony as EntityTestimony;
use \WilliamCosta\DatabaseManager\Pagination;

/**
 * ACD || Testimony Class Controller
 * Classe responsável pela controller da página de depoimentos
 * Class responsible for controlling the testimony page
 * 
 * @author Antonio Carlos Doná <contato@antoniocarlosdona.com.br>
 * @package App\Controllers\Pages
 */
class Testimony extends Template
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
        $obPagination = new Pagination($totalAmount, $currentPage, 3);

        //RESULTADOS DA PÁGINA
        $results = EntityTestimony::getTestimonies(null, 'id DESC', $obPagination->getLimit());

        //RENDERIZA O ITEM
        while($obTestimony = $results->fetchObject(EntityTestimony::class)){
               // VIEW DE DEPOIMENTOS
               $itens .= View::render('pages/testimony/item', [
                'username' => $obTestimony->username,
                'message'  => $obTestimony->message,
                'date'     => date('d/m/Y H:i:s', strtotime($obTestimony->date))
            ]);
        }

        //RETORNA OS DEPOIMENTOS
        return $itens;

    }

    /**
     * getTestimonies 
     * Método responsável por retornar o conteúdo (view) de depoimentos
     * Method responsible for returning the content (view) of testimonials
     *
     * @param Request $request
     * @return string
     */
    public static function getTestimonies($request)
    {
        // VIEW DE DEPOIMENTOS
        $content = View::render('pages/testimonies', [
            'itens' => self::getTestimonyItems($request, $obPagination),
            'pagination' => parent::getPagination($request, $obPagination)
        ]);

        // Retorna a VIEW da página
        return parent::getTemplate('DEPOIMENTOS > ACD WEBDEV', $content);
    }
    
    /**
     * insertTestimony
     * Método responsável por cadastrar um depoimento
     *
     * @param  Request $request
     * @return string
     */
    public static function insertTestimony($request)
    {
        //DADOS DO POST
        $postVars = $request->getPostVars();


        //NOVA INSTÂNCIA DE DEPOIMENTO
        $obTestimony = new EntityTestimony;
        $obTestimony->username = $postVars['username'];
        $obTestimony->message = $postVars['message'];
        $obTestimony->cadastrar();

        //RETORNA A PÁGINA DE LISTAGEM DE DEPOIMENTOS
        return self::getTestimonies($request);        
    }
}
