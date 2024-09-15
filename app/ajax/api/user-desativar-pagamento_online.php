<?php

include_once __DIR__ . "/../../model/tokensModel.php";
include_once __DIR__. "/../../utils/functions.php";

try {

    $status_core = 200;

    if( !isset($_POST['user_id'] ) || empty($_POST['user_id']) ){
        throw new Exception('Erro ao tentar obter o usuario');
    }

    $user_id        = $_POST['user_id'];
    $pdoEmail       = new TokensModel();
    $email_model    = $pdoEmail->desativar_pagamento_online($user_id);
    

    if($email_model){
        $retorno = [
            'status'    => $status_core,
            'msg'       => 'Ativado com sucesso!'
        ];
    }else{
        $retorno = [
            'status'    => $status_core,
            'msg'       => 'Email não verificado!'
        ];
    }

} catch (Exception $e) {

    $status_core = 400;
    $retorno = [
        'status' => $status_core,
        'msg'    => $e->getMessage()
    ];

}finally{
    echo json_encode($retorno);
}