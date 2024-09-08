<div class="modal fade" id="modal_mostra_data" role="dialog" aria-labelledby="modal_mostra_dataLabel" aria-hidden="true" data-keyboard="false" data-backdrop="static">
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
    <form action="#">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="modal_mostra_dataLabel">

                <button type="button" class="btn btn-dark botao_retorno d-none">
                    <i class="bi bi-arrow-left"></i>
                </button>
                <i class="bi bi-calendar-event-fill"></i>
                 Agenda disponibilidade</h5>

            <button type="button" class="close close_modal_agenda">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <h6 class="text-center">Aqui voce vai adicionar o horario de cada atendimento</h6>
          <div class="page-wrapper">
            <div class="page-content">
                <div class="card protected_page">
                    <div class="card-body">
                        <div id='calendar'>
                            
                        </div>
                        <form action="#" class="formulario_ver_horarios">
                            <div class="formulario_ver_horarios d-none">
                                <div class="md-3">
                                    <input type="text" class="form-control dia_mes_ano text-center" disabled>
                                </div>
                                <br>
                                <div class="horarios_adicionais">
                                    
                                </div>
                                <div class="row ">
                                    <div class="col-4 m-auto">
                                        <button type="button" class="btn btn-success w-100 botao_adicionar"><i class="bi bi-plus-circle-dotted"> Add</i></button>
                                    </div>
                                </div>
                                <br>
                                <div class="row ">
                                    <div class="col-4 m-auto">
                                        <button type="button"  class="btn btn-info w-100 botao_finalizar"><i class="bi bi-bookmark-check-fill"> Finalizar</i></button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
         </div>
        </div>
    </form>
  </div>
</div>

<script>

    const target_modal      = $("#modal_mostra_data");
    const botao_return      = $('.botao_retorno');
    const botao_add         = $('.botao_adicionar');
    const botao_finalizar   = $('.botao_finalizar');
    let dia                 = ''

    $('.close_modal_agenda').on('click',function(){
        target_modal.modal("hide");
        $('.horarios_adicionais').html('');
    })

    botao_add.on('click',function(){
    criaHorario();
    })

    
        botao_finalizar.on('click',function(){
            let horarios_div        = $('.horarios_adicionais');
            let horarios            = horarios_div.find('input[name="horario_a_disponibilizar[]"]');
            let valida              = true;
            let horarios_para_back  = [];

            if(horarios.length <= 0){
                Swal.fire('Erro','Você não disponibilizou nenhum horario!','error')
                return;
            }

            horarios.each(function(){
                let valores = $(this).val();

                if(!valores){
                    Swal.fire('Erro','É necessário enviar um horário em todos os campos','error');
                    valida = false;
                    return
                }

                horarios_para_back.push(valores);
            })

            if(!valida) return;

            Swal.fire({
                title: "Deseja continuar?",
                text: `Confirmar os horarios para o dia ${formatDateToBR(dia)} ?`,
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Sim"
                }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: "app/ajax/datas/data-marcar-horarios.php",
                        method: 'POST',
                        cache: false,
                        data:{
                            'horario':horarios_para_back,
                            'data': dia
                        },
                            success: function(response) {
                                let data = JSON.parse(response);

                                if(data['status'] == 200){
                                    Swal.fire('Sucesso',data['msg'],'success')
                                    .then(()=>{
                                        $('.horarios_adicionais').html('');
                                        atualiza_dia();
                                    })
                                }else{
                                    Swal.fire('Erro',$data['msg'],'error')
                                }

                            },
                            error: function(error) {
                                Swal.fire('Erro',error,'error');
                                console.log(error);
                            }
                    });
                }
            });
        })

    botao_return.on('click',function(){
        botao_return.addClass('d-none')
        $('.formulario_ver_horarios').addClass('d-none')
        $('#calendar').removeClass('d-none');
        $('.horarios_adicionais').html('');
        $(document).trigger("start_modal_valida_datas");
    })

    $(document).on("start_modal_valida_datas", function(){
        target_modal.modal("show");
            $('.formulario_ver_horarios').addClass('d-none')
            $('#calendar').removeClass('d-none');
            setTimeout(() => {
                $(document).ready(function() {
                    var calendarEl = $('#calendar')[0];
                    var calendar = new FullCalendar.Calendar(calendarEl, {
                        initialView: 'dayGridMonth',
                        locale: 'pt-br',
                        headerToolbar: {
                            left: 'prev,next today',
                            center: 'title',
                            right: 'dayGridMonth'
                        },
                        buttonText: {
                            month: 'Mês',
                            week: 'Semana',
                            day: 'Dia'
                        },
                        eventColor: '#378006',
                        eventTextColor: '#fff',
                        editable: true,
                        droppable: true,
                        dateClick: function(info) {
                            $('.dia_mes_ano').val(formatDateToBR(info.dateStr));
                            dia = info.dateStr
                            $('.formulario_ver_horarios').removeClass('d-none')
                            $('#calendar').addClass('d-none');
                            botao_return.removeClass('d-none')

                            atualiza_dia()
                        }
                    });
                    calendar.render();
                });
            }, 300);
        });

        function criaHorario(horario = null, id=null) {
            const html = horario
                ? `
                <div class="md-3">
                    <div class="row">
                        <div class="col-10">
                            <input type="time" name='horario' disabled value="${horario}" class="form-control">
                            <input type="hidden" name='horario_id' disabled value="${id}" class="form-control">
                        </div>
                        <div class="col-2">
                            <button type="button" class="btn btn-danger botao_apaga_horario_ajax">
                                <i class="bi bi-trash3-fill"></i>
                            </button>
                        </div>
                    </div>
                <br>
                </div>
                `
                : `
                <div class="md-3">
                    <div class="row">
                        <div class="col-10">
                            <input type="time" name='horario_a_disponibilizar[]' value="00:00" class="form-control">
                        </div>
                        <div class="col-2">
                            <button type="button" class="btn btn-danger botao_apaga_horario">
                                <i class="bi bi-trash3-fill"></i>
                            </button>
                        </div>
                    </div>
                <br>
                </div>
                `;

            $('.horarios_adicionais').append(html);

            if ($('.botao_apaga_horario').length === 1) {
                $('.horarios_adicionais').on('click', '.botao_apaga_horario', function() {
                    Swal.fire({
                        title: "Deseja continuar?",
                        text: "Quer remover o horário adicionado?",
                        icon: "warning",
                        showCancelButton: true,
                        confirmButtonColor: "#3085d6",
                        cancelButtonColor: "#d33",
                        confirmButtonText: "Sim"
                    }).then((result) => {
                        if (result.isConfirmed) {
                            $(this).closest('.md-3').remove();
                            Swal.fire({
                                title: "Sucesso",
                                text: "Horário removido com sucesso!",
                                icon: "success"
                            });
                        }
                    });
                });
            }
            if ($('.botao_apaga_horario_ajax').length === 1) {
                $('.horarios_adicionais').on('click', '.botao_apaga_horario_ajax', function() {
                    let div = $(this).closest('.md-3'); 
                    let horarioId = div.find('input[name="horario_id"]').val();
                    
                    Swal.fire({
                        title: "Deseja continuar?",
                        text: "Quer remover o horário já guardado?",
                        icon: "warning",
                        showCancelButton: true,
                        confirmButtonColor: "#3085d6",
                        cancelButtonColor: "#d33",
                        confirmButtonText: "Sim"
                    }).then((result) => {
                        if (result.isConfirmed) {
                            $.ajax({
                                url:'app/ajax/datas/data-remove-horario.php',
                                data:{'horario_id':horarioId},
                                method:"POST",
                                cache:false,
                                    success:function(response){
                                        let data = JSON.parse(response);

                                        if(data['status'] == 400){
                                            Swal.fire('Erro',data['msg'],'error');
                                        }else{
                                            Swal.fire("Sucesso","horario removido com sucesso","Success")
                                            .then(()=>{
                                                $('.horarios_adicionais').html('');
                                                atualiza_dia();
                                            })
                                        }
                                    },
                                    error:function(error){
                                        console.log(error)
                                    }
                            })
                        }
                    });
                });
            }
        }

        function atualiza_dia(){
            $.ajax({
                url:"app/ajax/datas/data-do-dia-e-horarios.php",
                method: 'POST',
                cache: false,
                data:{
                    'dia':dia
                },
                    success:function(response){
                        let data = JSON.parse(response);

                        if(data['status'] == 400 ){
                            Swal.fire('Erro',data['msg'],'error');
                        }else{
                            if(data.length >= 1){
                                data.forEach(element => {
                                    criaHorario(element.hora_disponivel, element.id);
                                });
                            }
                        }
                    }
            })
        }

</script>