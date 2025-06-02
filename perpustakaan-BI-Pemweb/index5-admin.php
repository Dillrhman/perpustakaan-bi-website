<?php
include 'konek.php'; // Pastikan koneksi database sudah benar

// Ambil data staff dari database
$sql = "SELECT id_staff, id_akun, nama, no_telepon FROM staff ORDER BY id_staff ASC";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Staff Perpustakaan Bina Informatika</title>
  <link rel="stylesheet" href="css/staff.css" />
</head>
<body>
  <div class="dashboard">
    <nav class="sidebar">
      <div class="logo">
        <img src="css/bina-informatika.png" alt="Logo Bina Informatika" />
        <span>Bina Informatika</span>
      </div>
      <div class="menu">
        <a href="index2-admin.php" class="">
          <img src="css/home putih.png" alt="Dashboard" class="menu-icon" />
          Dashboard
        </a>
        <a href="index3-admin.php" class="">
          <img src="css/dashboard putih.png" alt="Peminjaman" class="menu-icon" />
          Peminjaman
        </a>
        <a href="index4-admin.php" class="">
          <img src="css/buku putih.png" alt="Buku" class="menu-icon" />
          Buku
        </a>
        <a href="index5-admin.php" class="active">
          <img src="css/staff putih.png" alt="Staff" class="menu-icon" />
          Staff
        </a>
        <a href="index6-admin.php" class="">
          <img src="css/user putih.png" alt="Anggota" class="menu-icon" />
          Anggota
        </a>
        <a href="index7-admin.php" class="">
          <img src="css/laporan putih.png" alt="Laporan" class="menu-icon" />
          Laporan
        </a>
      </div>
      <div class="logout">
        <a href="index.php">
          <img src="css/pintu.png" alt="Logout" class="menu-icon" />
          Logout
        </a>
      </div>
    </nav>

    <main class="content">
      <h1>Staff</h1>
      <p class="subtitle">Perpustakaan Bina Informatika</p>

      <table class="staff-table">
        <thead>
          <tr>
            <th>Id Staff</th>
            <th>Id Akun</th>
            <th>Nama</th>
            <th>No. Telp</th>
          </tr>
        </thead>
        <tbody>
          <?php if ($result && $result->num_rows > 0): ?>
            <?php while ($row = $result->fetch_assoc()): ?>
              <tr>
                <td><?= htmlspecialchars($row['id_staff']) ?></td>
                <td><?= htmlspecialchars($row['id_akun']) ?></td>
                <td><?= htmlspecialchars($row['nama']) ?></td>
                <td><?= htmlspecialchars($row['no_telepon']) ?></td>
              </tr>
            <?php endwhile; ?>
          <?php else: ?>
            <tr>
              <td colspan="4" style="text-align:center;">Tidak ada data staff.</td>
            </tr>
          <?php endif; ?>
        </tbody>
      </table>
    </main>
  </div>
</body>
</html>
