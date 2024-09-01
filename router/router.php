<?php

require_once __DIR__ . '/configRouter.php';

$router = new Router();

$router->get('', 'home@index'); 
$router->get('login', 'home@index'); 
$router->get('cadastro','cadastro@pagina');
$router->post('cadastrarFotografo','cadastro@cadastra');

$router->post('login', 'login@logando');

$router->get('dashboard','dashboard@render');

$router->dispatch();
