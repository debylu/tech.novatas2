<?php

/*************************
 * Funções do aplicativo *
 ************************* 
 * Este arquivo contém diversas funções de uso geral no aplicativo.
 * A maior parte dessas funções pode ser usada em outras aplicações.
 * Guarde-as com cuidado e acessíveis no seu GitHub.com.
 **/

/**
 * Facilita o DEBUG dos códigos:
 * Referências: 
 *  • https://www.w3schools.com/php/php_functions.asp
 *  • https://www.w3schools.com/php/func_var_var_dump.asp
 *  • https://www.w3schools.com/php/func_var_print_r.asp
 *  • https://www.w3schools.com/php/func_misc_exit.asp
 **/
function debug($var, $exit = true, $dump = false)
{
    echo '<pre>';
    if ($dump) var_dump($var);
    else print_r($var);
    echo '</pre>';
    if ($exit) exit();
}

/**
 * Função que converte datas:
 * Formata datas de DD/MM/AAAA para AAAA-MM-DD
 * e DD/MM/AAAA HH:II:SS para AAAA-MM-DD HH:II:SS,
 * formatos suportados pelo MySQL.
 */
function datesys($mydate)
{
    /**
     * Separa data da hora em $p1, onde teremos:
     *  $p1[0] ← Data,
     *  $p1[1] ← Hora.
     **/
    $p1 = explode(' ', $mydate);

    /**
     * Separa partes da data em $p2, onde teremos:
     *  $p2[0] ← Ano,
     *  $p2[1] ← Mês, 
     *  $p2[2] ← Dia.
     **/
    $p2 = explode('/', $p1[0]);

    /**
     * Reorganiza os componentes da data para obter esta em BR:
     */
    $d = "{$p2[2]}-{$p2[1]}-{$p2[0]}";

    // Se a data original tem a hora, adiciona esta na nova data:
    if (isset($p1[1])) $d .= " {$p1[1]}";

    // Retorna a data formatada:
    return $d;
}
