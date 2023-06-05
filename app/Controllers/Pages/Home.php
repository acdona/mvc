<?php

declare(strict_types=1);

namespace App\Controllers\Pages;

use \App\Core\View;

/**
 * ACD || Home Class Controller
 * Classe responsável pela controller da página home
 * Class responsible for controlling the homepage
 * 
 * @author Antonio Carlos Doná <contato@antoniocarlosdona.com.br>
 * @package App\Controllers\Pages
 */
class Home
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
        
        return View::render('pages/home', [
            'name' => 'ACD WEB',
            'description' => 'https:/antoniocarlosdona.com.br'

        ]);
    }
}
