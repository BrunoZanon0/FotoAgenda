<?php

include_once __DIR__ . "/../../model/userModel.php";
include_once __DIR__ . "/../../model/emailModel.php";
require __DIR__. "/../../../vendor/autoload.php";
include_once __DIR__. "/../../utils/functions.php";

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;
$mail = new PHPMailer(true);

try {

    $status_core = 200;

    if( !isset($_POST['user_id'] ) || empty($_POST['user_id']) ){
        throw new Exception('Erro ao tentar obter o usuario');
    }

    if( !isset($_POST['email'] ) || empty($_POST['email'])){
        throw new Exception('Email não identificado');
    }

    $user_id        = $_POST['user_id'];
    $email_front    = $_POST['email'];
    $pdoUser        = new User($user_id);
    $auth           = $pdoUser->Auth();

    $tipo_imap = [
        'link' => 'imap.hostinger.com',
        'port' => 993
    ];

    $tipo_smtp = [
        'link' => 'smtp.hostinger.com',
        'port' => 465
    ];

    $tipo_pop = [
        'link' => 'pop.hostinger.com',
        'port' => 995
    ];

    $token_env = gerarNumeroAleatorioMenor();

    $email_to_env = "no-reply@zanontech.com.br";

    $mail->isSMTP();                                   
    $mail->Host         = 'smtp.hostinger.com';                     
    $mail->SMTPAuth     = true;                                  
    $mail->Username     = 'no-reply@zanontech.com.br'; 
    $mail->Password     = 'B&m1572141572009';                             
    $mail->SMTPSecure   = PHPMailer::ENCRYPTION_SMTPS;           
    $mail->Port         = 465;                                  
    $mail->setFrom($email_to_env, 'ZanonTech');
    $mail->addAddress("$email_front", 'No-Reply');

    $mail->isHTML(true);                      
    $mail->Subject = 'Ativar dois fatores ZanonTech';

    $mail->Body = '
        <html>
        <body>
            <table>
                <tr>
                    <th></th>
                    <th><h2>Ativação em 2 fatores</h2></th>
                    <th></th>
                </tr>
                <tr>
                    <td></td>
                    <td>Seu codigo de ativação é:</td>
                    <td></td>
                </tr>
                <tr>
                    <td></td>
                    <td>'.$token_env.'</td>
                    <td></td>
                </tr>
            </table>
        </body>
        </html>';

    if($mail->send()){
        $retorno = [
            'status'    => $status_core,
            'msg'       => $token_env
        ];
    }else{
        $retorno = [
            'status'    => 400,
            'msg'       =>  $mail->SMTPDebug    = SMTP::DEBUG_SERVER
        ];
    }

} catch (Exception $e) {

    $mail->ErrorInfo;
    $status_core = 400;
    $retorno = [
        'status' => $status_core,
        'msg'    => $mail
    ];

}finally{
    echo json_encode($retorno);
}