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
        max-width: 50em;
    }
</style>
<body>
    <div class="page-wrapper">
        <div class="page-content">
					
            <div class="card protected_page">
                <?php include_once __DIR__ . "/../../../layouts/menu.php"; ?>
                <div class="card-body">
                    <div class="w-100 justify-content-center align-items-center">
                        <form id="myForm"  method="post" action="cadastrardata" class=" p-3 mb-3 form-container mw-50 m-auto" >
                            <h6 class="text-center white">
                                <button style="color: white;" type="button" class="btn btn-info">
                                    <i class="bi bi-calendar4"></i>  
                                    <?= $data_convertida ?>
                                </button>
                            </h6>
                            <?php if($datas_from_front && !empty($datas_from_front)):?>
                                <div class="mb-3"
                                    style="position: fixed; right:10px; bottom:10px">
                                    <button type="button" class="btn btn-info botao_mostrar_compromissos" style="color:white">Todas os compromissos <i class="bi bi-box-arrow-in-down"></i></button>
                                </div>
                                <table class="w-100 tabela_dos_compromissos table table-info d-none">
                                        <tr>
                                            <th class="col">#</th>
                                            <th class="col">Evento</th>
                                            <th class="col">Descricao</th>
                                            <th class="col">Cliente</th>
                                            <th class="col">Total</th>
                                            <th class="col">Entrada</th>
                                            <th class="col">Pago?</th>
                                        </tr>
                                    <?php foreach($datas_from_front as $datas_info):?>
                                        <tr>
                                            <td scope="row"><?= $contador++; ?> </td>
                                            <td scope="row"><?= $datas_info['name']?></td>
                                            <td scope="row"><?= $datas_info['descricao']?></td>
                                            <td scope="row"><?= $datas_info['email']?></td>
                                            <td scope="row"><?= $datas_info['valor_total']?></td>
                                            <td scope="row"><?= $datas_info['entrada']?></td>
                                            <td scope="row"><?= $datas_info['pago'] == null? 'Não' : 'Sim' ?></td>
                                        </tr>
                                    <?php endforeach ?>
                                </table>
                            <?php endif?>
                            <br>
                            <div class="mb-3">
                                <input required class="form-control" value="<?= $data_convertida ?>" disabled type="text">
                            </div>
                            <div class="mb-3">
                                <input type="hidden" name="data_evento" value="<?= $data_convertida ?>">
                            </div>
                            <div class="mb-3">
                                <input required class="form-control" placeholder="Nome do evento"  type="text" name="nome" id="nome">
                            </div>

                            <div class="mb-3">
                                <input required class="form-control" placeholder="Email do cliente"  type="email" name="emailCliente" id="emailCliente">
                            </div>

                            <div class="mb-3">
                                <input required class="form-control" placeholder="Numero de celular do cliente"  type="number" name="numeroCliente" id="numeroCliente">
                            </div>

                            <div class="mb-3">
                                <input required class="form-control" placeholder="Hora do evento"  type="time" name="hora" id="hora">
                            </div>

                            <div class="mb-3">
                                <input required class="form-control" placeholder="Descricao"  type="text" name="descricao" id="descricao">
                            </div>
                            <div class="mb-3">
                                <input required class="form-control" placeholder="Valor total" 																			
                                onkeypress="return(moeda(this))"  
                                type="text" 
                                name="total" 
                                id="total">
                            </div>
                            <div class="mb-3">
                                <input class="form-control" placeholder="Valor Entrada, caso nao tenho, deixar em branco" 																			
                                onkeypress="return(moeda(this))"  
                                type="text" 
                                name="valor_entrada" 
                                id="valor_entrada">
                            </div>
                            <div class="form-check form-switch mb-3">
                                <input class="form-check-input" type="checkbox" role="switch" id="id_checkbox_assinatura">
                                <label class="form-check-label" for="id_checkbox_assinatura">Marque para o usuario assinar o contrato</label>
                            </div>
                            <div class="mb-3 d-none assinatura">
                                <input required type="text" placeholder="Nome do cliente que irá assinar o contrato!" name="nome_assinatura_cliente" class="form-control">
                            </div>
                            <div class="form-check mb-3">
                                <input required class="form-check-input" type="checkbox" value="" id="flexCheckDefault">
                                <label class="form-check-label" for="flexCheckDefault">
                                    Aceito os <a href="">Termos de uso</a>
                                </label>
                            </div>
                            <div class="mb-3">
                                <button type="submit" class="btn btn-success"><i class="bi bi-calendar-check-fill"></i>  Cadastrar</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

<script>

    $(document).ready(function() {
        $('.botao_mostrar_compromissos').on('click',function(){
            let tabela = $('.tabela_dos_compromissos');

            tabela.toggleClass('d-none');

            if (tabela.hasClass('d-none')) {
                $(this).html('Todas os compromissos <i class="bi bi-box-arrow-in-down"></i>');
            } else {
                $(this).html('Ocultar compromissos <i class="bi bi-box-arrow-in-up"></i>');
            }
        })
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