<?php
require_once 'conexao.php';

$nome = $_POST['nome'];
$email = $_POST['email'];
$telefone = $_POST['telefone'];
$cpf = $_POST['cpf'];
$senha = $_POST['senha'];
$confirmar_senha = $_POST['confirmar_senha'];
$tipo_usuario = $_POST['tipo_usuario']; // Adicionado

// Verifica se as senhas são iguais
if ($senha !== $confirmar_senha) {
    header('Location: registro.php?erro=As senhas não conferem');
    exit();
}

// Verifica se o email já está cadastrado
$stmt = $conn->prepare("SELECT * FROM usuario WHERE email = ?");
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    header('Location: registro.php?erro=Email já cadastrado');
    exit();
}

// Verifica se o CPF já está cadastrado
$stmt = $conn->prepare("SELECT * FROM usuario WHERE cpf = ?");
$stmt->bind_param("s", $cpf);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    header('Location: registro.php?erro=CPF já cadastrado');
    exit();
}

$senha_hash = password_hash($senha, PASSWORD_DEFAULT);

// Insere o novo usuário
$stmt = $conn->prepare("INSERT INTO usuario (nome, email, telefone, cpf, senha, tipo_usuario) VALUES (?, ?, ?, ?, ?, ?)");
$stmt->bind_param("ssssss", $nome, $email, $telefone, $cpf, $senha_hash, $tipo_usuario);

if ($stmt->execute()) {
    header('Location: index.php?mensagem=Registro realizado com sucesso! Faça login para continuar.');
} else {
    header('Location: registro.php?erro=Erro ao registrar. Tente novamente.');
}
?>
