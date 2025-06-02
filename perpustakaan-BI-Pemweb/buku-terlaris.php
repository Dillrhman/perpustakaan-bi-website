<?php
include 'konek.php'; // koneksi database

// Query untuk hitung total pinjam per buku dan ambil data judul buku
$sql = "
    SELECT 
        b.judul,
        COUNT(p.id_pinjam) AS total_pinjam
    FROM buku b
    LEFT JOIN peminjaman p ON b.id_buku = p.id_buku AND p.status = 'dipinjam'
    GROUP BY b.id_buku
    ORDER BY total_pinjam DESC
    LIMIT 10
";

$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Navbar Foto + Buku Terlaris</title>
  <link rel="stylesheet" href="css/buku-terlaris.css" />
</head>
<body>
  <div class="dashboard">
    <nav class="sidebar">
      <div class="logo">
        <img src="css/bina-informatika.png" alt="Logo" />
        <span>Bina Informatika</span>
      </div>

      <div class="menu">
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
          Laporan
        </a>
      </div>

      <div class="logout">
        <a href="index.php">
          <img src="css/pintu.png" alt="Logout" class="icon-photo" />
          Logout
        </a>
      </div>
    </nav>

    <main class="content">
      <h2>Buku Terlaris</h2>
      <p class="subtitle">Perpustakaan Bina Informatika</p>

      <table>
        <thead>
          <tr>
            <th>Judul</th>
            <th>Total Pinjam</th>
          </tr>
        </thead>
        <tbody>
          <?php if ($result && $result->num_rows > 0): ?>
            <?php while ($row = $result->fetch_assoc()): ?>
              <tr>
                <td><?= htmlspecialchars($row['judul']) ?></td>
                <td><?= $row['total_pinjam'] ?></td>
              </tr>
            <?php endwhile; ?>
          <?php else: ?>
            <tr>
              <td colspan="2">Data buku terlaris tidak ditemukan.</td>
            </tr>
          <?php endif; ?>
        </tbody>
      </table>
    </main>
  </div>
</body>
</html>
