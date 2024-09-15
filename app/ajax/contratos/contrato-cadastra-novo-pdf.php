<?php

session_start();

if(!isset($_SESSION['id']) || empty($_SESSION['id'])){
    header('location: login');
    exit();
}

include_once __DIR__ . "/../../model/contratoModel.php";

$status_core = 200;

try{

    if(!isset( $_FILES['input_pdf'] ) || empty($_FILES['input_pdf']) ){
        throw new Exception('Arquivo não enviado');
    }

    $pdo_contrato       = new ContratoModel();
    $pdf_to_move        =   $_FILES["input_pdf"];

    $original_name      = $pdf_to_move["name"];

    $path_file          = "../../../public/app/contratos/";
    $path_info          = pathinfo($original_name);
    $filename           = $path_info['filename'];
    $extension          = $path_info['extension'];
    $sanitized_name     = basename($filename);
    $encoded_name       = base64_encode($sanitized_name);
    $arquivo_name       = $encoded_name . '.' . $extension;
    $target_file        = $path_file . $_SESSION['id'].'-'. $arquivo_name;

    if ($pdf_to_move["error"] === UPLOAD_ERR_OK) {
        if (move_uploaded_file($pdf_to_move["tmp_name"], $target_file)) {
            $array_to_insert    = [
                'user_id' => $_SESSION['id'],
                'status'  => 'ativo',
                'nome'    => $arquivo_name
            ];

            $insert_contrato = $pdo_contrato->upload_arquivo($array_to_insert);
            if($insert_contrato['status'] == 400){
                throw new Exception($insert_contrato['msg']);
            }
        } else {
            throw new Exception('Erro ao mover o arquivo ERRO02');
        }
    } else {
        throw new Exception('Erro ao mover o arquivo ERRO01');
    }

    $retorno = [
        'status'    => $status_core,
        'msg'       => 'Contrato cadastrado com sucesso!'
    ];

}catch(Exception $e){

    $status_core    = 400;

    $retorno = [
        'status'    => $status_core,
        'msg'       => $e->getMessage()
    ];
}finally{
    echo json_encode($retorno);
}