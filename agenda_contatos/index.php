<?php
session_start();
include 'db_connect.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $senha = $_POST['senha'];

    $sql = "SELECT id, senha FROM usuarios WHERE email = ?";
    $stmt = $conn->prepare($sql);
    if ($stmt) {
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $stmt->store_result();
        $stmt->bind_result($id, $hashed_password);
        $stmt->fetch();

        if ($stmt->num_rows > 0) {
            if (password_verify($senha, $hashed_password)) {
                $_SESSION['userid'] = $id;
                
                // Redireciona para a página principal após o login bem-sucedido
                header("Location: home.php"); // Alterado aqui
                exit();
            } else {
                $error_message = "Senha incorreta.";
            }
        } else {
            $error_message = "Usuário não encontrado.";
        }
        $stmt->close();
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    
    <style>
        /* Estilos comuns */
        body {
            background-color: #f4f4f9;
        }
        .navbar {
            background-color: #343a40; /* Fundo escuro */
        }
        .navbar-brand img {
            height: 40px;
        }
        .navbar-brand, .navbar-nav .nav-link {
            color: white !important;
        }
        .form-container {
            margin-top: 100px;
            background-color: white;
            padding: 40px;
            border-radius: 8px;
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
            max-width: 600px;
            width: 100%;
        }
        .btn-custom {
            background-color: #007bff; /* Cor azul consistente */
            color: white;
        }
        .btn-custom:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>

<!-- Navbar -->
<nav class="navbar navbar-expand-lg">
    <a class="navbar-brand" href="home.php">
        <img src="assets/logo.png" alt="Logo Agenda">
        Minha Agenda
    </a>
</nav>

<div class="container d-flex justify-content-center">
    <div class="form-container">
        <h2 class="text-center">Faça o Login</h2>

        <!-- Exibe a mensagem de erro -->
        <?php if (!empty($error_message)): ?>
            <div class="alert alert-danger">
                <?= $error_message; ?>
            </div>
        <?php endif; ?>
        
        <form method="POST" action="index.php">
            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" class="form-control" name="email" required placeholder="Digite seu email">
            </div>
            <div class="form-group">
                <label for="senha">Senha:</label>
                <input type="password" class="form-control" name="senha" required placeholder="Digite sua senha">
            </div>
            <button type="submit" class="btn btn-custom btn-block">Login</button>
        </form>

        <!-- Adicionando o botão de registro -->
        <p class="text-center mt-3">Ainda não tem uma conta? <a href="register.php" class="btn btn-link">Registre-se</a></p>
    </div>
</div>

</body>
</html>
