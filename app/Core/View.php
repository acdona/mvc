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
     * vars
     * Variáveis padrões da VIEW
     * 
     * @var array
     */
    private static $vars = [];

    /**
     * init
     * Método responsável por definir os dados iniciais da classe
     *
     * @param  array $vars
     */
    public static function init($vars = [])
    {
        self::$vars = $vars;
    }
    
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
        $file = __DIR__ . '/../Views/' . $view . '.html';
        return file_exists($file) ? file_get_contents($file) : '';
    }
    
    /**
     * render
     * Método responsável por retornar o conteúdo renderizado de uma view
     * Method responsible for returning the rendered content of a view
     *
     * @param  string $view
     * @param array $vars (string/numeric)
     * @return string
     */
    public static function render($view, $vars = [])
    {
        // Conteúdo da View
        $contentView = self::getContentView($view);

        //MERGE DE VARIÁVEIS DA VIEW
        $vars = array_merge(self::$vars, $vars);

        // Chaves do array e variáveis
        $keys = array_keys($vars);

        // transformando em arrow function
        $transformedKeys = array_map(fn($item) => '{{' . $item . '}}', $keys);

        // Retorna conteúdo renderizado
        return str_replace($transformedKeys, array_values($vars), $contentView);
    }
}
