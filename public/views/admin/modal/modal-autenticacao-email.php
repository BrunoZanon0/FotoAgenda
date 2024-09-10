<div class="modal fade" id="mostra_modal_autenticacao" role="dialog" aria-labelledby="mostra_modal_autenticacaoLabel" aria-hidden="true" data-keyboard="false" data-backdrop="static">
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
    <form class="formulario_credenciais" method="POST">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="mostra_modal_autenticacaoLabel">

                <button type="button" class="btn btn-dark botao_retorno d-none">
                    <i class="bi bi-arrow-left"></i>
                </button>
                <i class="bi bi-key"></i>
                  Autenticação Two-fac Email</h5>

            <button type="button" class="close close_modal_autentication">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <h5 class="btn btn-info" type="button"> Mercado Pago</h5>
          <div class="page-wrapper">
            <div class="page-content">
                <div class="card protected_page">
                    <div class="card-body">
                        <div class="md-3">
                            <div class="row">
                                <div class="col-12">
                                    <input type="text" name='email_api_verifica' disabled value="<?= $auth['email'] ?>" class="form-control text-center email_api_verifica">
                                </div>
                            </div>
                        </div>
                        <br>
                        <div class="md-3">
                            <div class="row">
                                <div class="col-12 email_codigo">

                                </div>
                            </div>
                        </div>
                        <br>
                          <h6 class="text-center">Será enviado um token de validação para seu email!</h6>

                        <div class="md-3">
                            <div class="row">
                                <div class="col-12 text-end">
                                    <button type="button" class="btn btn-info botao_finalizar"><i class="bi bi-check2-square"></i>  Enviar</button>
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

    let target_modal      = $("#mostra_modal_autenticacao");
    let botao_return      = $('.botao_retorno');
    let botao_finalizar   = $('.botao_finalizar');
    let id_usuario        = '<?= $auth['id']; ?>'
    let email             = "<?= $auth['email']?>"

    $('.close_modal_autentication').on('click',function(){
        target_modal.modal("hide");
    })
    
    botao_finalizar.on('click',function(){
        if(!email){
            Swal.fire('Erro','Email não encontrado','error');
            return;
        }

        Swal.fire({
            title: "Deseja continuar?",
            text: "Uma chave será enviada para seu email!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Sim"
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url:"app/ajax/api/enviar-email-verifica-t2f.php",
                    method:"POST",
                    data:{
                        'email': email,
                        'user_id':id_usuario
                    },
                        success:function(response){
                            console.log(response);
                        },
                        error:function(error){
                            console.log(error);
                        }
                });
            }else{
                Swal.fire('Ação desfeita','Ação cancelada com sucesso!','info')
            }
        });

    })

    $(document).on("start_modal_autenticacao", function(){
        target_modal.modal("show");

    });


</script>