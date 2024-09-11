<?php
// Verifica se está rodando no servidor local ou remoto
if ($_SERVER['HTTP_HOST'] == 'localhost') {
    // Configurações do ambiente local (seu computador)
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "agenda_contatos";
} else {
    // Configurações do servidor remoto (Infinity Free)
    $servername = "sql112.infinityfree.com";  // MySQL Hostname fornecido pelo Infinity Free
    $username = "if0_37261356";               // MySQL Username fornecido
    $password = "xV8vyaATL6";               // Substitua por sua senha do painel de controle
    $dbname = "if0_37261356_agenda_contatos"; // MySQL Database Name fornecido
}

// Cria a conexão com o banco de dados
$conn = new mysqli($servername, $username, $password, $dbname);

// Verifica a conexão
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
?>
