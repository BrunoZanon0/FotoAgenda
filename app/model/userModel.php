<?php

include_once __DIR__ . "/../../db/connect/connect.php";
class User{

    public $conn;
    public $table;
    public $id;

    public function __construct($id = null) {
        $pdo        = new Connect();
        $conn       = $pdo->getConnection();
        $this->conn = $conn;
        $this->table= 'users';

        if($id) $this->id = $id;
    }

    public function get_all_by_email($email_user){

        $user_email = trim($email_user);

        $sql_select = "SELECT * FROM $this->table WHERE email = ? limit 1";
        $stmt       = $this->conn->prepare($sql_select);
        
        $stmt->bindParam(1,$user_email,PDO::PARAM_STR);
        
        if($stmt->execute()){
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
        }else{
            $result = null;
        }

        return $result;
    }

    public function Auth(){

        $id_user = intval($this->id);

        $sql_select = "SELECT * FROM $this->table WHERE id = ? limit 1";
        $stmt       = $this->conn->prepare($sql_select);
        
        $stmt->bindParam(1,$id_user,PDO::PARAM_INT);
        
        if($stmt->execute()){
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
        }else{
            $result = null;
        }

        return $result;
    }

}