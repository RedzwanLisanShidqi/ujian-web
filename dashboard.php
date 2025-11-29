<?php
include "db.php";
session_start();
if (!isset($_SESSION['login'])) {
    header("Location: login.php");
    exit;
}

$total = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) AS t FROM items"))['t'];

$stok = mysqli_fetch_assoc(mysqli_query($conn, "SELECT SUM(stock) AS s FROM items"))['s'];

$min = mysqli_fetch_assoc(mysqli_query($conn, "SELECT MIN(price) AS p FROM items"))['p'];

$max = mysqli_fetch_assoc(mysqli_query($conn, "SELECT MAX(price) AS p FROM items"))['p'];
?>

<!DOCTYPE html>
<html>
<head>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>

<body class="container py-5">

<h3>Dashboard</h3>

<div class="row mt-4">

    <div class="col-md-3">
        <div class="p-3 bg-primary text-white rounded">
            <h5>Total Barang</h5>
            <h3><?= $total ?></h3>
        </div>
    </div>

    <div class="col-md-3">
        <div class="p-3 bg-success text-white rounded">
            <h5>Total Stok</h5>
            <h3><?= $stok ?></h3>
        </div>
    </div>

    <div class="col-md-3">
        <div class="p-3 bg-warning text-white rounded">
            <h5>Harga Termurah</h5>
            <h3>Rp<?= number_format($min) ?></h3>
        </div>
    </div>

    <div class="col-md-3">
        <div class="p-3 bg-danger text-white rounded">
            <h5>Harga Termahal</h5>
            <h3>Rp<?= number_format($max) ?></h3>
        </div>
    </div>

</div>

<a href="index.php" class="btn btn-secondary mt-4">Kembali</a>

</body>
</html>
