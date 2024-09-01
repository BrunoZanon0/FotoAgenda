<?php 
    if(!isset($auth) || empty($auth)){
        session_start();
        $_SESSION['erro'] = "Você não está logado!";
        header("location: http://localhost:9090/servicos/barbearia/");
        exit();
    }
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agenda Inteligente</title>
</head>
<body>
    
</body>
</html>