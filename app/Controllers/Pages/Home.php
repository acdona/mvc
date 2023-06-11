<?php

declare(strict_types=1);

namespace App\Controllers\Pages;

use \App\Core\View;
use \App\Models\Entity\Organization;

/**
 * ACD || Home Class Controller
 * Classe responsável pela controller da página home
 * Class responsible for controlling the homepage
 * 
 * @author Antonio Carlos Doná <contato@antoniocarlosdona.com.br>
 * @package App\Controllers\Pages
 */
class Home extends Page
{
    /**
     * getHome 
     * Método responsável por retornar o conteúdo (view) da nossa homepage
     * Method responsible for returning the content (view) of our homepage
     *
     * @return string
     */
    public static function getHome()
    {
        // Organização
        $obOrganization = new Organization;

        // VIEW DA HOME
        $content = View::render('pages/home', [
            'name'        => $obOrganization->getName()
        ]);

        // Retorna a VIEW da página
        return parent::getPage('HOME > ACD WEBDEV', $content);
    }
}
