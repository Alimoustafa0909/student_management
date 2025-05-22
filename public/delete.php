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

// Initialize database and student class
$db = new Database();
$conn = $db->getConnection();
$studentModel = new Student($conn);

// Delete student
$studentModel->delete((int)$id);

// Redirect
header("Location: index.php");
exit;
