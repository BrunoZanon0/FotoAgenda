<?php 
session_start();
$mensagem_erro      = '';
$mensagem_success   = '';
if(isset($_SESSION['erro'])){
    $mensagem_erro = $_SESSION['erro'];
}
if(isset($_SESSION['success'])){
    $mensagem_success = $_SESSION['success'];
}
session_destroy();

?>


<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Foto Agenda Cadastro</title>
    <script src="https://www.google.com/recaptcha/enterprise.js?render=6LfLuo0pAAAAAPEuodg_ib89N1-oHVP-9TMJFJhF"></script>

</head>
<style>
    body{
        background-image: linear-gradient(45deg ,white,pink, purple);
    }
    .imagem {
        overflow: hidden;
        overflow-y: hidden;
        max-width: auto; 
        text-align: center;
    }

    .imagem > img {
        width: 100%; 
        height: 100%;
        display: block;
        border-radius: 10px 20px 20px 10px;
    }

    .container{
        max-width: 700px;

        width: 100%;
        position: absolute;

        left: 50%;
        top: 50%;

        transform: translate(-50%,-50%);
    }
    .imagem_background{
        width: 100%;
        height: 100%;
        background-image: url("public/src/img/wallpaper.jpg");

        background-size: cover;
    }
    
</style>
<body>

    <div class="imagem_background">
    </div>
    <div class="container card p-1">
            <div class="w-100 justify-content-center align-items-center">
                <form id="myForm"  method="post" action="cadastrarUsuario" class=" p-3 mb-3 form-container" >
                    <div class="text-end">
                        <a href="login" class="btn btn-dark"><i class="bi bi-arrow-left"></i></a>
                    </div>
                    <h4 class="font-weight-light text-center">Cadastrar</h4>
                    <br>
                    <h6 class="font-weight-light text-center">Bem vind(a) Cliente</h6>
                    <br>
                    <div class="mb-3">
                        <input class="form-control" placeholder="Digite seu email" type="email" name="email" id="login">
                    </div>
                    <div class="mb-3">
                        <input class="form-control" placeholder="Digite sua senha" type="password" name="senha" id="password">
                    </div>
                    <div class="mb-3">
                        <input class="form-control" placeholder="Digite sua senha novamente" type="password" name="senha2" id="password">
                    </div>
                    <div class="mb-3">
                        <input class="form-control" placeholder="Celular ex: 21 9 1234 5678" type="number" name="celular" id="celular">
                    </div>
                    <div class="mb-3">
                        <input class="form-control" placeholder="Nome pessoal completo" type="text" name="nome" id="nome">
                    </div>
                    <div class="mb-3">
                        <input class="form-control" placeholder="Nome da empresa" type="text" name="nomefantasia" id="nomefantasia">
                    </div>

                    <input type="hidden" name="recaptcha_token" id="recaptchaToken">

                    <div class="g-recaptcha m-auto" data-sitekey="6LecXpIpAAAAAKZboCU3lqj-nU2O-AcZ2-GrVxcZ" data-action="login" required></div>
                    <br>
                        <div style="text-align: center;">
                            <input type="submit" class="btn btn-success w-100" value="Entrar"><br><br>
                        </div>

                    <div class="text-center font-weight-light">
                        <h6>Criado por <a class="font-weight-light text-center" href="https://www.zanontech.com.br" target="_blank">zanontech</a></h6>
                    </div>
                </form>
            </div>
    </div>
</body>
</html>

<script>
        if(<?= json_encode($mensagem_erro)?>){
            Swal.fire('Erro','<?= $mensagem_erro?>','error');
        }
        if(<?= json_encode($mensagem_success)?>){
            Swal.fire("Sucess",'<?= $mensagem_success ?>' ,'success')
        }
        
    $(document).ready(function(){
        $("#myForm").fadeIn(1000);
    });
</script>



