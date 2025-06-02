<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Laporan</title>
  <link rel="stylesheet" href="css/laporan.css" />
</head>
<body>
  <div class="dashboard">
    <div class="sidebar">
      <div class="logo">
        <img src="css/bina-informatika.png" alt="Logo Bina Informatika" />
        <span>Bina Informatika</span>
      </div>
      <nav class="menu">
        <a href="index2-admin.php" class="active">
          <img src="css/home putih.png" alt="Dashboard" class="menu-icon" />
          Dashboard
        </a>
        <a href="index3-admin.php">
          <img src="css/dashboard putih.png" alt="Peminjaman" class="menu-icon" />
          Peminjaman
        </a>
        <a href="index4-admin.php">
          <img src="css/buku putih.png" alt="Buku" class="menu-icon" />
          Buku
        </a>
        <a href="index5-admin.php">
          <img src="css/staff putih.png" alt="Staff" class="menu-icon" />
          Staff
        </a>
        <a href="index6-admin.php">
          <img src="css/user putih.png" alt="Anggota" class="menu-icon" />
          Anggota
        </a>
        <a href="index7-admin.php">
          <img src="css/laporan putih.png" alt="Laporan" class="menu-icon" />
          Laporan
        </a>
      </nav>
      <div class="logout">
        <a href="index.php">
          <img src="css/pintu.png" alt="Logout" class="menu-icon" />
          Logout
        </a>
      </div>
    </div>

    <div class="content">
      <h1>Laporan</h1>

      <div class="side-menu-boxes">
        <a href="pinjaman-terbanyak.php" class="box green">
          <div class="icon">
            <img src="css/user-penuh.png" alt="Pinjaman Terbanyak" />
          </div>
          <div class="text"><strong>Pinjaman Terbanyak</strong></div>
        </a>

        <a href="buku-terlaris.php" class="box light-gray">
          <div class="icon">
            <img src="css/buku-laporan.png" alt="Buku Terlaris" width="300" height="300" />
          </div>
          <div class="text"><strong>Buku Terlaris</strong></div>
        </a>

        <a href="index3-admin.php" class="box light-gray">
          <div class="icon">
            <img src="https://img.icons8.com/ios-filled/64/2e4732/checklist.png" alt="Daftar Peminjaman" />
          </div>
          <div class="text"><strong>Daftar Peminjaman</strong></div>
        </a>

        <a href="daftar-pengembalian.php" class="box green">
          <div class="icon">
            <img src="https://img.icons8.com/ios-filled/64/ffffff/return.png" alt="Daftar Pengembalian" />
          </div>
          <div class="text"><strong>Daftar Pengembalian</strong></div>
        </a>
      </div>
    </div>
  </div>
</body>
</html>
