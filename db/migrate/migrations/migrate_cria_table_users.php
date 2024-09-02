<?php

include_once __DIR__. "../../../connect/connect.php";

class Migrate_cria_table_users {
    public $conn;

    public function __construct() {
        $pdo = new Connect();
        $this->conn = $pdo->getConnection();
    }

    public function tableExists($tableName) {
        $query = $this->conn->prepare("SHOW TABLES LIKE :table_name");
        $query->bindParam(':table_name', $tableName);
        $query->execute();
        return $query->rowCount() > 0;
    }

    public function cria_table() {
        $table_name = 'users';

        if ($this->tableExists($table_name)) {
            echo "A tabela '$table_name' já existe. Pulei a criação.\n";
            return;
        }

        $sql_table = "CREATE TABLE $table_name (
            id INT PRIMARY KEY AUTO_INCREMENT,
            id_key INT,
            permissao VARCHAR(30),
            name VARCHAR(50),
            email VARCHAR(100),
            password VARCHAR(250),
            token VARCHAR(30),
            fotografo INT,
            verificacao_two_fac INT,
            celular VARCHAR(30),
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            deleted_at TIMESTAMP NULL DEFAULT NULL
        )";

        try {
            $sql_query = $this->conn->prepare($sql_table);
            if ($sql_query->execute()) {
                echo "Migrate realizada com sucesso!\n";
            } else {
                echo "Migrate não realizada.\n";
            }
        } catch (Exception $e) {
            echo 'Erro: ' . $e->getMessage() . "\n";
        }
    }
}

$cria_migrete = new Migrate_cria_table_users();
$cria_migrete->cria_table();

?>
