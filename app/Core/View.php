<?php

declare(strict_types=1);

namespace App\Core;

/**
 * ACD || View Class
 * Classe responsável pela renderização das Views
 * Class responsible for rendering Views
 * 
 * @author Antonio Carlos Doná <contato@antoniocarlosdona.com.br>
 * @package App\Core
 */
class View
{
    
    /**
     * getContentView
     * Método responsável por retornar o conteúdo de uma view
     * Method responsible for returning the content of a view
     *
     * @param  string $view
     * @return string
     */
    private static function getContentView($view)
    {
        $file = __DIR__ . '../../Views/' . $view . '.html';
        return file_exists($file) ? file_get_contents($file) : '';
    }
    
    /**
     * render
     * Método responsável por retornar o conteúdo renderizado de uma view
     * Method responsible for returning the rendered content of a view
     *
     * @param  string $view
     * @return string
     */
    public static function render($view)
    {
        $contentView = self::getContentView($view);
        return $contentView;
    }
}
