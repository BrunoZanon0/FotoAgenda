<?php

class Connect {
    private $pdo;

    public function __construct() {
        $this->loadEnv(__DIR__ . '/../.env');
        $this->connect();
    }

    private function loadEnv($filePath) {
        if (!file_exists($filePath)) {
            throw new Exception("Arquivo .env não encontrado.");
        }

        $lines = file($filePath, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
        foreach ($lines as $line) {
            if (strpos(trim($line), '#') === 0 || strpos($line, '=') === false) {
                continue;
            }

            list($key, $value) = explode('=', $line, 2);
            $key = trim($key);
            $value = trim($value);

            $_ENV[$key] = $value;
            putenv("$key=$value");
        }
    }

    private function connect() {
        try {
            $dsn = "mysql:host=" . getenv('DB_HOST') . ";dbname=" . getenv('DB_DATABASE');
            $this->pdo = new PDO($dsn, getenv('DB_USERNAME'), getenv('DB_PASSWORD'));
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            
            $stmt = $this->pdo->query('SELECT 1');
            if ($stmt === false) {
                throw new Exception("Erro ao executar a consulta de teste.");
            }

        } catch (PDOException $e) {
            throw new Exception("Falha na conexão: " . $e->getMessage());
        }
    }

    public function getConnection() {
        return $this->pdo;
    }
}

?>
