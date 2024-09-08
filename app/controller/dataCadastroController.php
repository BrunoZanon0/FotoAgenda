<?php


session_start();

if(!isset($_SESSION['id'])){
    header('location: login');
    exit();
}

include_once __DIR__ . "/../model/userModel.php";
include_once __DIR__ . "/../model/datasModel.php";

class DataCadastroController{

    public $user_id;
    public function __construct() {
        $this->user_id = $_SESSION['id'];
    }

    public function registraData(){


        $nome                   = $_POST['nome'];
        $descricao              = $_POST['descricao'];
        $total                  = $_POST['total'];
        $nome_assinatura_cliente= $_POST['nome_assinatura_cliente'];
        $hora                   = $_POST['hora'];
        $data                   = $_POST['data_evento'];
        $email_cliente          = $_POST['emailCliente'];
        $entrada_cliente        = $_POST['valor_entrada'];
        $celular_cliente        = $_POST['numeroCliente'];


        $dados = [
            'name'          => $nome,
            'user_id'       => $this->user_id,
            'descricao'     => $descricao,
            'data_evento'   => $data,
            'hora_evento'   => $hora,
            'assinatura'    => $nome_assinatura_cliente,
            'email'         => $email_cliente,
            'valor_total'   => $total,
            'entrada'       => $entrada_cliente,
            'celular'       => $celular_cliente,
        ];

        $data_connect = new DatasModel();
        $retorno_func = $data_connect->new_date($dados);

        var_dump($retorno_func);
    }
}