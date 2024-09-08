<?php

session_start();

if(!isset($_SESSION['id']) || empty($_SESSION['id'])){
    header('location: login');
    exit();
}

include_once __DIR__ . "/../../model/datasModel.php";

$status_core    = 200;
$msg            = 'Cadastrado com sucesso!';
$user_id        = $_SESSION['id'];
$pdo_data       = new DatasModel();

try {
    $busca_data = $pdo_data->get_all_date($user_id);
    $retorno    = $busca_data;
    
} catch (Exception $e) {
    $status_core = 400;
    $retorno = [
        'status' => $status_core,
        'msg'    => $e->getMessage()
    ];
}

echo json_encode($retorno);