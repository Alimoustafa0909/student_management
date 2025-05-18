<?php
session_start();
require '../config/db.php';


if (!isset($_SESSION['admin'])) {
    header("Location: ../auth/login.php");
    exit;
}

$id = $_GET['id'];

$selectQuery = $pdo->prepare("SELECT * FROM students WHERE id = ?");
$selectQuery->execute([$id]);
$student = $selectQuery->fetch(PDO::FETCH_ASSOC);

if (!$student) {
    die('Student not found.');
}

function validateStudent($name, $email, $gender, $phone) {
    if (!$name || !$email || !$gender || !$phone) {
        return "All fields are required.";
    }

    if (!preg_match('/^[0-9]{1,12}$/', $phone)) {
        return "Phone must be number and 12 number only.";
    }

    return null; 
}


if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name   = $_POST['name'];
    $email  = $_POST['email'];
    $gender = $_POST['gender'];
    $phone  = $_POST['phone'];

    $error = validateStudent($name, $email, $gender, $phone);

    if (!$error) {
        $query = $pdo->prepare("UPDATE students SET name = ?, email = ?, gender = ?, phone = ? WHERE id = ?");
        if ($query->execute([$name, $email, $gender, $phone, $id])) {
            header("Location: index.php");
            exit;
        } else {
            $error = "Failed to update student.";
        }
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
    <p style="color:red; text-align:center;"><?= htmlspecialchars($error) ?></p>
<?php endif; ?>

<form method="POST" class="create-form">
    <input type="text" name="name" value="<?= htmlspecialchars($student['name']) ?>" required>
    <input type="email" name="email" value="<?= htmlspecialchars($student['email']) ?>" required>
    <select name="gender" required>
        <option value="">Select Gender</option>
        <option value="Male" <?= $student['gender'] === 'Male' ? 'selected' : '' ?>>Male</option>
        <option value="Female" <?= $student['gender'] === 'Female' ? 'selected' : '' ?>>Female</option>
    </select>
    <input type="text" name="phone" value="<?= htmlspecialchars($student['phone']) ?>" required>
    <button type="submit">Update</button>
</form>
</div>
</body>
</html>
