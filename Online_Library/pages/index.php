<?php
include('../includes/db.php');
session_start();
if (!isset($_SESSION['student'])) {
    header("Location: login.php");
    exit;
}

$student_id = $_SESSION['student'];
$books = $conn->query("SELECT * FROM books")->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Student Dashboard</title>
    <style>
        :root {
            --bg-gradient: linear-gradient(135deg, #667eea, #764ba2);
            --card-bg: rgba(255, 255, 255, 0.95);
            --text-color: #1f2937;
            --header-color: #4c1d95;
            --link-bg: linear-gradient(to right, #4f46e5, #7c3aed);
            --link-hover-bg: linear-gradient(to right, #5b21b6, #8b5cf6);
            --table-th-bg: linear-gradient(to right, #4f46e5, #7c3aed);
            --table-row-hover: #f3f4f6;
        }

        body.dark {
            --bg-gradient: linear-gradient(135deg, #0f2027, #203a43, #2c5364);
            --card-bg: rgba(30, 30, 30, 0.95);
            --text-color: #f0f0f0;
            --header-color: #9f7aea;
            --link-bg: linear-gradient(to right, #6b46c1, #805ad5);
            --link-hover-bg: linear-gradient(to right, #553c9a, #6b46c1);
            --table-th-bg: linear-gradient(to right, #5a189a, #7b2cbf);
            --table-row-hover: #2d2d2d;
        }

        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            font-family: 'Segoe UI', sans-serif;
            background: var(--bg-gradient);
            min-height: 100vh;
            padding: 30px 10px;
            color: var(--text-color);
            transition: background 0.5s, color 0.3s;
        }

        .theme-toggle {
            position: fixed;
            top: 20px;
            right: 30px;
            background: var(--link-bg);
            color: white;
            padding: 8px 14px;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            font-weight: bold;
            transition: background 0.3s;
            z-index: 100;
        }

        .theme-toggle:hover {
            background: var(--link-hover-bg);
        }

        .dashboard {
            max-width: 960px;
            margin: auto;
            background: var(--card-bg);
            padding: 40px;
            border-radius: 15px;
            box-shadow: 0 12px 30px rgba(0,0,0,0.2);
        }

        .header {
            text-align: center;
            margin-bottom: 30px;
        }

        .header h2 {
            margin: 0;
            font-size: 34px;
            color: var(--header-color);
        }

        .nav-links {
            text-align: center;
            margin-bottom: 30px;
        }

        .nav-links a {
            display: inline-block;
            margin: 10px 15px;
            padding: 12px 24px;
            background: var(--link-bg);
            color: white;
            text-decoration: none;
            border-radius: 8px;
            font-weight: bold;
            box-shadow: 0 4px 10px rgba(0,0,0,0.2);
            transition: transform 0.2s ease, background 0.3s;
        }

        .nav-links a:hover {
            background: var(--link-hover-bg);
            transform: scale(1.05);
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
        }

        th, td {
            padding: 14px 12px;
            border-bottom: 1px solid #ddd;
            text-align: center;
            font-size: 16px;
        }

        th {
            background: var(--table-th-bg);
            color: white;
        }

        tr:hover {
            background-color: var(--table-row-hover);
        }

        h3 {
            text-align: center;
            font-size: 24px;
            margin-bottom: 10px;
        }

        @media (max-width: 768px) {
            table, thead, tbody, th, td, tr {
                display: block;
                width: 100%;
            }

            th, td {
                text-align: right;
                padding-left: 50%;
                position: relative;
            }

            th::before, td::before {
                position: absolute;
                left: 15px;
                width: 45%;
                white-space: nowrap;
                font-weight: bold;
                text-align: left;
            }

            th:nth-of-type(1)::before { content: "Book Name"; }
            th:nth-of-type(2)::before { content: "Author"; }
            th:nth-of-type(3)::before { content: "Total Copies"; }
            th:nth-of-type(4)::before { content: "Available"; }
            td:nth-of-type(1)::before { content: "Book Name"; }
            td:nth-of-type(2)::before { content: "Author"; }
            td:nth-of-type(3)::before { content: "Total Copies"; }
            td:nth-of-type(4)::before { content: "Available"; }
        }
    </style>
</head>
<body>
    <button class="theme-toggle" onclick="toggleTheme()">🌙 Toggle Theme</button>

    <div class="dashboard">
        <div class="header">
            <h2>📚 Welcome to Your Dashboard</h2>
        </div>

        <div class="nav-links">
            <a href="issue_book.php">📖 Issue Book</a>
            <a href="return_book.php">📥 Return Book</a>
            <a href="logout.php">🚪 Logout</a>
        </div>

        <h3>📗 Available Books</h3>
        <table>
            <tr>
                <th>Book Name</th>
                <th>Author</th>
                <th>Total Copies</th>
                <th>Available</th>
            </tr>
            <?php foreach ($books as $book): ?>
                <tr>
                    <td><?= htmlspecialchars($book['book_name']) ?></td>
                    <td><?= htmlspecialchars($book['author']) ?></td>
                    <td><?= htmlspecialchars($book['total_copies']) ?></td>
                    <td><?= htmlspecialchars($book['available_copies']) ?></td>
                </tr>
            <?php endforeach; ?>
        </table>
    </div>

    <script>
        // Theme toggle logic
        function toggleTheme() {
            document.body.classList.toggle("dark");
            localStorage.setItem("theme", document.body.classList.contains("dark") ? "dark" : "light");
        }

        // Load saved theme
        window.onload = () => {
            if (localStorage.getItem("theme") === "dark") {
                document.body.classList.add("dark");
            }
        };
    </script>
</body>
</html>
