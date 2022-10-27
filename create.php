<?php

/**
 * create.php
 * Aplicativo que cadastra um novo usuário no sistema.
 **/

/**
 * Importa as configurações e funções do aplicativo:
 * Referências: https://www.w3schools.com/php/php_includes.asp
 **/
require('includes/config.php');

/**
 * Declara / inicializa variável do aplicativo:
 * Neste caso, estamos criando um "menu principal" na variável $output que é 
 * usada no final do código, para exibir os resultados no navegador.
 **/
$output = '
<a href="/readall.php">Listar</a> 
|
<a href="/create.php">Cadastrar</a>
<hr>
';

/**
 * Detecta se o formulário foi enviado:
 * Referências:
 *  • https://www.w3schools.com/php/func_var_isset.asp
 *  • https://www.w3schools.com/php/php_superglobals.asp
 *  • https://www.w3schools.com/php/php_superglobals_post.asp
 **/
if (isset($_POST['send'])) :

    /**
     * Processando os dados do formulário:
     **/

    /**
     * Converte data de cadastro do usuário de BR para system date:
     * OBS: estamos usando a função "datesys()" que criamos e está disponível
     * no arquivo "includes/functions.php".
     **/
    $birth = datesys($_POST['birth']);

    // Query que insere dados do formulário no banco de dados:
    $sql = <<<SQL

INSERT INTO users (
    name,
    email,
    password,
    photo,
    birth,
    bio
) VALUES (
    '{$_POST['name']}',
    '{$_POST['email']}',
    -- Senha criptografada usando "SHA1".
    SHA1('{$_POST['password']}'),
    '{$_POST['photo']}',
    -- Data de nascimento já convertida para MySQL.
    '{$birth}',
    '{$_POST['bio']}'
);

SQL;

    // Executa a query:
    $conn->query($sql);

    // Gera o feedback:
    $output .= "Oba! Usuário cadastrado com sucesso...";

else :

    // Cria o formulário de cadastro → HTML:
    $output .= <<<HTML

<h2>Cadastra usuário (Create)</h2>

<form method="post" action="{$_SERVER['PHP_SELF']}">
 
    <input type="hidden" name="send" value="ok">
    <p>Nome: <input type="text" name="name" value=""></p>
    <p>E-mail: <input type="text" name="email" value=""></p>
    <p>Senha: <input type="text" name="password" value=""></p>
    <p>Foto: <input type="text" name="photo" value=""></p>
    <p>Nacimento: <input type="text" name="birth" value=""></p>
    <p>Biografia: <textarea name="bio"></textarea></p>
    <p>
        <button type="submit">Salvar</button>
        &nbsp; &nbsp;
        <button type="reset">Limpar</button>
    </p>

</form>

HTML;

endif;

// Envia saída para o navegador:
echo $output;

