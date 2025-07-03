<?php
include('../includes/db.php');
session_start();

if (!isset($_SESSION['admin'])) {
    header("Location: ../pages/login.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['book_name'];
    $author = $_POST['author'];
    $total = $_POST['total_copies'];
    $available = $_POST['available_copies'];

    $stmt = $conn->prepare("INSERT INTO books (book_name, author, total_copies, available_copies) VALUES (?, ?, ?, ?)");
    $stmt->execute([$name,$author, $total, $available]);

    header("Location: index.php");
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Add New Book</title>
    <link rel="stylesheet" href="../style.css">
    <style>
        .add-form {
            max-width: 500px;
            margin: 60px auto;
            background: #fff;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 0 15px rgba(0,0,0,0.1);
        }

        .add-form h2 {
            text-align: center;
            margin-bottom: 25px;
            color: #007bff;
        }

        .add-form input {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 6px;
        }

        .add-form .buttons {
            display: flex;
            justify-content: space-between;
        }

        .btn {
            flex: 1;
            padding: 10px;
            margin: 0 5px;
            border: none;
            border-radius: 6px;
            font-weight: bold;
            cursor: pointer;
            transition: background 0.3s ease;
        }

        .btn-add {
            background: #28a745;
            color: white;
        }

        .btn-add:hover {
            background: #1e7e34;
        }

        .btn-cancel {
            background: #dc3545;
            color: white;
        }

        .btn-cancel:hover {
            background: #c82333;
        }
    </style>
</head>
<body>
    <div class="add-form">
        <h2>➕ Add New Book</h2>
        <form method="post">
            <input type="text" name="book_name" placeholder="Book Name" required>
            <input type="text" name="author" placeholder="Author Name" required>
            <input type="number" name="total_copies" placeholder="Total Copies" min="1" required>
            <input type="number" name="available_copies" placeholder="Available Copies" min="0" required>

            <div class="buttons">
                <button type="submit" class="btn btn-add">Add Book</button>
                <a href="index.php" class="btn btn-cancel" style="text-align:center; display:inline-block;">Cancel</a>
            </div>
        </form>
    </div>
</body>
</html>
