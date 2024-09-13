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
            font-family: Arial, sans-serif;
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
        }

        .menu {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 20px;
            margin-bottom: 20px;
            width: 100%;
            max-width: 1000px;
        }

        .menu-item {
            background-color: #007bff;
            color: #fff;
            border-radius: 8px;
            text-align: center;
            height: 100px;
            cursor: pointer;
            transition: background-color 0.3s;
            display: flex;
            align-items: center;
            justify-content: center;
            box-sizing: border-box;
        }

        .menu-item:hover {
            background-color: #0056b3;
        }

        .menu-item a {
            color: #fff;
            text-decoration: none;
            font-size: 18px;
            display: block;
            width: 100%;
            height: 100%;
            line-height: 100px;
            text-align: center;
            box-sizing: border-box;
        }

        .menu-item a:hover {
            text-decoration: underline;
        }

        .welcome-message {
            margin-bottom: 20px;
            text-align: center;
        }

        .welcome-message h2 {
            margin: 0;
            color: #333;
        }

        .logout-button {
            background-color: #dc3545;
            border: none;
            color: #fff;
            padding: 10px 20px;
            border-radius: 4px;
            cursor: pointer;
            transition: background-color 0.3s;
            font-size: 16px;
            margin-top: 20px;
        }

        .logout-button:hover {
            background-color: #c82333;
        }

        .menu-footer {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 20px;
            width: 100%;
            max-width: 1000px;
            margin-top: 20px;
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
            <!-- Primeira linha de opções -->
            <div class="menu-item"><a href="cadastrousuario.php">Cadastro de Usuário</a></div>
            <div class="menu-item"><a href="cadastrolivro.php">Cadastro de Livro</a></div>
            <div class="menu-item"><a href="cadastroeditora.php">Cadastro de Editora</a></div>
            <div class="menu-item"><a href="cadastroautor.php">Cadastro de Autor</a></div>
            
            <!-- Segunda linha de opções -->
            <div class="menu-item"><a href="editarusuario.php">Editar Usuário</a></div>
            <div class="menu-item"><a href="editarlivro.php">Editar Livro</a></div>
            <div class="menu-item"><a href="editareditora.php">Editar Editora</a></div>
            <div class="menu-item"><a href="editarautor.php">Editar Autor</a></div>
            
            <!-- Terceira linha de opções -->
            <div class="menu-item"><a href="removerusuario.php">Remover Usuário</a></div>
            <div class="menu-item"><a href="removerlivro.php">Remover Livro</a></div>
            <div class="menu-item"><a href="removereditora.php">Remover Editora</a></div>
            <div class="menu-item"><a href="removerautor.php">Remover Autor</a></div>
            
            <!-- Quarta linha de opções -->
            <div class="menu-item"><a href="consultarusuario.php">Consultar Usuário</a></div>
            <div class="menu-item"><a href="consultarlivro.php">Consultar Livro</a></div>
            <div class="menu-item"><a href="consultareditora.php">Consultar Editora</a></div>
            <div class="menu-item"><a href="consultarautor.php">Consultar Autor</a></div>
        </div>
        <!-- Linha final de opções -->
        <div class="menu-footer">
            <div class="menu-item"><a href="emprestarlivro.php">Empréstimo de Livro</a></div>
            <div class="menu-item"><a href="devolverlivro.php">Devolução de Livro</a></div>
            <div class="menu-item"><a href="consultaremprestimos.php">Consultar Empréstimos</a></div>
            <div class="menu-item"><a href="instrucoesfuncionario.php">Instruções do Site</a></div>
            
            
        </div>
        <form action="logout.php" method="post">
            <button type="submit" class="logout-button">Sair</button>
        </form>
    </div>
</body>

</html>
