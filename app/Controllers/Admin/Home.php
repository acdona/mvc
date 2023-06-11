<?php

declare(strict_types=1);

namespace App\Controllers\Admin;

use app\Core\View;

class Home extends Page
{

    /**
     * getHome
     * Método responsável por renderizar a view de Home do painel
     *
     * @param  Request $request
     * @return string
     */
    public static function getHome($request)
    {
        //CONTEÚDO DA HOME
        $content = View::render('admin/modules/home/index', []);

        //RETORNA A PÁGINA COMPLETA
        return parent::getPanel('Home - ACD WEB DEV', $content, 'home');
    }
}
