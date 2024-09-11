<?php
include 'db_connect.php';

$message = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nome = $_POST['nome'];
    $email = $_POST['email'];
    $senha = $_POST['senha'];
    $confirm_senha = $_POST['confirm_senha'];

    if ($senha === $confirm_senha) {
        $sql = "SELECT id FROM usuarios WHERE email = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            $message = "<div class='alert alert-danger'>Este email já está registrado. Tente outro.</div>";
        } else {
            $hashed_senha = password_hash($senha, PASSWORD_DEFAULT);
            $sql = "INSERT INTO usuarios (nome, email, senha) VALUES (?, ?, ?)";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("sss", $nome, $email, $hashed_senha);

            if ($stmt->execute()) {
                $message = "<div class='alert alert-success'>Parabéns, $nome! Registro realizado com sucesso! Redirecionando para o login...</div>";
                header("refresh:3;url=index.php");
            } else {
                $message = "Erro: " . $stmt->error;
            }
        }

        $stmt->close();
    } else {
        $message = "<div class='alert alert-warning'>As senhas não coincidem. Tente novamente.</div>";
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrar</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    
    <style>
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
            background-color: #007bff;
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
    <a class="navbar-brand" href="index.php">
        <img src="assets/logo.png" alt="Logo Agenda">
        Minha Agenda
    </a>
</nav>

<div class="container d-flex justify-content-center">
    <div class="form-container">
        <h2 class="text-center">Crie sua Conta</h2>

        <?= $message; ?>

        <form method="POST" action="register.php">
            <div class="form-group">
                <label for="nome">Nome:</label>
                <input type="text" class="form-control" name="nome" required maxlength="100" placeholder="Digite seu nome completo">
            </div>
            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" class="form-control" name="email" required maxlength="100" placeholder="Digite seu email">
            </div>
            <div class="form-group">
                <label for="senha">Senha:</label>
                <input type="password" class="form-control" name="senha" required maxlength="100" placeholder="Digite sua senha">
            </div>
            <div class="form-group">
                <label for="confirm_senha">Confirme sua Senha:</label>
                <input type="password" class="form-control" name="confirm_senha" required maxlength="100" placeholder="Confirme sua senha">
            </div>
            <button type="submit" class="btn btn-custom btn-block">Registrar</button>
        </form>

        <!-- Botão de voltar -->
        <a href="index.php" class="btn btn-link mt-3 d-block text-center">Voltar para o Login</a>
    </div>
</div>

</body>
</html>
