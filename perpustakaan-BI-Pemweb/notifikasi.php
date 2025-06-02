<?php
include 'konek.php'; // koneksi database

// Query gabungan notifikasi peminjaman dan pengembalian terbaru
$sql = "
    SELECT 
        'Peminjaman' AS jenis,
        pm.id_pinjam,
        ag.nama AS nama_anggota,
        bk.judul AS judul_buku,
        pm.tanggal_pinjam,
        pm.tanggal_kembali,
        pm.status,
        pm.create_date
    FROM peminjaman pm
    LEFT JOIN anggota ag ON pm.id_anggota = ag.id_anggota
    LEFT JOIN buku bk ON pm.id_buku = bk.id_buku

    UNION ALL

    SELECT
        'Pengembalian' AS jenis,
        pg.id_kembali AS id_pinjam,
        ag.nama AS nama_anggota,
        bk.judul AS judul_buku,
        NULL AS tanggal_pinjam,
        pg.tanggal_kembali,
        'kembali' AS status,
        pg.create_date
    FROM pengembalian pg
    LEFT JOIN peminjaman pm ON pg.id_pinjam = pm.id_pinjam
    LEFT JOIN anggota ag ON pm.id_anggota = ag.id_anggota
    LEFT JOIN buku bk ON pm.id_buku = bk.id_buku

    ORDER BY create_date DESC
    LIMIT 10
";

$result = $conn->query($sql);

$notifications = [];
if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $notifications[] = $row;
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Notifikasi - Perpustakaan Bina Informatika</title>
  <link rel="stylesheet" href="css/notifikasi.css" />
  <!-- FontAwesome atau ikon lain bisa ditambahkan di sini jika perlu -->
</head>
<body>
  <div class="dashboard">
    <aside class="sidebar">
      <div class="logo">
        <img src="css/bina-informatika.png" alt="Logo Bina Informatika" />
        <span>Bina Informatika</span>
      </div>
      <nav class="menu">
        <a href="index2-admin.php">
          <img src="css/home putih.png" alt="Dashboard" class="menu-icon" /> Dashboard
        </a>
        <a href="index3-admin.php">
          <img src="css/dashboard putih.png" alt="Peminjaman" class="menu-icon" /> Peminjaman
        </a>
        <a href="index4-admin.php">
          <img src="css/buku putih.png" alt="Buku" class="menu-icon" /> Buku
        </a>
        <a href="index5-admin.php">
          <img src="css/staff putih.png" alt="Staff" class="menu-icon" /> Staff
        </a>
        <a href="index6-admin.php">
          <img src="css/user putih.png" alt="Anggota" class="menu-icon" /> Anggota
        </a>
        <a href="index7-admin.php">
          <img src="css/laporan putih.png" alt="Laporan" class="menu-icon" /> Laporan
        </a>
        <a href="notifikasi.php" class="active">
          <img src="css/notifikasi ijo.png" alt="Notifikasi" class="menu-icon" /> Notifikasi
        </a>
      </nav>
      <div class="logout">
        <a href="index.php">
          <img src="css/pintu.png" alt="Logout" class="menu-icon" /> Logout
        </a>
      </div>
    </aside>

    <main class="main-content">
      <header>
        <h1>Notifikasi</h1>
        <p>Perpustakaan Bina Informatika</p>
      </header>

      <section class="notifications">
        <ul class="notification-list">
          <?php if (count($notifications) > 0): ?>
            <?php foreach ($notifications as $notif): ?>
              <li class="notification-item">
                <div class="notif-icon">
                  <img src="css/notifikasi ijo.png" alt="Info" class="menu-icon" />
                </div>
                <div class="notif-content">
                  <?php if ($notif['jenis'] == 'Peminjaman'): ?>
                    <p>
                      <strong>Status peminjaman:</strong> Buku "<em><?= htmlspecialchars($notif['judul_buku']) ?></em>" dipinjam oleh anggota <em><?= htmlspecialchars($notif['nama_anggota']) ?></em>
                      sejak tanggal <?= $notif['tanggal_pinjam'] ?> sampai <?= $notif['tanggal_kembali'] ?>. Status: <strong><?= $notif['status'] ?></strong>.
                    </p>
                    <span class="notif-date"><?= $notif['create_date'] ?></span>
                  <?php else: /* Pengembalian */ ?>
                    <p>
                      <strong>Pengembalian buku:</strong> Buku "<em><?= htmlspecialchars($notif['judul_buku']) ?></em>" dikembalikan oleh anggota <em><?= htmlspecialchars($notif['nama_anggota']) ?></em> pada tanggal <?= $notif['tanggal_kembali'] ?>.
                    </p>
                    <span class="notif-date"><?= $notif['create_date'] ?></span>
                  <?php endif; ?>
                </div>
              </li>
            <?php endforeach; ?>
          <?php else: ?>
            <li>Tidak ada notifikasi.</li>
          <?php endif; ?>
        </ul>
      </section>
    </main>
  </div>
</body>
</html>
