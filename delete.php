<?php
include "db.php";
session_start();
if (!isset($_SESSION['login'])) {
    header("Location: login.php");
    exit;
}

$id = $_GET['id'];

mysqli_query($conn, "DELETE FROM items WHERE id=$id");

header("Location: index.php");
