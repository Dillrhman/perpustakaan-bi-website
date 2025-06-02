<?php
include 'konek.php'; // koneksi ke database

$sql = "
SELECT 
  pengembalian.id_kembali,
  peminjaman.id_buku,
  pengembalian.tanggal_kembali,
  pengembalian.denda
FROM pengembalian
JOIN peminjaman ON pengembalian.id_pinjam = peminjaman.id_pinjam
ORDER BY pengembalian.tanggal_kembali DESC
";

$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Daftar Pengembalian - Perpustakaan Bina Informatika</title>
  <link rel="stylesheet" href="css/pengembalian.css" />
</head>
<body>
  <div class="dashboard">
    <aside class="sidebar">
      <div class="logo">
        <img src="css/bina-informatika.png" alt="Logo Bina Informatika" />
        <span>Bina Informatika</span>
      </div>
      <nav class="menu">
        <a href="index2-admin.php" class="active">
          <img src="css/home putih.png" alt="Dashboard" class="icon-photo" />
          Dashboard
        </a>
        <a href="index3-admin.php">
          <img src="css/dashboard putih.png" alt="Peminjaman" class="icon-photo" />
          Peminjaman
        </a>
        <a href="index4-admin.php">
          <img src="css/buku putih.png" alt="Buku" class="icon-photo" />
          Buku
        </a>
        <a href="index5-admin.php">
          <img src="css/staff putih.png" alt="Staff" class="icon-photo" />
          Staff
        </a>
        <a href="index6-admin.php">
          <img src="css/user putih.png" alt="Anggota" class="icon-photo" />
          Anggota
        </a>
        <a href="index7-admin.php">
          <img src="css/laporan putih.png" alt="Laporan" class="icon-photo" />
          <strong>Laporan</strong>
        </a>
      </nav>
      <div class="logout">
        <a href="index.php">
          <img src="css/pintu.png" alt="Logout" class="icon-photo" />
          Logout
        </a>
      </div>
    </aside>

    <main>
      <h1>Daftar Pengembalian</h1>
      <p class="subtitle">Perpustakaan Bina Informatika</p>

      <div class="table-header">
        <div>Buku (ID)</div>
        <div>Tanggal Pengembalian</div>
        <div>Denda (Rp)</div>
      </div>

      <?php if ($result && $result->num_rows > 0): ?>
        <?php while($row = $result->fetch_assoc()): ?>
          <div class="table-row">
            <div><?= htmlspecialchars($row['id_buku']) ?></div>
            <div><?= htmlspecialchars($row['tanggal_kembali']) ?></div>
            <div><?= number_format($row['denda'], 2, ',', '.') ?></div>
          </div>
        <?php endwhile; ?>
      <?php else: ?>
        <p>Tidak ada data pengembalian.</p>
      <?php endif; ?>

    </main>
  </div>
</body>
</html>

<?php
$conn->close();
?>
