<?php
require_once 'conexao.php';

// Consulta todas as editoras
$stmt = $conn->prepare("SELECT id, nome FROM editoras");
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Consulta de Editoras - Bibliolink</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: url('assets/bibliolink.jpg') no-repeat center center fixed;
            background-size: cover;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }
        .consulta-container {
            background: rgba(255, 255, 255, 0.9);
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            width: 90%;
            max-width: 900px;
            text-align: center;
        }
        .consulta-container h1 {
            margin-bottom: 20px;
            color: #333;
            font-size: 24px;
        }
        .consulta-container table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        .consulta-container table, th, td {
            border: 1px solid #ddd;
        }
        .consulta-container th, td {
            padding: 12px;
            text-align: left;
        }
        .consulta-container th {
            background-color: #f8f8f8;
            color: #333;
        }
        .consulta-container tr:nth-child(even) {
            background-color: #f2f2f2;
        }
        .consulta-container .back-button {
            padding: 12px 20px;
            background-color: #007bff;
            border: none;
            border-radius: 5px;
            color: #fff;
            font-size: 16px;
            cursor: pointer;
            transition: background-color 0.3s;
        }
        .consulta-container .back-button:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <div class="consulta-container">
        <h1>Consulta de Editoras - Bibliolink</h1>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nome</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($row['id']); ?></td>
                        <td><?php echo htmlspecialchars($row['nome']); ?></td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
        <form action="home.php" method="get">
            <button type="submit" class="back-button">Voltar</button>
        </form>
    </div>
</body>
</html>