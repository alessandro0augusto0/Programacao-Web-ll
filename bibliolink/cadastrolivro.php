<?php
// Habilita a exibição de erros para depuração
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Conexão com o banco de dados
require_once 'conexao.php';

// Mensagem de erro ou sucesso
$mensagem = "";
$mensagem_classe = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Pegando os dados do formulário
    $isbn = $_POST['isbn'];
    $titulo = $_POST['titulo'];
    $quantidadeDisponivel = $_POST['quantidade'];
    $dataPublicacao = date('Y-m-d', strtotime($_POST['data_publicacao']));
    $status = $_POST['status'];
    $genero = $_POST['genero'];
    $idEditora = $_POST['id_editora'];

    // Verificando se ISBN já existe no banco de dados
    $stmt = $conn->prepare("SELECT * FROM cadastrolivro WHERE ISBN = ?");
    $stmt->bind_param("s", $isbn);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $mensagem = "O livro com esse ISBN já está cadastrado.";
        $mensagem_classe = 'message error'; // classe para mensagem de erro
    } else {
        // Verificando se a editora existe
        $stmt = $conn->prepare("SELECT * FROM editoras WHERE ID = ?");
        $stmt->bind_param("i", $idEditora);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows == 0) {
            $mensagem = "ID da editora não consta no banco de dados. Por favor, adicione a editora antes de cadastrar o livro.";
            $mensagem_classe = 'message error';
        } else {
            // Inserindo no banco de dados
            $stmt = $conn->prepare("INSERT INTO cadastrolivro (ISBN, Titulo, QuantidadeDisponivel, DataPublicacao, Status, Genero, IDeditora) VALUES (?, ?, ?, ?, ?, ?, ?)");
            $stmt->bind_param("ssisssi", $isbn, $titulo, $quantidadeDisponivel, $dataPublicacao, $status, $genero, $idEditora);

            if ($stmt->execute()) {
                $mensagem = "Livro cadastrado com sucesso!";
                $mensagem_classe = 'message success'; // classe para mensagem de sucesso
            } else {
                $mensagem = "Erro ao cadastrar o livro. Tente novamente.";
                $mensagem_classe = 'message error';
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro de Livro - Bibliolink</title>
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
        .cadastro-container input, .cadastro-container select {
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
        .message {
            color: #d9534f;
            text-align: center;
            margin-bottom: 20px; /* Aumenta o espaçamento abaixo da mensagem */
        }
        .success {
            color: #28a745;
            margin-bottom: 20px;
        }
        .error {
            color: #d9534f;
        }
    </style>
</head>
<body>
    <div class="cadastro-container">
        <img src="assets/logo.png" alt="Logo" class="logo">
        <h1>Cadastro de Livro</h1>
        
        <?php if (!empty($mensagem)): ?>
            <div class="<?php echo $mensagem_classe; ?>">
                <?php echo htmlspecialchars($mensagem); ?>
            </div>
        <?php endif; ?>
        
        <form action="cadastrolivro.php" method="POST">
            <label for="isbn">ISBN:</label>
            <input type="text" id="isbn" name="isbn" placeholder="Digite o ISBN do livro" required>
            
            <label for="titulo">Título:</label>
            <input type="text" id="titulo" name="titulo" placeholder="Digite o título do livro" required>
            
            <label for="quantidade">Quantidade Disponível:</label>
            <input type="number" id="quantidade" name="quantidade" placeholder="Digite a quantidade disponível" required>
            
            <label for="data_publicacao">Data de Publicação:</label>
            <input type="date" id="data_publicacao" name="data_publicacao" required>
            
            <label for="status">Status:</label>
            <select id="status" name="status" required>
                <option value="Disponível">Disponível</option>
                <option value="Emprestado">Emprestado</option>
            </select>
            
            <label for="genero">Gênero:</label>
            <input type="text" id="genero" name="genero" placeholder="Digite o gênero do livro" required>
            
            <label for="id_editora">ID da Editora:</label>
            <input type="number" id="id_editora" name="id_editora" placeholder="Digite o ID da editora" required>
            
            <button type="submit">Cadastrar Livro</button>
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
