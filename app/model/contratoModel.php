<?php 

date_default_timezone_set('America/Fortaleza');

include_once __DIR__ . "/../../db/connect/connect.php";

class ContratoModel{
    public $conn;
    public $table;
    public function __construct() {

        $pdo            = new Connect();
        $this->conn     = $pdo->getConnection();
        $this->table    = 'contratos';

    }

    public function upload_arquivo($arquivo = []){

        $remove_all = $this->remove_all_contracts($arquivo['user_id']);

        if($remove_all['status'] == 200){
            $sql_insert_contrato = "INSERT INTO $this->table 
                        (
                            user_id,
                            status,
                            nome
                        ) VALUES (
                            ?,?,?
                        )";

            $stmt = $this->conn->prepare($sql_insert_contrato);

            $stmt->bindParam(1,$arquivo['user_id'],PDO::PARAM_INT);
            $stmt->bindParam(2,$arquivo['status'],PDO::PARAM_STR);
            $stmt->bindParam(3,$arquivo['nome'],PDO::PARAM_STR);

            if($stmt->execute()){
                $retorno = [
                    'status' => 200,
                    'msg'    => 'cadastrou'
                ];
            }else{
                $retorno = [
                    'status' => 400,
                    'msg'    => $stmt->errorInfo()
                ];
            }

            return $retorno;
        }
    }

    public function get_one_contract($user_id){
        
        $status = 'ativo';
        $sql_contract = "SELECT * FROM $this->table WHERE user_id = ? AND status = ?";
        $sql_query    = $this->conn->prepare($sql_contract);

        $sql_query->bindParam(1,$user_id,PDO::PARAM_INT);
        $sql_query->bindParam(2,$status,PDO::PARAM_STR);

        $result = [];

        if($sql_query->execute()){
            $result = $sql_query->fetchAll(PDO::FETCH_ASSOC);
        }

        return $result;
    }

    public function remove_all_contracts($user_id){

        $retorno        = [];
        $status         = 200;
        $msg            = '';
        $status_from_db = 'desativado';
        $status_by_db   = 'ativo';
        $now            = (new DateTime())->format('Y-m-d H:i:s');
        try {
            $sql_insert = "UPDATE $this->table SET
                            status = ? ,
                            deleted_at = ?
                            WHERE user_id = ? and status = ?
                       ";

            $sql_query = $this->conn->prepare($sql_insert);

            $sql_query->bindParam(1,$status_from_db,PDO::PARAM_STR);
            $sql_query->bindParam(2,$now,PDO::PARAM_STR);
            $sql_query->bindParam(3,$user_id,PDO::PARAM_INT);
            $sql_query->bindParam(4,$status_by_db,PDO::PARAM_STR);


            if($sql_query->execute()){
                $msg     = 'ok';

                $retorno = [
                    'status' => $status,
                    'msg'    => $msg
                ];
            }else{
                $msg = $sql_query->errorInfo();
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