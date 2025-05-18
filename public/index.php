<?php
session_start();
require '../config/db.php';

$search = $_GET['search'] ?? '';

// Prepare SQL with LIKE for search
$sql = "SELECT * FROM students WHERE name LIKE :search OR id LIKE :search";
$stmt = $pdo->prepare($sql);

// Bind search with wildcards
$searchParam = '%' . $search . '%';
$stmt->bindParam(':search', $searchParam, PDO::PARAM_STR);

// Execute and fetch all results
$stmt->execute();
$students = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Student List</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
    <?php include 'navbar.php'; ?>

    <div class="page-content">
        <h2>Student List</h2>
        <a href="create.php">+ Add New Student</a><br><br>

        <!-- Search Form with Clear Option -->
        <form method="GET" class="search-form">
            <input type="text" name="search" placeholder="Search by name or ID" value="<?= htmlspecialchars($search) ?>">
            <?php if (!empty($search)): ?>
                <a href="index.php" class="clear-search-button">Clear Search</a>
            <?php else: ?>
                <input type="submit" value="Search">
            <?php endif; ?>
        </form>

        <?php if (count($students) > 0): ?>
            <table>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Gender</th>
                    <th>Phone</th>
                    <?php if (!empty($_SESSION['admin'])): ?>
                    <th>Actions</th>
                    <?php endif; ?>
                </tr>
                <?php foreach ($students as $row): ?>
                    <tr>
                        <td><?= htmlspecialchars($row['id']) ?></td>
                        <td><?= htmlspecialchars($row['name']) ?></td>
                        <td><?= htmlspecialchars($row['email']) ?></td>
                        <td><?= htmlspecialchars($row['gender']) ?></td>
                        <td><?= htmlspecialchars($row['phone']) ?></td>
                        <?php if (!empty($_SESSION['admin'])): ?>
                        <td>
                     <a href="edit.php?id=<?= $row['id'] ?>">Edit</a> |
                     <a href="delete.php?id=<?= $row['id'] ?>">Delete</a>
                        </td>
                        <?php endif; ?>
                    </tr>
                <?php endforeach; ?>
            </table>
        <?php else: ?>
            <p>No students found.</p>
        <?php endif; ?>
    </div>
</body>
</html>
