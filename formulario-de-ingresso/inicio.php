<!DOCTYPE html>
<html>
<head>
    <title>Início</title>
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
        }
        h1 {
            text-align: center;
            color: #333;
        }
        label {
            font-weight: bold;
            color: #555;
        }
        input[type="text"], input[type="number"], select {
            width: 100%;
            padding: 8px;
            margin: 5px 0 15px 0;
            border: 1px solid #ccc;
            border-radius: 4px;
        }
        input[type="radio"] {
            margin-right: 5px;
        }
        input[type="radio"] + label {
            margin-right: 20px;
            vertical-align: middle;
        }
        input[type="submit"] {
            background-color: #4CAF50;
            color: white;
            border: none;
            cursor: pointer;
            padding: 10px;
            font-size: 16px;
            border-radius: 4px;
        }
        input[type="submit"]:hover {
            background-color: #45a049;
        }
        .checkbox-group {
            display: flex;
            flex-direction: column;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Formulário de Ingresso</h1>
        <form action="resultado.php" method="post">
            <label for="nome">Nome:</label>
            <input type="text" id="nome" name="nome" required>

            <label for="idade">Idade:</label>
            <input type="number" id="idade" name="idade" required>

            <label for="time">Selecione seu time:</label>
            <select id="time" name="time" required>
                <option value="Time A">Time A</option>
                <option value="Time B">Time B</option>
                <option value="Time C">Time C</option>
                <option value="Time D">Time D</option>
            </select>

            <label>Sexo:</label><br>
            <input type="radio" id="masculino" name="sexo" value="masculino" required>
            <label for="masculino">Masculino</label>
            <input type="radio" id="feminino" name="sexo" value="feminino" required>
            <label for="feminino">Feminino</label><br><br>

            <div class="checkbox-group">
                <label>É sócio-torcedor?</label>
                <input type="checkbox" id="socio" name="socio">

                <label>Foi a algum estádio nos últimos 3 meses?</label>
                <input type="checkbox" id="estadio" name="estadio">

                <label>Seu time ganhou?</label>
                <input type="checkbox" id="ganhou" name="ganhou">
            </div><br>

            <input type="submit" value="Enviar">
        </form>
    </div>
</body>
</html>
