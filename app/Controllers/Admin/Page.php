<?php

declare(strict_types=1);

namespace App\Controllers\Admin;

use App\Core\View;

class Page
{

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
        //RETORNA A PÁGINA RENDERIZADA
        return self::getPage($title, $content);
    }
}
