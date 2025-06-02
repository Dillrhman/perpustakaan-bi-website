<?php
include 'konek.php';

// Proses update status jika tombol ditekan
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['id_akun'], $_POST['new_status'])) {
        $id_akun = intval($_POST['id_akun']);
        $new_status = $_POST['new_status'] === 'aktif' ? 'aktif' : 'nonaktif';

        $stmt = $conn->prepare("UPDATE akun SET status = ? WHERE id_akun = ?");
        $stmt->bind_param("si", $new_status, $id_akun);
        $stmt->execute();

        header("Location: " . $_SERVER['PHP_SELF']);
        exit;
    }

    // Proses hapus anggota dan akun jika tombol hapus ditekan
    if (isset($_POST['delete_id_akun'])) {
        $delete_id_akun = intval($_POST['delete_id_akun']);

        // Cari id_anggota dari id_akun
        $stmt = $conn->prepare("SELECT id_anggota FROM anggota WHERE id_akun = ?");
        $stmt->bind_param("i", $delete_id_akun);
        $stmt->execute();
        $res = $stmt->get_result();

        if ($res->num_rows > 0) {
            $row = $res->fetch_assoc();
            $id_anggota = $row['id_anggota'];

            // Hapus data pengembalian terkait
            $stmtDelPengembalian = $conn->prepare("
                DELETE FROM pengembalian WHERE id_pinjam IN (
                    SELECT id_pinjam FROM peminjaman WHERE id_anggota = ?
                )
            ");
            $stmtDelPengembalian->bind_param("i", $id_anggota);
            $stmtDelPengembalian->execute();

            // Hapus data peminjaman yang terkait
            $stmtDelPinjam = $conn->prepare("DELETE FROM peminjaman WHERE id_anggota = ?");
            $stmtDelPinjam->bind_param("i", $id_anggota);
            $stmtDelPinjam->execute();

            // Hapus data anggota
            $stmtDelAnggota = $conn->prepare("DELETE FROM anggota WHERE id_akun = ?");
            $stmtDelAnggota->bind_param("i", $delete_id_akun);
            $stmtDelAnggota->execute();

            // Hapus akun
            $stmtDelAkun = $conn->prepare("DELETE FROM akun WHERE id_akun = ?");
            $stmtDelAkun->bind_param("i", $delete_id_akun);
            $stmtDelAkun->execute();
        }

        header("Location: " . $_SERVER['PHP_SELF']);
        exit;
    }
}

// Query data anggota beserta email dan status akun
$sql = "SELECT ag.nama, ak.email, ag.alamat, ag.kelas, ak.status, ak.id_akun
        FROM anggota ag
        LEFT JOIN akun ak ON ag.id_akun = ak.id_akun
        ORDER BY ag.id_anggota ASC";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Perpustakaan Bina Informatika - Anggota</title>
  <link rel="stylesheet" href="css/anggota.css" />
  <link
    rel="stylesheet"
    href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"
    crossorigin="anonymous"
  />
  <style>
    .btn-status {
      padding: 6px 14px;
      border: none;
      border-radius: 6px;
      cursor: pointer;
      color: white;
      font-weight: 600;
      font-size: 0.9rem;
      transition: background-color 0.3s ease;
      margin-right: 5px;
    }
    .btn-aktif {
      background-color: #28a745;
    }
    .btn-aktif:hover {
      background-color: #218838;
    }
    .btn-nonaktif {
      background-color: #dc3545;
    }
    .btn-nonaktif:hover {
      background-color: #c82333;
    }
    .btn-hapus {
      background-color: #6c757d;
      color: white;
      border-radius: 6px;
      padding: 6px 12px;
      border: none;
      cursor: pointer;
      font-weight: 600;
      font-size: 0.9rem;
      transition: background-color 0.3s ease;
    }
    .btn-hapus:hover {
      background-color: #5a6268;
    }
    form.inline-form {
      display: inline;
    }
    table {
      width: 100%;
      border-collapse: collapse;
    }
    th, td {
      padding: 10px;
      border: 1px solid #ddd;
      text-align: left;
    }
    th {
      background-color: #50b38f;
      color: white;
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
        <a href="index2-admin.php"><img src="css/home putih.png" alt="Dashboard" class="menu-icon" /> Dashboard</a>
        <a href="index3-admin.php"><img src="css/dashboard putih.png" alt="Peminjaman" class="menu-icon" /> Peminjaman</a>
        <a href="index4-admin.php"><img src="css/buku putih.png" alt="Buku" class="menu-icon" /> Buku</a>
        <a href="index5-admin.php"><img src="css/staff putih.png" alt="Staff" class="menu-icon" /> Staff</a>
        <a href="index6-admin.php" class="active"><img src="css/user putih.png" alt="Anggota" class="menu-icon" /> Anggota</a>
        <a href="index7-admin.php"><img src="css/laporan putih.png" alt="Laporan" class="menu-icon" /> Laporan</a>
      </nav>

      <div class="logout">
        <a href="index.php"><img src="css/pintu.png" alt="Logout" /> Logout</a>
      </div>
    </aside>

    <main class="content">
      <h1>Anggota</h1>
      <p>Perpustakaan Bina Informatika</p>

      <table>
        <thead>
          <tr>
            <th>Nama</th>
            <th>Email</th>
            <th>Alamat</th>
            <th>Kelas</th>
            <th>Status</th>
            <th>Aksi</th>
          </tr>
        </thead>
        <tbody>
          <?php if ($result && $result->num_rows > 0): ?>
            <?php while ($row = $result->fetch_assoc()): ?>
              <tr>
                <td><?= htmlspecialchars($row['nama']) ?></td>
                <td><?= htmlspecialchars($row['email']) ?></td>
                <td><?= htmlspecialchars($row['alamat']) ?></td>
                <td><?= htmlspecialchars($row['kelas']) ?></td>
                <td><?= htmlspecialchars(ucfirst($row['status'])) ?></td>
                <td>
                  <form method="POST" class="inline-form">
                    <input type="hidden" name="id_akun" value="<?= $row['id_akun'] ?>" />
                    <?php if ($row['status'] === 'aktif'): ?>
                      <input type="hidden" name="new_status" value="nonaktif" />
                      <button type="submit" class="btn-status btn-nonaktif" title="Nonaktifkan akun">Nonaktifkan</button>
                    <?php else: ?>
                      <input type="hidden" name="new_status" value="aktif" />
                      <button type="submit" class="btn-status btn-aktif" title="Aktifkan akun">Aktifkan</button>
                    <?php endif; ?>
                  </form>

                  <form method="POST" class="inline-form" onsubmit="return confirm('Yakin ingin menghapus anggota ini?');">
                    <input type="hidden" name="delete_id_akun" value="<?= $row['id_akun'] ?>" />
                    <button type="submit" class="btn-hapus" title="Hapus anggota"><i class="fa fa-trash"></i> Hapus</button>
                  </form>
                </td>
              </tr>
            <?php endwhile; ?>
          <?php else: ?>
            <tr>
              <td colspan="6" style="text-align:center; padding: 20px; color: #666;">
                Data anggota belum tersedia.
              </td>
            </tr>
          <?php endif; ?>
        </tbody>
      </table>
    </main>
  </div>
</body>
</html>
