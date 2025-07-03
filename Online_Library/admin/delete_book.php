<?php
include('../includes/db.php');
session_start();

if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit;
}

$id = $_GET['id'];
$conn->prepare("DELETE FROM books WHERE book_id = ?")->execute([$id]);

header("Location: index.php");
exit;
?>
