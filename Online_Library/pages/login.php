<?php
include('../includes/db.php');

session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $pass = $_POST['password'];
    $role = $_POST['role'];

    if ($role === 'student') {
        $stmt = $conn->prepare("SELECT * FROM students WHERE st_email = ?");
        $stmt->execute([$email]);
        $user = $stmt->fetch();

        if ($user && password_verify($pass, $user['st_pass'])) {
            $_SESSION['student'] = $user['st_id'];
            header("Location: index.php");
            exit;
        } else {
            $error = "Invalid student email or password!";
        }

    } elseif ($role === 'admin') {
        $stmt = $conn->prepare("SELECT * FROM admin WHERE admin_id = ?");
        $stmt->execute([$email]);
        $admin = $stmt->fetch();

        if ($admin && $pass === $admin['admin_pass']) {
            $_SESSION['admin'] = $admin['admin_id'];
            header("Location: ../admin/index.php");
            exit;
        } else {
            $error = "Invalid admin ID or password!";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login | Library System</title>
    <style>
        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            font-family: 'Segoe UI', sans-serif;
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            background: linear-gradient(to right, #6a11cb, #2575fc);
        }

        .login-container {
            background: rgba(255, 255, 255, 0.15);
            backdrop-filter: blur(15px);
            border-radius: 16px;
            padding: 40px 30px;
            width: 350px;
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.2);
            color: #fff;
            animation: slideFadeIn 0.6s ease-out;
        }

        @keyframes slideFadeIn {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .login-container h2 {
            text-align: center;
            margin-bottom: 25px;
        }

        label {
            display: block;
            margin-bottom: 6px;
            font-weight: 500;
        }

        input[type="text"], input[type="password"] {
            width: 100%;
            padding: 12px;
            margin-bottom: 20px;
            border: none;
            border-radius: 10px;
            background: rgba(255, 255, 255, 0.2);
            color: #fff;
            font-size: 15px;
            outline: none;
            transition: background 0.3s;
        }

        input[type="text"]:focus, input[type="password"]:focus {
            background: rgba(255, 255, 255, 0.35);
        }

        .role-toggle {
            display: flex;
            justify-content: space-between;
            margin-bottom: 20px;
        }

        .role-toggle input {
            display: none;
        }

        .role-toggle label {
            padding: 10px 15px;
            background-color: rgba(255,255,255,0.2);
            border-radius: 10px;
            cursor: pointer;
            flex: 1;
            text-align: center;
            margin: 0 5px;
            transition: all 0.3s;
        }

        .role-toggle input:checked + label {
            background-color: rgba(255,255,255,0.4);
            font-weight: bold;
            box-shadow: 0 0 8px rgba(255,255,255,0.3);
        }

        button {
            width: 100%;
            padding: 12px;
            border: none;
            border-radius: 10px;
            background-color: #00c6ff;
            color: #fff;
            font-size: 16px;
            font-weight: bold;
            cursor: pointer;
            transition: background 0.3s ease;
        }

        button:hover {
            background-color: #0072ff;
        }

        p {
            text-align: center;
            margin-top: 15px;
        }

        a {
            color: #fff;
            text-decoration: underline;
        }

        .error {
            color: #ffbaba;
            background-color: rgba(255,0,0,0.1);
            padding: 10px;
            text-align: center;
            border-radius: 8px;
            margin-bottom: 15px;
        }
    </style>
</head>
<body>
    <form class="login-container" method="post">
        <h2>Login</h2>

        <?php if (isset($error)) echo "<div class='error'>$error</div>"; ?>

        <div class="role-toggle">
            <input type="radio" id="student" name="role" value="student" required>
            <label for="student">Student</label>

            <input type="radio" id="admin" name="role" value="admin" required>
            <label for="admin">Admin</label>
        </div>

        <label for="email">Email / Admin ID</label>
        <input type="text" id="email" name="email" required>

        <label for="password">Password</label>
        <input type="password" id="password" name="password" required>

        <button type="submit">Login</button>
        <p>New student? <a href="register.php">Register here</a></p>
    </form>
</body>
</html>
