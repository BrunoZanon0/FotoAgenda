<?php 
session_start();

$mensagem_erro = '';

if(isset($_SESSION['erro'])){
    $mensagem_erro = $_SESSION['erro'];
    session_destroy();
}
?>


<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Foto Agenda</title>
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
        width: 100%;
        position: absolute;

        left: 50%;
        top: 50%;

        transform: translate(-50%,-50%);

        border-radius: 20px 20px 40px 20px;
    }
    
</style>
<body>
    <br>
    <div class="container card">
        <div class="row justify-content-center w-100">
            <div class="col-md-6  imagem p-3">
                <img src="public/src/img/imagemFundo.jpg"  alt="">
            </div>
            <div class="col-md-6  justify-content-center align-items-center">
                <form id="myForm"  method="post" action="login" class=" p-3 mb-3 form-container" >
                    <h6 class="font-weight-light text-center">Bem vind(a) Fotógrafo(a)</h6>
                    <br>
                    <div class="mb-3">
                        <input class="form-control" placeholder="Digite seu email" type="email" name="email" id="login">
                    </div>
                    <div class="mb-3">
                        <input class="form-control" placeholder="Digite sua senha" type="password" name="senha" id="password">
                    </div>
                    <input type="hidden" name="recaptcha_token" id="recaptchaToken">

                    <div class="g-recaptcha m-auto" data-sitekey="6LecXpIpAAAAAKZboCU3lqj-nU2O-AcZ2-GrVxcZ" data-action="login" required></div>
                    <br>
                        <div style="text-align: center;">
                            <input type="submit" class="btn btn-success w-100" value="Entrar"><br><br>
                        </div>
                    <br>
                    <div>
                        
                    </div>
                    <div class="text-end font-weight-light">
                        <h6>Criado por <a class="font-weight-light text-center" href="https://www.zanontech.com.br" target="_blank">zanontech</a></h6>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>
</html>

<script>
    setTimeout(() => {
        if(<?= json_encode($mensagem_erro)?>){
            swal('Erro','<?= $mensagem_erro?>','error');
        }
    }, 200);
    $(document).ready(function(){
        $("#myForm").fadeIn(1000);
    });
</script>



