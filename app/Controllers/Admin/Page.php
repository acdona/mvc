<?php

declare(strict_types=1);

namespace App\Controllers\Admin;

use App\Core\View;

class Page
{

    /**
     * modules
     * Módulos disponíveis no painel
     * 
     * @var array
     */
    private static $modules = [
        'home' => [
            'label' => 'Home',
            'link' => URL . '/admin'
        ],
        'testimonies' => [
            'label' => 'Depoimentos',
            'link' => URL . '/admin/testimonies'
        ],
        'users' => [
            'label' => 'Usuários',
            'link' => URL . '/admin/users'
        ]
    ];

    /**
     * getPage
     * Método responsável por retornar o conteúdo da estrutura genérica de página do painel
     *
     * @param  string $title
     * @param  string $content
     * @return string
     */
    public static function getPage($title, $content)
    {
        return View::render('admin/page', [
            'title' => $title,
            'content' => $content
        ]);
    }

    /**
     * getMenu
     * Método responsável por renderizar a view do menu do painel
     *
     * @param  string $currentModule
     * @return string
     */
    private static function getMenu($currentModule)
    {

        //LINKS DO MENU
        $links = '';

        //ITERA OS MÓDULOS
        foreach (self::$modules as $hash => $module) {
            $links .= View::render('admin/menu/link', [
                'label' => $module['label'],
                'link' => $module['link'],
                'current' => $hash == $currentModule ? 'text-success' : ''
            ]);
        }


        //RETORNA A RENDERIZAÇÃO DO MENU
        return View::render('admin/menu/box', [
            'links' => $links
        ]);
    }

    /**
     * getPanel
     * Método responsável por renderizar a view do Painel com conteúdos dinâmicos
     *
     * @param  string $title
     * @param  string $content
     * @param  string $currentModule
     * @return string
     */
    public static function getPanel($title, $content, $currentModule)
    {
        //RENDERIZA A VIEW DO PAINEL
        $contentPanel = View::render('admin/panel', [
            'menu' => self::getMenu($currentModule),
            'content' => $content
        ]);

        //RETORNA A PÁGINA RENDERIZADA
        return self::getPage($title, $contentPanel);
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
            $links .= View::render('admin/pagination/link', [
                'page' => $page['page'],
                'link' => $link,
                'active' => ($page['current'] ? 'active' : '')
            ]);
        }

        //RENDERIZA BOX DE PAGINAÇÃO
        return View::render('admin/pagination/box', [
            'links' => $links
        ]);
    }
}
