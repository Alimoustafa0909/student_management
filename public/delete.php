<?php
session_start();
require '../config/db.php';


if (!isset($_SESSION['admin'])) {
    header("Location: ../auth/login.php");
    exit;
}

$id = $_GET['id'];
if ($id && is_numeric($id)) {
    $stmt = $pdo->prepare("DELETE FROM students WHERE id = ?");
    $stmt->execute([$id]);
}

header("Location: index.php");
exit;
?>


