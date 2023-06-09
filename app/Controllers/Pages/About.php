<?php

declare(strict_types=1);

namespace App\Controllers\Pages;

use \App\Core\View;
use \App\Models\Entity\Organization;

/**
 * ACD || About Class Controller
 * Classe responsável pela controller da página About
 * Class responsible for controlling the Aboutpage
 * 
 * @author Antonio Carlos Doná <contato@antoniocarlosdona.com.br>
 * @package App\Controllers\Pages
 */
class About extends Template
{
    /**
     * getAbout 
     * Método responsável por retornar o conteúdo (view) da nossa página sobre
     * Method responsible for returning the content (view) of our aboutpage
     *
     * @return string
     */
    public static function getAbout()
    {
        // Organização
        $obOrganization = new Organization;

        // VIEW DA ABOUT
        $content = View::render('pages/about', [
            'name'        => $obOrganization->getName(),
            'description' => $obOrganization->getDescription(),
            'site'        => $obOrganization->getSite(),
            'situation'   => $obOrganization->getSituation()
        ]);

        // Retorna a VIEW da página
        return parent::getTemplate('SOBRE - ACD-WEB', $content);
    }
}
