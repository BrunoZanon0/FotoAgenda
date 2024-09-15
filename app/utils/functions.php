<?php 

function gerarNumeroAleatorioMenor() {
    $numero = '';
    for ($i = 0; $i < 7; $i++) {
        $numero .= rand(0, 9);
    }
    return $numero;
}