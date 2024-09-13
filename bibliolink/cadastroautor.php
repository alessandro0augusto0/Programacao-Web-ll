<?php
// Conexão com o banco de dados
require_once 'conexao.php';

// Mensagem de erro ou sucesso
$mensagem = "";

// Verifica se o usuário está logado
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: index.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nome = $_POST['nome'];

    // Valida se o campo nome não está vazio
    if (empty($nome)) {
        $mensagem = "Por favor, preencha o nome do autor.";
    } else {
        // Prepara a consulta para inserir o autor no banco de dados
        $stmt = $conn->prepare("INSERT INTO autor (nome) VALUES (?)");
        $stmt->bind_param("s", $nome);

        if ($stmt->execute()) {
            // Exibe a mensagem de sucesso e mantém a página
            $mensagem = "Autor cadastrado com sucesso! O ID gerado automaticamente é: " . $stmt->insert_id;
        } else {
            $mensagem = "Erro ao cadastrar o autor.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro de Autor - Bibliolink</title>
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
        .cadastro-container {
            background: rgba(255, 255, 255, 0.8);
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 500px;
            text-align: center;
        }
        .cadastro-container img.logo {
            max-width: 150px;
            margin-bottom: 20px;
        }
        .cadastro-container h1 {
            margin-bottom: 20px;
            color: #333;
        }
        .cadastro-container label {
            display: block;
            margin-bottom: 8px;
            font-weight: bold;
            color: #555;
        }
        .cadastro-container input {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ddd;
            border-radius: 4px;
            box-sizing: border-box;
        }
        .cadastro-container button {
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
        .cadastro-container button:hover {
            background-color: #0056b3;
        }
        .cadastro-container .back-button {
            margin-top: 10px;
            background-color: #6c757d;
        }
        .cadastro-container .back-button:hover {
            background-color: #5a6268;
        }
        .cadastro-container .logout-button {
            margin-top: 10px;
            background-color: #dc3545;
        }
        .cadastro-container .logout-button:hover {
            background-color: #c82333;
        }
        .cadastro-container .message {
            color: #d9534f;
            text-align: center;
            margin-bottom: 15px;
        }
        .cadastro-container .success {
            color: #28a745;
            text-align: center;
            margin-bottom: 15px;
        }
    </style>
</head>
<body>
    <div class="cadastro-container">
        <img src="assets/logo.png" alt="Logo" class="logo">
        <h1>Cadastro de Autor</h1>
        
        <?php if (!empty($mensagem)): ?>
            <div class="<?php echo (strpos($mensagem, 'sucesso') !== false) ? 'success' : 'message'; ?>">
                <?php echo htmlspecialchars($mensagem); ?>
            </div>
        <?php endif; ?>
        
        <form action="cadastroautor.php" method="POST">
            <label for="nome">Nome do Autor:</label>
            <input type="text" id="nome" name="nome" placeholder="Digite o nome do autor" required>
            
            <button type="submit">Cadastrar Autor</button>
        </form>
        
        <form action="home.php" method="get">
            <button type="submit" class="back-button">Voltar</button>
        </form>
        
        <form action="logout.php" method="get">
            <button type="submit" class="logout-button">Sair</button>
        </form>
    </div>
</body>
</html>
