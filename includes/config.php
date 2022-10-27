<?php

/**
 * Variáveis do site:
 *  • https://www.w3schools.com/php/php_arrays.asp
 **/
$c = array(
    'sitename' => 'Tech.Novatas',
    'siteslogan' => 'Toda mulher é capaz de tudo, inclusive programar.',
    'sitelogo' => '/img/logo01.png',
    'favicon' => '/img/logo01.png'
);

// Redes sociais:
$s = array(
    array( // [0]
        'name' => 'Facebook',
        'link' => 'https://facebook.com/Tech.Novatas',
        'icon' => 'fa-facebook'
    ),
    array( // [1]
        'name' => 'Youtube',
        'link' => 'https://youtube.com/Tech.Novatas',
        'icon' => 'fa-youtube'
    ),
    array( // [2]
        'name' => 'GitHub',
        'link' => 'https://github.com/Tech.Novatas',
        'icon' => 'fa-github'
    )
);

// Conponentes de cada página:
$page_css = $page_js = $pagename = '';

// Dados para conexão com MySQL/MariaDB e database:
$hostname = 'localhost';
$username = 'root';
$password = '';
$database = 'technovatas';

/**
 * Define a tabela de caracteres para UTF-8:
 * Referências:
 *  • https://www.w3schools.com/php/func_network_header.asp
 **/
header('Content-Type: text/html; charset=utf-8');

/**
 * Define fuso horário do aplicativo para horário de Brasília:
 *  Referências:
 *  • https://www.w3schools.com/php/func_date_default_timezone_set.asp
 **/
date_default_timezone_set('America/Sao_Paulo');

/**
 * Conexão com o MySQL/MariaDB e com o banco de dados:
 * Referências:
 *  • https://www.w3schools.com/php/php_mysql_intro.asp
 **/
$conn = new mysqli($hostname, $username, $password, $database);

// Seta transações com MySQL/MariaDB para UTF-8:
$conn->query('SET NAMES utf8');
$conn->query('SET character_set_connection=utf8');
$conn->query('SET character_set_client=utf8');
$conn->query('SET character_set_results=utf8');

// Seta dias da semana e meses do MySQL/MariaDB para "português do Brasil":
$conn->query('SET GLOBAL lc_time_names = pt_BR');
$conn->query('SET lc_time_names = pt_BR');

/**
 * Importa a bilbioteca de funções:
 * Referências:
 *  • https://www.w3schools.com/php/php_includes.asp
 **/
require('functions.php');
