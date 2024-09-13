<?php
require_once 'conexao.php';

// Mensagem de erro ou sucesso
$mensagem = "";
$mensagem_classe = "";

// Inicializa variáveis para os campos
$id_autor = $nome_autor = "";

// Se o ID do autor for fornecido, exibe o formulário de edição
if (isset($_GET['id']) && !empty($_GET['id'])) {
    $id_autor = $_GET['id'];

    // Busca as informações do autor com o ID fornecido
    $stmt = $conn->prepare("SELECT * FROM autor WHERE id = ?");
    $stmt->bind_param("i", $id_autor);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $autor = $result->fetch_assoc();

        // Inicializa as variáveis com os valores do autor
        $nome_autor = $autor['nome'] ?? '';

        // Atualiza as informações do autor se o formulário for submetido
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $nome_autor = $_POST['nome'] ?? '';

            // Atualiza o autor na tabela
            $stmt = $conn->prepare("UPDATE autor SET nome = ? WHERE id = ?");
            $stmt->bind_param("si", $nome_autor, $id_autor);

            if ($stmt->execute()) {
                $mensagem = "Autor atualizado com sucesso!";
                $mensagem_classe = 'success';
            } else {
                $mensagem = "Erro ao atualizar o autor. Tente novamente.";
                $mensagem_classe = 'error';
            }
        }
    } else {
        $mensagem = "ID do autor não encontrado.";
        $mensagem_classe = 'error';
    }
} else {
    // Exibe a lista de autores para edição
    $stmt = $conn->prepare("SELECT id, nome FROM autor");
    $stmt->execute();
    $result = $stmt->get_result();
    $autores = $result->fetch_all(MYSQLI_ASSOC);

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $id_autor = $_POST['id'] ?? '';

        if (!empty($id_autor)) {
            header("Location: editarautor.php?id=" . urlencode($id_autor));
            exit();
        } else {
            $mensagem = "Selecione um autor para editar.";
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
    <title>Editar Autor - Bibliolink</title>
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
        <h1>Editar Autor - Bibliolink</h1>
        <?php if (!empty($mensagem)): ?>
            <div class="<?php echo $mensagem_classe; ?>">
                <?php echo htmlspecialchars($mensagem); ?>
            </div>
        <?php endif; ?>
        <?php if (!isset($_GET['id'])): ?>
            <form action="editarautor.php" method="POST">
                <label for="id">Selecione o Autor para Editar:</label>
                <select id="id" name="id" required>
                    <option value="">Selecione um autor</option>
                    <?php foreach ($autores as $autor): ?>
                        <option value="<?php echo htmlspecialchars($autor['id']); ?>">
                            <?php echo htmlspecialchars($autor['nome']); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
                <button type="submit">Editar</button>
            </form>
        <?php else: ?>
            <form action="editarautor.php?id=<?php echo htmlspecialchars($id_autor); ?>" method="POST">
                <label for="nome">Nome do Autor:</label>
                <input type="text" id="nome" name="nome" value="<?php echo htmlspecialchars($nome_autor); ?>">
                <button type="submit">Atualizar Autor</button>
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