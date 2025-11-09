<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();
require_once 'konfigurasi/koneksi_db.php';
require_once 'konfigurasi/fungsi_autentikasi.php';

sudah_login();

$error = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (empty($_POST['email']) || empty($_POST['password'])) {
        $error = 'Email dan kata sandi tidak boleh kosong.';
    } else {
        $email = $_POST['email'];
        $password = $_POST['password'];

        try {
            $stmt = $pdo->prepare("SELECT * FROM pengguna WHERE email = ?");
            $stmt->execute([$email]);
            $pengguna = $stmt->fetch();

            //INI DIA PERUBAHANNYA: Kita membandingkan teks biasa
            if ($pengguna && $password == $pengguna['kata_sandi']) {
                
                $_SESSION['id_pengguna'] = $pengguna['id_pengguna'];
                $_SESSION['nama_lengkap'] = $pengguna['nama_lengkap'];
                $_SESSION['peran'] = $pengguna['peran'];

                if ($pengguna['peran'] == 'admin') {
                    header("Location: admin/index.php");
                } else {
                    header("Location: mahasiswa/index.php");
                }
                exit();
            } else {
                $error = 'Email atau kata sandi salah.';
            }
        } catch (PDOException $e) {
            $error = "Terjadi masalah: " . $e->getMessage();
        }
    }
}

require_once 'templat/header_publik.php';
?>

<div class="w-full max-w-md p-8 space-y-6 bg-white rounded-lg shadow-md">
    <div class="flex justify-center">
        <img src="aset/img/logo_amba.png" alt="Logo Universitas AMBA" class="w-24 h-auto">
    </div>
    <h1 class="text-2xl font-bold text-center text-gray-900">
        Sistem Informasi Pelatihan
    </h1>
    <h2 class="text-lg text-center text-gray-700">
        Universitas Akademi Milenial Berprestasi Agung
    </h2>

    <?php if ($error): ?>
        <div class="p-4 text-sm text-red-700 bg-red-100 rounded-lg" role="alert">
            <?php echo htmlspecialchars($error); ?>
        </div>
    <?php endif; ?>

    <form class="space-y-6" action="masuk.php" method="POST">
        <div>
            <label for="email" class="block text-sm font-medium text-gray-700">
                Alamat Email
            </label>
            <div class="mt-1">
                <input id="email" name="email" type="email" autocomplete="email" required
                       class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-amba-hijau-tua focus:border-amba-hijau-tua sm:text-sm">
            </div>
        </div>

        <div>
            <label for="password" class="block text-sm font-medium text-gray-700">
                Kata Sandi
            </label>
            <div class="mt-1">
                <input id="password" name="password" type="password" autocomplete="current-password" required
                       class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-amba-hijau-tua focus:border-amba-hijau-tua sm:text-sm">
            </div>
        </div>

        <div>
            <button type="submit"
                    class="w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-amba-hijau-tua hover:bg-amba-hijau-muda hover:text-amba-hijau-tua focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-amba-hijau-tua transition-all duration-200">
                Masuk
            </button>
        </div>
    </form>
</div>

<?php
require_once 'templat/footer_publik.php';
?>