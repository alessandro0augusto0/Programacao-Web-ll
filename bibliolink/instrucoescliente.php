<?php
session_start();
require_once 'conexao.php';

// Verifica se o usuário está logado
if (!isset($_SESSION['user_id'])) {
    header('Location: index.php');
    exit();
}

$usuario_id = $_SESSION['user_id'];

// Consulta para obter informações do usuário
$stmt = $conn->prepare("SELECT nome FROM usuario WHERE id = ?");
$stmt->bind_param("i", $usuario_id);
$stmt->execute();
$result = $stmt->get_result();
$usuario = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Instruções - Bibliolink</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Roboto', sans-serif;
            background: url('assets/bibliolink.jpg') no-repeat center center fixed;
            background-size: cover;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            color: #333;
        }

        .instructions-container {
            background: rgba(255, 255, 255, 0.95);
            border-radius: 10px;
            padding: 30px;
            max-width: 800px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            text-align: center;
        }

        .instructions-container h1 {
            font-size: 2.5em;
            margin-bottom: 20px;
            color: #007bff;
        }

        .instructions-container p {
            font-size: 1.2em;
            line-height: 1.8;
            margin-bottom: 20px;
        }

        .instructions-container ul {
            list-style: none;
            padding: 0;
        }

        .instructions-container li {
            font-size: 1.1em;
            margin-bottom: 10px;
            text-align: left;
        }

        .instructions-container li strong {
            color: #007bff;
        }

        .back-button {
            background-color: #007bff;
            border: none;
            color: #fff;
            padding: 12px 25px;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s;
            font-size: 1em;
            text-decoration: none;
            display: inline-block;
            margin-top: 20px;
        }

        .back-button:hover {
            background-color: #0056b3;
        }
    </style>
</head>

<body>
    <div class="instructions-container">
        <h1>Instruções do Site</h1>
        <p>Bem-vindo ao Bibliolink! Aqui você pode gerenciar sua biblioteca de forma fácil e eficiente. Abaixo estão as instruções para utilizar o site:</p>
        <ul>
            <li><strong>Consultar Livro:</strong> Permite consultar informações dos livros cadastrados na biblioteca</li>
            <li><strong>Devolução de Livro:</strong> Permite a devolução de livros. Informe o ISBN do livro emprestado e o CPF</li>
        </ul>
        <a href="clientehome.php" class="back-button">Voltar</a>
    </div>
</body>

</html>