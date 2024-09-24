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
                $celular_front  = $this->valida_dados_front($_POST['celular']);
                $nome           = $this->valida_dados_front($_POST['nome']);
                $nomefantasia   = $this->valida_dados_front($_POST['nomefantasia']);
                $cpf_front      = $this->valida_dados_front($_POST['cpf']);


                if (!$senha || !$celular_front || !$nome || !$nomefantasia || !$email || !$cpf_front) {
                    $this->retorna_front_msg("Algum campo veio sem estar preenchido!", 'erro');
                    die;
                }

                $cpf            = encrypt($cpf_front,'zanontech2024');
                $celular        = encrypt($celular_front,'zanontech2024');
                $table          = 'users';
                $idkey          = '2';
                $permissao      = 'fotografo';
                $token          = gerarToken(10);
                $fotografo      = 1;
    
                $senha_encrypt  = password_hash($senha, PASSWORD_DEFAULT);
    
    
                $sql_pdo = "INSERT INTO $table (id_key,permissao,name,email,password,cpf,token,fotografo,celular)
                            VALUES(?,?,?,?,?,?,?,?,?)";
                $stmt    = $this->conn->prepare($sql_pdo);
    
                $stmt->bindParam(1,$idkey,PDO::PARAM_INT);
                $stmt->bindParam(2,$permissao,PDO::PARAM_STR);
                $stmt->bindParam(3,$nome,PDO::PARAM_STR);
                $stmt->bindParam(4,$email,PDO::PARAM_STR);
                $stmt->bindParam(5,$senha_encrypt,PDO::PARAM_STR);
                $stmt->bindParam(6,$cpf,PDO::PARAM_STR);
                $stmt->bindParam(7,$token,PDO::PARAM_STR);
                $stmt->bindParam(8,$fotografo,PDO::PARAM_STR);
                $stmt->bindParam(9,$celular,PDO::PARAM_STR);
    
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

    public function cadastrarEvento(){
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
            $valor_entrada  = '';
            $cep            = '';
            
            if(!isset($_POST['id_usuario'])          || empty($_POST['id_usuario'])){
                $this->retorna_front_msg('id_usuario é obrigatório','erro');
            }

            if(!isset($_POST['email'])          || empty($_POST['email'])){
                $this->retorna_front_msg('Email é obrigatório','erro');
            }

            if(!isset($_POST['cpf'])            || empty($_POST['cpf'])){
                $this->retorna_front_msg('cpf é obrigatório','erro');
            }

            if(!isset($_POST['endereco'])       || empty($_POST['endereco'])){
                $this->retorna_front_msg('Endereço é obrigatório','erro');
            }

            if(!isset($_POST['numero_casa'])    || empty($_POST['numero_casa'])){
                $this->retorna_front_msg('Numero da casa é obrigatório','erro');
            }

            if(!isset($_POST['hora_escolhida']) || empty($_POST['hora_escolhida'])){
                $this->retorna_front_msg('Horário é obrigatório','erro');
            }

            if(!isset($_POST['valor_total'])    || empty($_POST['valor_total'])){
                $this->retorna_front_msg('Valor total é obrigatório','erro');
            }

            if(!isset($_POST['aceite_termos'])  || empty($_POST['aceite_termos'])){
                $this->retorna_front_msg('É necessário aceitar os termos','erro');
            }

            if(!isset($_POST['data_selecionada'])|| empty($_POST['data_selecionada'])){
                $this->retorna_front_msg('É necessário enviar a data para cadastro','erro');
            }

            if(isset($_POST['cpf']) && !empty($_POST['cpf'])){
                $cpf = $_POST['cpf'];
            }

            if(isset($_POST['valor_entrada']) && !empty($_POST['valor_entrada'])){
                $valor_entrada = $_POST['valor_entrada'];
            }

            $email              = $_POST['email'];
            $cpf                = $_POST['cpf'];
            $endereco           = $_POST['endereco'];
            $numero_casa        = $_POST['numero_casa'];
            $hora_id            = $_POST['hora_escolhida'];
            $valor_total        = $_POST['valor_total'];
            $aceite_termos      = $_POST['aceite_termos'];
            $data_selecionada   = $_POST['data_selecionada'];
            $id_usuario         = $_POST['id_usuario'];

            $array_to_insert = [
                'email'             => $email,
                'cpf'               => $cpf,
                'endereco'          => $endereco,
                'numero_casa'       => $numero_casa,
                'hora_id'           => $hora_id,
                'valor_total'       => $valor_total,
                'aceite_termos'     => $aceite_termos,
                'data_selecionada'  => $data_selecionada,
                'valor_entrada'     => $valor_entrada,
                'id_usuario'        => $id_usuario,
                'cep'               => $cep,
                'status'            => 'pendente',
                'aceite'            => '0'
            ];

            $sql_insert_data = "INSERT INTO data_cadastro 
                            (
                                user_id,
                                status,
                                data_solicitado,
                                hora_solicitado_id,
                                email_cliente,
                                endereco,
                                numero_casa,
                                valor_total,
                                valor_entrada,
                                cep
                            )VALUES(
                                ?,?,?,?,?,?,?,?,?,?
                            )";

            $stmt = $this->conn->prepare($sql_insert_data);

            $stmt->bindParam(1,$array_to_insert['id_usuario'],PDO::PARAM_INT);
            $stmt->bindParam(2,$array_to_insert['status'],PDO::PARAM_STR);
            $stmt->bindParam(3,$array_to_insert['data_selecionada'],PDO::PARAM_STR);
            $stmt->bindParam(4,$array_to_insert['hora_id'],PDO::PARAM_INT);
            $stmt->bindParam(5,$array_to_insert['email'],PDO::PARAM_STR);
            $stmt->bindParam(6,$array_to_insert['endereco'],PDO::PARAM_STR);
            $stmt->bindParam(7,$array_to_insert['numero_casa'],PDO::PARAM_INT);
            $stmt->bindParam(8,$array_to_insert['valor_total'],PDO::PARAM_STR);
            $stmt->bindParam(9,$array_to_insert['valor_entrada'],PDO::PARAM_STR);
            $stmt->bindParam(10,$array_to_insert['cep'],PDO::PARAM_STR);

            if($stmt->execute()){
                $this->retorna_front_msg('Horario cadastrado, está com o status pendente!','success');
            }else{
                var_dump($stmt->errorInfo());
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