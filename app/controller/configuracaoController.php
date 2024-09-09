<?php
    session_start();

    if(!isset($_SESSION['id'])){
        header('location: login');
        exit();
    }

include_once __DIR__ ."/../../app/utils/auxiliares.php";
include_once __DIR__ . "/../model/userModel.php";
include_once __DIR__ . "/../model/tokensModel.php";

class ConfiguracaoController{
        public $auth;
        public $conn;
        public $tokenApi;
    public function __construct() {
        $user       = new User($_SESSION['id']);
        $this->auth = $user->Auth();

        $this->tokenApi = new TokensModel();
    }

    public function atualizaChaveApi(){

        if( !isset($_POST['token_api_access']) || empty($_POST['token_api_access'])){
            $this->retorna_front_msg('Token de acesso não enviado! Necessita do token!','erro');
        }

        if( !isset($_POST['token_api_public']) || empty($_POST['token_api_public'])){
            $this->retorna_front_msg('Token publico não enviado! Necessita do token!','erro');
        }

        $tipo               = isset($_POST['tipo']) && !empty($_POST['tipo']) ? $_POST['tipo'] : 'producao';
        $token_api_access   = $_POST['token_api_access'];
        $token_api_public   = $_POST['token_api_public'];


        $apiToken = $this->tokenApi->updateOrCreateToken($token_api_access,$token_api_public,$this->auth['id'],$tipo);

        if($apiToken){
            $this->retorna_front_msg('Tokens atualizados com sucesso','success');
        }else{
            $this->retorna_front_msg('Tokens não atualizados, contecte o suporte','error');
        }
    }
    public function render(){
        $auth = $this->auth;
        include_once __DIR__ . "/../../public/views/admin/config/configuracao.php";
    }

    public function retorna_front_msg($titulo,$tipo){
        session_start();
        $_SESSION[$tipo] = $titulo; 
        $url = $_SERVER['HTTP_REFERER'];
        header('Location: ' . $url);
        exit;
    }

}