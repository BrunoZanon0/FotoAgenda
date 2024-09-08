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
    .imagem {
        overflow: hidden;
        overflow-y: hidden;
        max-width: auto; 
        text-align: center;
    }

    .container{
        width: 100%;
        position: absolute;

        left: 50%;
        top: 50%;

        transform: translate(-50%,-50%);

        max-width: 700px;
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
    <div class="container card ">
        <div class="row justify-content-center w-100">
            <div class="col-md-10  justify-content-center align-items-center">
                <form id="myForm"  method="post" action="login" class=" p-3 mb-3 form-container" >
                    <br>
                    <h4 class="font-weight-light text-center">Login</h4>
                    <br>
                    <h6 class="font-weight-light text-center">Bem vind(a) Fotógrafo(a)</h6>
                    <br>
                    <div class="mb-3">
                        <input class="form-control" required placeholder="Digite seu email" type="email" name="email" id="login">
                    </div>
                    <div class="mb-3">
                        <input class="form-control" required placeholder="Digite sua senha" type="password" name="senha" id="password">
                    </div>
                    <input type="hidden" name="recaptcha_token" id="recaptchaToken">

                    <div class="g-recaptcha m-auto" data-sitekey="6LecXpIpAAAAAKZboCU3lqj-nU2O-AcZ2-GrVxcZ" data-action="login" required></div>
                    <br>
                        <div style="text-align: center;">
                            <input type="submit" class="btn btn-success w-100 btn_logar" value="Entrar"><br><br>
                        </div>
                    <br>
                    <div class="mb-3 text-center">
                        Você é usuario? não?<a href="cadastrarUser">Sign up</a>
                    </div>
                    <div class="text-center font-weight-light">
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
            Swal.fire('Erro','<?= $mensagem_erro?>','error');
        }
    }, 200);

    $(document).ready(function(){
        $('form').submit(function(e){
            e.preventDefault();

            let valida = true;

            if($('input[name=email]').val() == ''){
                Swal.fire('Erro','Email é obrigatório','error');
                valida = false;
                return;
            }

            if($('input[name=senha]').val() == ''){
                Swal.fire('Erro','senha é obrigatório','error');
                valida = false;
                return;
            }

            if(valida) this.submit();
        })
    })
</script>



