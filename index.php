<?php
// Pastikan session sudah dimulaian jika menggunakan $_SESSION
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// 1. Definisikan URL Target
$targetMobile  = "https://s.shopee.co.id/4VdMitUXZ3";
$targetDesktop = "https://s.shopee.co.id/4VdMitUXZ3";
$defaultImage  = "https://imgur.com/gallery/no-pet-left-behind-oc-FXF0RTv";

// 2. Fungsi Helper untuk Cek Perangkat Mobile (Gabungan dari index.php & plug.php)
function isMobileDevice() {
    if (!isset($_SERVER["HTTP_USER_AGENT"])) {
        return false;
    }
    $userAgent = strtolower($_SERVER["HTTP_USER_AGENT"]);
    return preg_match("/(android|wap|phone|ipad)/i", $userAgent) === 1;
}

// 3. Logika Utama Pengalihan (Pencocokan Referrer & Cookie)
if (!empty($_SERVER["HTTP_REFERER"])) {
    
    // Cek apakah pengunjung datang dari domain/halaman Facebook
    if (strpos($_SERVER["HTTP_REFERER"], "facebook") !== false) {
        $_SESSION["cameFromfacebook"] = "yes";
    }

    // Jika teridentifikasi dari Facebook
    if (isset($_SESSION["cameFromfacebook"]) && $_SESSION["cameFromfacebook"] === "yes") {

        // Skenario Kunjungan Pertama (Cookie belum ada)
        if (!isset($_COOKIE["the_cookie"])) {
            // Pasang cookie selama 3 jam
            setcookie("the_cookie", "1", time() + (3600 * 3), "/");
            
            // Tentukan URL tujuan berdasarkan jenis perangkat
            $redirectUrl = isMobileDevice() ? $targetMobile : $targetDesktop;
            
            header("Location: " . $redirectUrl);
            exit();
        } else {
            // Skenario Kunjungan Berulang (Cookie sudah ada) -> Tampilkan Gambar Normal
            header("Location: " . $defaultImage);
            exit();
        }
    } else {
        // Bukan dari Poringa -> Tampilkan Gambar Normal
        header("Location: " . $defaultImage);
        exit();
    }
} else {
    // Referrer Kosong / Direct Access -> Tampilkan Gambar Normal
    header("Location: " . $defaultImage);
    exit();
}
?>