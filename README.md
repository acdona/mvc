<h1 align="center">
<br>
<img src="https://github.com/acdona/acd-images/blob/main/images/acd-logotipo-3-2022.png" alt="acdona" width="120">
<br>
A. C. <b>Doná Dev FSPHP</b>
</h1>
<br>

# Projeto ACD-MVC 📱 💻 🖥️ 

>Este projeto é uma estrutura MVC em PHP

Objetivo é a utilização do mesmo em outros projetos

## Histórico de alterações

### 001 - Preparação do ambiente 

- Criação dos arquivos para teste e documentação
    - index.php
    - README.md

### 002 - Preparação do ambiente 
- Habilitanto todos os erros do PHP no index.php
- Criando o composer.json para o autoload
     ```TERMINAL
    > composer update
    ```
- chamando o autoload pelo index.php
   
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

- Criando uma Controller
    - app\Controllers\Pages\Home.php

- Criando uma classe para renderizar as VIEWS
    - app\Core\View.php

- Criando a View da homepage
    - app\Views\pages\home.html

- Chamando o MVC da index.php para testar
```PHP
use \App\Controllers\Pages\Home;

echo Home::getHome();
```

### 004 - Passando variáveis para a VIEW
- Modificamos o método render para receber mais um parâmetro array
    - Utilizamos array_keys e array_maps para obter as chaves do array
- Modificamos o home.php para receber as variáveis passadas

### 005 - Criando template, header e footer
- Criação do Controller app/Controllers/Pages/Template.php
- Criação da app\Views\__template.html
- Criação do app\Views\header.html
- Criação do app\Views\footer.html

### 006 - Criando uma MODEL de exemplo
- Criando pasta e arquivo
    - app/Models/Entity/Organization.php
    - Substituindo os valores da Controller Home.php pelos dados da Model Organization.php

### 007 - Criando outra MODEL de exemplo (ABOUTUS)

### 008 - Modificando as variáveis da Model Organization.php
- Mudando as variáveis para private e criando as fets

### 009 - Criando a classe de HTTP Request
- app\Html\Request.php


### 010 - Criando a classe de HTTP Response
- app\Html\Response.php

### 011 - Criando a classe de rotas
- app\Html\Router.php

### 012 - Criando o CRUD
- instalando o dot-env 
```TERMINAL
composer require william-costa/dot-env
```
- instalando database-manager
```TERMINAL
composer require william-costa/database-manager
```
- criando arquivo includes/app.php
- criando arquivo app/Controllers/Testimony.php
- criando Views/pages/testimony/item.html

### 013 - Implementando Middlewares
- criando arquivo app/Httmp/Middleware/Queue.php
- criando middlewares default

### 014 - Autenticação de usuários
- criando arquivo routes/admin/Template.php
- criando arquivo routes/admin/Login.php
- criando a Model app/Models/Entity/User.php
- criando a View app/Views/admin/_template.html
- criando a View app/Views/admin/status.html
- criando a View app/Views/admin/login.html
- validando e-mail
    - validando senha

### 015 - Criando sessão de login do usuário
- criando classe app\Session\Admin\Login.php


#

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
