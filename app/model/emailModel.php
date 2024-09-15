<?php 

date_default_timezone_set('America/Fortaleza');

include_once __DIR__ . "/../../db/connect/connect.php";

class EmailModel{
    public $conn;
    public $table;
    public function __construct() {

        $pdo        = new Connect();
        $this->conn = $pdo->getConnection();
        $this->table= 'email_dois_fatores';

    }

    public function get_token_email_verify($user_id){

        $sql_select_one = "SELECT * FROM $this->table WHERE user_id =? ORDER BY id desc LIMIT 1";
        $stmt = $this->conn->prepare($sql_select_one);
        $stmt->bindParam(1,$user_id,PDO::PARAM_INT);

        $result = [];

        if($stmt->execute()){
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        }

        return $result;
    }

    public function ativar_verificacao_dois_fatores($user_id){

        $retorno        = [];
        $status         = 200;
        $msg            = '';
        $status_from_db = 1;

        try {
            $sql_insert = "UPDATE users SET
                            verificacao_two_fac = ? 
                            WHERE id = ?
                       ";

            $sql_query = $this->conn->prepare($sql_insert);

            $sql_query->bindParam(1,$status_from_db,PDO::PARAM_INT);
            $sql_query->bindParam(2,$user_id,PDO::PARAM_INT);


            if($sql_query->execute()){

                $msg     = 'ok';

                $retorno = [
                    'status' => $status,
                    'msg'    => $msg
                ];
            }
        } catch (Exception $e) {
            $status = 400;
            $retorno = [
                'status' => $status,
                'msg'    => $e->getMessage(),
            ];
            
        }finally{
            return $retorno;
        }
    }
    public function desativar_verificacao_dois_fatores($user_id){

        $retorno        = [];
        $status         = 200;
        $msg            = '';
        $status_from_db = null;

        try {
            $sql_insert = "UPDATE users SET
                            verificacao_two_fac = ? 
                            WHERE id = ?
                       ";

            $sql_query = $this->conn->prepare($sql_insert);

            $sql_query->bindParam(1,$status_from_db,PDO::PARAM_INT);
            $sql_query->bindParam(2,$user_id,PDO::PARAM_INT);


            if($sql_query->execute()){
                $msg     = 'ok';

                $retorno = [
                    'status' => $status,
                    'msg'    => $msg
                ];
            }
        } catch (Exception $e) {
            $status = 400;
            $retorno = [
                'status' => $status,
                'msg'    => $e->getMessage(),
            ];
            
        }finally{
            return $retorno;
        }
    }

}