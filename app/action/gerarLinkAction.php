<?php

$status_core = 200;
$msg         = '';

session_start();

if(!isset($_SESSION['id']) || empty($_SESSION['id'])){
    header('location: login');
    exit();
}

try {
    
    if( !isset( $_POST['id_user'] ) || empty( $_POST['id_user'] ) ){
        throw new Exception('ID NECESSITA SER ENVIADO');
    }
    
    if( !isset( $_POST['token'] ) || empty( $_POST['token'] ) ){
        throw new Exception('token NECESSITA SER ENVIADO');
    }

    if( !isset( $_POST['url'] ) || empty( $_POST['url'] ) ){
        throw new Exception('URL NECESSITA SER ENVIADO');
    }

    $id_user    = $_POST['id_user'];
    $token      = $_POST['token'];
    $url        = $_POST['url'];
    

    $encrypt = base64_encode('id=' ."$id_user" . '&token=' . "$token");
    $lastSlashPos = strrpos($url, '/');
    $baseUrl = substr($url, 0, $lastSlashPos);
    $msg = $baseUrl.'/link_externo?'.$encrypt;

    $retorno = [
        'mensagem'  => $msg,
        'status'    => $status_core
    ];

} catch (Exception $e) {

    $retorno = [
        'mensagem'  => $e->getMessage(),
        'status'    => 400
    ];

}finally{
    echo json_encode($retorno);
}