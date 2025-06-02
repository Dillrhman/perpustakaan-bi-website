<?php
session_start();
if (!isset($_SESSION['id_akun']) || $_SESSION['role'] !== 'anggota') {
    header("Location: index1-log-anggota.php");
    exit;
}

if (!isset($_GET['kode'])) {
    header("Location: home-anggota.php");
    exit;
}

$kode = htmlspecialchars($_GET['kode']);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Peminjaman Berhasil</title>
    <link rel="stylesheet" href="css/anggota-home.css" />
    <style>
        .container {
            max-width: 400px;
            margin: 100px auto;
            border: 1px solid #000;
            border-radius: 10px;
            padding: 20px;
            text-align: center;
            font-size: 1.2rem;
        }
        a {
            color: #2e5732;
            font-weight: 600;
            text-decoration: none;
        }
        a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
<div class="container">
    <h2>Peminjaman Berhasil!</h2>
    <p>Kode Peminjaman Anda: <strong><?php echo $kode; ?></strong></p>
    <p>Silakan simpan kode ini untuk keperluan pengembalian buku.</p>
    <p><a href="home-anggota.php">Kembali ke Daftar Buku</a></p>
</div>
</body>
</html>
