<?php
// nyalain error reporting biar gampang debugging kalo ada masalah
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();
require_once 'konfigurasi/koneksi_db.php';
require_once 'konfigurasi/fungsi_autentikasi.php';

// kalo user udah login, langsung lempar ke halaman dashboard sesuai perannya
sudah_login();

$error = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (empty($_POST['email']) || empty($_POST['password'])) {
        $error = 'Email dan kata sandi tidak boleh kosong.';
    } else {
        $email = $_POST['email'];
        $password = $_POST['password'];

        // validasi domain email, wajib pake @amba.ac.id
        if (substr($email, -11) !== '@amba.ac.id') {
            $error = 'Harap gunakan email kampus (@amba.ac.id) untuk masuk.';
        } else {
            try {
                $stmt = $pdo->prepare("SELECT * FROM pengguna WHERE email = ?");
                $stmt->execute([$email]);
                $pengguna = $stmt->fetch();

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
}

require_once 'templat/header_publik.php';
?>

<div style="display:flex;min-height:100vh;overflow:hidden;font-family:'Poppins',sans-serif;">
    
    <div style="width:33.33%;background-color:white;display:flex;align-items:center;justify-content:center;padding:2rem;flex-direction:column;">
        
        <div style="text-align:center;width:100%;max-width:320px;">
            
            <img src='aset/img/logo_amba.png' alt='Logo Universitas AMBA' style="width:100px;height:auto;margin-bottom:15px; display:inline-block;">
            
            <h1 style="font-size:24px;font-weight:700;color:#1c1c1c;margin-bottom:4px;">Sistem Informasi Pelatihan</h1>
            <h2 style="font-size:14px;color:#555;margin-bottom:20px;">Universitas Akademi Milenial Berprestasi Agung</h2>

            <?php if ($error): ?>
                <div style="background:#fee2e2;color:#991b1b;padding:8px 10px;border-radius:5px;font-size:12px;margin-bottom:10px;">
                    <?php echo htmlspecialchars($error); ?>
                </div>
            <?php endif; ?>

            <form action="masuk.php" method="POST" style="display:flex;flex-direction:column;gap:10px;">
                <label for="email" style="font-size:14px;color:#333;text-align:left;font-weight:500;margin-top:10px;">Alamat Email</label>
                <input 
                    id="email" 
                    name="email" 
                    type="email" 
                    required 
                    placeholder="nama@amba.ac.id" 
                    pattern=".+@amba\.ac\.id" 
                    title="Harap gunakan alamat email dengan domain @amba.ac.id"
                    style="padding:10px 12px;border:1px solid #ccc;border-radius:8px;font-size:14px;outline:none;"
                >
                
                <label for="password" style="font-size:14px;color:#333;text-align:left;font-weight:500;">Kata Sandi</label>
                <input id="password" name="password" type="password" required style="padding:10px 12px;border:1px solid #ccc;border-radius:8px;font-size:14px;outline:none;margin-bottom:15px;">

                <button type="submit" style="background-color:#4b5632;color:white;border:none;padding:12px;border-radius:8px;font-size:16px;font-weight:600;cursor:pointer;transition:background-color 0.2s;">Masuk</button>
            </form>
        </div>
    </div>

    <div style="width:66.67%;background-image:url('https://images.unsplash.com/photo-1541339907198-e08756dedf3f?q=80&w=2070&auto=format&fit=crop');background-size:cover;background-position:center;position:relative;display:flex;align-items:flex-end;justify-content:flex-start;">
        <div style="position:absolute;top:0;left:0;width:100%;height:100%;background:rgba(0,0,0,0.4);"></div>
        <div style="position:relative;z-index:2;padding:3rem;color:white;">
            <h1 style="font-size:36px;font-weight:700;margin-bottom:8px;">Selamat Datang.</h1>
            <p style="font-size:18px;color:#f1f1f1;">Masuk untuk mengakses materi pelatihan dan melihat progres belajar Anda.</p>
        </div>
    </div>
</div>

<?php
require_once 'templat/footer_publik.php';
?>