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
    composer update
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
