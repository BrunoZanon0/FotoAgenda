<?php

include_once __DIR__ ."/../../db/connect/connect.php";
require __DIR__ . "/../model/userModel.php";

class LoginController {
    public $conn;
    public function __construct() {
        $new_pdo    =  new Connect();
        $conn       = $new_pdo->getConnection();
        $this->conn = $conn;
    }
    public function logando() {
        $curl = curl_init();

        curl_setopt_array($curl,[
            CURLOPT_URL => "https://www.google.com/recaptcha/api/siteverify",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_CUSTOMREQUEST =>'POST',
            CURLOPT_POSTFIELDS =>[
                'secret' => '6LecXpIpAAAAAL75yJUPdZkPv4oFpnpW99aqOc6Q',
                'response' => $_POST['g-recaptcha-response' ?? '']
            ]
        ]);
    
        $response = curl_exec($curl);
        curl_close($curl);
        
        $responseData = json_decode($response, true);
        session_start();

        if($responseData['success']){
            if(isset($_POST['email']) && !empty($_POST['email']) && isset($_POST['senha']) && !empty($_POST['senha'])){
                $email = $_POST['email'];
                $senha = $_POST['senha'];
                
                $this->verifica_login($email,$senha);

            }else{
                $this->retorna_front_msg('Valores nã enviados!','erro');
            }
        }else{
            $this->retorna_front_msg('Recaptcha é obrigatorio!','erro');
        }
    }

    public function verifica_login($email,$senha){

        $sql_query_login = "SELECT id,email,password FROM users WHERE email=? limit 1";
        $stmt = $this->conn->prepare($sql_query_login);
        $stmt->bindParam(1,$email,PDO::PARAM_STR);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        if($result){

            if(password_verify($senha, $result['password'])){

                $model_user = new User();
                $user       = $model_user->get_all_by_email($email);
                
                if($user){
                    session_start();

                    $_SESSION['id_key']              = $user['id_key'];
                    $_SESSION['permissao']           = $user['permissao'];
                    $_SESSION['name']                = $user['name'];
                    $_SESSION['token']               = $user['token'];
                    $_SESSION['fotografo']           = $user['fotografo'];
                    $_SESSION['celular']             = $user['celular'];
                    $_SESSION['verificacao_two_fac'] = $user['verificacao_two_fac'];
                    $_SESSION['id']                  = $user['id'];

                    header('location: dashboard');
                    exit();
                }else{
                    $this->retorna_front_msg('Usuario inexistente, procure o ADM','erro');
                }
            }else{
                $this->retorna_front_msg('Email ou senha inválida','erro');
            }

        }else{
            $this->retorna_front_msg('Email ou senha inválida','erro');
        }
    }

    public function retorna_front_msg($titulo,$tipo){
        session_start();
        $_SESSION[$tipo] = $titulo; 
        $url = $_SERVER['HTTP_REFERER'];
        header('Location: ' . $url);
        exit;
    }
}

?>
