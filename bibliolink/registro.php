<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro - Bibliolink</title>
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
        .register-container {
            background: rgba(255, 255, 255, 0.8);
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 400px;
            text-align: center;
        }
        .register-container img.logo {
            max-width: 150px;
            margin-bottom: 20px;
        }
        .register-container h1 {
            margin-bottom: 20px;
            color: #333;
        }
        .register-container label {
            display: block;
            margin-bottom: 8px;
            font-weight: bold;
            color: #555;
        }
        .register-container input,
        .register-container select {
            width: calc(100% - 22px); /* Ajusta o width para acomodar o padding */
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ddd;
            border-radius: 4px;
            box-sizing: border-box;
        }
        .register-container button {
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
        .register-container button:hover {
            background-color: #0056b3;
        }
        .register-container .back-button {
            margin-top: 10px;
            background-color: #6c757d;
        }
        .register-container .back-button:hover {
            background-color: #5a6268;
        }
        .register-container .message {
            color: #d9534f;
            margin-bottom: 15px;
        }
        .register-container .success {
            color: #5bc0de;
        }
    </style>
</head>
<body>
    <div class="register-container">
        <img src="assets/logo.png" alt="Logo" class="logo">
        <h1>Registro - Bibliolink</h1>
        <?php if (isset($_GET['erro'])): ?>
            <div class="message"><?php echo htmlspecialchars($_GET['erro']); ?></div>
        <?php endif; ?>
        <?php if (isset($_GET['mensagem'])): ?>
            <div class="success"><?php echo htmlspecialchars($_GET['mensagem']); ?></div>
        <?php endif; ?>
        <form action="processar_registro.php" method="POST">
            <label for="nome">Nome:</label>
            <input type="text" id="nome" name="nome" placeholder="Digite seu nome completo" required>
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" placeholder="Digite seu email" required>
            <label for="telefone">Telefone:</label>
            <input type="text" id="telefone" name="telefone" placeholder="Digite seu telefone" required>
            <label for="cpf">CPF:</label>
            <input type="text" id="cpf" name="cpf" placeholder="Digite seu CPF" required>
            <label for="senha">Senha:</label>
            <input type="password" id="senha" name="senha" placeholder="Digite sua senha" required>
            <label for="confirmar_senha">Confirmar Senha:</label>
            <input type="password" id="confirmar_senha" name="confirmar_senha" placeholder="Confirme sua senha" required>
            <label for="tipo_usuario">Tipo de Usuário:</label>
            <select id="tipo_usuario" name="tipo_usuario" required>
                <option value="cliente">Cliente</option>
                <option value="funcionario">Funcionário</option>
            </select>
            <button type="submit">Registrar</button>
        </form>
        <form action="index.php" method="get">
            <button type="submit" class="back-button">Voltar</button>
        </form>
    </div>
</body>
</html>
