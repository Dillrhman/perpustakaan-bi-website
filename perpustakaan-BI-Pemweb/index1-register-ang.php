<?php
session_start();
include 'konek.php';

$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username']);
    $email = trim($_POST['email']);
    $password = $_POST['password'];

    if (!$username || !$email || !$password) {
        $error = "Semua field wajib diisi.";
    } else {
        // Cek username atau email sudah terdaftar belum
        $stmt = $conn->prepare("SELECT id_akun FROM akun WHERE username = ? OR email = ?");
        $stmt->bind_param("ss", $username, $email);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            $error = "Username atau email sudah terdaftar.";
        } else {
            // Ambil id_role anggota dari tabel role
            $result = $conn->query("SELECT id_role FROM role WHERE nama_role = 'anggota' LIMIT 1");
            if ($result && $row = $result->fetch_assoc()) {
                $id_role = (int)$row['id_role'];
            } else {
                // Jika tidak ditemukan role anggota, default 2
                $id_role = 2;
            }

            // Hash password dengan SHA256 (atau pakai password_hash)
            $password_hash = hash('sha256', $password);

            $status = 'nonaktif';

            $stmt = $conn->prepare("INSERT INTO akun (username, email, password, id_role, status) VALUES (?, ?, ?, ?, ?)");
            $stmt->bind_param("sssis", $username, $email, $password_hash, $id_role, $status);

            if ($stmt->execute()) {
                // Simpan id_akun baru ke session untuk proses tahap 2
                $_SESSION['new_id_akun'] = $stmt->insert_id;

                // Redirect ke halaman lengkapi data diri
                header("Location: lengkapidata.php");
                exit;
            } else {
                $error = "Gagal registrasi: " . $conn->error;
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
<title>Register Akun</title>
<link rel="stylesheet" href="css/anggota-register.css" />
</head>
<body>
<div class="container">
  <div class="left">
    <img src="css/reg-staf.jpg" alt="Background photo" />
  </div>
  <div class="right">
    <h1>Register Anggota</h1>

    <?php if ($error): ?>
      <p style="color:red;"><?= htmlspecialchars($error) ?></p>
    <?php endif; ?>

    <form method="POST" action="">
      <label for="username">Username</label>
      <input type="text" id="username" name="username" required />

      <label for="email">Email</label>
      <input type="email" id="email" name="email" required />

      <label for="password">Password</label>
      <input type="password" id="password" name="password" required />

      <button type="submit" class="btn">Register</button>
    </form>
  </div>
</div>
</body>
</html>
