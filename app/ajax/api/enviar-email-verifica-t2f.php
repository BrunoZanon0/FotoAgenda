<?php

include_once __DIR__ . "/../../model/userModel.php";

// HOSTINGER -> API CONNECT ENV AUTO EMAIL

try {

    if( !isset($_POST['user_id'] ) || empty($_POST['user_id']) ){
        throw new Exception('Erro ao tentar obter o usuario');
    }

    if( !isset($_POST['email'] ) || empty($_POST['email'])){
        throw new Exception('Email não identificado');
    }
    
    $tipo_imap = [
        'link' => 'imap.hostinger.com',
        'port' => 993
    ];

    $tipo_smtp = [
        'link' => 'smtp.hostinger.com',
        'port' => 465
    ];

    $tipo_pop = [
        'link' => 'pop.hostinger.com',
        'port' => 995
    ];

    $pdoUser = new User();

    $email_to_env = "no-reply@zanontech.com.br";

} catch (Exception $e) {
    $msg = $e->getMessage();

    echo $msg;
}finally{
    echo 'ola';
}