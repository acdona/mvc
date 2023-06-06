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
            'title' => 'ACD WEB 2023',
            'header' => self::getHeader(),
            'footer' => self::getFooter(),
            'content' => $content

        ]);
    }
}
