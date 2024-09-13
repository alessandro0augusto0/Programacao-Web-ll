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

    // Consulta para verificar se o empréstimo existe
    $stmt = $conn->prepare("SELECT * FROM emprestimos WHERE isbn = ? AND cpf = ?");
    $stmt->bind_param("ss", $isbn, $cpf);
    $stmt->execute();
    $result = $stmt->get_result();
    $emprestimo = $result->fetch_assoc();

    if ($emprestimo) {
        // Remove o empréstimo
        $stmt = $conn->prepare("DELETE FROM emprestimos WHERE isbn = ? AND cpf = ?");
        $stmt->bind_param("ss", $isbn, $cpf);
        $stmt->execute();

        // Atualiza o status do livro para "Disponível"
        $stmt = $conn->prepare("UPDATE cadastrolivro SET status = 'Disponível' WHERE isbn = ?");
        $stmt->bind_param("s", $isbn);
        $stmt->execute();

        $mensagem = "Devolução realizada com sucesso!";
    } else {
        $mensagem = "Empréstimo não encontrado.";
    }
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Devolução de Livro - Bibliolink</title>
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

        .devolucao-container {
            background: rgba(255, 255, 255, 0.9);
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 400px;
            text-align: center;
        }

        .devolucao-container h1 {
            margin-bottom: 20px;
            color: #333;
        }

        .devolucao-container form {
            display: flex;
            flex-direction: column;
        }

        .devolucao-container input[type="text"] {
            padding: 10px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        .devolucao-container button {
            padding: 10px;
            background-color: #007bff;
            border: none;
            border-radius: 4px;
            color: #fff;
            font-size: 16px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .devolucao-container button:hover {
            background-color: #0056b3;
        }

        .devolucao-container .back-button {
            margin-top: 10px;
            background-color: #6c757d;
        }

        .devolucao-container .back-button:hover {
            background-color: #5a6268;
        }

        .devolucao-container .logout-button {
            margin-top: 10px;
            background-color: #dc3545;
        }

        .devolucao-container .logout-button:hover {
            background-color: #c82333;
        }

        .mensagem {
            margin-top: 20px;
            color: #333;
        }
    </style>
</head>
<body>
    <div class="devolucao-container">
        <h1>Devolução de Livro</h1>
        <form method="post">
            <input type="text" name="isbn" placeholder="ISBN do Livro" required>
            <input type="text" name="cpf" placeholder="CPF do Usuário" required>
            <button type="submit">Devolver</button>
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