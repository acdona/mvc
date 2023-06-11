<?php

declare(strict_types=1);

namespace App\Controllers\Admin;

use App\Core\View;

class Template
{
    
    /**
     * getTemplate
     * Método responsável por retornar o conteúdo da estrutura genérica de página do painel
     *
     * @param  string $title
     * @param  string $content
     * @return string
     */
    public static function getTemplate($title, $content)
    {
        return View::render('admin/_template',[
            'title' => $title,
            'content' => $content
        ]);
    }

}
 

 

