<?php

declare(strict_types=1);

namespace App\Controllers\Pages;

use \App\Core\View;

/**
 * ACD || Page Class Controller
 * Classe responsável pela controller a page
 * Class responsible for controlling the page
 * 
 * @author Antonio Carlos Doná <contato@antoniocarlosdona.com.br>
 * @package App\Controllers\Pages
 */
class Page
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

        //PÁGINA ATUAL
        $currentPage = $queryParams['page'] ?? 1;

        //LIMITE DE PÁGINAS
        $limit = getenv('PAGINATION_LIMIT');

        //MEIO DA PAGINAÇÃO
        $middle = ceil($limit / 2);

        //INÍCIO DA PAGINAÇÃO
        $start = $middle > $currentPage ? 0 : $currentPage - $middle;

        //AJUSTA O FINAL DA PAGINAÇÃO
        $limit = $limit + $start;

        //AJUSTA O INÍCIO DA PAGINAÇÃO
        if ($limit > count($pages)) {
            $diff = $limit - count($pages);
            $start = $start - $diff;
        }

        //LINK INICIAL
        if($start >0){
            $links .= self::getPaginationLink($queryParams, reset($pages), $url, '<<');
        }


        //RENDERIZA OS LINKS
        foreach ($pages as $page) {
            //VERIFICA O START DA PAGINAÇÃO
            if ($page['page'] <= $start) continue;

            //VERIFICA LIMITE DE PAGINAÇÃO
            if ($page['page'] > $limit) {
                $links .= self::getPaginationLink($queryParams, end($pages), $url, '>>');
                break;
            }

            $links .= self::getPaginationLink($queryParams, $page, $url);
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
     * getPaginationLink
     * Método responsável por retornar um link da paginação
     *
     * @param  array $queryParansm
     * @param  array $page
     * @param  string $url
     * @return void
     */
    public static function getPaginationLink($queryParams, $page, $url, $label = null)
    {
        //ALTERA A PÁGINA
        $queryParams['page'] = $page['page'];

        //LINK
        $link = $url . '?' . http_build_query($queryParams);

        //VIEW
        return View::render('pages/pagination/link', [
            'page' => $label ?? $page['page'],
            'link' => $link,
            'active' => ($page['current'] ? 'active' : '')
        ]);
    }

    /**
     * getPage 
     * Método responsável por retornar o conteúdo (view) da nossa page
     * Method responsible for returning the content (view) of our page
     *
     * @return string
     */
    public static function getPage($title, $content)
    {

        return View::render('pages/page', [
            'title' => $title,
            'header' => self::getHeader(),
            'content' => $content,
            'footer' => self::getFooter()

        ]);
    }
}
