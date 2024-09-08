<?php

require_once __DIR__ . '/configRouter.php';

$router = new Router();

// GET -> rotas

$router->get('', 'home@index'); 
$router->get('/', 'home@index'); 
$router->get('login', 'home@index'); 
$router->get('cadastro','cadastro@pagina');
$router->get('cadastrarUser','cadastro@paginaUsuario');
$router->get('montarAgenda','montarAgenda@render');

// EXTERNOS

$router->get('link_externo','linkexterno@decrypt');

// POST -> rotas

$router->post('cadastrarFotografo','cadastro@cadastra');
$router->post('cadastrarUsuario','cadastro@cadastrarUsuario');
$router->post('login', 'login@logando');

// AUTENTICADOS -> rotas // só entra se estiver logado do contrario volta para o home@index

$router->get('dashboard','dashboard@render');
$router->post('dashboarddata','dashboard@data');
$router->post('cadastrardata','dataCadastro@registraData');

// PAGINA DE ERRO PADRAO

$router->get('notfound','notfound@exit');


// SAIDAS E ZERAMENTO DA SESSION

$router->get('sair','sair@redirecionar');

$router->dispatch();
