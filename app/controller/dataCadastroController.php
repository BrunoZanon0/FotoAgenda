<?php


session_start();

if(!isset($_SESSION['id'])){
    header('location: login');
    exit();
}

include_once __DIR__ . "/../model/userModel.php";
include_once __DIR__ . "/../model/datasModel.php";

class DataCadastroController{

    public function registraData(){


        dd($_POST);

        $nome                   = $_POST['nome'];
        $descricao              = $_POST['descricao'];
        $total                  = $_POST['total'];
        $nome_assinatura_cliente= $_POST['nome_assinatura_cliente'];


    }
}