<?php
include('../includes/db.php');
session_start();

if (!isset($_SESSION['student'])) {
    header("Location: login.php");
    exit;
}

$student_id = $_SESSION['student'];

// Fetch available books for dropdown
$books = $conn->query("SELECT * FROM books WHERE available_copies > 0")->fetchAll(PDO::FETCH_ASSOC);

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $book_id = $_POST['book_id'];
    $issue_date = date('Y-m-d');

    // Insert into issue_logs
    $stmt = $conn->prepare("INSERT INTO issue_logs (st_id, book_id, issued_date) VALUES (?, ?, ?)");
    $stmt->execute([$student_id, $book_id, $issue_date]);

    // Update available copies
    $conn->prepare("UPDATE books SET available_copies = available_copies - 1 WHERE book_id = ?")->execute([$book_id]);

    header("Location: index.php");
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Issue Book</title>
    <link rel="stylesheet" href="../style.css">
    <style>
        body {
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            background: #f4f7fa;
            margin: 0;
        }

        .issue-container {
            background: #fff;
            padding: 30px 40px;
            border-radius: 12px;
            box-shadow: 0 0 15px rgba(0,0,0,0.1);
            max-width: 500px;
            width: 100%;
            text-align: center;
        }

        h2 {
            margin-bottom: 25px;
            color: #007bff;
        }

        select, button {
            width: 100%;
            padding: 12px;
            margin: 15px 0;
            border-radius: 8px;
            border: 1px solid #ccc;
            font-size: 16px;
        }

        button {
            background-color: #007bff;
            color: white;
            border: none;
            font-weight: bold;
            transition: background 0.3s ease;
        }

        button:hover {
            background-color: #0056b3;
        }

        .back-link {
            display: inline-block;
            margin-top: 10px;
            color: #007bff;
            text-decoration: none;
        }

        .back-link:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="issue-container">
        <h2>📚 Issue a Book</h2>
        <form method="post">
            <select name="book_id" required>
                <option value="">-- Select a Book --</option>
                <?php foreach ($books as $book): ?>
                    <option value="<?= $book['book_id'] ?>">
                        <?= $book['book_name'] ?> by <?= $book['author'] ?>
                    </option>
                <?php endforeach; ?>
            </select>
            <button type="submit">Issue Book</button>
        </form>
        <a href="index.php" class="back-link">← Back to Dashboard</a>
    </div>
</body>
</html>
