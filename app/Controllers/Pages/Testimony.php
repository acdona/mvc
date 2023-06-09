<?php

declare(strict_types=1);

namespace App\Controllers\Pages;

use \App\Core\View;
use \App\Models\Entity\Testimony as EntityTestimony;

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
     * @return string
     */
    private static function getTestimonyItems()
    {
        //DEPOIMENTOS
        $itens = '';

        //RESULTADOS DA PÁGINA
        $results = EntityTestimony::getTestimonies(null, 'id DESC');

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
     * @return string
     */
    public static function getTestimonies()
    {
        // VIEW DE DEPOIMENTOS
        $content = View::render('pages/testimonies', [
            'itens' => self::getTestimonyItems()
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

        return self::getTestimonies();        
    }
}
