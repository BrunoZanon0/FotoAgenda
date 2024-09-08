<?php

function gerarNumeroAleatorio() {
    $numero = '';
    for ($i = 0; $i < 30; $i++) {
        $numero .= rand(0, 9);
    }
    return $numero;
}

function gerarNumeroAleatorioMenor() {
    $numero = '';
    for ($i = 0; $i < 7; $i++) {
        $numero .= rand(0, 9);
    }
    return $numero;
}

function deletarConteudoDaPasta($caminhoPasta,$token) {
    $conteudo = glob($caminhoPasta . '/*');

    foreach ($conteudo as $item) {
        if($item == "../recaptch/$token.png"){
            continue;
        }
        if (is_dir($item)) {
            deletarConteudoDaPasta($item,$token);
            rmdir($item);
        } else {
            unlink($item);
        }
    }
}

function getIp()
{
    try {
        if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
            $ip = $_SERVER['HTTP_CLIENT_IP'];
        } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
        } else {
            $ip = $_SERVER['REMOTE_ADDR'];
        }
    } catch (\Exception $e) {
        $ip = "Via Console";
    }

    return $ip;
}

function validarCpf($cpf)
{
    if (empty($cpf)) {
        return false;
    }

    // Elimina possivel mascara
    $cpf = preg_replace('[^0-9]', '', $cpf);
    $cpf = str_pad($cpf, 11, '0', STR_PAD_LEFT);

    // Verifica se o numero de digitos informados é igual a 11
    if (strlen($cpf) != 11) {
        return false;
    }
    // Verifica se nenhuma das sequências invalidas abaixo
    // foi digitada. Caso afirmativo, retorna falso
    else if (
        $cpf == '00000000000' ||
        $cpf == '11111111111' ||
        $cpf == '22222222222' ||
        $cpf == '33333333333' ||
        $cpf == '44444444444' ||
        $cpf == '55555555555' ||
        $cpf == '66666666666' ||
        $cpf == '77777777777' ||
        $cpf == '88888888888' ||
        $cpf == '99999999999'
    ) {
        return false;
        // Calcula os digitos verificadores para verificar se o
        // CPF é válido
    } else {
        for ($t = 9; $t < 11; $t++) {
            for ($d = 0, $c = 0; $c < $t; $c++) {
                $d += $cpf[$c] * (($t + 1) - $c);
            }
            $d = ((10 * $d) % 11) % 10;
            if ($cpf[$c] != $d) {
                return false;
            }
        }

        return true;
    }
}

function limparFormatacaoNumeros($valor)
{
    return preg_replace('/[^0-9]/', '', $valor);
}

function formatarCpf($valor)
{
    if (empty($valor)) {
        return "";
    } else {
        $valor = limparFormatacaoNumeros($valor);
        return substr($valor, 0, 3) . "." . substr($valor, 3, 3) . "." . substr($valor, 6, 3) . "-" . substr($valor, 9, 2);
    }
}

function formatarCnpj($valor)
{
    if (empty($valor)) {
        return "";
    } else {
        $valor = limparFormatacaoNumeros($valor);
        return substr($valor, 0, 2) . "." . substr($valor, 2, 3) . "." . substr($valor, 5, 3) . "/" . substr($valor, 8, 4) . "-" . substr($valor, 12, 2);
    }
}

function formatarDataBrToUs($valor)
{
    if (!empty($valor)) {
        $valor = explode("/", $valor);
        return $valor[2] . "/" . $valor[1] . "/" . $valor[0];
    } else {
        return "";
    }
}

function formatarDatetimeToDate($valor)
{
    $date = date_create($valor);
    return date_format($date, 'Y-m-d');
}

function formatarDataBrToUsDb($valor)
{
    if (!empty($valor)) {
        $valor = explode("/", $valor);
        return $valor[2] . "-" . $valor[1] . "-" . $valor[0];
    } else {
        return "";
    }
}

function formatarDataHoraBrToUs($valor)
{
    if (!empty($valor)) {
        $separa_dt_hr = explode(" ", $valor);
        $valor = explode("/", $separa_dt_hr[0]);
        return $valor[2] . "/" . $valor[1] . "/" . $valor[0] . ' ' . $separa_dt_hr[1];
    } else {
        return "";
    }
}

function formatarDataUsToBr($valor)
{
    if (!empty($valor)) {
        $separa_dt_hr = explode(" ", $valor);
        $valor = explode("-", $separa_dt_hr[0]);
        return substr($valor[2], 0, 2) . "/" . substr($valor[1], 0, 2) . "/" . substr($valor[0], 0, 4);
    } else {
        return "";
    }
}

function formataValorBrToUs($valor)
{
    str_replace(',', '.', $valor);
    return;
}

function formatarDataHoraUsToBr($valor)
{
    if (!empty($valor)) {
        if (mb_strpos($valor, 'T')) {
            $separa_dt_hr = explode("T", $valor);
            $valor = explode("-", $separa_dt_hr[0]);
            $separa_dt_hr = explode("-", $separa_dt_hr[1]);
            return substr($valor[2], 0, 2) . "/" . substr($valor[1], 0, 2) . "/" . substr($valor[0], 0, 4) . ' as ' . substr($separa_dt_hr[0], 0, 5);
        } else {
            $separa_dt_hr = explode(" ", $valor);
            $valor = explode("-", $separa_dt_hr[0]);
            return substr($valor[2], 0, 2) . "/" . substr($valor[1], 0, 2) . "/" . substr($valor[0], 0, 4) . ' ' . substr($separa_dt_hr[1], 0, 5);
        }
    } else {
        return "";
    }
}

function formatarDataHoraUsToBr2($valor)
{
    if (!empty($valor)) {
        if (mb_strpos($valor, 'T')) {
            $separa_dt_hr = explode("T", $valor);
            $valor = explode("-", $separa_dt_hr[0]);
            $separa_dt_hr = explode("-", $separa_dt_hr[1]);

            return substr($valor[0], 0, 4) . "-" . substr($valor[1], 0, 2) . "-" . substr($valor[2], 0, 2) .' '.substr($separa_dt_hr[0], 0, 5);

        } else {
            $separa_dt_hr = explode(" ", $valor);
            $valor = explode("-", $separa_dt_hr[0]);
            return substr($valor[0], 0, 4) . "-" . substr($valor[1], 0, 2) . "-" . substr($valor[2], 0, 2) .' '.substr($separa_dt_hr[0], 0, 5);
        }
    } else {
        return "";
    }
}

function formataMvnoTel($valor)
{
    if (empty($valor)) {
        return "";
    } else {
        return substr($valor, 4);
    }
}

function validarCaracteresEspeciais($valor)
{
    return preg_match('/^[a-zA-ZÀ-ú0-9\s]+$/u', $valor);
}

function removeCaracteresEspeciaisNumeros($valor)
{
    $replace = preg_replace('/[^a-zA-Z\s]/', '', $valor);
    return preg_replace('/( )+/', ' ', $replace);
}

function removerAcentos($str) {
    $acentos = array('À', 'Á', 'Â', 'Ã', 'Ä', 'Å', 'Æ', 'Ç', 'È', 'É', 'Ê', 'Ë', 'Ì', 'Í', 'Î', 'Ï', 'Ð', 'Ñ', 'Ò', 'Ó', 'Ô', 'Õ', 'Ö', 'Ø', 'Ù', 'Ú', 'Û', 'Ü', 'Ý', 'à', 'á', 'â', 'ã', 'ä', 'å', 'æ', 'ç', 'è', 'é', 'ê', 'ë', 'ì', 'í', 'î', 'ï', 'ð', 'ñ', 'ò', 'ó', 'ô', 'õ', 'ö', 'ø', 'ù', 'ú', 'û', 'ü', 'ý', 'ÿ');
    $semAcentos = array('A', 'A', 'A', 'A', 'A', 'A', 'AE', 'C', 'E', 'E', 'E', 'E', 'I', 'I', 'I', 'I', 'D', 'N', 'O', 'O', 'O', 'O', 'O', 'O', 'U', 'U', 'U', 'U', 'Y', 'a', 'a', 'a', 'a', 'a', 'a', 'ae', 'c', 'e', 'e', 'e', 'e', 'i', 'i', 'i', 'i', 'd', 'n', 'o', 'o', 'o', 'o', 'o', 'o', 'u', 'u', 'u', 'u', 'y', 'y');
    
    return strtr($str, array_combine($acentos, $semAcentos));
}

function gerarToken($tamanho)
{

    $ma = "ABCDEFGHIJKLMNOPQRSTUVYXWZ"; // $ma contem as letras maiúsculas
    $mi = "abcdefghijklmnopqrstuvyxwz"; // $mi contem as letras minusculas
    $nu = "0123456789"; // $nu contem os números

    $token = str_shuffle($ma);

    $token .= str_shuffle($mi);

    $token .= str_shuffle($nu);

    return substr(str_shuffle($token), 0, $tamanho);
}

function removeCodFormatDddTelefone($numero)
{
    $num_sem_55 = substr($numero, 2);
    $novo_num = "(" . substr($num_sem_55, 0, 2) . ") " . substr($num_sem_55, 2, 5) . "-" . substr($num_sem_55, -4);
    return $novo_num;
}

function formatarSegundos($segundos) {
    // Calcula as horas, minutos e segundos
    $horas = floor($segundos / 3600);
    $minutos = floor(($segundos - ($horas * 3600)) / 60);
    $segundos = $segundos - ($horas * 3600) - ($minutos * 60);

    return sprintf("%02d:%02d:%02d", $horas, $minutos, $segundos);
}

function minutosParaHoras($minutos) {
    $horas = floor($minutos / 60);
    $minutos %= 60;
    $segundos = 0; // Não estamos lidando com segundos nesse caso

    return sprintf("%02d:%02d:%02d", $horas, $minutos, $segundos);
}

function formatarNumeroTelefone($numero) {
    $numero = preg_replace('/\D/', '', $numero);

    if (strlen($numero) >= 12 && substr($numero, 0, 2) == '55') {
        $numero = substr($numero, 2);
    }

    $parte1 = substr($numero, 0, 2);
    $parte2 = substr($numero, 2, 5);
    $parte3 = substr($numero, 7, 4);

    return '(' . $parte1 . ') ' . $parte2 . '-' . $parte3;
}

function pegarUltimos9Numeros($string) {
    if (preg_match('/\d{9}$/', $string, $matches)) {
        return $matches[0];
    } else {
        return false;
    }
}

//Função Milanage - GO
function hexToBytes($hex)
{
    return pack('H*', $hex);
}

function computeOPc($k, $op)
{
    $hash = hash_hmac('sha256', $op, $k, true);

    return substr($hash, 0, 16);
}

function aes_decrypt($key, $data) {
    $cipher = 'aes-128-cbc';
    $key = hex2bin($key);
    $data = hex2bin($data);

    $ivSize = openssl_cipher_iv_length($cipher);
    $iv = substr($data, 0, $ivSize);
    $ciphertext = substr($data, $ivSize);

    $blockSize = 16; 
    $padding = $blockSize - (strlen($ciphertext) % $blockSize);
    $ciphertext .= str_repeat(chr($padding), $padding);

    $plaintext = openssl_decrypt($ciphertext, $cipher, $key, OPENSSL_RAW_DATA | OPENSSL_ZERO_PADDING, $iv);

    if ($plaintext === false) {
       // echo "Erro durante a descriptografia: " . openssl_error_string() . "\n";
    }

    $resultHex = bin2hex($plaintext);

    return $resultHex;
}

?>

<!--  LOADING AJAX -->

<script>

    function moeda(campo) {
        let valor = campo.value.replace(/\D/g, '');

        if (valor.length > 2) {
            valor = valor.replace(/(\d)(\d{1})$/, '$1,$2'); 
            valor = valor.replace(/\B(?=(\d{3})+(?!\d))/g, '.'); 
        } else {
            valor = valor.replace(/(\d{1,2})$/, '$1'); 
        }

        campo.value = valor ? `${valor}` : '';
    }

    function formatDateToBR(dateStr) {
        const regex = /^\d{4}-\d{2}-\d{2}$/;
        const [year, month, day] = dateStr.split('-');
        return `${day}/${month}/${year}`;
    }
</script>