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
    #calendar {
        max-width: 86vw;
        margin: 0 auto;
        border: 1px solid #ddd;
        border-radius: 8px;
        font-family: 'roboto',Arial, Helvetica, sans-serif;
    }

    .fc-daygrid-day-number{
        text-decoration: none;
        margin: auto;
    }

    .fc-daygrid-day-top{
        text-align: center;
    }

    .fc {
        font-family: Arial, sans-serif;
    }

    .fc-toolbar {
        background-color: #f4f4f4;
        border-bottom: 1px solid #ddd;
    }

    .fc-dayGridMonth-button {
        background-color: #007bff;
        color: #fff;
    }

    .fc-dayGridMonth-button:hover {
        background-color: #0056b3;
    }

    .fc-daygrid-day {
        border: 1px solid #ddd;
    }

    .fc-daygrid-day:hover {
        background-color: #f0f8ff;
    }

    .fc-daygrid-day-number {
        font-size: 16px;
        color: #333;
    }

    .fc-col-header-cell-cushion {
        text-decoration: none;
    }
</style>
<body>
    
    <div class="page-wrapper">
        <div class="page-content">
					
            <div class="card protected_page">
                <?php include_once __DIR__ . "/../../layouts/menu.php"; ?>
                <div class="card-body">
                    <?php if($auth['permissao'] == 'admin' || $auth['permissao'] == 'fotografo' ):?>
                        <div id='calendar'></div>
                    <?php endif ?>
                </div>
            </div>
        </div>
    </div>

    <form class="form_fake_data" method="post" action="dashboarddata">
        <input class="input_data" type="hidden" name="data">
    </form>
<script>
$(document).ready(function() {
    var calendarEl = $('#calendar')[0];
    var calendar = new FullCalendar.Calendar(calendarEl, {
        initialView: 'dayGridMonth',
        locale: 'pt-br',
        headerToolbar: {
            left: 'prev,next today',
            center: 'title',
            right: 'dayGridMonth,dayGridWeek'
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
            $('.input_data').val(info.dateStr);
            $('.form_fake_data').submit();
        }
    });
    calendar.render();
});
</script>
</body>
</html>