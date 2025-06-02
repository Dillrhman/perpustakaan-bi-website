<?php
session_start();
require 'konek.php';

$loginError = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

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

        // Cek status akun
        if ($data['status'] === 'nonaktif') {
            $loginError = "Akun Anda belum aktif. Silakan hubungi administrator.";
        } else {
            // Jika aktif, cek password
            if (hash('sha256', $password) === $data['password']) {
                if ($data['nama_role'] === 'anggota') {
                    // Ambil id_anggota dari tabel anggota berdasar id_akun
                    $stmt2 = $conn->prepare("SELECT id_anggota FROM anggota WHERE id_akun = ?");
                    $stmt2->bind_param("i", $data['id_akun']);
                    $stmt2->execute();
                    $res2 = $stmt2->get_result();

                    if ($res2->num_rows > 0) {
                        $anggota = $res2->fetch_assoc();

                        // Simpan session id_akun dan id_anggota
                        $_SESSION['id_akun'] = $data['id_akun'];
                        $_SESSION['id_anggota'] = $anggota['id_anggota'];
                        $_SESSION['username'] = $data['username'];
                        $_SESSION['role'] = $data['nama_role'];

                        header("Location: home-anggota.php");
                        exit;
                    } else {
                        $loginError = "Akun belum terdaftar sebagai anggota.";
                    }
                } else {
                    $loginError = "Role anda bukan anggota. Silakan login melalui halaman yang sesuai.";
                }
            } else {
                $loginError = "Username atau password salah!";
            }
        }
    } else {
        $loginError = "Username atau password salah!";
    }
}
?>

?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <title>Login Anggota</title>
    <link rel="stylesheet" href="css/login-anggota.css" />
</head>
<body>
    <div class="wrapper">
        <form method="POST">
            <h1>Login Anggota</h1>

            <?php if ($loginError): ?>
                <div style="color: red; margin-bottom: 10px;"><?= $loginError ?></div>
            <?php endif; ?>

            <div class="input-box">
                <input type="text" name="username" placeholder="Username" required />
            </div>

            <div class="input-box">
                <input type="password" name="password" placeholder="Password" required />
            </div>

            <div class="ingat-lupasandi">
                <label><input type="checkbox" name="remember" /> Ingat saya</label>
                <a href="#">Lupa Sandi?</a>
            </div>

            <button type="submit" class="btn">Login</button>
        </form>

        <div class="daftar-link">
            <p>Belum punya akun? <a href="index1-register-ang.php">Daftar</a></p>
        </div>
    </div>
</body>
</html>
