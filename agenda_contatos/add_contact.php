<?php
include 'db_connect.php';
session_start();

if (!isset($_SESSION['userid'])) {
    header("Location: login.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nome_completo = $_POST['nome_completo'];
    $telefone = $_POST['telefone'];
    $email = $_POST['email'];
    $endereco = $_POST['endereco'];
    $observacoes = $_POST['observacoes'];
    $userid = $_SESSION['userid'];

    $sql = "INSERT INTO contatos (nome_completo, telefone, email, endereco, observacoes, user_id) VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssssi", $nome_completo, $telefone, $email, $endereco, $observacoes, $userid);

    if ($stmt->execute()) {
        header("Location: home.php");
        exit();
    } else {
        echo "Erro: " . $stmt->error;
    }

    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Adicionar Contato</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
<div class="container">
    <h2>Adicionar Contato</h2>
    <form method="POST" action="add_contact.php">
        <div class="form-group">
            <label for="nome_completo">Nome Completo:</label>
            <input type="text" class="form-control" name="nome_completo" required>
        </div>
        <div class="form-group">
            <label for="telefone">Telefone:</label>
            <input type="text" class="form-control" name="telefone">
        </div>
        <div class="form-group">
            <label for="email">Email:</label>
            <input type="email" class="form-control" name="email">
        </div>
        <div class="form-group">
            <label for="endereco">Endereço:</label>
            <textarea class="form-control" name="endereco"></textarea>
        </div>
        <div class="form-group">
            <label for="observacoes">Observações:</label>
            <textarea class="form-control" name="observacoes"></textarea>
        </div>
        <button type="submit" class="btn btn-primary">Adicionar</button>
        <!-- Botão Voltar -->
        <a href="home.php" class="btn btn-secondary">Voltar</a>
    </form>
</div>
</body>
</html>
