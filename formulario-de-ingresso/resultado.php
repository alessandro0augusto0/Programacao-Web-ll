<!DOCTYPE html>
<html>
<head>
    <title>Resultado</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f0f0f0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }
        .container {
            background-color: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            width: 300px;
            text-align: center;
        }
        h1 {
            color: #333;
        }
        p {
            color: #555;
            font-weight: bold;
            margin: 10px 0;
        }
        .result {
            font-size: 16px;
            line-height: 1.6;
            margin-bottom: 20px;
        }
        .back-button {
            background-color: #4CAF50;
            color: white;
            padding: 10px 20px;
            text-decoration: none;
            border-radius: 4px;
            font-size: 16px;
            display: inline-block;
        }
        .back-button:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Resultado do Ingresso</h1>
        <div class="result">
            <?php
            $nome = isset($_POST['nome']) ? $_POST['nome'] : '';
            $idade = isset($_POST['idade']) ? $_POST['idade'] : 0;
            $time = isset($_POST['time']) ? $_POST['time'] : '';
            $sexo = isset($_POST['sexo']) ? $_POST['sexo'] : '';
            $socio = isset($_POST['socio']) ? true : false;
            $estadio = isset($_POST['estadio']) ? true : false;
            $ganhou = isset($_POST['ganhou']) ? true : false;

            $valorIngresso = 120.00;
            $desconto = 0;

            if ($idade < 18) {
                $desconto += 0.30;
            }

            if ($sexo == 'feminino') {
                $desconto += 0.20;
            }

            if ($socio) {
                $desconto += 0.05;
            }

            if ($estadio) {
                $desconto += 0.05;
            }

            if ($ganhou) {
                $desconto += 0.02;
            }

            $valorFinal = $valorIngresso * (1 - $desconto);

            echo "<p>Nome: " . htmlspecialchars($nome) . "</p>";
            echo "<p>Idade: " . htmlspecialchars($idade) . "</p>";
            echo "<p>Time: " . htmlspecialchars($time) . "</p>";
            echo "<p>Sexo: " . htmlspecialchars($sexo) . "</p>";
            echo "<p>É sócio-torcedor: " . ($socio ? "Sim" : "Não") . "</p>";
            echo "<p>Foi a algum estádio nos últimos 3 meses: " . ($estadio ? "Sim" : "Não") . "</p>";
            echo "<p>Seu time ganhou: " . ($ganhou ? "Sim" : "Não") . "</p>";
            echo "<p>Valor final do ingresso: R$ " . number_format($valorFinal, 2, ',', '.') . "</p>";
            ?>
        </div>
        <a href="inicio.php" class="back-button">Voltar</a>
    </div>
</body>
</html>
