<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Dashboard Perpustakaan</title>
  <link rel="stylesheet" href="css/homepage.css" />
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;700&display=swap" rel="stylesheet" />
  <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
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
  <img src="css/home putih.png" alt="Dashboard Icon" class="menu-icon" />
  Dashboard
</a>
<a href="index3-admin.php">
  <img src="css/dashboard putih.png" alt="Peminjaman Icon" class="menu-icon" />
  Peminjaman
</a>
<a href="index4-admin.php">
  <img src="css/buku putih.png" alt="Buku Icon" class="menu-icon" />
  Buku
</a>
<a href="index5-admin.php">
  <img src="css/staff putih.png" alt="Staff Icon" class="menu-icon" />
  Staff
</a>
<a href="index6-admin.php">
  <img src="css/user putih.png" alt="Anggota Icon" class="menu-icon" />
  Anggota
</a>
<a href="index7-admin.php">
  <img src="css/laporan putih.png" alt="Laporan Icon" class="menu-icon" />
  Laporan
</a>

     <div class="logout">
  <a href="index.php">
    <img src="css/pintu.png" alt="Logout Icon" class="menu-icon" />
    Logout
  </a>
</div>
    </aside>
    <main class="main-content">
      <header>
        <h1>Dashboard</h1>
        <p>Perpustakaan Bina Informatika</p>
      </header>
      <section class="welcome-banner">
        <div class="welcome-text">
          <h2>Welcome, Admin</h2>
          <p>perpustakaan bina informatika</p>
        </div>
        <div class="welcome-image">
          <img src="css/buku-home.png" alt="Books" />
        </div>
      </section>
      
  <section class="cards">
  <a href="notifikasi.php" class="card">
    <div class="icon">
      <img src="css/notifikasi ijo.png" alt="Notifikasi Icon" class="menu-icon" />
    </div>
    <div class="card-text">Notifikasi</div>
  </a>
  <a href="index3-admin.php" class="card">
    <div class="icon">
      <img src="css/buku tanda ijo.png" alt="Peminjaman Icon" class="menu-icon" />
    </div>
    <div class="card-text">Peminjaman</div>
  </a>
  <a href="index7-admin.php" class="card">
    <div class="icon">
      <img src="css/laporan ijo.png" alt="Laporan Icon" class="menu-icon" />
    </div>
    <div class="card-text">Laporan</div>
  </a>
  <a href="index6-admin.php" class="card">
    <div class="icon">
      <img src="css/user ijo.png" alt="Anggota Icon" class="menu-icon" />
    </div>
    <div class="card-text">Anggota</div>
  </a>
</section>

    </main>
  </div>
</body>
</html>
