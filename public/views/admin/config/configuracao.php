<?php 
    if(!isset($auth) || empty($auth)){
        $_SESSION['erro'] = "Você não está logado!";
        header("location: login");
        exit();
    }

    $mensagem_erro      = '';
    $mensagem_success   = '';
    if(isset($_SESSION['erro'])){
        $mensagem_erro = $_SESSION['erro'];
        unset($_SESSION['erro']);
    }
    if(isset($_SESSION['success'])){
        $mensagem_success = $_SESSION['success'];
        unset($_SESSION['success']);
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
                <?php include_once __DIR__ . "/../../../layouts/menu.php"; ?>
                <div class="card-body">
                <div class="row">
					<div class="col-12 col-lg-12">
						<div class="card">
							<div class="card-body">
								<div class="row mt-3">
									<div class="col-12 col-lg-4 credenciais">
										<div class="card shadow-none border radius-15">
											<div class="card-body text-center">
                                                <h2><i class="bi bi-cart-check"></i></h2>
                                                <h4>Credenciais</h4>
											</div>
										</div>
									</div>
									<div class="col-12 col-lg-4">
										<div class="card shadow-none border radius-15">
											<div class="card-body text-center">
                                                <h2><i class="bi bi-check2-all"></i></h2>
												<h4>Autenticação</h4>
											</div>
										</div>
									</div>
									<div class="col-12 col-lg-4">
										<div class="card shadow-none border radius-15">
											<div class="card-body text-center">
                                                <h2><i class="bi bi-person-circle"></i></h2>
                                                <h4>Perfil</h4>
											</div>
										</div>
									</div>
								</div>
								<!--end row-->
								<!--end row-->
								<div class="table-responsive mt-3">
									<table class="table table-striped table-hover table-sm mb-0">
										<thead>
											<tr>
												<th>Evento <i class="bx bx-up-arrow-alt ms-2"></i>
												</th>
												<th>Data</th>
												<th>Horário</th>
												<th></th>
											</tr>
										</thead>
										<tbody>
											<tr>
												<td>
													<div class="d-flex align-items-center">
														<div><i class="bx bxs-file-doc me-2 font-24 text-success"></i>
														</div>
														<div class="font-weight-bold text-success">15 anos da Mirella Zanon</div>
													</div>
												</td>
												<td>17/09/1996</td>
												<td>19h - 22h</td>
												<td><i class="bx bx-dots-horizontal-rounded font-24"></i>
												</td>
											</tr>
										</tbody>
									</table>
								</div>
							</div>
						</div>
					</div>
				</div>
                </div>
            </div>
        </div>
    </div>
    <?php include_once __DIR__ . "/../modal/modal-credenciais-pagamento.php"; ?>
</body>
</html>

<script>

    if(<?= json_encode($mensagem_erro)?>){
        Swal.fire('Erro','<?= $mensagem_erro?>','error');
    }
    if(<?= json_encode($mensagem_success)?>){
        Swal.fire("Sucess",'<?= $mensagem_success ?>' ,'success')
    }
    $(document).on("click", ".credenciais", function(e){
        $(document).trigger("start_modal_credenciais");
    });
</script>