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
### home.html (VIEW da homepage)
```HTML
<h1>Home do ACD</h1>
Carregou a home do ACD
```
### Chamando o MVC da index.php para testar
```PHP
use \App\Controllers\Pages\Home;

echo Home::getHome();
```

### 004 - Passando variáveis para a VIEW
- Modificamos o método render para receber mais um parâmetro array
    - Utilizamos array_keys e array_maps para obter as chaves do array
```PHP
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

        // Chaves do array e variáveis
        $keys = array_keys($vars);
        $keys = array_map(function($item){

            return '{{' . $item . '}}';
        }, $keys);

        // Retorna conteúdo renderizado
        return str_replace($keys, array_values($vars), $contentView);
    }
```
- Modificamos o home.php para receber as variáveis passadas
```HTML
<h1>Home {{name}}</h1>
<hr>
<p>{{description}}</p>
Carregou a home do ACD
```

### 005 - Criando template, header e footer
- Criação do Controller Template.php
```PHP
<?php

declare(strict_types=1);

namespace App\Controllers\Pages;

use \App\Core\View;

/**
 * ACD || Template Class Controller
 * Classe responsável pela controller da página home
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
```
### _template.html
```HTML
<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
    <title>{{title}}</title>
</head>

<body class="bg-dark text-light">

    <div class="container"></div>

    {{header}}

    {{content}}

    {{footer}}

    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz"
        crossorigin="anonymous"></script>
</body>

</html>

```
### header.html
```HTML
<div class="jumbotron bg-success p-3 my-3">

    <h1>ACD - WEB</h1>
    <p>Model - View - Controller</p>

</div>
```
### footer.html
```HTML
<hr>
ACD WEBDEV - 2023 - www.acd
```
### 006 - Criando uma MODEL de exemplo
- Criando pasta e arquivo
    - app/Models/Entity/Organization.php


```PHP
 <?php

declare(strict_types=1);

namespace App\Models\Entity;

class Organization
{
    /** @var integer $id */
    public $id = 1;

    /** @var string $name */
    public $name = "ACD WEBDEV";
        
    /** @var string $site */
    public $site = 'https://antoniocarlosdona';

    /** @var string $description */
    public $description = 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Optio iusto aperiam voluptate consequuntur, id officiis soluta asperiores repudiandae dolor perspiciatis illum ab possimus nobis! Eaque placeat asperiores sed ex fugiat.';
}
```

- Substituindo os valores da Controller Home.php pelos dados da Model Organization.php
### Home.php
```PHP
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
class Home extends Template
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
            'name'        => $obOrganization->name,
            'description' => $obOrganization->description,
            'site'        => $obOrganization->site
        ]);

        // Retorna a VIEW da página
        return parent::getTemplate('ACD-WEB - HOME', $content);
    }
}
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
