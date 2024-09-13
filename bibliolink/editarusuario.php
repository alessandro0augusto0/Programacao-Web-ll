<?php
require_once 'conexao.php';

// Mensagem de erro ou sucesso
$mensagem = "";
$mensagem_classe = "";

// Variável para verificar se o usuário foi selecionado
$usuarioSelecionado = false;

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['id'])) {
    $id = $_POST['id'];
    $nome = $_POST['nome'];
    $email = $_POST['email'];
    $telefone = $_POST['telefone'];
    $cpf = $_POST['cpf'];

    // Atualiza os dados do usuário
    $stmt = $conn->prepare("UPDATE usuariocliente SET nome = ?, email = ?, telefone = ?, cpf = ? WHERE id = ?");
    $stmt->bind_param("ssssi", $nome, $email, $telefone, $cpf, $id);

    if ($stmt->execute()) {
        $mensagem = "Usuário atualizado com sucesso!";
        $mensagem_classe = 'success';
    } else {
        $mensagem = "Erro ao atualizar usuário. Tente novamente.";
        $mensagem_classe = 'error';
    }
} elseif (isset($_GET['id']) && !empty($_GET['id'])) {
    $id = $_GET['id'];
    $stmt = $conn->prepare("SELECT * FROM usuariocliente WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $user = $stmt->get_result()->fetch_assoc();

    if ($user) {
        $usuarioSelecionado = true;
    } else {
        $mensagem = "Usuário não encontrado.";
        $mensagem_classe = 'error';
    }
}

// Obtém a lista de usuários
$usuarios = [];
$stmt = $conn->prepare("SELECT id, nome FROM usuariocliente");
$stmt->execute();
$result = $stmt->get_result();

while ($row = $result->fetch_assoc()) {
    $usuarios[] = $row;
}

?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Usuário - Bibliolink</title>
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
            max-width: 600px;
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
        .register-container input, .register-container select {
            width: calc(100% - 22px); /* Ajusta o width para acomodar o padding */
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
            color: #d9534f; /* Cor para mensagens de erro */
            margin-bottom: 20px; /* Espaçamento ajustado */
        }
        .register-container .success {
            color: #28a745; /* Cor para mensagens de sucesso */
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
    <div class="register-container">
        <img src="assets/logo.png" alt="Logo" class="logo">
        <h1>Editar Usuário - Bibliolink</h1>
        <?php if (!empty($mensagem)): ?>
            <div class="<?php echo $mensagem_classe; ?>">
                <?php echo htmlspecialchars($mensagem); ?>
            </div>
        <?php endif; ?>

        <!-- Exibe a lista de usuários somente se não houver um usuário selecionado -->
        <?php if (!$usuarioSelecionado): ?>
            <form action="editarusuario.php" method="GET">
                <label for="id">Selecionar Usuário:</label>
                <select id="id" name="id" required>
                    <option value="">Escolha um usuário</option>
                    <?php foreach ($usuarios as $usuario): ?>
                        <option value="<?php echo $usuario['id']; ?>"><?php echo htmlspecialchars($usuario['nome']); ?></option>
                    <?php endforeach; ?>
                </select>
                <button type="submit">Editar</button>
            </form>
        <?php endif; ?>

        <!-- Exibe o formulário de edição somente se um usuário estiver selecionado -->
        <?php if ($usuarioSelecionado): ?>
            <form action="editarusuario.php" method="POST">
                <input type="hidden" name="id" value="<?php echo htmlspecialchars($user['id']); ?>">
                <label for="nome">Nome:</label>
                <input type="text" id="nome" name="nome" value="<?php echo htmlspecialchars($user['nome']); ?>">
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($user['email']); ?>">
                <label for="telefone">Telefone:</label>
                <input type="text" id="telefone" name="telefone" value="<?php echo htmlspecialchars($user['telefone']); ?>">
                <label for="cpf">CPF:</label>
                <input type="text" id="cpf" name="cpf" value="<?php echo htmlspecialchars($user['cpf']); ?>">
                <button type="submit">Atualizar</button>
            </form>
        <?php endif; ?>
        
        <form action="home.php" method="get">
            <button type="submit" class="back-button">Voltar</button>
        </form>
        <form action="logout.php" method="post">
            <button type="submit" class="logout-button">Sair</button>
        </form>
    </div>
</body>
</html>
