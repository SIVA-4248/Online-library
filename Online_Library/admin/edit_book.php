<?php
include('../includes/db.php');
session_start();

if (!isset($_SESSION['admin'])) {
    header("Location: ../pages/login.php");
    exit;
}

$book_id = $_GET['id'] ?? null;
if (!$book_id) {
    echo "Book ID is missing.";
    exit;
}

// Get existing book details
$stmt = $conn->prepare("SELECT * FROM books WHERE book_id = ?");
$stmt->execute([$book_id]);
$book = $stmt->fetch();

if (!$book) {
    echo "Book not found.";
    exit;
}

// Handle update form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['book_name'];
    $author = $_POST['author'];
    $total = $_POST['total_copies'];
    $available = $_POST['available_copies'];

    $update = $conn->prepare("UPDATE books SET book_name = ?, author = ?, total_copies = ?, available_copies = ? WHERE book_id = ?");
    $update->execute([$name, $author, $total, $available, $book_id]);

    header("Location: index.php");
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Book</title>
    <link rel="stylesheet" href="../style.css">
    <style>
        .edit-form {
            max-width: 500px;
            margin: 60px auto;
            background: #fff;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 0 15px rgba(0,0,0,0.1);
        }

        .edit-form h2 {
            text-align: center;
            margin-bottom: 25px;
            color: #007bff;
        }

        .edit-form input {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 6px;
            box-sizing: border-box;
        }

        .edit-form .buttons {
            display: flex;
            justify-content: space-between;
        }

        .edit-form .btn {
            flex: 1;
            padding: 10px;
            margin: 0 5px;
            border: none;
            border-radius: 6px;
            font-weight: bold;
            cursor: pointer;
            transition: background 0.3s ease;
        }

        .btn-update {
            background: #007bff;
            color: white;
        }

        .btn-update:hover {
            background: #0056b3;
        }

        .btn-cancel {
            background: #dc3545;
            color: white;
        }

        .btn-cancel:hover {
            background: #b52a38;
        }
    </style>
</head>
<body>
    <div class="edit-form">
        <h2>✏️ Edit Book</h2>
        <form method="post">
            <input type="text" name="book_name" value="<?= htmlspecialchars($book['book_name']) ?>" placeholder="Book Name" required>
            <input type="text" name="author" value="<?= htmlspecialchars($book['author']) ?>" placeholder="Author Name" required>
            <input type="number" name="total_copies" value="<?= $book['total_copies'] ?>" placeholder="Total Copies" min="1" required>
            <input type="number" name="available_copies" value="<?= $book['available_copies'] ?>" placeholder="Available Copies" min="0" required>

            <div class="buttons">
                <button type="submit" class="btn btn-update">Update Book</button>
                <a href="index.php" class="btn btn-cancel" style="text-align:center; display:inline-block;">Cancel</a>
            </div>
        </form>
    </div>
</body>
</html>
