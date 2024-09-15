<?php

session_start();

if(!isset($_SESSION['id']) || empty($_SESSION['id'])){
    header('location: login');
    exit();
}

$status_core = 200;

try{

    $tudo   = $_FILES;

    $retorno = [
        'status'    => $status_core,
        'msg'       => json_encode($tudo)
    ];

}catch(Exception $e){

    $status_core    = 400;

    $retorno = [
        'status'    => $status_core,
        'msg'       => 'deu tudo certo'
    ];
}finally{
    echo json_encode($retorno);
}