<?php 

include_once __DIR__ ."/../../db/connect/connect.php";
include_once __DIR__ ."/../../app/utils/auxiliares.php";


class CadastroController{
    public $conn;
    public function __construct() {
        $new_pdo    =  new Connect();
        $conn       = $new_pdo->getConnection();
        $this->conn = $conn;
    }

    public function verifica_email_exist($email){

        $sql_query_login = "SELECT email,password FROM users WHERE email=? limit 1";
        $stmt = $this->conn->prepare($sql_query_login);
        $stmt->bindParam(1,$email,PDO::PARAM_STR);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        return $result;
    }

    public function valida_dados_front($dado) {
        return trim($dado);
    }

    public function cadastra(){
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

        if($responseData['success']){

            $email          = $this->valida_dados_front($_POST['email']);
            $exist_email    = $this->verifica_email_exist($email);

            if(!$exist_email){
                $senha          = $this->valida_dados_front($_POST['senha']);
                $celular        = $this->valida_dados_front($_POST['celular']);
                $nome           = $this->valida_dados_front($_POST['nome']);
                $nomefantasia   = $this->valida_dados_front($_POST['nomefantasia']);


                if (!$senha || !$celular || !$nome || !$nomefantasia || !$email) {
                    $this->retorna_front_msg("Algum campo veio sem estar preenchido!", 'erro');
                    die;
                }

                $table          = 'users';
                $idkey          = '2';
                $permissao      = 'fotografo';
                $token          = gerarToken(10);
                $fotografo      = 1;
    
                $senha_encrypt  = password_hash($senha, PASSWORD_DEFAULT);
    
    
                $sql_pdo = "INSERT INTO $table (id_key,permissao,name,email,password,token,fotografo,celular)
                            VALUES(?,?,?,?,?,?,?,?)";
                $stmt    = $this->conn->prepare($sql_pdo);
    
                $stmt->bindParam(1,$idkey,PDO::PARAM_INT);
                $stmt->bindParam(2,$permissao,PDO::PARAM_STR);
                $stmt->bindParam(3,$nome,PDO::PARAM_STR);
                $stmt->bindParam(4,$email,PDO::PARAM_STR);
                $stmt->bindParam(5,$senha_encrypt,PDO::PARAM_STR);
                $stmt->bindParam(6,$token,PDO::PARAM_STR);
                $stmt->bindParam(7,$fotografo,PDO::PARAM_STR);
                $stmt->bindParam(7,$fotografo,PDO::PARAM_STR);
                $stmt->bindParam(8,$celular,PDO::PARAM_STR);
    
                if($stmt->execute()){
                    $this->retorna_front_msg('Email cadastrado com sucesso','success');
                }else{
                    $this->retorna_front_msg($stmt->errorInfo(),'erro');
                }
            }else{
                $this->retorna_front_msg('Email já existente! escolha outro email','erro');
            }
            
        }else{
            $this->retorna_front_msg('Validação do recaptcha é obrigatorio!','erro');
        }
    }

    public function cadastrarUsuario(){
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

        if($responseData['success']){

            $email          = $this->valida_dados_front($_POST['email']);
            $exist_email    = $this->verifica_email_exist($email);

            if(!$exist_email){
                $senha          = $this->valida_dados_front($_POST['senha']);
                $celular        = $this->valida_dados_front($_POST['celular']);
                $nome           = $this->valida_dados_front($_POST['nome']);
                $nomefantasia   = $this->valida_dados_front($_POST['nomefantasia']);


                if (!$senha || !$celular || !$nome || !$nomefantasia || !$email) {
                    $this->retorna_front_msg("Algum campo veio sem estar preenchido!", 'erro');
                    die;
                }

                $table          = 'users';
                $idkey          = '3';
                $permissao      = 'cliente';
                $token          = gerarToken(10);
                $fotografo      = 0;
    
                $senha_encrypt  = password_hash($senha, PASSWORD_DEFAULT);
    
                $sql_pdo = "INSERT INTO $table (id_key,permissao,name,email,password,token,fotografo,celular)
                            VALUES(?,?,?,?,?,?,?,?)";
                $stmt    = $this->conn->prepare($sql_pdo);
    
                $stmt->bindParam(1,$idkey,PDO::PARAM_INT);
                $stmt->bindParam(2,$permissao,PDO::PARAM_STR);
                $stmt->bindParam(3,$nome,PDO::PARAM_STR);
                $stmt->bindParam(4,$email,PDO::PARAM_STR);
                $stmt->bindParam(5,$senha_encrypt,PDO::PARAM_STR);
                $stmt->bindParam(6,$token,PDO::PARAM_STR);
                $stmt->bindParam(7,$fotografo,PDO::PARAM_STR);
                $stmt->bindParam(7,$fotografo,PDO::PARAM_STR);
                $stmt->bindParam(8,$celular,PDO::PARAM_STR);
    
                if($stmt->execute()){
                    $this->retorna_front_msg('Email cadastrado com sucesso','success');
                }else{
                    $this->retorna_front_msg($stmt->errorInfo(),'erro');
                }
            }else{
                $this->retorna_front_msg('Email já existente! escolha outro email','erro');
            }
            
        }else{
            $this->retorna_front_msg('Validação do recaptcha é obrigatorio!','erro');
        }
    }

    public function retorna_front_msg($titulo,$tipo){
        session_start();
        $_SESSION[$tipo] = $titulo; 
        $url = $_SERVER['HTTP_REFERER'];
        header('Location: ' . $url);
        exit;
    }

    public function pagina(){
        include __DIR__ . "../../../public/views/home/cadastro.php";
    }

    public function paginaUsuario(){
        include __DIR__. "../../../public/views/home/cadastroUser.php";
    }
}