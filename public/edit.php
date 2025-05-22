<?php
session_start();
require '../classes/database.php';
require '../classes/student.php';
require '../classes/Validator.php';

if (!isset($_SESSION['admin'])) {
    header("Location: ../auth/login.php");
    exit;
}


$db = new Database();
$conn = $db->getConnection();
$studentModel = new Student($conn);

// Get student ID
$id = $_GET['id'] ?? null;
if (!$id) {
    die('Invalid student ID.');
}

// Fetch student data
$student = $studentModel->getById((int)$id);
if (!$student) {
    die('Student not found.');
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name   = $_POST['name'];
    $email  = $_POST['email'];
    $gender = $_POST['gender'];
    $phone  = $_POST['phone'];

    $error = Validator::validateStudent($name, $email, $gender, $phone);

    if (!$error) {
        $studentModel->update($id, $name, $email, $gender, $phone);
        header("Location: index.php");
        exit;
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Student</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
<?php include 'navbar.php'; ?>

<div class="page-content">
    <h2>Edit Student</h2>

    <?php if (!empty($error)): ?>
        <p class="error"><?= $error ?></p>
    <?php endif; ?>

    <form method="POST" class="create-form">
        <input type="text" name="name" value="<?= $student['name'] ?>" required>
        <input type="email" name="email" value="<?= $student['email'] ?>" required>
        <select name="gender" required>
            <option value="">Select Gender</option>
            <option value="Male" <?= $student['gender'] === 'Male' ? 'selected' : '' ?>>Male</option>
            <option value="Female" <?= $student['gender'] === 'Female' ? 'selected' : '' ?>>Female</option>
        </select>
        <input type="text" name="phone" value="<?= $student['phone'] ?>" required>
        <button class="add-button" type="submit">Update</button>
    </form>
</div>
</body>
</html>
