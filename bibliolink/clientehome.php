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
    <title>Home - Bibliolink</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: url('assets/bibliolink.jpg') no-repeat center center fixed;
            background-size: cover;
            margin: 0;
            padding: 0;
        }
        .home-container {
            display: flex;
            flex-direction: column;
            align-items: center;
            padding: 20px;
            background: rgba(255, 255, 255, 0.9);
            border-radius: 8px;
            max-width: 1200px;
            margin: 20px auto;
        }
        .home-container h1 {
            color: #333;
            font-size: 2.5em;
            margin-bottom: 10px;
        }
        .menu {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
            justify-content: center;
            margin-bottom: 20px;
        }
        .menu-item {
            background-color: #007bff;
            color: #fff;
            padding: 15px;
            border-radius: 8px;
            text-align: center;
            width: 200px;
            cursor: pointer;
            transition: background-color 0.3s, transform 0.3s;
            font-size: 1.2em;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        .menu-item:hover {
            background-color: #0056b3;
            transform: translateY(-5px);
        }
        .menu-item a {
            color: #fff;
            text-decoration: none; /* Remove underline */
            display: block;
            width: 100%;
            height: 100%;
        }
        .menu-item a:hover {
            text-decoration: none;
        }
        .welcome-message {
            margin-bottom: 20px;
            text-align: center;
        }
        .welcome-message h2 {
            margin: 0;
            color: #333;
            font-size: 1.8em;
        }
        .logout-button {
            background-color: #dc3545;
            border: none;
            color: #fff;
            padding: 10px 20px;
            border-radius: 4px;
            cursor: pointer;
            transition: background-color 0.3s, transform 0.3s;
            font-size: 1.1em;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        .logout-button:hover {
            background-color: #c82333;
            transform: translateY(-5px);
        }
    </style>
</head>
<body>
    <div class="home-container">
        <div class="welcome-message">
            <h1>Bem-vindo, <?php echo htmlspecialchars($usuario['nome']); ?>!</h1>
            <p>Escolha uma das opções abaixo para gerenciar a biblioteca.</p>
        </div>
        <div class="menu">
            <a class="menu-item" href="consultalivrocliente.php">Consultar Livro</a>
            <a class="menu-item" href="devolucaolivrocliente.php">Devolução de Livro</a>
            <a class="menu-item" href="instrucoescliente.php">Instruções do Site</a>
        </div>
        <form action="logout.php" method="post">
            <button type="submit" class="logout-button">Sair</button>
        </form>
    </div>
</body>
</html>
