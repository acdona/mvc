<?php

declare(strict_types=1);

namespace App\Controllers\Pages;

use \App\Core\View;
use \App\Models\Entity\About;

/**
 * ACD || About Class Controller
 * Classe responsável pela controller da página sobre
 * Class responsible for controlling the about
 * 
 * @author Antonio Carlos Doná <contato@antoniocarlosdona.com.br>
 * @package App\Controllers\Pages
 */
class AboutUs extends Template
{
    /**
     * getAbout 
     * Método responsável por retornar o conteúdo (view) da página sobre
     * Method responsible for returning the content (view) of our about page
     *
     * @return string
     */
    public static function getAbout()
    {
        // Organização
        $obAbout = new About;

        // VIEW DA ABOUT
        $content = View::render('pages/about', [
            'name' => $obAbout->name,
            'description' => $obAbout->description,
            'site' => $obAbout->site,
        ]);

        // Retorna a VIEW da página
        return parent::getTemplate('ACD-WEB - ABOUT', $content);
    }
}
