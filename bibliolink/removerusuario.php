<?php
require_once 'conexao.php';

// Mensagem de erro ou sucesso
$mensagem = "";
$mensagem_classe = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $cpf = $_POST['cpf'];

    // Verifica se o CPF está cadastrado
    $stmt = $conn->prepare("SELECT * FROM usuariocliente WHERE cpf = ?");
    $stmt->bind_param("s", $cpf);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Remove o usuário da tabela 'usuariocliente'
        $stmt = $conn->prepare("DELETE FROM usuariocliente WHERE cpf = ?");
        $stmt->bind_param("s", $cpf);

        if ($stmt->execute()) {
            $mensagem = "Usuário removido com sucesso!";
            $mensagem_classe = 'success';
        } else {
            $mensagem = "Erro ao remover usuário. Tente novamente.";
            $mensagem_classe = 'error';
        }
    } else {
        $mensagem = "CPF não encontrado.";
        $mensagem_classe = 'cpf-error'; // Classe específica para CPF
    }
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Remover Usuário - Bibliolink</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: url('assets/bibliolink.jpg') no-repeat center center fixed;
            background-size: cover;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }
        .register-container {
            background: rgba(255, 255, 255, 0.8);
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 400px;
            text-align: center;
        }
        .register-container img.logo {
            max-width: 150px;
            margin-bottom: 20px;
        }
        .register-container h1 {
            margin-bottom: 20px;
            color: #333;
        }
        .register-container label {
            display: block;
            margin-bottom: 8px;
            font-weight: bold;
            color: #555;
        }
        .register-container input {
            width: calc(100% - 22px);
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ddd;
            border-radius: 4px;
            box-sizing: border-box;
        }
        .register-container button {
            width: 100%;
            padding: 10px;
            background-color: #007bff;
            border: none;
            border-radius: 4px;
            color: #fff;
            font-size: 16px;
            cursor: pointer;
            transition: background-color 0.3s;
        }
        .register-container button:hover {
            background-color: #0056b3;
        }
        .register-container .back-button {
            margin-top: 10px;
            background-color: #6c757d;
        }
        .register-container .back-button:hover {
            background-color: #5a6268;
        }
        .register-container .logout-button {
            margin-top: 10px;
            background-color: #dc3545;
        }
        .register-container .logout-button:hover {
            background-color: #c82333;
        }
        .register-container .message {
            color: #d9534f;
            margin-bottom: 20px;
        }
        .register-container .cpf-error {
            color: red;
            margin-bottom: 20px;
        }
        .register-container .success {
            color: #28a745;
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
    <div class="register-container">
        <img src="assets/logo.png" alt="Logo" class="logo">
        <h1>Consultar Usuário - Bibliolink</h1>
        <?php if (!empty($mensagem)): ?>
            <div class="<?php echo $mensagem_classe; ?>">
                <?php echo htmlspecialchars($mensagem); ?>
            </div>
        <?php endif; ?>
        <form action="removerusuario.php" method="POST">
            <label for="cpf">CPF:</label>
            <input type="text" id="cpf" name="cpf" placeholder="Digite o CPF do usuário" required>
            <button type="submit">Remover Usuário</button>
        </form>
        <form action="home.php" method="get">
            <button type="submit" class="back-button">Voltar</button>
        </form>
        <form action="logout.php" method="post">
            <button type="submit" class="logout-button">Sair</button>
        </form>
    </div>
</body>
</html>