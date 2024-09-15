<div class="modal fade" id="mostra_modal_contrato" role="dialog" aria-labelledby="mostra_modal_contratoLabel" aria-hidden="true" data-keyboard="false" data-backdrop="static">
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
    <form class="formulario_credenciais" method="POST" enctype="multipart/form-data">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="mostra_modal_contratoLabel">

                <button type="button" class="btn btn-dark botao_retorno d-none">
                    <i class="bi bi-arrow-left"></i>
                </button>
                <i class="bi bi-key"></i>
                  Contrato Upload</h5>

            <button type="button" class="close close_modal_contrato">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="page-wrapper">
            <div class="page-content">
                <div class="card protected_page">
                    <div class="card-body">
                        <div class="md-3">
                            <div class="row">
                                <div class="col-12 upload_ativa_input">
                                    <h1 class="text-center cor_icon" style="font-size: 5em;"><i class="bi bi-upload"></i></h1>
                                </div>
                            </div>
                        </div>
                        <br>
                        <input type="text" disabled value="" class="form-control text-center input_nome_arquivo" >
                        <br>
                            <div class="md-3 d-none botao_enviar_contrato">
                                <div class="row">
                                    <div class="col-12 text-center">
                                        <button type="button" class="btn btn-success w-50 botao_enviar_contrato_back">Enviar</button>
                                    </div>
                                </div>
                            </div>
                        <br>
                    </div>
                </div>
            </div>
         </div>
        </div>
    </form>

    <div class="d-none">
        <input type="file" class="ativa_input" name="arquivo_contrato" id="arquivo_contrato">
    </div>
  </div>
</div>

<script>

    $('.close_modal_contrato').on('click',function(){
        target_modal.modal("hide");
    })
    
    $('.upload_ativa_input').on('click',function(){
        $('.ativa_input').trigger('click')
    })

    $('.ativa_input').on('change',function(){
        
        if($(this)[0].files.length > 0){
            $('.input_nome_arquivo').val($(this)[0].files[0].name);
            $('.botao_enviar_contrato').removeClass('d-none')
        }else{
            $('.input_nome_arquivo').val('');
            $('.botao_enviar_contrato').addClass('d-none')
        }
    })

    $('.botao_enviar_contrato_back').on('click',function(){
        let input_pdf   = $('.ativa_input')[0].files[0]
        let user_id     = "<?= $auth['id']?>";
        
        if(input_pdf.type !="application/pdf"){
            Swal.fire('Erro',"Só é permitido PDF's como contrato",'error')
            $('.ativa_input').val('')
            $('.input_nome_arquivo').val('');
            return;
        }

        let formData = new FormData();

        formData.append('user_id',user_id);
        formData.append('input_pdf',input_pdf);

        Swal.fire({
            title: "Deseja continuar?",
            text: "Você irá cadastrar um novo contrato!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Sim"
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url:"app/ajax/contratos/contrato-cadastra-novo-pdf.php",
                            method:"POST",
                            data:formData,
                            processData: false,
                            contentType: false,
                                success:function(response){
                                    console.log(response);
                                    // let data = JSON.parse(response);

                                    // if(data.status == 200){
                                    //     Swal.fire('Sucesso',`${data.msg}`,'success')
                                    //     .then(()=>{
                                    //         window.location.reload();
                                    //     })
                                    // }else{
                                    //     Swal.fire('Erro',`${data.msg}`,'error')
                                    // }
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

    $(document).on("start_modal_contrato", function(){
        $("#mostra_modal_contrato").modal("show");
        target_modal      = $("#mostra_modal_contrato");
        id_usuario        = '<?= $auth['id']; ?>'
        email             = "<?= $auth['email']?>"

    });


</script>