<?php

require_once __DIR__ . '/configRouter.php';

$router = new Router();

// GET -> rotas

$router->get('', 'home@index'); 
$router->get('/', 'home@index'); 
$router->get('login', 'home@index'); 
$router->get('cadastro','cadastro@pagina');

// POST -> rotas

$router->post('cadastrarFotografo','cadastro@cadastra');
$router->post('login', 'login@logando');

// AUTENTICADOS -> rotas // só entra se estiver logado do contrario volta para o home@index

$router->get('dashboard','dashboard@render');
$router->post('dashboard/data','dashboard@data');

// SAIDAS E ZERAMENTO DA SESSION

$router->get('sair','sair@redirecionar');

$router->dispatch();
