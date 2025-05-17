<?php
require '../config/db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name   = $_POST['name'];
    $email  = $_POST['email'];
    $gender = $_POST['gender'];
    $phone  = $_POST['phone'];

    if ($name && $email && $gender && $phone) {
        $stmt = $pdo->prepare("INSERT INTO students (name, email, gender, phone) VALUES (?, ?, ?, ?)");
         $stmt->execute([$name, $email, $gender, $phone]);
            header("Location: index.php");
        
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Add New Student</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>

<h2>Add New Student</h2>

<?php if (!empty($error)): ?>
    <p style="color:red; text-align:center;"><?= htmlspecialchars($error) ?></p>
<?php endif; ?>

<form method="POST" class="create-form">
    <input type="text" name="name" placeholder="Your Name" required>
    <input type="email" name="email" placeholder="Your Email" required>
    <select name="gender" required>
        <option value="">Select Gender</option>
        <option value="Male">Male</option>
        <option value="Female">Female</option>
    </select>
    <input type="text" name="phone" placeholder="Your Phone" required>
    <button type="submit">Save</button>
</form>

</body>
</html>
