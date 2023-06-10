<?php

declare(strict_types=1);

namespace App\Controllers\Pages;

use \App\Core\View;

/**
 * ACD || Template Class Controller
 * Classe responsável pela controller a template
 * Class responsible for controlling the template
 * 
 * @author Antonio Carlos Doná <contato@antoniocarlosdona.com.br>
 * @package App\Controllers\Pages
 */
class Template
{
    /**
     * getHeader
     * Método responsável por renderizar o topo da página
     * Method responsible for rendering the page footer 
     *
     * @return string
     */
    private static function getHeader()
    {
        return View::render('pages/header');
    }

    /**
     * getPagination
     * Método responsável por renderizar o layout de páginação
     *
     * @param  Reques $request
     * @param  Pagination $obPagination
     * @return string
     */
    public static function getPagination($request, $obPagination)
    {
        //PÁGINAS
        $pages = $obPagination->getPages();

        // VERIFICA A QUANTIDADE DE PÁGINAS
        if (count($pages) <= 1) return '';

        //LINKS
        $links = '';

        //URL ATUAL (SEM GETS)
        $url = $request->getRouter()->getCurrentUrl();

        //GET
        $queryParams = $request->getQueryParams();

        //RENDERIZA OS LINKS
        foreach ($pages as $page) {
            //ALTERA A PÁGINA
            $queryParams['page'] = $page['page'];

            //LINK
            $link = $url . '?' . http_build_query($queryParams);

            //VIEW
            $links .= View::render('pages/pagination/link', [
                'page' => $page['page'],
                'link' => $link,
                'active' => ($page['current'] ? 'active' : '')
            ]);
        }

        //RENDERIZA BOX DE PAGINAÇÃO
        return View::render('pages/pagination/box', [
            'links' => $links
        ]);
    }   

    /**
     * getFooter
     * Método responsável por renderizar o rodapé da página
     * Method responsible for rendering the top of the page 
     *
     * @return string
     */
    private static function getFooter()
    {
        return View::render('pages/footer');
    }


    /**
     * getTemplate 
     * Método responsável por retornar o conteúdo (view) da nossa template
     * Method responsible for returning the content (view) of our template
     *
     * @return string
     */
    public static function getTemplate($title, $content)
    {

        return View::render('pages/_template', [
            'title' => $title,
            'header' => self::getHeader(),
            'content' => $content,
            'footer' => self::getFooter()

        ]);
    }
}
