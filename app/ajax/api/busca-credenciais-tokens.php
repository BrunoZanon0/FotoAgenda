<?php

session_start();

if(!isset($_SESSION['id']) || empty($_SESSION['id'])){
    header('location: login');
    exit();
}

include_once __DIR__ . "/../../model/tokensModel.php";

$status_core    = 200;
$user_id        = $_SESSION['id'];
$pdo_data       = new TokensModel();

try {
    if( !isset($_POST['user_id'] ) || empty($_POST['user_id'])){
        throw new Exception('Usuario nao idenficiado');
    }

    $buscar_token   = $pdo_data->pega_token_api($user_id);
    $retorno        = $buscar_token;
    
} catch (Exception $e) {
    $status_core = 400;
    $retorno = [
        'status' => $status_core,
        'msg'    => $e->getMessage()
    ];
}

echo json_encode($retorno);