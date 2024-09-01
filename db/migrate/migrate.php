<?php

$migrationsPath = __DIR__ . '/migrations';

function includeMigrations($path) {
    if (!is_dir($path)) {
        echo "Diretório de migrations não encontrado: $path\n";
        return;
    }
    
    $files = glob($path . '/*.php');
    
    if (empty($files)) {
        echo "Nenhuma migration encontrada em $path.\n";
        return;
    }
    
    foreach ($files as $file) {
        include_once $file;
    }
}

function runMigrations() {
    global $migrationsPath;
    
    includeMigrations($migrationsPath);
    
    $userFunctions = get_defined_functions()['user'];
    
    foreach ($userFunctions as $function) {
        if (strpos($function, 'migrate_') === 0) {
            try {
                call_user_func($function);
                echo "Executed $function successfully.\n";
            } catch (Exception $e) {
                echo "Failed to execute $function: " . $e->getMessage() . "\n";
            }
        }
    }
}

runMigrations();

echo "Migrations executadas com sucesso.\n";
