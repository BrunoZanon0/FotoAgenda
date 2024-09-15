<div class="modal fade" id="modal_mostra_credenciais" role="dialog" aria-labelledby="modal_mostra_credenciaisLabel" aria-hidden="true" data-keyboard="false" data-backdrop="static">
<link href='https://cdn.jsdelivr.net/npm/fullcalendar@5.10.2/main.min.css' rel='stylesheet' />
<script src='https://cdn.jsdelivr.net/npm/fullcalendar@5.10.2/main.min.js'></script>
<script src='https://cdn.jsdelivr.net/npm/fullcalendar@5.10.2/locales/pt-br.js'></script>
<style>
        .inputs {
            display: flex;
            align-items: center;
        }
        .inputs input {
            margin-right: 10px; 
        }
    </style>
  <div class="modal-dialog modal-lg " role="document">
    <form action="atualizaChaveApi" class="formulario_credenciais" method="POST">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="modal_mostra_credenciaisLabel">

                <button type="button" class="btn btn-dark botao_retorno d-none">
                    <i class="bi bi-arrow-left"></i>
                </button>
                <i class="bi bi-key"></i>
                 Credencias</h5>

            <button type="button" class="close close_modal_agenda">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>


          <div class="page-wrapper">
            <div class="page-content">
                <div class="card protected_page ">
                    <div class="card-body">
                        <div class="md-3 text-center">
                            <div class="form-check form-switch">
                                <input class="form-check-input input_checkbox" type="checkbox" id="flexSwitchCheckChecked" >
                            </div>
                        </div>
                    </div>
                    <div class="card-body card_body_tokens d-none">
                    <h5 class="btn btn-info w-100" type="button"> Mercado Pago</h5>
                    <h6 class="text-center">Fique atento com relação aos campos</h6>
                        <?php if($auth['permissao'] == 'admin'): ?>
                            <div class="md-3">
                                <div class="row">
                                    <div class="col-12">
                                        <select name="tipo" id="tipo" class="form-control text-center">
                                            <option value="producao">Produção</option>
                                            <option value="teste">Teste</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        <br> 
                        <?php endif?>
                        <div class="md-3">
                            <div class="row">
                                <div class="col-12">
                                    <input type="text" name='token_api_access' placeholder="API TOKEN ACCESS" class="form-control text-center token_api_access">
                                </div>
                            </div>
                        </div>
                        <br>
                        <div class="md-3">
                            <div class="row">
                                <div class="col-12">
                                    <input type="text" name='token_api_public' placeholder="API PUBLIC API" class="form-control text-center token_api_public">
                                </div>
                            </div>
                        </div>
                        <br>

                        <h6 class="text-center">Outros bancos estaram disponiveis nas proximas atualizações do sistema</h6>

                        <div class="md-3">
                            <div class="row">
                                <div class="col-12 text-end">
                                    <button type="button" class="btn btn-success botao_finalizar"><i class="bi bi-check2-square"></i> Registrar</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
         </div>
        </div>
    </form>
  </div>
</div>

<script>

  
    $('.close_modal_agenda').on('click',function(){
        $("#modal_mostra_credenciais").modal("hide");
    })

    $('.input_checkbox').on('click',function(){
        let checkbox    = $(this).is(':checked')
        let id_usuario  = '<?= $auth['id']; ?>'
        
        if(checkbox){
            $.ajax({
            url:"app/ajax/api/user-ativar-pagamento_online.php",
            method:"POST",
            data:{
                'user_id':id_usuario,
            },
            cache:false,
                success:function(response){

                    let data = JSON.parse(response);

                    if(data.status == 200){
                        $('.card_body_tokens').removeClass('d-none')
                    }else{
                        console.log(data.msg)
                    }
                },
                error:function(error){
                    console.log(error);
                }
            })

        }else{
            $.ajax({
            url:"app/ajax/api/user-desativar-pagamento_online.php",
            method:"POST",
            data:{
                'user_id':id_usuario,
            },
            cache:false,
                success:function(response){

                    let data = JSON.parse(response);

                    if(data.status == 200){
                        $('.card_body_tokens').addClass('d-none')
                    }else{
                        console.log(data.msg)
                    }

                },
                error:function(error){
                    console.log(error);
                }
            })
        }
    })

    $('.botao_finalizar').on('click',function(){
        let token_access        = $('.token_api_access');
        let token_public        = $('.token_api_public');
        let formulario          = $('.formulario_credenciais');


        if(!token_access.val()){
            Swal.fire('Erro','Token de acesso não idenficado!','error');
            return;
        }

        if(!token_public.val()){
            Swal.fire('Erro','Token publico não idenficado!','error');
            return;
        }

        Swal.fire({
            title: "Deseja continuar?",
            text: "Deseja atualizar as chaves de acesso?",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Sim"
        }).then((result) => {
            if (result.isConfirmed) {
                formulario.submit();
            }else{
                Swal.fire('Ação desfeita','Ação cancelada com sucesso!','info')
            }
        });
        
    })

    $(document).on("start_modal_credenciais", function(){
        $("#modal_mostra_credenciais").modal("show");
        let id_usuario          = '<?= $auth['id']; ?>'
        let pagamento_online    = '<?= $auth['pagamento_online']; ?>'

        if(pagamento_online){
            $('.input_checkbox').attr('checked',true)
            $('.card_body_tokens').removeClass('d-none')
        }else{
            $('.input_checkbox').attr('checked',false)
        }

        $.ajax({
            url:"app/ajax/api/busca-credenciais-tokens.php",
            method:"POST",
            data:{'user_id':id_usuario},
            cache:false,
                success:function(response){

                    let data = JSON.parse(response);

                    if(data.id){
                        $('.token_api_access').val(data.token_api_acess);
                        $('.token_api_public').val(data.token_public_key);
                    }else{
                        Swal.fire('Não encontrado','Tokens não encontrados anteriormente','warning');
                    }
                },
                error:function(error){
                    console.log(error);
                }
        })
    });


</script>