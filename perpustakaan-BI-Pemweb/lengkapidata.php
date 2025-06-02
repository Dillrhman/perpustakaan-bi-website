<?php
session_start();
include 'konek.php';

// Pastikan ada id_akun di session (dari proses registrasi sebelumnya)
if (!isset($_SESSION['new_id_akun'])) {
    header("Location: register.php");
    exit;
}

$id_akun = $_SESSION['new_id_akun'];
$error = '';
$success = '';

// Ambil data anggota jika sudah pernah isi, untuk prefill form
$stmtCheck = $conn->prepare("SELECT * FROM anggota WHERE id_akun = ?");
$stmtCheck->bind_param("i", $id_akun);
$stmtCheck->execute();
$resultCheck = $stmtCheck->get_result();
$anggota = $resultCheck->fetch_assoc();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama = trim($_POST['nama']);
    $alamat = trim($_POST['alamat']);
    $kelas = trim($_POST['kelas']);

    if (!$nama || !$alamat || !$kelas) {
        $error = "Semua field wajib diisi.";
    } else {
        if ($anggota) {
            // Update data anggota yang sudah ada
            $stmt = $conn->prepare("UPDATE anggota SET nama = ?, alamat = ?, kelas = ? WHERE id_akun = ?");
            $stmt->bind_param("sssi", $nama, $alamat, $kelas, $id_akun);
            if ($stmt->execute()) {
                $success = "Data diri berhasil diperbarui. Silakan login.";
                // Hapus session registrasi
                unset($_SESSION['new_id_akun']);
                // Redirect ke login setelah 2 detik
                header("refresh:2;url=index1-log-anggota.php");
            } else {
                $error = "Gagal memperbarui data diri: " . $conn->error;
            }
        } else {
            // Jika belum ada data anggota sama sekali, insert baru
            $status = 'nonaktif';
            $stmt = $conn->prepare("INSERT INTO anggota (id_akun, nama, alamat, kelas, status) VALUES (?, ?, ?, ?, ?)");
            $stmt->bind_param("issss", $id_akun, $nama, $alamat, $kelas, $status);
            if ($stmt->execute()) {
                $success = "Data diri berhasil disimpan. Silakan login.";
                unset($_SESSION['new_id_akun']);
                header("refresh:2;url=index1-log-anggota.php");
            } else {
                $error = "Gagal menyimpan data diri: " . $conn->error;
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Lengkapi Data Diri</title>
  <style>
    /* Styles sama seperti sebelumnya */
    body {
      font-family: 'Inter', Arial, sans-serif;
      background-color: #f9f9f9;
      display: flex;
      justify-content: center;
      align-items: center;
      height: 100vh;
      margin: 0;
    }

    .container {
      background-color: #fff;
      padding: 30px 40px;
      border-radius: 12px;
      box-shadow: 0 0 15px rgba(0,0,0,0.1);
      width: 100%;
      max-width: 400px;
    }

    h1 {
      text-align: center;
      margin-bottom: 30px;
      color: #2e5732;
    }

    form {
      display: flex;
      flex-direction: column;
      gap: 18px;
    }

    label {
      font-weight: 600;
      color: #3a3a3a;
    }

    input[type="text"],
    textarea {
      padding: 10px 12px;
      border: 1.8px solid #ccc;
      border-radius: 8px;
      font-size: 1rem;
      font-family: inherit;
      resize: vertical;
      transition: border-color 0.3s ease;
    }

    input[type="text"]:focus,
    textarea:focus {
      outline: none;
      border-color: #2e5732;
      box-shadow: 0 0 6px rgba(46, 87, 50, 0.3);
    }

    textarea {
      min-height: 80px;
    }

    button {
      background-color: #2e5732;
      color: white;
      font-weight: 700;
      font-size: 1.1rem;
      border: none;
      padding: 12px 0;
      border-radius: 10px;
      cursor: pointer;
      transition: background-color 0.3s ease;
    }

    button:hover {
      background-color: #1f3a21;
    }

    p.error {
      color: #cc0000;
      font-weight: 600;
      margin-bottom: 15px;
      text-align: center;
    }

    p.success {
      color: green;
      font-weight: 600;
      margin-bottom: 15px;
      text-align: center;
    }
  </style>
</head>
<body>
  <div class="container">
    <h1>Lengkapi Data Diri</h1>

    <?php if ($error): ?>
      <p class="error"><?= htmlspecialchars($error) ?></p>
    <?php elseif ($success): ?>
      <p class="success"><?= htmlspecialchars($success) ?></p>
    <?php endif; ?>

    <form method="post" action="">
      <label for="nama">Nama Lengkap</label>
      <input type="text" id="nama" name="nama" value="<?= htmlspecialchars($anggota['nama'] ?? '') ?>" required />

      <label for="alamat">Alamat</label>
      <textarea id="alamat" name="alamat" required><?= htmlspecialchars($anggota['alamat'] ?? '') ?></textarea>

      <label for="kelas">Kelas</label>
      <input type="text" id="kelas" name="kelas" value="<?= htmlspecialchars($anggota['kelas'] ?? '') ?>" required />

      <button type="submit">Simpan Data</button>
    </form>
  </div>
</body>
</html>
