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
<body>
    
    <div class="page-wrapper">
        <div class="page-content">
					
            <div class="card">
                <?php include_once __DIR__ . "/../../layouts/menu.php"; ?>
                <div class="card-body">
                    <div id='calendar'></div>
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