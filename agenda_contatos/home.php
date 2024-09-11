<?php
include 'db_connect.php';
session_start();

if (!isset($_SESSION['userid'])) {
    header("Location: login.php");
    exit();
}

$userid = $_SESSION['userid'];

$sql = "SELECT id, nome_completo, telefone, email FROM contatos WHERE user_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $userid);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agenda de Contatos</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            background-color: #f4f4f9;
        }
        .navbar {
            background-color: #343a40; /* Fundo escuro */
        }
        .navbar-brand img {
            height: 40px; /* Tamanho da logo */
        }
        .navbar-brand, .navbar-nav .nav-link {
            color: white !important;
        }
        .btn-custom {
            background-color: #28a745;
            color: white;
        }
        .btn-custom:hover {
            background-color: #218838;
            color: white;
        }
        .table-hover tbody tr:hover {
            background-color: #f1f1f1;
        }
        .footer {
            background-color: #343a40;
            color: white;
            text-align: center;
            padding: 10px;
            position: fixed;
            left: 0;
            bottom: 0;
            width: 100%;
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
    <div class="collapse navbar-collapse">
        <ul class="navbar-nav ml-auto">
            <li class="nav-item">
                <a class="nav-link" href="logout.php">Logout</a>
            </li>
        </ul>
    </div>
</nav>

<div class="container mt-5">
    <div class="row">
        <div class="col-md-12">
            <h2 class="mb-4">Meus Contatos</h2>
            <a href="add_contact.php" class="btn btn-custom mb-3"><i class="fas fa-plus-circle"></i> Adicionar Contato</a>
            <table class="table table-bordered table-hover">
                <thead class="thead-dark">
                    <tr>
                        <th>Nome Completo</th>
                        <th>Telefone</th>
                        <th>Email</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?= htmlspecialchars($row['nome_completo']) ?></td>
                        <td><?= htmlspecialchars($row['telefone']) ?></td>
                        <td><?= htmlspecialchars($row['email']) ?></td>
                        <td>
                            <a href="edit_contact.php?id=<?= $row['id'] ?>" class="btn btn-warning btn-sm"><i class="fas fa-edit"></i> Editar</a>
                            <a href="delete_contact.php?id=<?= $row['id'] ?>" class="btn btn-danger btn-sm" onclick="return confirmDelete('<?= htmlspecialchars($row['nome_completo']) ?>')"><i class="fas fa-trash"></i> Excluir</a>
                        </td>
                    </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Footer -->
<div class="footer">
    <p>&copy; 2024 Minha Agenda de Contatos. Todos os direitos reservados.</p>
</div>

<!-- Função de confirmação de exclusão -->
<script>
    function confirmDelete(contactName) {
        return confirm('Você tem certeza que deseja excluir o contato "' + contactName + '"? Esta ação não pode ser desfeita.');
    }
</script>

<script src="https://kit.fontawesome.com/a076d05399.js"></script>
</body>
</html>

<?php
$stmt->close();
?>
