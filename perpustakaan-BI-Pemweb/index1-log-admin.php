<?php
session_start();
require 'konek.php';

$loginError = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Ambil data akun berdasarkan username
    $stmt = $conn->prepare("
        SELECT a.*, r.nama_role 
        FROM akun a
        JOIN role r ON a.id_role = r.id_role 
        WHERE a.username = ?
    ");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $data = $result->fetch_assoc();

        // Verifikasi password dengan hash SHA-256
        if (hash('sha256', $password) === $data['password']) {
            if ($data['nama_role'] === 'admin') {
                $_SESSION['id_akun'] = $data['id_akun'];
                $_SESSION['username'] = $data['username'];
                $_SESSION['role'] = $data['nama_role'];
                header("Location: index2-admin.php"); // ganti ke dashboard admin
                exit;
            } else {
                $loginError = "Role anda bukan admin. Silakan login melalui halaman yang sesuai.";
            }
        } else {
            $loginError = "Username atau password salah!";
        }
    } else {
        $loginError = "Username atau password salah!";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login Admin</title>
    <link rel="stylesheet" href="css/login-admin.css">
</head>
<body>
    <div class="wrapper">
        <form method="POST">
            <h1>Login Admin</h1>

            <?php if ($loginError): ?>
                <div style="color: red; margin-bottom: 10px;"><?= $loginError ?></div>
            <?php endif; ?>

            <div class="input-box">
                <input type="text" name="username" placeholder="Username" required>
                <i class="ri-user-3-fill"></i>
            </div>

            <div class="input-box">
                <input type="password" name="password" placeholder="Password" required>
                <i class="ri-lock-2-line"></i>
            </div>

            <div class="ingat-lupasandi">
                <label><input type="checkbox" name="remember">Ingat saya</label>
                <a href="#">Lupa Sandi?</a>
            </div>

            <button type="submit" class="btn">Login</button>
        </form>

        <div class="daftar-link">
            <p>Belum punya akun? <a href="index1-register-admn.php">Daftar</a></p>
        </div>
    </div>

    <script>
    document.querySelector('form').addEventListener('submit', function(e) {
        const username = document.querySelector('input[name="username"]').value.trim();
        const password = document.querySelector('input[name="password"]').value.trim();

        if (username === '' || password === '') {
            e.preventDefault();
            alert("Username dan password tidak boleh kosong.");
        }
    });
    </script>
</body>
</html>
