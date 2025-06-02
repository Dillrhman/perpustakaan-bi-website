<?php
include 'konek.php'; // koneksi database

// Query untuk hitung total transaksi dan total buku per anggota
$sql = "
    SELECT 
        ag.nama,
        COUNT(pm.id_pinjam) AS total_transaksi,
        COUNT(pm.id_buku) AS total_buku
    FROM anggota ag
    LEFT JOIN peminjaman pm ON ag.id_anggota = pm.id_anggota
    GROUP BY ag.id_anggota
    ORDER BY total_transaksi DESC
";

$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Pinjaman Terbanyak - Perpustakaan Bina Informatika</title>
  <link rel="stylesheet" href="css/pinjaman-terbanyak.css" />
</head>
<body>
  <div class="dashboard">
    <aside class="sidebar">
      <div class="logo">
        <img src="css/bina-informatika.png" alt="Logo" />
        <span>Bina Informatika</span>
      </div>
      <nav class="menu">
        <a href="index2-admin.php" class="active">
          <img src="css/home putih.png" alt="Dashboard" class="icon" />
          Dashboard
        </a>
        <a href="index3-admin.php">
          <img src="css/dashboard putih.png" alt="Peminjaman" class="icon" />
          Peminjaman
        </a>
        <a href="index4-admin.php">
          <img src="css/buku putih.png" alt="Buku" class="icon" />
          Buku
        </a>
        <a href="index5-admin.php">
          <img src="css/staff putih.png" alt="Staff" class="icon" />
          Staff
        </a>
        <a href="index6-admin.php">
          <img src="css/user putih.png" alt="Anggota" class="icon" />
          Anggota
        </a>
        <a href="index7-admin.php">
          <img src="css/laporan putih.png" alt="Laporan" class="icon" />
          Laporan
        </a>
      </nav>
      <div class="logout">
        <a href="index.php">
          <img src="css/pintu.png" alt="Logout" class="icon" />
          Logout
        </a>
      </div>
    </aside>

    <main class="content">
      <h1>Pinjaman Terbanyak</h1>
      <p>Perpustakaan Bina Informatika</p>

      <table>
        <thead>
          <tr>
            <th>Nama</th>
            <th>Total Transaksi</th>
            <th>Total Buku</th>
          </tr>
        </thead>
        <tbody>
          <?php if ($result && $result->num_rows > 0): ?>
            <?php while ($row = $result->fetch_assoc()): ?>
              <tr>
                <td><?= htmlspecialchars($row['nama']) ?></td>
                <td><?= $row['total_transaksi'] ?></td>
                <td><?= $row['total_buku'] ?></td>
              </tr>
            <?php endwhile; ?>
          <?php else: ?>
            <tr>
              <td colspan="3">Data tidak ditemukan.</td>
            </tr>
          <?php endif; ?>
        </tbody>
      </table>
    </main>
  </div>
</body>
</html>
