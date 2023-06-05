<h1 align="center">
<br>
<img src="https://github.com/acdona/acd-images/blob/main/images/acd-logotipo-3-2022.png" alt="acdona" width="120">
<br>
A. C. <b>Doná Dev FSPHP</b>
</h1>
<br>

# Projeto acd-project-name 📱 💻 🖥️ 

>Este projeto é uma estrutura MVS em PHP

Objetivo é a utilização do mesmo em outros projetos

## Histórico de alterações

### 001 - Preparação do ambiente 

- Criação dos arquivos para teste e documentação
    - index.php
    - README.md

### 002 - Preparação do ambiente 
- Habilitanto todos os erros do PHP no index.php
    ```PHP
    <?php 
    // ativa a checagem de tipo
    declare(strict_types=1);
    
    // Ativa todos os tipo de erros e aviso do php
    // Deve ser retirado no deploy do projeto

    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
    ```
- Criando o composer.json para o autoload
    ```JSON
    {
        "description": "ACD Project MVC-PHP",
        "name": "acdona/mvc",
        "minimum-stability": "dev",
        "license": "MIT",
        "authors": [
            {
                "name": "Antonio Carlos Dona",
                "email": "contato@antoniocarlosdona.com.br",
                "role": "Developer",
                "homepage": "https://antoniocarlosdona.com.br"
            }
        ],
        "config": {
            "vendor-dir": "vendor"
        },
        "autoload" : {
            "psr-4" : {
                "App\\": "app/"
            }
        }
    }

    ```
    ```TERMINAL
    > composer update
    ```
- chamando o autoload pelo index.php
    ```PHP
    // Ativa o buffer de saída
    ob_start();

    require __DIR__ . "/vendor/autoload.php";


    // Descarrega e desativa o buffer de saída
    ob_end_flush();
    ```
### 003 - Iniciando o MVC

- Criando as Pastas:
    - app/Controllers
    - app/Models
    - app/Views
    - app/Controllers/Pages
    - app/Core
    - app/Views/pages

- Criando os arquivos
    - app/Controllers/Pages/Home.php (Controller Home)
    - app/Views/Pages/home.html (view da homepage)
    - app/Core/View.php (classe que irá renderizar as views)

### Home.php (Controller)
```PHP
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
        return View::render('pages/home');
    }
}
```
### View.php (Classe para renderizar as views)
```PHP
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
```
### home.html (view da homepage)
```HTML
<h1>Home do ACD</h1>
Carregou a home do ACD
```
### Chamando o MVC da index.php para testar
```PHP
use \App\Controllers\Pages\Home;

echo Home::getHome();
```



## Instalação

### Pré requisitos

- um navegador com suporte a javascript

## Software utilizado
- Visual Studio Code
- Notepad++

## Observações

- Para funcionar corretamente, o projeto deve ser em localhost/mvc/,
sendo o localhost o endereço do seu servidor. 
Se for tentado o acesso direto pelo index.html, o navegador apontará erro:
O acesso ao script foi bloqueado pela política CORS.
Access to script has been blocked by CORS policyps.

## Crédito

- Antonio Carlos Doná - [acdona](https://guithub.com/acdona)

### Agradecimentos
Agradecimentos a Microsoft, por disponibilizar gratuitamente, esse sensacional software o [**Visual Studio Code**](https://code.visualstudio.com/).

## Licença
Software de código fonte aberto licenciado conforme à [MIT](https://choosealicense.com/licenses/mit/)
