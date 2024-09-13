<?php
require_once 'conexao.php';

// Mensagem de erro ou sucesso
$mensagem = "";
$mensagem_classe = "";

// Inicializa variáveis para os campos
$isbn = $titulo = $quantidade_disponivel = $data_publicacao = $status = $genero = $id_editora = "";

// Se o ISBN for fornecido, exibe o formulário de edição
if (isset($_GET['isbn']) && !empty($_GET['isbn'])) {
    $isbn = $_GET['isbn'];

    // Busca as informações do livro com o ISBN fornecido
    $stmt = $conn->prepare("SELECT * FROM cadastrolivro WHERE isbn = ?");
    $stmt->bind_param("s", $isbn);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $livro = $result->fetch_assoc();

        // Inicializa as variáveis com os valores do livro
        $titulo = $livro['titulo'] ?? '';
        $quantidade_disponivel = $livro['quantidadedisponivel'] ?? '';
        $data_publicacao = $livro['datapublicacao'] ?? '';
        $status = $livro['status'] ?? '';
        $genero = $livro['genero'] ?? '';
        $id_editora = $livro['ideditora'] ?? '';

        // Atualiza as informações do livro se o formulário for submetido
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $isbn = $_POST['isbn'] ?? '';
            $titulo = $_POST['titulo'] ?? '';
            $quantidade_disponivel = $_POST['quantidadedisponivel'] ?? '';
            $data_publicacao = $_POST['datapublicacao'] ?? '';
            $status = $_POST['status'] ?? '';
            $genero = $_POST['genero'] ?? '';
            $id_editora = $_POST['ideditora'] ?? '';

            // Verifica se o ID da editora existe
            $stmt = $conn->prepare("SELECT id FROM editoras WHERE id = ?");
            $stmt->bind_param("i", $id_editora);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows > 0) {
                // Atualiza o livro na tabela
                $stmt = $conn->prepare("UPDATE cadastrolivro SET titulo = ?, quantidadedisponivel = ?, datapublicacao = ?, status = ?, genero = ?, ideditora = ? WHERE isbn = ?");
                $stmt->bind_param("sissssi", $titulo, $quantidade_disponivel, $data_publicacao, $status, $genero, $id_editora, $isbn);

                if ($stmt->execute()) {
                    $mensagem = "Livro atualizado com sucesso!";
                    $mensagem_classe = 'success';
                } else {
                    $mensagem = "Erro ao atualizar o livro. Tente novamente.";
                    $mensagem_classe = 'error';
                }
            } else {
                $mensagem = "ID da editora não encontrado.";
                $mensagem_classe = 'error';
            }
        }
    } else {
        $mensagem = "ID do livro não encontrado.";
        $mensagem_classe = 'error';
    }
} else {
    // Exibe a lista de livros para edição
    $stmt = $conn->prepare("SELECT isbn, titulo FROM cadastrolivro");
    $stmt->execute();
    $result = $stmt->get_result();
    $livros = $result->fetch_all(MYSQLI_ASSOC);

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $isbn = $_POST['isbn'] ?? '';

        if (!empty($isbn)) {
            header("Location: editarlivro.php?isbn=" . urlencode($isbn));
            exit();
        } else {
            $mensagem = "Selecione um livro para editar.";
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
    <title>Editar Livro - Bibliolink</title>
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
        <h1>Editar Livro - Bibliolink</h1>
        <?php if (!empty($mensagem)): ?>
            <div class="<?php echo $mensagem_classe; ?>">
                <?php echo htmlspecialchars($mensagem); ?>
            </div>
        <?php endif; ?>
        <?php if (!isset($_GET['isbn'])): ?>
            <form action="editarlivro.php" method="POST">
                <label for="isbn">Selecione o Livro para Editar:</label>
                <select id="isbn" name="isbn" required>
                    <option value="">Selecione um livro</option>
                    <?php foreach ($livros as $livro): ?>
                        <option value="<?php echo htmlspecialchars($livro['isbn']); ?>">
                            <?php echo htmlspecialchars($livro['titulo']); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
                <button type="submit">Editar</button>
            </form>
        <?php else: ?>
            <form action="editarlivro.php?isbn=<?php echo htmlspecialchars($isbn); ?>" method="POST">
                <label for="isbn">ISBN:</label>
                <input type="text" id="isbn" name="isbn" value="<?php echo htmlspecialchars($isbn); ?>" readonly>
                <label for="titulo">Título:</label>
                <input type="text" id="titulo" name="titulo" value="<?php echo htmlspecialchars($titulo); ?>">
                <label for="quantidadedisponivel">Quantidade Disponível:</label>
                <input type="number" id="quantidadedisponivel" name="quantidadedisponivel" value="<?php echo htmlspecialchars($quantidade_disponivel); ?>">
                <label for="datapublicacao">Data de Publicação:</label>
                <input type="date" id="datapublicacao" name="datapublicacao" value="<?php echo htmlspecialchars($data_publicacao); ?>">
                <label for="status">Status:</label>
                <select id="status" name="status">
                    <option value="Disponível" <?php echo ($status == 'Disponível') ? 'selected' : ''; ?>>Disponível</option>
                    <option value="Indisponível" <?php echo ($status == 'Indisponível') ? 'selected' : ''; ?>>Indisponível</option>
                </select>
                <label for="genero">Gênero:</label>
                <input type="text" id="genero" name="genero" value="<?php echo htmlspecialchars($genero); ?>">
                <label for="ideditora">ID Editora:</label>
                <input type="number" id="ideditora" name="ideditora" value="<?php echo htmlspecialchars($id_editora); ?>">
                <button type="submit">Atualizar Livro</button>
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
