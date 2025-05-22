<?php
session_start();
require '../classes/database.php';
require '../classes/student.php';

if (!isset($_SESSION['admin'])) {
    header("Location: ../auth/login.php");
    exit;
}

// Validate ID
$id = $_GET['id'] ?? null;
if (!$id || !is_numeric($id)) {
    header("Location: index.php");
    exit;
}


$db = new Database();
$conn = $db->getConnection();
$studentModel = new Student($conn);

$studentModel->delete((int)$id);


header("Location: index.php");
exit;
