<?php
include('../includes/db.php');
session_start();

if (!isset($_SESSION['student'])) {
    header("Location: login.php");
    exit;
}

$student_id = $_SESSION['student'];

// Get issued books (not yet returned)
$stmt = $conn->prepare("
    SELECT il.issue_id, b.book_name, b.author, il.issued_date 
    FROM issue_logs il
    JOIN books b ON il.book_id = b.book_id
    WHERE il.st_id = ? AND il.return_date IS NULL
");
$stmt->execute([$student_id]);
$issued_books = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Handle return action
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['issue_id'])) {
    $issue_id = $_POST['issue_id'];

    // Mark book as returned
    $conn->prepare("UPDATE issue_logs SET return_date = CURDATE() WHERE issue_id = ?")->execute([$issue_id]);

    // Increase available copies
    $conn->prepare("
        UPDATE books 
        SET available_copies = available_copies + 1 
        WHERE book_id = (SELECT book_id FROM issue_logs WHERE issue_id = ?)
    ")->execute([$issue_id]);

    header("Location: return_book.php");
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Return Book</title>
    <link rel="stylesheet" href="../style.css">
    <style>
        body {
            background-color: #f5f7fa;
            display: flex;
            justify-content: center;
            align-items: flex-start;
            padding: 50px 20px;
            min-height: 100vh;
            margin: 0;
        }

        .return-container {
            background: #fff;
            padding: 30px;
            border-radius: 12px;
            max-width: 700px;
            width: 100%;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
        }

        h2 {
            text-align: center;
            color: #007bff;
            margin-bottom: 25px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        th, td {
            padding: 12px;
            text-align: center;
            border-bottom: 1px solid #ccc;
        }

        th {
            background-color: #007bff;
            color: white;
        }

        tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        .btn-return {
            padding: 8px 16px;
            background-color: #28a745;
            color: white;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            font-weight: bold;
            transition: background 0.3s ease;
        }

        .btn-return:hover {
            background-color: #218838;
        }

        .no-books {
            text-align: center;
            color: #888;
            font-style: italic;
            margin-top: 20px;
        }

        .back-link {
            display: block;
            text-align: center;
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
    <div class="return-container">
        <h2>📖 Return Issued Books</h2>

        <?php if (count($issued_books) > 0): ?>
            <table>
                <tr>
                    <th>Book</th>
                    <th>Author</th>
                    <th>Issued On</th>
                    <th>Action</th>
                </tr>
                <?php foreach ($issued_books as $book): ?>
                    <tr>
                        <td><?= htmlspecialchars($book['book_name']) ?></td>
                        <td><?= htmlspecialchars($book['author']) ?></td>
                        <td><?= $book['issued_date'] ?></td>
                        <td>
                            <form method="post" style="margin: 0;">
                                <input type="hidden" name="issue_id" value="<?= $book['issue_id'] ?>">
                                <button type="submit" class="btn-return">Return</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </table>
        <?php else: ?>
            <p class="no-books">You have no books to return 🎉</p>
        <?php endif; ?>

        <a href="index.php" class="back-link">← Back to Dashboard</a>
    </div>
</body>
</html>
