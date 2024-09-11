<?php
include 'db_connect.php';
session_start();

if (!isset($_SESSION['userid'])) {
    header("Location: home.php");
    exit();
}

$userid = $_SESSION['userid'];
$id = $_GET['id'];

$sql = "DELETE FROM contatos WHERE id = ? AND user_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ii", $id, $userid);

if ($stmt->execute()) {
    header("Location: home.php");
    exit();
} else {
    echo "Erro: " . $stmt->error;
}

$stmt->close();
?>
