<?php
require '../config/db.php';

// 1. Validate if ID is provided
if (!isset($_GET['id'])) {
    die('Student ID is required.');
}

$id = $_GET['id'];

// 2. Fetch student data
$stmt = $pdo->prepare("SELECT * FROM students WHERE id = ?");
$stmt->execute([$id]);
$student = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$student) {
    die('Student not found.');
}

// 3. Handle form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name   = $_POST['name'];
    $email  = $_POST['email'];
    $gender = $_POST['gender'];
    $phone  = $_POST['phone'];

    if ($name && $email && $gender && $phone) {
        $stmt = $pdo->prepare("UPDATE students SET name = ?, email = ?, gender = ?, phone = ? WHERE id = ?");
        if ($stmt->execute([$name, $email, $gender, $phone, $id])) {
            header("Location: index.php");
            exit;
        } else {
            $error = "Failed to update student.";
        }
    } else {
        $error = "All fields are required.";
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
        <option value="Other" <?= $student['gender'] === 'Other' ? 'selected' : '' ?>>Other</option>
    </select>
    <input type="text" name="phone" value="<?= htmlspecialchars($student['phone']) ?>" required>
    <button type="submit">Update</button>
</form>

</body>
</html>
