<?php
include 'db_connect.php';
session_start();

if (!isset($_SESSION['userid'])) {
    header("Location: login.php");
    exit();
}

$userid = $_SESSION['userid'];
$id = $_GET['id'];

$sql = "SELECT * FROM contatos WHERE id = ? AND user_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ii", $id, $userid);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows == 0) {
    echo "Contato não encontrado!";
    exit();
}

$contact = $result->fetch_assoc();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nome_completo = $_POST['nome_completo'];
    $telefone = $_POST['telefone'];
    $email = $_POST['email'];
    $endereco = $_POST['endereco'];
    $observacoes = $_POST['observacoes'];

    $sql = "UPDATE contatos SET nome_completo = ?, telefone = ?, email = ?, endereco = ?, observacoes = ? WHERE id = ? AND user_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssssii", $nome_completo, $telefone, $email, $endereco, $observacoes, $id, $userid);

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
    <title>Editar Contato</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
<div class="container">
    <h2>Editar Contato</h2>
    <form method="POST" action="edit_contact.php?id=<?= $id ?>">
        <div class="form-group">
            <label for="nome_completo">Nome Completo:</label>
            <input type="text" class="form-control" name="nome_completo" value="<?= htmlspecialchars($contact['nome_completo']) ?>" required>
        </div>
        <div class="form-group">
            <label for="telefone">Telefone:</label>
            <input type="text" class="form-control" name="telefone" value="<?= htmlspecialchars($contact['telefone']) ?>">
        </div>
        <div class="form-group">
            <label for="email">Email:</label>
            <input type="email" class="form-control" name="email" value="<?= htmlspecialchars($contact['email']) ?>">
        </div>
        <div class="form-group">
            <label for="endereco">Endereço:</label>
            <textarea class="form-control" name="endereco"><?= htmlspecialchars($contact['endereco']) ?></textarea>
        </div>
        <div class="form-group">
            <label for="observacoes">Observações:</label>
            <textarea class="form-control" name="observacoes"><?= htmlspecialchars($contact['observacoes']) ?></textarea>
        </div>
        <button type="submit" class="btn btn-primary">Atualizar</button>
        <!-- Botão Voltar -->
        <a href="home.php" class="btn btn-secondary">Voltar</a>
    </form>
</div>
</body>
</html>
