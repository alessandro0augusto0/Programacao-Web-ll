<?php
session_start();
require_once 'conexao.php';

// Mensagem de erro ou sucesso
$mensagem = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $senha = $_POST['senha'];
    $tipo_usuario = $_POST['tipo_usuario']; // Obtém o tipo de usuário selecionado

    // Valida se os campos não estão vazios
    if (empty($email) || empty($senha) || empty($tipo_usuario)) {
        $mensagem = "Por favor, preencha todos os campos.";
    } else {
        // Prepara a consulta para verificar o email e a senha
        $stmt = $conn->prepare("SELECT id, senha FROM usuario WHERE email = ? AND tipo_usuario = ?");
        $stmt->bind_param("ss", $email, $tipo_usuario);
        $stmt->execute();
        $result = $stmt->get_result();
        $user = $result->fetch_assoc();

        if ($user) {
            // Verifica se a senha está correta
            if (password_verify($senha, $user['senha'])) {
                // Define o user_id na sessão e redireciona para a página apropriada
                $_SESSION['user_id'] = $user['id'];
                if ($tipo_usuario == 'funcionario') {
                    header('Location: home.php');
                } else if ($tipo_usuario == 'cliente') {
                    header('Location: clientehome.php');
                }
                exit();
            } else {
                $mensagem = "Senha incorreta.";
            }
        } else {
            $mensagem = "Usuário não encontrado ou tipo de usuário incorreto.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Bibliolink</title>
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
        .login-container {
            background: rgba(255, 255, 255, 0.8);
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 400px;
            text-align: center;
        }
        .login-container img.logo {
            max-width: 150px;
            margin-bottom: 20px;
        }
        .login-container h1 {
            margin-bottom: 20px;
            color: #333;
        }
        .login-container label {
            display: block;
            margin-bottom: 8px;
            font-weight: bold;
            color: #555;
        }
        .login-container input,
        .login-container select {
            width: calc(100% - 22px); /* Ajusta o width para acomodar o padding */
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ddd;
            border-radius: 4px;
            box-sizing: border-box;
        }
        .login-container button {
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
        .login-container button:hover {
            background-color: #0056b3;
        }
        .login-container .message {
            color: #d9534f;
            text-align: center;
            margin-bottom: 15px;
        }
        .login-container .success {
            color: #000;
            text-align: center;
            margin-bottom: 15px;
        }
        .login-container .register-link {
            margin-top: 10px;
        }
        .login-container .register-link a {
            color: #007bff;
            text-decoration: none;
        }
        .login-container .register-link a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="login-container">
        <img src="assets/logo.png" alt="Logo" class="logo">
        <h1>Login - Bibliolink</h1>
        <?php if (!empty($mensagem)): ?>
            <div class="<?php echo strpos($mensagem, 'incorreto') !== false || strpos($mensagem, 'não encontrado') !== false ? 'message' : 'success'; ?>">
                <?php echo htmlspecialchars($mensagem); ?>
            </div>
        <?php endif; ?>
        <form action="index.php" method="POST">
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" placeholder="Digite seu email" required>
            <label for="senha">Senha:</label>
            <input type="password" id="senha" name="senha" placeholder="Digite sua senha" required>
            <label for="tipo_usuario">Tipo de Usuário:</label>
            <select id="tipo_usuario" name="tipo_usuario" required>
                <option value="" disabled selected>Selecione</option>
                <option value="cliente">Cliente</option>
                <option value="funcionario">Funcionário</option>
            </select>
            <button type="submit">Entrar</button>
        </form>
        <div class="register-link">
            <p>Não tem uma conta? <a href="registro.php">Registre-se aqui</a></p>
        </div>
    </div>
</body>
</html>
