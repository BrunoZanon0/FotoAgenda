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
    })

    $(document).on("start_modal_valida_datas", function(){
        target_modal.modal("show");
        let divHorarios     = $('.horarios_select');
        divHorarios.html('');

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
                            data_selecao = info.dateStr;
                            $(document).trigger('buscar_data_selecionada');
                        },
                        events: function(fetchInfo, successCallback, failureCallback) {
                            $.ajax({
                                url: 'app/ajax/datas/data-todos-dias.php',
                                method: 'GET',
                                dataType: 'json',
                                success: function(data) {
                                    var availableDates = data.map(function(item) {
                                    return item.data_disponivel;
                                });

                                var availableEvents = availableDates.map(function(date) {
                                    return {
                                        start: date,
                                        display: 'background',
                                        color: '#00FF00' 
                                    };
                                });

                                var allDates = [];
                                var today = new Date();
                                var start = fetchInfo.start;
                                var end = fetchInfo.end;

                                var currentDate = start;
                                while (currentDate <= end) {
                                    allDates.push(currentDate.toISOString().split('T')[0]);
                                    currentDate.setDate(currentDate.getDate() + 1);
                                }

                                var unavailableDates = allDates.filter(function(date) {
                                    return !availableDates.includes(date);
                                });

                                var unavailableEvents = unavailableDates.map(function(date) {
                                    return {
                                        start: date,
                                        display: 'background',
                                        color: '#FF0000'
                                    };
                                });

                                var events = availableEvents.concat(unavailableEvents);
                                
                                successCallback(events);

                                    successCallback(events);
                                },
                                error: function() {
                                    failureCallback();
                                }
                            });
                        }
                    });
                    calendar.render();
                });
            }, 300);
        });


</script>