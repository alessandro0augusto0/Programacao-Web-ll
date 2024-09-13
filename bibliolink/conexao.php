<?php
$servername = "localhost";
$username = "root";  // Usuário padrão do MySQL
$password = "";  // Se você configurou uma senha, coloque-a aqui
$dbname = "bibliolink";  // O nome do banco de dados que você criou

// Criando a conexão
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificando a conexão
if ($conn->connect_error) {
    die("Conexão falhou: " . $conn->connect_error);
}

?>
