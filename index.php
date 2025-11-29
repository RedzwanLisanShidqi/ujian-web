<?php
include "db.php";
session_start();
if (!isset($_SESSION['login'])) {
    header("Location: login.php");
    exit;
}

// SEARCH
$keyword = isset($_GET['search']) ? $_GET['search'] : '';

// SORTING
$order = "";
if (isset($_GET['sort'])) {
    if ($_GET['sort'] == "name_asc") $order = "ORDER BY name ASC";
    if ($_GET['sort'] == "name_desc") $order = "ORDER BY name DESC";
    if ($_GET['sort'] == "price_low") $order = "ORDER BY price ASC";
    if ($_GET['sort'] == "price_high") $order = "ORDER BY price DESC";
}

$query = "SELECT * FROM items WHERE name LIKE '%$keyword%' $order";
$result = mysqli_query($conn, $query);
?>
<!DOCTYPE html>
<html>

<head>
    <title>Daftar Barang</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>

<body class="container py-5">

<h2 class="text-center mb-4">Daftar Barang</h2>

<div class="d-flex justify-content-between mb-3">
    <a href="add.php" class="btn btn-primary">+ Tambah Barang</a>
    <a href="dashboard.php" class="btn btn-warning">📊 Dashboard</a>
    <a href="logout.php" class="btn btn-danger">Logout</a>
</div>

<!-- SEARCH BAR -->
<form method="GET" class="mb-3">
    <input type="text" name="search" placeholder="Cari barang..." class="form-control"
           style="max-width:300px;" value="<?= $keyword ?>">
</form>

<!-- SORTING -->
<form method="GET" class="mb-4 d-flex gap-2">
    <select name="sort" class="form-select" style="max-width:200px;">
        <option value="">Sortir</option>
        <option value="name_asc">Nama A → Z</option>
        <option value="name_desc">Nama Z → A</option>
        <option value="price_low">Harga Terendah</option>
        <option value="price_high">Harga Tertinggi</option>
    </select>
    <button class="btn btn-secondary">Urutkan</button>
</form>

<!-- TABLE -->
<table class="table table-bordered table-striped">
    <thead class="table-dark">
        <tr>
            <th>Foto</th>
            <th>Nama Barang</th>
            <th>Harga</th>
            <th>Stok</th>
            <th>Aksi</th>
        </tr>
    </thead>

    <tbody>
        <?php while ($row = mysqli_fetch_assoc($result)) : ?>
            <tr>
                <td>
                    <?php if ($row['image']) : ?>
                        <img src="img/<?= $row['image']; ?>" width="70">
                    <?php else : ?>
                        <span class="text-muted">Tidak ada foto</span>
                    <?php endif; ?>
                </td>

                <td><?= $row['name']; ?></td>
                <td>Rp <?= number_format($row['price']); ?></td>
                <td><?= $row['stock']; ?></td>

                <td>
                    <a href="edit.php?id=<?= $row['id']; ?>" class="btn btn-warning btn-sm">Edit</a>

                    <a href="delete.php?id=<?= $row['id']; ?>"
                       class="btn btn-danger btn-sm"
                       onclick="return confirm('Yakin ingin hapus barang ini?');">
                        Delete
                    </a>
                </td>
            </tr>
        <?php endwhile; ?>
    </tbody>
</table>

</body>
</html>
