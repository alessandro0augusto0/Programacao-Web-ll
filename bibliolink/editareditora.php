<?php
require_once 'conexao.php';

// Mensagem de erro ou sucesso
$mensagem = "";
$mensagem_classe = "";

// Inicializa variáveis para os campos
$id_editora = $nome_editora = "";

// Se o ID da editora for fornecido, exibe o formulário de edição
if (isset($_GET['id']) && !empty($_GET['id'])) {
    $id_editora = $_GET['id'];

    // Busca as informações da editora com o ID fornecido
    $stmt = $conn->prepare("SELECT * FROM editoras WHERE id = ?");
    $stmt->bind_param("i", $id_editora);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $editora = $result->fetch_assoc();

        // Inicializa as variáveis com os valores da editora
        $nome_editora = $editora['nome'] ?? '';

        // Atualiza as informações da editora se o formulário for submetido
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $nome_editora = $_POST['nome'] ?? '';

            // Atualiza a editora na tabela
            $stmt = $conn->prepare("UPDATE editoras SET nome = ? WHERE id = ?");
            $stmt->bind_param("si", $nome_editora, $id_editora);

            if ($stmt->execute()) {
                $mensagem = "Editora atualizada com sucesso!";
                $mensagem_classe = 'success';
            } else {
                $mensagem = "Erro ao atualizar a editora. Tente novamente.";
                $mensagem_classe = 'error';
            }
        }
    } else {
        $mensagem = "ID da editora não encontrado.";
        $mensagem_classe = 'error';
    }
} else {
    // Exibe a lista de editoras para edição
    $stmt = $conn->prepare("SELECT id, nome FROM editoras");
    $stmt->execute();
    $result = $stmt->get_result();
    $editoras = $result->fetch_all(MYSQLI_ASSOC);

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $id_editora = $_POST['id'] ?? '';

        if (!empty($id_editora)) {
            header("Location: editareditora.php?id=" . urlencode($id_editora));
            exit();
        } else {
            $mensagem = "Selecione uma editora para editar.";
            $mensagem_classe = 'error';
        }
    }
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Editora - Bibliolink</title>
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
        .edit-container {
            background: rgba(255, 255, 255, 0.8);
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 600px;
            text-align: center;
        }
        .edit-container img.logo {
            max-width: 150px;
            margin-bottom: 20px;
        }
        .edit-container h1 {
            margin-bottom: 20px;
            color: #333;
        }
        .edit-container label {
            display: block;
            margin-bottom: 8px;
            font-weight: bold;
            color: #555;
        }
        .edit-container input, .edit-container select {
            width: calc(100% - 22px); /* Ajusta o width para acomodar o padding */
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ddd;
            border-radius: 4px;
            box-sizing: border-box;
        }
        .edit-container button {
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
        .edit-container button:hover {
            background-color: #0056b3;
        }
        .edit-container .back-button {
            margin-top: 10px;
            background-color: #6c757d;
        }
        .edit-container .back-button:hover {
            background-color: #5a6268;
        }
        .edit-container .logout-button {
            margin-top: 10px;
            background-color: #dc3545;
        }
        .edit-container .logout-button:hover {
            background-color: #c82333;
        }
        .edit-container .message {
            color: #d9534f; /* Cor para mensagens de erro */
            margin-bottom: 20px; /* Espaçamento ajustado */
        }
        .edit-container .success {
            color: #28a745; /* Cor para mensagens de sucesso */
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
    <div class="edit-container">
        <img src="assets/logo.png" alt="Logo" class="logo">
        <h1>Editar Editora - Bibliolink</h1>
        <?php if (!empty($mensagem)): ?>
            <div class="<?php echo $mensagem_classe; ?>">
                <?php echo htmlspecialchars($mensagem); ?>
            </div>
        <?php endif; ?>
        <?php if (!isset($_GET['id'])): ?>
            <form action="editareditora.php" method="POST">
                <label for="id">Selecione a Editora para Editar:</label>
                <select id="id" name="id" required>
                    <option value="">Selecione uma editora</option>
                    <?php foreach ($editoras as $editora): ?>
                        <option value="<?php echo htmlspecialchars($editora['id']); ?>">
                            <?php echo htmlspecialchars($editora['nome']); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
                <button type="submit">Editar</button>
            </form>
        <?php else: ?>
            <form action="editareditora.php?id=<?php echo htmlspecialchars($id_editora); ?>" method="POST">
                <label for="nome">Nome da Editora:</label>
                <input type="text" id="nome" name="nome" value="<?php echo htmlspecialchars($nome_editora); ?>">
                <button type="submit">Atualizar Editora</button>
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