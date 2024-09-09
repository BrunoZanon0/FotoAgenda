<?php 

include_once __DIR__ . "/../../db/connect/connect.php";

class TokensModel{
    public $conn;
    public $table;
    public function __construct() {
        $pdo        = new Connect();
        $this->conn = $pdo->getConnection();
        $this->table= 'tokens_pay';
    }

    public function updateOrCreateToken($tokenAccess,$tokenPublic,$id_user,$tipo){
        $decrypt      = 'zanontech2024';
        $token_acesso = $this->encrypt($tokenAccess,$decrypt);
        $token_public = $this->encrypt($tokenPublic,$decrypt);
        
        $verifica = $this->verificaExistenciaToken($id_user,$tipo);
        $api_name = 'Mercado Pago';

        if(!$verifica){
            $sql_insere = "INSERT INTO $this->table 
                        (user_id, getway_api_name,tipo,token_api_acess,token_public_key)
                            VALUES (?,?,?,?,?)";
            $stmt = $this->conn->prepare($sql_insere);
            $stmt->bindParam(1,$id_user,PDO::PARAM_INT);
            $stmt->bindParam(2,$api_name,PDO::PARAM_STR);
            $stmt->bindParam(3,$tipo,PDO::PARAM_STR);
            $stmt->bindParam(4,$token_acesso,PDO::PARAM_STR);
            $stmt->bindParam(5,$token_public,PDO::PARAM_STR);
        }else{
            $sql_update = "UPDATE $this->table SET
                            token_api_acess = ?,
                            token_public_key= ?
                            WHERE id = ?";

            $stmt = $this->conn->prepare($sql_update);
            $stmt->bindParam(1,$token_acesso,PDO::PARAM_STR);
            $stmt->bindParam(2,$token_public,PDO::PARAM_STR);
            $stmt->bindParam(3,$verifica['id'],PDO::PARAM_INT);
        }

        if($stmt->execute()){
            return true;
        }else{
            return $stmt->errorInfo();
        }
    }

    public function verificaExistenciaToken($id_user,$tipo){

        $sql_verifica = "SELECT id FROM $this->table WHERE user_id = ? and tipo = ? LIMIT 1";

        try {
            $stmt = $this->conn->prepare($sql_verifica);
            $stmt->bindParam(1, $id_user, PDO::PARAM_INT);
            $stmt->bindParam(2, $tipo, PDO::PARAM_STR);
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            return $result;
        } catch (PDOException $e) {
            echo "Erro: " . $e->getMessage();
        }
    }

    public function pega_token_api($user_id,$tipo = 'producao'){
        $decrypt        = 'zanontech2024';
        $retorno        = [];
        $sql_verifica   = "SELECT * FROM $this->table WHERE user_id = ? and tipo = ? LIMIT 1";

        try {
            $stmt = $this->conn->prepare($sql_verifica);
            $stmt->bindParam(1, $user_id, PDO::PARAM_INT);
            $stmt->bindParam(2, $tipo, PDO::PARAM_STR);
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);

            if($result){
                $token_1 = $this->decrypt($result['token_api_acess'],$decrypt);
                $token_2 = $this->decrypt($result['token_public_key'],$decrypt);
                $retorno = [
                    'id' => $result['id'],
                    'token_api_acess' => $token_1,
                    'token_public_key' => $token_2 
                ];
            }

            return $retorno;
        } catch (PDOException $e) {
            echo "Erro: " . $e->getMessage();
        }
    }

    function encrypt($data, $key) {
      
        if (strlen($key) < 32) {
            $key = str_pad($key, 32, '0'); 
        } elseif (strlen($key) > 32) {
            $key = substr($key, 0, 32); 
        }
    
        $iv = openssl_random_pseudo_bytes(16);
        $encrypted = openssl_encrypt($data, 'AES-256-CBC', $key, OPENSSL_RAW_DATA, $iv);
    
        if ($encrypted === false) {
            throw new Exception('Erro ao criptografar o dado.');
        }
    
        return base64_encode($iv . $encrypted);
    }
    
    function decrypt($data, $key) {
        if (strlen($key) < 32) {
            $key = str_pad($key, 32, '0'); 
        } elseif (strlen($key) > 32) {
            $key = substr($key, 0, 32); 
        }
    
        $data = base64_decode($data);
        if ($data === false) {
            throw new Exception('Erro ao decodificar o dado.');
        }
    
        $iv = substr($data, 0, 16); 
        $encrypted = substr($data, 16); 
        $decrypted = openssl_decrypt($encrypted, 'AES-256-CBC', $key, OPENSSL_RAW_DATA, $iv);
    
        if ($decrypted === false) {
            throw new Exception('Erro ao descriptografar o dado.');
        }
    
        return $decrypted;
    }
}