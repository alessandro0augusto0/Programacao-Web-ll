<?php
session_start();
require_once 'conexao.php';

// Verifica se o usuário está logado
if (!isset($_SESSION['user_id'])) {
    header('Location: index.php');
    exit();
}

// Verifica se o formulário foi enviado
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $isbn = $_POST['isbn'];
    $cpf = $_POST['cpf'];

    // Consulta para obter informações do usuário pelo CPF
    $stmt = $conn->prepare("SELECT id, nome FROM usuariocliente WHERE cpf = ?");
    $stmt->bind_param("s", $cpf);
    $stmt->execute();
    $result = $stmt->get_result();
    $usuario = $result->fetch_assoc();

    if ($usuario) {
        // Consulta para verificar o status e quantidade disponível do livro
        $stmt = $conn->prepare("SELECT status, quantidadedisponivel FROM cadastrolivro WHERE isbn = ?");
        $stmt->bind_param("s", $isbn);
        $stmt->execute();
        $result = $stmt->get_result();
        $livro = $result->fetch_assoc();

        if ($livro) {
            // Normaliza a comparação do status para ser insensível à capitalização
            if (strtolower($livro['status']) == 'disponível' && $livro['quantidadedisponivel'] > 0) {
                // Registra o empréstimo
                $stmt = $conn->prepare("INSERT INTO emprestimos (cpf, isbn, data_emprestimo) VALUES (?, ?, NOW())");
                $stmt->bind_param("ss", $cpf, $isbn);
                $stmt->execute();

                // Atualiza a quantidade do livro
                $stmt = $conn->prepare("UPDATE cadastrolivro SET quantidadedisponivel = quantidadedisponivel - 1 WHERE isbn = ?");
                $stmt->bind_param("s", $isbn);
                $stmt->execute();

                // Atualiza o status do livro para "Emprestado"
                $stmt = $conn->prepare("UPDATE cadastrolivro SET status = 'Emprestado' WHERE isbn = ?");
                $stmt->bind_param("s", $isbn);
                $stmt->execute();

                $mensagem = "Empréstimo realizado com sucesso!";
            } else {
                $mensagem = "Livro não disponível para empréstimo. Status atual: " . htmlspecialchars($livro['status']);
            }
        } else {
            $mensagem = "Livro não encontrado.";
        }
    } else {
        $mensagem = "Usuário não encontrado.";
    }
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Empréstimo de Livro - Bibliolink</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: url('assets/bibliolink.jpg') no-repeat center center fixed;
            background-size: cover;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .emprestimo-container {
            background: rgba(255, 255, 255, 0.9);
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 400px;
            text-align: center;
        }

        .emprestimo-container h1 {
            margin-bottom: 20px;
            color: #333;
        }

        .emprestimo-container form {
            display: flex;
            flex-direction: column;
        }

        .emprestimo-container input[type="text"] {
            padding: 10px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        .emprestimo-container button {
            padding: 10px;
            background-color: #007bff;
            border: none;
            border-radius: 4px;
            color: #fff;
            font-size: 16px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .emprestimo-container button:hover {
            background-color: #0056b3;
        }

        .emprestimo-container .back-button {
            margin-top: 10px;
            background-color: #6c757d;
        }

        .emprestimo-container .back-button:hover {
            background-color: #5a6268;
        }

        .emprestimo-container .logout-button {
            margin-top: 10px;
            background-color: #dc3545;
        }

        .emprestimo-container .logout-button:hover {
            background-color: #c82333;
        }

        .mensagem {
            margin-top: 20px;
            color: #333;
        }
    </style>
</head>
<body>
    <div class="emprestimo-container">
        <h1>Empréstimo de Livro</h1>
        <form method="post">
            <input type="text" name="isbn" placeholder="ISBN do Livro" required>
            <input type="text" name="cpf" placeholder="CPF do Usuário" required>
            <button type="submit">Emprestar</button>
        </form>
        <form action="home.php" method="get">
            <button type="submit" class="back-button">Voltar</button>
        </form>
        <form action="logout.php" method="post">
            <button type="submit" class="logout-button">Sair</button>
        </form>
        <?php if (isset($mensagem)): ?>
            <p class="mensagem"><?php echo htmlspecialchars($mensagem); ?></p>
        <?php endif; ?>
    </div>
</body>
</html>
