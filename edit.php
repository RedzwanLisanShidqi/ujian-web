<?php
session_start();
if (!isset($_SESSION['login'])) {
    header("Location: login.php");
    exit;
}

include "db.php";

// AMBIL DATA
$id = $_GET['id'];
$result = mysqli_query($conn, "SELECT * FROM items WHERE id=$id");
$item = mysqli_fetch_assoc($result);

if (!$item) {
    die("Data tidak ditemukan!");
}

if (isset($_POST['submit'])) {
    $name  = $_POST['name'];
    $price = $_POST['price'];
    $stock = $_POST['stock'];

    $oldImage = $item['image'];
    $imageName = $oldImage;

    // CEK FILE BARU
    if (!empty($_FILES['image']['name'])) {
        $imageName = time() . "_" . $_FILES['image']['name'];
        move_uploaded_file($_FILES['image']['tmp_name'], "img/" . $imageName);
    }

    mysqli_query($conn, "
        UPDATE items SET 
            name='$name',
            price='$price',
            stock='$stock',
            image='$imageName'
        WHERE id=$id
    ");

    header("Location: index.php");
    exit;
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Edit Barang</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">

    <style>
        .drop-zone {
            width: 250px;
            height: 250px;
            border: 2px dashed #0d6efd;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            text-align: center;
            cursor: pointer;
            color: #6c757d;
            overflow: hidden;
            background: #f8f9fa;
        }
        .drop-zone.dragover {
            background: #e9f2ff;
            border-color: #0056b3;
        }
        .drop-zone img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }
    </style>
</head>

<body class="container py-4">

<h2>Edit Barang</h2>

<form method="POST" enctype="multipart/form-data">

    <div class="mb-3">
        <label>Nama Barang</label>
        <input type="text" name="name" required class="form-control" value="<?= $item['name'] ?>">
    </div>

    <div class="mb-3">
        <label>Harga</label>
        <input type="number" name="price" required class="form-control" value="<?= $item['price'] ?>">
    </div>

    <div class="mb-3">
        <label>Stok</label>
        <input type="number" name="stock" required class="form-control" value="<?= $item['stock'] ?>">
    </div>

    <!-- AREA DRAG & DROP -->
    <div class="mb-3">
        <label class="form-label">Foto Barang</label>

        <div id="dropZone" class="drop-zone">
            <?php if ($item['image']) { ?>
                <img src="img/<?= $item['image'] ?>" id="previewImg">
            <?php } else { ?>
                <span>Drag & Drop atau klik untuk pilih gambar</span>
            <?php } ?>
        </div>

        <!-- INPUT FILE ASLI -->
        <input type="file" name="image" id="imageInput" accept="image/*" hidden>
    </div>

    <button name="submit" class="btn btn-success">Simpan</button>
    <a href="index.php" class="btn btn-secondary">Kembali</a>

</form>

<script>
const dropZone = document.getElementById("dropZone");
const imageInput = document.getElementById("imageInput");

// Klik → buka file
dropZone.addEventListener("click", () => imageInput.click());

// Jika file dipilih manual
imageInput.addEventListener("change", function () {
    if (this.files.length > 0) {
        previewImage(this.files[0]);
    }
});

// Drag masuk
dropZone.addEventListener("dragover", function (e) {
    e.preventDefault();
    dropZone.classList.add("dragover");
});

// Drag keluar
dropZone.addEventListener("dragleave", () => dropZone.classList.remove("dragover"));

// Drop file
dropZone.addEventListener("drop", function (e) {
    e.preventDefault();
    dropZone.classList.remove("dragover");

    const file = e.dataTransfer.files[0];
    imageInput.files = e.dataTransfer.files;  // FIX PENTING!
    previewImage(file);
});

// Preview gambar
function previewImage(file) {
    const reader = new FileReader();
    reader.onload = e => {
        dropZone.innerHTML = `<img id="previewImg" src="${e.target.result}">`;
    };
    reader.readAsDataURL(file);
}
</script>

</body>
</html>
