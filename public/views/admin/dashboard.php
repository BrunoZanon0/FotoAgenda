<?php 
    if(!isset($auth) || empty($auth)){
        session_start();
        $_SESSION['erro'] = "Você não está logado!";
        header("location: http://localhost:9090/servicos/FotoAgendaDev/FotoAgenda/");
        exit();
    }
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
</head>

<body>
    
    <div class="page-wrapper">
        <div class="page-content">
					
            <div class="card protected_page">
                <?php include_once __DIR__ . "/../../layouts/menu.php"; ?>
                <div class="card-body">
                </div>
            </div>
        </div>
    </div>
</body>
</html>