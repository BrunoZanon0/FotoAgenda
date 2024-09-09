<?php
if(!$id || !$token){
    header('location: notfound');
}

session_start();
$_SESSION['id']     = $id;
$mensagem_erro      = '';
$mensagem_success   = '';
if(isset($_SESSION['erro'])){
    $mensagem_erro = $_SESSION['erro'];
    session_destroy();
}
if(isset($_SESSION['success'])){
    $mensagem_success = $_SESSION['success'];
    session_destroy();
}

include_once __DIR__. "/../../../app/model/userModel.php";
$busca_user = new User($id);
$auth = $busca_user->Auth();

?>


  <script src="https://sdk.mercadopago.com/js/v2"></script>
  <script>
    const mp = new MercadoPago("TEST-c80d6330-0600-4afb-91b4-1c37d1496c51");
  </script>


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

    .step {
            display: none;
        }
        .step.active {
            display: block;
        }
    
</style>
<body>

    <div class="imagem_background">
    </div>
    <div class="container card p-3">
        <form id="myForm" method="post" action="cadastrarUsuario" class="form-container">
            <h4 class="font-weight-light text-center">Cadastrar dados</h4>
            <br>
            <div class="step step-1 active">
                <div class="mb-3">
                    <input class="form-control valida" value="Fotografo(a): <?= $auth['name'] ?>" disabled type="text" name="name">
                </div>
                <div class="mb-3">
                    <input class="form-control valida" required placeholder="Digite seu email" type="email" name="email" id="login">
                </div>
                <div class="mb-3">
                    <input class="form-control valida" required placeholder="Digite sua senha" type="password" name="senha" id="password">
                </div>
                <div class="mb-3">
                    <input class="form-control valida" required placeholder="Digite sua senha novamente" type="password" name="senha2" id="password2">
                </div>
                <div class="mb-3">
                    <input class="form-control valida" required placeholder="CPF" type="text" name="cpf" id="cpf">
                </div>
                <div class="text-center">
                    <button type="button" class="btn btn-primary" onclick="nextStep()">Próximo</button>
                </div>
            </div>
            <div class="step step-2">
                <div class="mb-3">
                    <select name="tipo_evento" class="form-control select_evento" id="tipo_evento">
                        <option value="#" selected disabled>Selecione</option>
                        <option value="ensaio">Ensaio</option>
                        <option value="festa">Festa</option>
                    </select>
                </div>
                <div class="mb-3">
                    <input class="form-control valida endereco_input" required placeholder="Endereço do evento" type="text" name="endereco" id="endereco">
                </div>
                <div class="mb-3">
                    <input class="form-control valida" required placeholder="Numero da casa de Evento / Sitio / Casa / APT " type="numero_casa" name="numero_casa" id="numero_casa">
                </div>
                <div class="mb-3">
                    <div class="row">
                        <div class="col-12">
                            <input class="form-control cep_search_input"  placeholder="CEP do evento" type="number" name="cep" id="cep">
                        </div>
                        <div class="col-12">
                            <button type="button" class="btn btn-warning search_cep w-100"><i class="bi bi-search"></i></button>
                        </div>
                    </div>
                </div>
                <div class="text-center">
                    <button type="button" class="btn btn-secondary" onclick="prevStep()">Anterior</button>
                    <button type="button" class="btn btn-primary" onclick="nextStep()">Próximo</button>
                </div>
            </div>
            <div class="step step-3">
            <div class="mb-3">
                    <div class="row">
                        <div class="col-12">
                            <h6 class="text-center">Buscar datas disponiveis</h6>
                            <button type="button" class="btn btn-success buscar_data w-100"><i class="bi bi-search"></i></button>
                        </div>
                    </div>
                    <div class="mb-3 horarios_select">
                    </div>
                </div>
                <div class="mb-3">
                    <input class="form-control valida" required placeholder="Valor total" onkeypress="return(moeda(this))" type="text" name="valor_total" id="valor_total">
                </div>
                <div class="mb-3">
                    <input class="form-control" placeholder="Entrada?" onkeypress="return(moeda(this))" type="text" name="valor_entrada" id="valor_entrada">
                </div>
                <div class="mb-3">
                    <input class="form-control card_number"  required placeholder="Card Number" type="text" name="card_number" id="card_number">
                </div>
                <div class="mb-3">
                    <div class="row">
                        <div class="col-6">
                            <input class="form-control"required placeholder="Data EX: 08/27" type="month" name="card_data" id="card_data">
                        </div>
                        <div class="col-6">
                            <input class="form-control" required placeholder="Código EX: 123" maxlength="3" type="text" name="card_cod" id="card_cod">
                        </div>
                    </div>
                </div>
                <div class="mb-3">
                    <input type="checkbox" name="valor_entrada" id="aceite">
                    <label for="aceite">Aceita todos os termos de transição</label>
                </div>
                <input type="hidden" name="recaptcha_token" id="recaptchaToken">
                <div class="g-recaptcha" data-sitekey="6LecXpIpAAAAAKZboCU3lqj-nU2O-AcZ2-GrVxcZ" data-action="login" required></div>
                <br>
                <div class="text-center">
                    <button type="button" class="btn btn-secondary" onclick="prevStep()">Anterior</button>
                    <button type="button" class="btn btn-success btn_enviar">Enviar</button>
                </div>
            </div>
            <br>
            <div class="text-center font-weight-light">
                <h6>Criado por <a class="font-weight-light text-center" href="https://www.zanontech.com.br" target="_blank">zanontech</a></h6>
            </div>
        </form>
    </div>
    <?php include_once __DIR__ . "/../admin/modal/modal-datas-seleciona-cliente.php"; ?>
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
        let data_selecao = '';

        $('.btn_enviar').on('click',function(){
            let inputs = $('.valida');
            let valida = true;
            let horarios = $('input[name=data_escolhida]')

            if(!horarios.length){
                Swal.fire('Erro','É necessário selecionar os horarios');
                return;
            }

            if(!horarios.is(':checked')){
                Swal.fire("Erro",'Algum horário deverá ser marcado!','error');
                return;
            }
            
            inputs.each(function(index, element) {
                let $element = $(element);
                
                if (!$element.val()) {
                    Swal.fire('Erro','Algum campo não foi preenchido','error')
                    valida   = false;
                }

                return valida;
            });


            
            // if(valida){
            //     document.querySelector('#myForm').submit();
            // }
        })

        $('.select_evento').on('change',function(){
            if($(this).val() == 'ensaio'){
                $('.endereco_input').attr('disabled',true)
                $('.cep_search_input').attr('disabled',true)
                $('.endereco_input').val('Estudio fotografico do(a) fotografo(a)')
                $('.cep_search_input').val('000000000')
                $('.search_cep').hide();
            }else{
                $('.endereco_input').attr('disabled',false)
                $('.endereco_input').val('')
                $('.cep_search_input').attr('disabled',false)
                $('.cep_search_input').val('')
                $('.search_cep').show();
            }
        })

        $('.search_cep').on('click',function(){
            
            let cep = $('.cep_search_input').val();

            if(!cep) return Swal.fire('Erro','Cep é obrigatorio para pesquisa','error') 

            $.ajax({
                url:`https://viacep.com.br/ws/${cep}/json/`,
                cache:false,
                    success:function(response){
                        if(response['uf']){
                            let uf          = response['uf'];
                            let logradouro  = response['logradouro'];
                            let regiao      = response['regiao'];
                            
                            $('.endereco_input').val(uf + ' - ' + logradouro + ' / ' + regiao);
                            Swal.fire('Sucesso','Cep encontrado','success')
                        }else{
                            Swal.fire('Erro','CEP não identificado','error')
                            return
                        }
                    },
                    error:function(response){
                        Swal.fire('Erro','CEP não identificado','error')
                        return
                    }
            })
        })

        function card_model(event) {
            const input = event.target; 
            let value = input.value.replace(/\D/g, '');

            if (value.length > 16) {
                value = value.slice(0, 16);
            }

            value = value.replace(/(.{4})/g, '$1 ').trim();

            input.value = value;

            const key = event.which || event.keyCode;
            return (key >= 48 && key <= 57) || key === 32;
        }

        document.getElementById('card_number').addEventListener('input', card_model);
    });

    let currentStep = 0;
    const steps = document.querySelectorAll('.step');

    function showStep(stepIndex) {
        steps.forEach((step, index) => {
            step.classList.toggle('active', index === stepIndex);
        });
        currentStep = stepIndex;
    }

    function nextStep() {
        if (currentStep < steps.length - 1) {
            showStep(currentStep + 1);
        }
    }

    function prevStep() {
        if (currentStep > 0) {
            showStep(currentStep - 1);
        }
    }

    showStep(currentStep);

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

    $('.buscar_data').on('click',function(){
        $(document).trigger('start_modal_valida_datas');
    })

    $(document).on('buscar_data_selecionada',function(){
        target_modal.modal("hide");
        let user_id         = '<?= $auth['id'] ?>'; 
        let divHorarios     = $('.horarios_select');

        divHorarios.html('');

        if(!data_selecao){
            Swal.fire('Erro','Nenhuma data selecionada','error');
            return;
        }

        $.ajax({
            url:'app/ajax/datas/data-do-dia-e-horarios.php',
            method:'POST',
            cache:false,
            data:{
                'dia' : data_selecao
            },
                success:function(response){
                    let data = JSON.parse(response);
                    
                    if(data == false){
                        Swal.fire('Erro','Não há horarios disponiveis para esta data','error')
                    }
                    if(data['status'] == 400){
                        Swal.fire('Erro',data['msg'],'error');
                        return;
                    }else{

                        divHorarios.append(`<br>`);

                        data.forEach(diaInfos => {
                            const [hora, minuto] = diaInfos.hora_disponivel.split(':');
                            divHorarios.append(`
                            <span class='btn btn-success'>
                                    <input required class="form-check-input" type="radio" name="data_escolhida" id="data_id_${diaInfos.id}">
                                <label class="form-check-label" for="data_id_${diaInfos.id}">${hora}:${minuto}</label>
                            </span>
                        `)
                        });
                    }
                },
                error:function(error){
                    console.log(error);
                }
        })
    })

    
</script>