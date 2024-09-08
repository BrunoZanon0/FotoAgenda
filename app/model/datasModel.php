<?php 

include_once __DIR__ . "/../../db/connect/connect.php";

class DatasModel{
    public $conn;
    public $table;
    public function __construct() {

        $pdo        = new Connect();
        $this->conn = $pdo->getConnection();
        $this->table= 'data_disponivel';

    }

    public function get_all_date($id){
        $status = 'ativo';

        $sql_get_all    = "SELECT * FROM $this->table WHERE user_id = ? AND status = ? group by data_disponivel";
        $stmt           = $this->conn->prepare($sql_get_all);
        $stmt->bindParam(1,$id,PDO::PARAM_INT);
        $stmt->bindParam(2,$status,PDO::PARAM_STR);

        $result = [];

        if($stmt->execute()){
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        }

        return $result;
    }

    public function get_one_date($data,$user_id){
        $status = 'ativo';

        $sql_select_one = "SELECT * FROM $this->table WHERE data_disponivel = ? AND user_id =? AND status =? ORDER BY hora_disponivel asc";
        $stmt = $this->conn->prepare($sql_select_one);
        $stmt->bindParam(1,$data,PDO::PARAM_STR);
        $stmt->bindParam(2,$user_id,PDO::PARAM_INT);
        $stmt->bindParam(3,$status,PDO::PARAM_STR);

        $result = [];

        if($stmt->execute()){
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        }

        return $result;
    }

    public function delete_one_hour($data_id){

        $status = 'desativado';

        $sql_select_one = "UPDATE $this->table SET status = ? WHERE id=?";
        $stmt = $this->conn->prepare($sql_select_one);
        $stmt->bindParam(1,$status,PDO::PARAM_STR);
        $stmt->bindParam(2,$data_id,PDO::PARAM_INT);

        $result = false;

        if($stmt->execute()){
            $result = true;
        }

        return $result;
    }

    public function new_date($dados = []){

        $retorno = [];
        $status  = 200;
        $msg     = '';

        try {
            $sql_insert = "INSERT INTO $this->table
                        (
                            user_id,
                            data_disponivel,
                            hora_disponivel,
                            status
                        )
                        VALUES
                        (
                            ?,?,?,?
                        )";

            $sql_query = $this->conn->prepare($sql_insert);

            $sql_query->bindParam(1,$dados['user_id'],PDO::PARAM_STR);
            $sql_query->bindParam(2,$dados['data_disponivel'],PDO::PARAM_STR);
            $sql_query->bindParam(3,$dados['hora_disponivel'],PDO::PARAM_STR);
            $sql_query->bindParam(4,$dados['status'],PDO::PARAM_STR);

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