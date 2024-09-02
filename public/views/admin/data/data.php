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
    <link href='https://cdn.jsdelivr.net/npm/fullcalendar@5.10.2/main.min.css' rel='stylesheet' />
    <script src='https://cdn.jsdelivr.net/npm/fullcalendar@5.10.2/main.min.js'></script>
    <script src='https://cdn.jsdelivr.net/npm/fullcalendar@5.10.2/locales/pt-br.js'></script>
    <title>Agenda Inteligente</title>
</head>
<style>
    .form-container{
        max-width: 40em;
    }
</style>
<body>
    <div class="page-wrapper">
        <div class="page-content">
					
            <div class="card">
                <?php include_once __DIR__ . "/../../../layouts/menu.php"; ?>
                <div class="card-body">
                    <div class="w-100 justify-content-center align-items-center">
                        <form id="myForm"  method="post" action="#" class=" p-3 mb-3 form-container mw-50 m-auto" >
                            <h6 class="text-center white">
                                <button style="color: white;" type="button" class="btn btn-info">
                                    <i class="bi bi-calendar4"></i>  
                                    <?= $data_convertida ?>
                                </button>
                            </h6>
                            <br>
                            <div class="mb-3">
                                <input class="form-control" value="<?= $data_convertida ?>" disabled type="text" name="data" id="data">
                            </div>

                            <div class="mb-3">
                                <input class="form-control" placeholder="Nome do evento"  type="text" name="nome" id="nome">
                            </div>

                            <div class="mb-3">
                                <input class="form-control" placeholder="Descricao"  type="text" name="descricao" id="descricao">
                            </div>
                            <div class="mb-3">
                                <input class="form-control" placeholder="Valor total" 																			
                                onkeypress="return(moeda(this))"  
                                type="text" 
                                name="total" 
                                id="total">
                            </div>
                            <div class="mb-3">
                                <input class="form-control" placeholder="Valor Entrada, caso nao tenho, deixar em branco" 																			
                                onkeypress="return(moeda(this))"  
                                type="text" 
                                name="total" 
                                id="total">
                            </div>
                            <div class="form-check form-switch mb-3">
                                <input class="form-check-input" type="checkbox" role="switch" id="id_checkbox_assinatura">
                                <label class="form-check-label" for="id_checkbox_assinatura">Marque para o usuario assinar o contrato</label>
                            </div>
                            <div class="mb-3 d-none assinatura">
                                <input type="text" placeholder="Nome do cliente que irá assinar o contrato!" name="nome_assinatura_cliente" class="form-control">
                            </div>
                            <div class="form-check mb-3">
                                <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault">
                                <label class="form-check-label" for="flexCheckDefault">
                                    Default checkbox
                                </label>
                            </div>
                            <div class="mb-3">
                                <button class="btn btn-success"><i class="bi bi-calendar-check-fill"></i>  Cadastrar</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

<script>
    function moeda(campo) {
        let valor = campo.value.replace(/\D/g, '');

        if (valor.length > 2) {
            valor = valor.replace(/(\d)(\d{1})$/, '$1,$2'); 
            valor = valor.replace(/\B(?=(\d{3})+(?!\d))/g, '.'); 
        } else {
            valor = valor.replace(/(\d{1,2})$/, '$1'); 
        }

        campo.value = valor ? `${valor}` : '';
    }

    $(document).ready(function() {
            $('#id_checkbox_assinatura').on('change', function() {
                if ($(this).is(':checked')) {
                    $('.assinatura').removeClass('d-none').addClass('d-block');
                } else {
                    $('.assinatura input').val('');
                    $('.assinatura').removeClass('d-block').addClass('d-none');
                }
            });
        });
</script>
</html>