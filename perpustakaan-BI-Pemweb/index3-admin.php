<?php
session_start();
include 'konek.php';

// Pastikan user login dan berperan sebagai admin atau yang berhak lihat
// Contoh: cek session role, sesuaikan sesuai sistem kamu
// if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
//     header("Location: index.php");
//     exit;
// }

// Proses update status dan input pengembalian jika tombol diklik
if (isset($_POST['update_status'])) {
    $id_pinjam = intval($_POST['id_pinjam']);

    // Cek status dulu, untuk menghindari update ganda
    $cekStatus = $conn->query("SELECT status FROM peminjaman WHERE id_pinjam = $id_pinjam");
    if ($cekStatus && $cekStatus->num_rows > 0) {
        $row = $cekStatus->fetch_assoc();
        if ($row['status'] === 'dipinjam') {
            // update status jadi 'kembali'
            $update = $conn->query("UPDATE peminjaman SET status = 'kembali' WHERE id_pinjam = $id_pinjam");

            if ($update) {
                // insert data ke tabel pengembalian, tanggal kembali = hari ini
                $today = date('Y-m-d');
                $insert = $conn->query("INSERT INTO pengembalian (id_pinjam, tanggal_kembali, denda) VALUES ($id_pinjam, '$today', 0.00)");

                if (!$insert) {
                    echo "<script>alert('Gagal menambahkan data pengembalian!');</script>";
                }
            } else {
                echo "<script>alert('Gagal mengubah status peminjaman!');</script>";
            }
        }
    } else {
        echo "<script>alert('Data peminjaman tidak ditemukan!');</script>";
    }
}

// Ambil data peminjaman dengan join anggota untuk dapatkan nama peminjam
$sql = "SELECT p.id_pinjam, a.nama AS nama_anggota, p.tanggal_pinjam, p.tanggal_kembali, p.status
        FROM peminjaman p
        LEFT JOIN anggota a ON p.id_anggota = a.id_anggota
        ORDER BY p.tanggal_pinjam DESC";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Dashboard Peminjaman</title>
  <link rel="stylesheet" href="css/peminjaman.css" />
  <style>
    .dashboard {
      display: flex;
      min-height: 100vh;
    }
    aside.sidebar {
      width: 250px;
      background: #2e4732;
      color: #d8e4d8;
      padding: 20px;
      box-sizing: border-box;
    }
    .menu a {
      display: flex;
      align-items: center;
      gap: 10px;
      padding: 10px 15px;
      color: #d8e4d8;
      text-decoration: none;
      margin-bottom: 10px;
      border-radius: 5px;
    }
    .menu a.active, .menu a:hover {
      background: #1f3a21;
      font-weight: 700;
    }
    .menu-icon {
      width: 20px;
      height: 20px;
    }
    .logout a {
      color: #d8e4d8;
      text-decoration: none;
      display: flex;
      align-items: center;
      gap: 10px;
      margin-top: 30px;
    }
    .main-content {
      flex: 1;
      padding: 30px;
      background: #f5f7f6;
    }
    h1 {
      color: #2e5732;
      margin-bottom: 5px;
    }
    .subtitle {
      margin-bottom: 30px;
      color: #555;
    }
    .table-header, .data-row {
      display: grid;
      grid-template-columns: 2fr 1fr 1fr 1fr;
      padding: 10px 15px;
      border-bottom: 1px solid #ddd;
      align-items: center;
    }
    .table-header {
      background: #50b38f;
      color: white;
      font-weight: 700;
      border-radius: 6px 6px 0 0;
    }
    .status-btn {
      padding: 8px 12px;
      border: none;
      border-radius: 6px;
      color: white;
      font-weight: 700;
      cursor: pointer;
      transition: background-color 0.3s ease;
    }
    .status-peminjam {
      background-color: #dc3545;
    }
    .status-peminjam:hover {
      background-color: #c82333;
    }
    .status-dikembalikan {
      background-color: #28a745;
      cursor: default;
    }
    p {
      font-style: italic;
      color: #777;
    }
  </style>
</head>
<body>
  <div class="dashboard">
    <aside class="sidebar">
      <div class="logo">
        <img src="css/bina-informatika.png" alt="Logo Bina Informatika" />
        <span>Bina Informatika</span>
      </div>
      <nav class="menu">
        <a href="index2-admin.php"><img class="menu-icon" src="css/home putih.png" alt="Dashboard" /> Dashboard</a>
        <a href="index3-admin.php" class="active"><img class="menu-icon" src="css/dashboard putih.png" alt="Peminjaman" /> Peminjaman</a>
        <a href="index4-admin.php"><img class="menu-icon" src="css/buku putih.png" alt="Buku" /> Buku</a>
        <a href="index5-admin.php"><img class="menu-icon" src="css/staff putih.png" alt="Staff" /> Staff</a>
        <a href="index6-admin.php"><img class="menu-icon" src="css/user putih.png" alt="Anggota" /> Anggota</a>
        <a href="index7-admin.php"><img class="menu-icon" src="css/laporan putih.png" alt="Laporan" /> Laporan</a>
      </nav>
      <div class="logout">
        <a href="index.php"><img class="menu-icon" src="css/pintu.png" alt="Logout" /> Logout</a>
      </div>
    </aside>

    <section class="main-content">
      <h1>Peminjaman</h1>
      <p class="subtitle">Perpustakaan Bina Informatika</p>

      <div class="table-header">
        <div>Anggota</div>
        <div>Tgl Pinjam</div>
        <div>Tgl Kembali</div>
        <div>Status</div>
      </div>

      <div class="data-list">
        <?php if ($result && $result->num_rows > 0): ?>
          <?php while($row = $result->fetch_assoc()): ?>
            <div class="data-row">
              <div><?= htmlspecialchars($row['nama_anggota']) ?></div>
              <div><?= htmlspecialchars($row['tanggal_pinjam']) ?></div>
              <div><?= htmlspecialchars($row['tanggal_kembali']) ?></div>
              <div>
                <form method="post" style="margin:0;">
                  <input type="hidden" name="id_pinjam" value="<?= intval($row['id_pinjam']) ?>" />
                  <?php if ($row['status'] === 'dipinjam'): ?>
                    <button type="submit" name="update_status" class="status-btn status-peminjam">Di pinjam</button>
                  <?php else: ?>
                    <button type="button" class="status-btn status-dikembalikan" disabled>Di kembalikan</button>
                  <?php endif; ?>
                </form>
              </div>
            </div>
          <?php endwhile; ?>
        <?php else: ?>
          <p>Tidak ada data peminjaman.</p>
        <?php endif; ?>
      </div>
    </section>
  </div>
</body>
</html>
