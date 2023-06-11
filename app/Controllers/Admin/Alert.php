<?php

declare(strict_types=1);

namespace App\Controllers\Admin;

use \App\Core\View;

class Alert
{  

        /**
     * getError
     * Método responsável por retornar uma mensagem de erro
     * 
     * @param string $message
     * @return string
     */
    public static function getError($message)
    {
        return View::render('admin/alert/status',[
            'type' => 'danger',
            'message' => $message
        ]);
    }
    
    
    /**
     * getSucess
     * Método responsável por retornar uma mensagem de sucesso
     * 
     * @param string $message
     * @return string
     */
    public static function getSuccess($message)
    {
        return View::render('admin/alert/status',[
            'type' => 'success',
            'message' => $message
        ]);
    }
}
