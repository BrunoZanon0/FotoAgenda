<style>
    .menuzinho{
        padding: 0;
        margin: 0;
        border-radius: 0;
    }

    .protected_page{
        border:none;
        border-radius: 0;
    }

    .navegacao_menu{
        background-image: linear-gradient(120deg, black 70%, purple, orange);
    }

</style>

<div class="card-body menuzinho" >
    <nav class="navbar navbar-expand-lg navbar-dark navegacao_menu" style="border-radius: 0;" >
        <div class="container-fluid" >	<a class="navbar-brand" href="dashboard"><?= $auth['name'] ?></a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent3" aria-controls="navbarSupportedContent3" aria-expanded="false" aria-label="Toggle navigation"> <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent3">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item"> <a class="nav-link active" aria-current="page" href="dashboard"><i class="bi bi-camera"></i>  Inicio</a>
                    </li>
                    <li class="nav-item"> <a class="nav-link active" aria-current="page" href="montarAgenda"><i class="bi bi-calendar-plus"></i> Montar Agenda</a>
                    </li>
                    <li class="nav-item"> <a class="nav-link active" aria-current="page" href="configuracao"><i class="bi bi-person-add"></i> Configuração</a>
                    </li>
                    <li class="nav-item dropdown"> 
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            Mais opções
                        </a>
                        <ul class="dropdown-menu" style="font-size:.8em">
                            <li><a class="dropdown-item" href="#"><i class="bi bi-currency-dollar"></i>  Financeiro</a>
                            </li>
                            <li><a class="dropdown-item" href="#"><i class="bi bi-archive"></i>  Quantidades</a>
                            </li>
                            <li>
                                <hr class="dropdown-divider">
                            </li>
                            <li><a class="dropdown-item" href="#"><i class="bi bi-patch-question-fill"></i>  Precisa de ajuda?</a>
                            </li>
                        </ul>
                    </li>
                </ul>
                    <button type="button" class="btn_gera_link btn btn-success me-3 font-size-2 radius-30 px-4" style="font-size:.9em">
                    <i style="font-size:.8em" class="bi bi-share-fill"></i> Gerar Link
                    </button>
                    <a class="btn btn-warning me-3 font-size-2 radius-30 px-4" style="font-size:.9em" target="_blank" href="https://www.zanontech.com.br">
                    <i class="bi bi-stars" style="font-size:.8em"></i>  Crie seu proprio site  <i style="font-size:.8em" class="bi bi-stars"></i></a>
                    <a href="sair"><button class="btn btn-danger radius-30 px-4" type="button"><i class="bi bi-box-arrow-right"></i> Sair</button></a>
            </div>
        </div>
    </nav>
</div>



<script>
    $('.btn_gera_link').on('click',function(){
        let id_user     = '<?= $auth['id']; ?>'
        let token_user  = '<?= $auth['token']?>'; 
        let url         = window.location.href

        $.ajax({
            url:"app/action/gerarLinkAction.php",
            type:"post",
            data:{
                'id_user'   : id_user,
                'token'     : token_user,
                'url'       : url
            },
            cache:false,
                success:function(response){
                    let data = JSON.parse(response);
                    Swal.fire({
                        title: 'Sucesso',
                        text: data.mensagem,
                        icon: 'success',
                        showCancelButton: true,
                        confirmButtonText: 'Copiar',
                        cancelButtonText: 'OK',
                        preConfirm: () => {
                            if (navigator.clipboard) {
                                return navigator.clipboard.writeText(data.mensagem).then(() => {
                                    return 'Link Copiado!';
                                }).catch(() => {
                                    return 'Erro ao copiar link';
                                });
                            } else {
                                return 'A função de copiar não está disponível neste navegador.';
                            }
                        }
                    }).then((result) => {
                        if (result.value) {
                            Swal.fire(result.value);
                        }
                    });
                },
                error:function(error){
                    console.log(error);
                }
        })
    })
</script>