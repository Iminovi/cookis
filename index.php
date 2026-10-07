<!DOCTYPE html>
<html>
<head>
    <title>Redirect Simulation</title>
</head>
<body>
    <script>
        // 1. Cek Referrer
        const referrer = document.referrer;
        const targetUrlMobile = "https://s.shopee.co.id/4VdMitUXZ3";
        const targetUrlDesktop = "https://s.shopee.co.id/4VdMitUXZ3";
        const defaultImg = "http://img4fun.com/kYnIzOi.png";

        // 2. Cek Device (Mobile/Desktop)
        const isMobile = /android|webos|iphone|ipad|ipod|blackberry|iemobile|opera mini/i.test(navigator.userAgent);

        // 3. Fungsi Cek Cookie
        function getCookie(name) {
            return document.cookie.split('; ').find(row => row.startsWith(name + '='));
        }

        // Logika Pengalihan
        if (referrer.includes("poringa")) {
            if (!getCookie("la_cookie")) {
                // Pasang Cookie (berlaku 3 jam)
                document.cookie = "la_cookie=1; max-age=" + (3600 * 3) + "; path=/";
                
                // Redirect berdasarkan perangkat
                window.location.href = isMobile ? targetUrlMobile : targetUrlDesktop;
            } else {
                window.location.href = defaultImg;
            }
        } else {
            window.location.href = defaultImg;
        }
    </script>
</body>
</html>
