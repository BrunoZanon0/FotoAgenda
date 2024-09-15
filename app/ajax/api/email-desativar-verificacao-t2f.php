<?php

include_once __DIR__ . "/../../model/userModel.php";
include_once __DIR__ . "/../../model/emailModel.php";
include_once __DIR__. "/../../utils/functions.php";


try {

    $status_core = 200;

    if( !isset($_POST['user_id'] ) || empty($_POST['user_id']) ){
        throw new Exception('Erro ao tentar obter o usuario');
    }

    if( !isset($_POST['email'] ) || empty($_POST['email'])){
        throw new Exception('Email não identificado');
    }

    $user_id        = $_POST['user_id'];
    $email_front    = $_POST['email'];
    $pdoEmail       = new EmailModel();
    $email_model    = $pdoEmail->desativar_verificacao_dois_fatores($user_id);

    if($email_model){
        $retorno = [
            'status'    => $status_core,
            'msg'       => 'Desativado com sucesso!'
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