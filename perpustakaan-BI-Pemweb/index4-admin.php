<?php
include 'konek.php';

$id_buku = 0;
$judul = '';
$pengarang = '';
$penerbit = '';
$tahun_terbit = '';
$stok = '';
$edit_mode = false;
$message = '';

if (isset($_GET['delete'])) {
    $id_to_delete = intval($_GET['delete']);
    $delete = $conn->query("DELETE FROM buku WHERE id_buku = $id_to_delete");
    if ($delete) {
        header("Location: index4-admin.php");
        exit;
    } else {
        $message = "Gagal menghapus data buku!";
    }
}

if (isset($_GET['edit'])) {
    $id_to_edit = intval($_GET['edit']);
    $edit_mode = true;
    $result = $conn->query("SELECT * FROM buku WHERE id_buku = $id_to_edit");
    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();
        $id_buku = $row['id_buku'];
        $judul = $row['judul'];
        $pengarang = $row['pengarang'];
        $penerbit = $row['penerbit'];
        $tahun_terbit = $row['tahun_terbit'];
        $stok = $row['stok'];
    } else {
        $message = "Data tidak ditemukan!";
    }
}

if (isset($_POST['submit'])) {
    $judul = $conn->real_escape_string($_POST['judul']);
    $pengarang = $conn->real_escape_string($_POST['pengarang']);
    $penerbit = $conn->real_escape_string($_POST['penerbit']);
    $tahun_terbit = $conn->real_escape_string($_POST['tahun_terbit']);
    $stok = intval($_POST['stok']);

    if ($_POST['submit'] == 'Tambah') {
        $conn->query("INSERT INTO buku (judul, pengarang, penerbit, tahun_terbit, stok) VALUES ('$judul', '$pengarang', '$penerbit', '$tahun_terbit', $stok)");
        $message = "Data berhasil ditambahkan.";
    } elseif ($_POST['submit'] == 'Update') {
        $id_buku = intval($_POST['id_buku']);
        $conn->query("UPDATE buku SET judul='$judul', pengarang='$pengarang', penerbit='$penerbit', tahun_terbit='$tahun_terbit', stok=$stok WHERE id_buku=$id_buku");
        $message = "Data berhasil diperbarui.";
        $edit_mode = false;
    }
}

$buku_result = $conn->query("SELECT * FROM buku ORDER BY id_buku DESC");
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Daftar Buku - Perpustakaan Bina Informatika</title>
  <link rel="stylesheet" href="css/buku.css" />
  <style>
    /* Form tambahan agar lebih rapi dan konsisten */
    form {
      max-width: 900px;
      background-color: #f9f9f9;
      padding: 30px 40px;
      border-radius: 12px;
      margin-bottom: 40px;
      box-shadow: 0 6px 15px rgba(0, 0, 0, 0.08);
      transition: box-shadow 0.3s ease;
    }
    form:hover,
    form:focus-within {
      box-shadow: 0 8px 20px rgba(0, 0, 0, 0.12);
    }
    form label {
      font-weight: 700;
      display: block;
      margin-bottom: 8px;
      color: #2e4732;
      font-size: 1.05rem;
    }
    form input[type="text"],
    form input[type="number"] {
      width: 100%;
      padding: 12px 16px;
      margin-bottom: 20px;
      border: 1.8px solid #ccc;
      border-radius: 8px;
      font-size: 1.1rem;
      color: #1f2a1f;
      transition: border-color 0.3s ease, box-shadow 0.3s ease;
    }
    form input[type="text"]:focus,
    form input[type="number"]:focus {
      border-color: #4f7d58;
      box-shadow: 0 0 6px #4f7d58aa;
      outline: none;
    }
    form button[type="submit"] {
      background-color: #4f7d58;
      color: #d8e4d8;
      border: none;
      padding: 14px 32px;
      border-radius: 10px;
      cursor: pointer;
      font-weight: 700;
      font-size: 1.2rem;
      transition: background-color 0.3s ease, box-shadow 0.3s ease;
      user-select: none;
    }
    form button[type="submit"]:hover {
      background-color: #2e4732;
      box-shadow: 0 4px 15px #2e473280;
    }
    form a {
      font-weight: 600;
      color: #e00000;
      text-decoration: none;
      margin-left: 25px;
      padding: 14px 25px;
      border-radius: 10px;
      background-color: #fdecea;
      transition: background-color 0.3s ease, color 0.3s ease;
      user-select: none;
    }
    form a:hover {
      background-color: #f8c1c1;
      color: #b00000;
    }
    form input::placeholder {
      color: #999;
      font-style: italic;
    }
    @media (max-width: 600px) {
      form {
        padding: 20px 25px;
      }
      form button[type="submit"],
      form a {
        font-size: 1rem;
        padding: 12px 20px;
      }
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
        <a href="index2-admin.php" class="menu-icon">
          <img class="menu-icon" src="css/home putih.png" alt="Dashboard Icon" />
          Dashboard
        </a>
        <a href="index3-admin.php" class="menu-icon">
          <img class="menu-icon" src="css/dashboard putih.png" alt="Peminjaman Icon" />
          Peminjaman
        </a>
        <a href="index4-admin.php" class="menu-icon active">
          <img class="menu-icon" src="css/buku putih.png" alt="Buku Icon" />
          Buku
        </a>
        <a href="index5-admin.php" class="menu-icon">
          <img class="menu-icon" src="css/staff putih.png" alt="Staff Icon" />
          Staff
        </a>
        <a href="index6-admin.php" class="menu-icon">
          <img class="menu-icon" src="css/user putih.png" alt="Anggota Icon" />
          Anggota
        </a>
        <a href="index7-admin.php" class="menu-icon">
          <img class="menu-icon" src="css/laporan putih.png" alt="Laporan Icon" />
          Laporan
        </a>
      </nav>

      <div class="logout">
        <a href="index.php" class="menu-icon">
          <img class="menu-icon" src="css/pintu.png" alt="Logout Icon" />
          Logout
        </a>
      </div>
    </aside>

    <main class="main-content">
      <h1>Daftar Buku</h1>
      <p class="subtitle">Perpustakaan Bina Informatika</p>

      <?php if ($message): ?>
        <div class="message"><?= htmlspecialchars($message) ?></div>
      <?php endif; ?>

      <form method="post" action="">
        <input type="hidden" name="id_buku" value="<?= $id_buku ?>">
        <label for="judul">Judul</label>
        <input type="text" name="judul" id="judul" required placeholder="Masukkan judul buku" value="<?= htmlspecialchars($judul) ?>">

        <label for="pengarang">Pengarang</label>
        <input type="text" name="pengarang" id="pengarang" required placeholder="Masukkan nama pengarang" value="<?= htmlspecialchars($pengarang) ?>">

        <label for="penerbit">Penerbit</label>
        <input type="text" name="penerbit" id="penerbit" required placeholder="Masukkan penerbit" value="<?= htmlspecialchars($penerbit) ?>">

        <label for="tahun_terbit">Tahun Terbit</label>
        <input type="number" name="tahun_terbit" id="tahun_terbit" min="1900" max="<?= date('Y') ?>" required placeholder="Misal: 2023" value="<?= htmlspecialchars($tahun_terbit) ?>">

        <label for="stok">Stok</label>
        <input type="number" name="stok" id="stok" min="0" required placeholder="Jumlah stok buku" value="<?= htmlspecialchars($stok) ?>">

        <button type="submit" name="submit" value="<?= $edit_mode ? 'Update' : 'Tambah' ?>">
          <?= $edit_mode ? 'Update' : 'Tambah' ?>
        </button>

        <?php if ($edit_mode): ?>
          <a href="index4-admin.php" style="margin-left: 10px;">Batal</a>
        <?php endif; ?>
      </form>

      <div class="table-header">
        <div>Judul</div>
        <div>Pengarang</div>
        <div>Penerbit</div>
        <div>Tahun</div>
        <div>Stok</div>
        <div>Kelola Buku</div>
      </div>

      <div class="data-list">
        <?php if ($buku_result->num_rows > 0): ?>
          <?php while($row = $buku_result->fetch_assoc()): ?>
            <div class="data-row">
              <div><?= htmlspecialchars($row['judul']) ?></div>
              <div><?= htmlspecialchars($row['pengarang']) ?></div>
              <div><?= htmlspecialchars($row['penerbit']) ?></div>
              <div><?= htmlspecialchars($row['tahun_terbit']) ?></div>
              <div><?= intval($row['stok']) ?></div>
              <div>
                <a href="?edit=<?= $row['id_buku'] ?>" class="btn-edit" title="Edit Buku">Edit</a>
                <a href="?delete=<?= $row['id_buku'] ?>" class="btn-delete" title="Hapus Buku" onclick="return confirm('Yakin ingin menghapus buku ini?');">Hapus</a>
              </div>
            </div>
          <?php endwhile; ?>
        <?php else: ?>
          <p>Tidak ada data buku.</p>
        <?php endif; ?>
      </div>
    </main>
  </div>
</body>
</html>
