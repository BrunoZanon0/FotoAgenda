<?php

include_once __DIR__. "../../../connect/connect.php";

class Migrate_cria_table_contratos {
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
        $table_name = 'contratos';

        if ($this->tableExists($table_name)) {
            echo "A tabela '$table_name' já existe. Pulei a criação.\n";
            return;
        }

        $sql_table = "CREATE TABLE $table_name (
            id INT PRIMARY KEY AUTO_INCREMENT,
            user_id INT,
            status VARCHAR(30),
            nome VARCHAR(250),
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            deleted_at TIMESTAMP NULL DEFAULT NULL,
            FOREIGN KEY (user_id) REFERENCES users(id)   
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

$cria_migrete = new Migrate_cria_table_contratos();
$cria_migrete->cria_table();

?>
