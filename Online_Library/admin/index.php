<?php
include('../includes/db.php');
session_start();

if (!isset($_SESSION['admin'])) {
    header("Location: ../pages/login.php");
    exit;
}

$books = $conn->query("SELECT * FROM books")->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html>
<head>
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="../style.css">
    <style>
        .admin-panel {
            max-width: 1000px;
            margin: auto;
            background: #fff;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 0 20px rgba(0,0,0,0.1);
        }

        .admin-header {
            text-align: center;
            margin-bottom: 20px;
        }

        .admin-header h2 {
            margin: 0;
            font-size: 30px;
            color: #007bff;
        }

        .admin-actions {
            text-align: center;
            margin-bottom: 30px;
        }

        .admin-actions a {
            display: inline-block;
            margin: 5px 10px;
            padding: 10px 20px;
            background: #28a745;
            color: white;
            text-decoration: none;
            border-radius: 6px;
            transition: 0.3s;
        }

        .admin-actions a:hover {
            background: #218838;
        }

        .logout-btn {
            background: #dc3545 !important;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            background: white;
        }

        th, td {
            padding: 12px;
            border-bottom: 1px solid #ddd;
            text-align: center;
        }

        th {
            background-color: #007bff;
            color: white;
        }

        tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        .action-btn {
            padding: 5px 10px;
            margin: 0 2px;
            border-radius: 4px;
            text-decoration: none;
            color: white;
        }

        .edit-btn {
            background-color: #ffc107;
        }

        .delete-btn {
            background-color: #dc3545;
        }
    </style>
</head>
<body>
    <div class="admin-panel">
        <div class="admin-header">
            <h2>📚 Admin Dashboard</h2>
        </div>

        <div class="admin-actions">
            <a href="add_book.php">➕ Add New Book</a>
            <a href="../pages/logout.php" class="logout-btn">🚪 Logout</a>
        </div>

        <h3 style="text-align:center;">Library Books</h3>
        <table>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Author</th>
                <th>Total</th>
                <th>Available</th>
                <th>Actions</th>
            </tr>
            <?php foreach ($books as $book): ?>
                <tr>
                    <td><?= $book['book_id'] ?></td>
                    <td><?= $book['book_name'] ?></td>
                    <td><?= $book['author'] ?></td>
                    <td><?= $book['total_copies'] ?></td>
                    <td><?= $book['available_copies'] ?></td>
                    <td>
                        <a href="edit_book.php?id=<?= $book['book_id'] ?>" class="action-btn edit-btn">Edit</a>
                        <a href="delete_book.php?id=<?= $book['book_id'] ?>" class="action-btn delete-btn" onclick="return confirm('Are you sure to delete this book?')">Delete</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </table>
    </div>
</body>
</html>
