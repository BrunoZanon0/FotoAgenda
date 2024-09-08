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

    if( !isset( $_POST['horario'] ) || empty( $_POST['horario'] ) ){
        throw new Exception('não foi identificado nenhum horario para cadastro!');
    }

    if( !isset( $_POST['data'] ) || empty( $_POST['data'] ) ){
        throw new Exception('não foi identificado nenhuma data para cadastro!');
    }

    $horarios_cadastro  = $_POST['horario'];
    $dia_mes_ano        = $_POST['data'];

    foreach($horarios_cadastro as $horario){
        $dados = [
            'user_id'          => $user_id,
            'data_disponivel'  => $dia_mes_ano,
            'hora_disponivel'  => $horario,
            'status'           => 'ativo'
        ];

        $retorno_func = $pdo_data->new_date($dados);

        if($retorno_func['status'] == 400 ){
            throw new Exception($retorno_func['msg']);
        }
    }

    $retorno = [
        'status' => $status_core,
        'msg' => $msg
    ];
    
} catch (Exception $e) {
    $status_core = 400;
    $retorno     = [
        'status' => $status_core,
        'msg' => $e->getMessage()
    ];
}

echo json_encode($retorno);