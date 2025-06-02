<?php
session_start();
include 'konek.php';

// Pastikan user login anggota
if (!isset($_SESSION['id_akun']) || $_SESSION['role'] !== 'anggota') {
    header("Location: index1-log-anggota.php");
    exit;
}

// Ambil id_akun dan id_anggota dari session
$id_akun = $_SESSION['id_akun'] ?? null;
$id_anggota = $_SESSION['id_anggota'] ?? null;

if (!$id_akun || !$id_anggota) {
    die("Error: Session id_akun atau id_anggota belum tersedia. Pastikan sudah login dengan benar.");
}

// Ambil id_buku dari URL
if (!isset($_GET['id_buku'])) {
    header("Location: home-anggota.php");
    exit;
}
$id_buku = intval($_GET['id_buku']);

// Ambil data buku
$stmt = $conn->prepare("SELECT * FROM buku WHERE id_buku = ?");
$stmt->bind_param("i", $id_buku);
$stmt->execute();
$buku = $stmt->get_result()->fetch_assoc();

if (!$buku) {
    echo "Buku tidak ditemukan.";
    exit;
}

// Generate kode peminjaman unik (contoh)
$kode_peminjaman = "PINJAM" . time() . rand(100, 999);

$error = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $tanggal_pinjam = date('Y-m-d');
    $tanggal_kembali = date('Y-m-d', strtotime('+7 days'));
    $status = 'dipinjam';

    // Insert ke tabel peminjaman
    $insert_stmt = $conn->prepare("INSERT INTO peminjaman (id_anggota, id_buku, tanggal_pinjam, tanggal_kembali, status, create_by) VALUES (?, ?, ?, ?, ?, ?)");
    $insert_stmt->bind_param("iisssi", $id_anggota, $id_buku, $tanggal_pinjam, $tanggal_kembali, $status, $id_akun);

    if ($insert_stmt->execute()) {
        header("Location: sukses-pinjam.php?kode=$kode_peminjaman");
        exit;
    } else {
        $error = "Gagal memproses peminjaman: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Konfirmasi Peminjaman</title>
  <link rel="stylesheet" href="css/anggota-home.css" />
  <style>
    .container { max-width: 400px; margin: 50px auto; border: 1px solid #000; border-radius: 10px; padding: 20px; text-align: center; }
    img { max-width: 200px; height: auto; border-radius: 6px; box-shadow: 0 0 8px rgba(0,0,0,0.1); }
    button { margin-top: 20px; background-color: #2e5732; color: white; border: none; padding: 12px 30px; font-weight: 600; border-radius: 8px; cursor: pointer; font-size: 1.1rem; }
    button:hover { background-color: #1f3a21; }
    .error { color: red; margin-top: 15px; }
  </style>
</head>
<body>
  <div class="container">
    <h2>Konfirmasi Peminjaman</h2>
    <img src="css/<?php echo htmlspecialchars($buku['gambar']); ?>" alt="<?php echo htmlspecialchars($buku['judul']); ?>" />
    <h3><?php echo htmlspecialchars($buku['judul']); ?></h3>
    <p><strong>Kode Peminjaman:</strong> <?php echo $kode_peminjaman; ?></p>

    <?php if ($error) : ?>
      <p class="error"><?php echo $error; ?></p>
    <?php endif; ?>

    <form method="post" action="">
      <button type="submit">Konfirmasi Pinjam</button>
    </form>
    <p><a href="home-anggota.php">Batal dan Kembali</a></p>
  </div>
</body>
</html>
