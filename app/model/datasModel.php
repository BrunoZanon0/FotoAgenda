<?php 

include_once __DIR__ . "/../../db/connect/connect.php";

class DatasModel{
    public $conn;
    public $table;
    public function __construct() {

        $pdo        = new Connect();
        $this->conn = $pdo->getConnection();
        $this->table= 'agenda_data';

    }

    public function get_all_date($id){
        $sql_get_all    = "SELECT * FROM $this->table WHERE user_id = ?";
        $stmt           = $this->conn->prepare($sql_get_all);
        $stmt->bindParam(1,$id,PDO::PARAM_INT);

        $result = [];
        if($stmt->execute()){
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
        }

        return $result;
    }

    public function get_one_date($data,$user_id){

        $sql_select_one = "SELECT * FROM $this->table WHERE data = ? AND user_id =? ";
        $stmt = $this->conn->prepare($sql_select_one);
        $stmt->bindParam(1,$data,PDO::PARAM_STR);
        $stmt->bindParam(2,$user_id,PDO::PARAM_INT);

        $result = [];

        if($stmt->execute()){
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
        }

        return $result;
    }

    public function new_date($dados){
        $sql_insert = "INSERT INTO
                    (
                        name,
                        user_id,
                        descricao,
                        data_evento,
                        assinatura,
                        user_assinatura,
                        email,
                        pago,
                        valor_total,
                        entrada,
                        celular	
                    )
                    VALUES
                    (
                        $dados[1]
                    )";
    }

}