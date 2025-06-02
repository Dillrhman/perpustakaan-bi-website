<?php
session_start();
include 'konek.php';

// Pastikan user sudah login sebagai anggota
if (!isset($_SESSION['id_akun']) || $_SESSION['role'] !== 'anggota') {
    header("Location: index1-log-anggota.php");
    exit;
}

$search = '';
if (isset($_GET['search'])) {
    $search = trim($_GET['search']);
}

// Query pencarian buku
if ($search != '') {
    $stmt = $conn->prepare("SELECT * FROM buku WHERE judul LIKE CONCAT('%', ?, '%') ORDER BY id_buku ASC");
    $stmt->bind_param("s", $search);
    $stmt->execute();
    $result = $stmt->get_result();
} else {
    $result = $conn->query("SELECT * FROM buku ORDER BY id_buku ASC");
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Perpustakaan Bina Informatika</title>
  <link rel="stylesheet" href="css/anggota-home.css" />
</head>
<body>
  <header>
    <h1>Perpustakaan Bina Informatika</h1>
  </header>

  <div class="search-container">
    <form method="get" action="home-anggota.php" class="search-input-wrapper">
      <img
        src="https://upload.wikimedia.org/wikipedia/commons/5/55/Magnifying_glass_icon.svg"
        alt="Search Icon"
        class="search-icon"
      />
      <input type="text" name="search" placeholder="Cari buku..." value="<?php echo htmlspecialchars($search); ?>" />
    </form>
  </div>

  <main>
    <?php if ($result && $result->num_rows > 0): ?>
      <?php while ($row = $result->fetch_assoc()): ?>
        <div class="book-card">
          <img src="css/<?php echo htmlspecialchars($row['gambar']); ?>" alt="<?php echo htmlspecialchars($row['judul']); ?>" />
          <h3><?php echo htmlspecialchars($row['judul']); ?></h3>
          <!-- Tombol Pinjam arahkan ke halaman pinjam.php dengan id_buku -->
          <a href="pinjam.php?id_buku=<?php echo $row['id_buku']; ?>" class="btn-pinjam">Pinjam</a>
        </div>
      <?php endwhile; ?>
    <?php else: ?>
      <p style="text-align:center; width: 100%; font-weight: 600; color: #555;">Buku tidak ditemukan.</p>
    <?php endif; ?>
  </main>
</body>
</html>
