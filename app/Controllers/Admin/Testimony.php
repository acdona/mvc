<?php

declare(strict_types=1);

namespace App\Controllers\Admin;

use app\Core\View;

class Testimony extends Page
{

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
        $content = View::render('admin/modules/testimonies/index', []);

        //RETORNA A PÁGINA COMPLETA
        return parent::getPanel('Depoimentos - ACD WEB DEV', $content, 'testimonies');
    }
}
