<?php
include('../includes/db.php');
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $admin_id = $_POST['admin_id'];
    $admin_pass = $_POST['admin_pass'];

    $stmt = $conn->prepare("SELECT * FROM admin WHERE admin_id = ? AND admin_pass = ?");
    $stmt->execute([$admin_id, $admin_pass]);
    $admin = $stmt->fetch();

    if ($admin) {
        $_SESSION['admin'] = $admin_id;
        header("Location: login.php");
        exit;
    } else {
        $error = "Invalid Admin Credentials";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Admin Login</title>
    <link rel="stylesheet" href="../style.css">
</head>
<body>
    <h2>Admin Login</h2>
    <?php if (isset($error)) echo "<p style='color:red;'>$error</p>"; ?>
    <form method="post">
        Admin ID: <input type="text" name="admin_id" required><br>
        Password: <input type="password" name="admin_pass" required><br>
        <button type="submit">Login</button>
    </form>
</body>
</html>
