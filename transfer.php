<?php
// فعال کردن نمایش خطاها
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// URL فایل در هاست قدیمی
$fileUrl = 'https://dv.latari.us/wp-admin.tar';

// نام و مسیر ذخیره فایل در هاست جدید (داخل public_html)
$saveTo = '/home/latarius/public_html/wp-admin.tar';

// باز کردن فایل برای نوشتن
$fp = fopen($saveTo, 'a+');
if ($fp === false) {
    echo 'خطا در باز کردن فایل برای نوشتن.';
    http_response_code(500); // ارسال کد خطای HTTP
    exit;
}

// تنظیم cURL برای دانلود فایل
$ch = curl_init($fileUrl);
curl_setopt($ch, CURLOPT_FILE, $fp);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
curl_setopt($ch, CURLOPT_TIMEOUT, 0);  // بدون محدودیت زمانی
curl_setopt($ch, CURLOPT_BUFFERSIZE, 1024 * 1024); // 1MB per read
curl_setopt($ch, CURLOPT_RESUME_FROM, filesize($saveTo)); // ادامه دانلود از جایی که متوقف شده است

// اجرای دانلود
$result = curl_exec($ch);

// بررسی خطاها
if ($result === false) {
    echo 'خطا در دانلود فایل: ' . curl_error($ch);
    http_response_code(500); // ارسال کد خطای HTTP
    fclose($fp);
    curl_close($ch);
    exit;
}

// بستن cURL و فایل
fclose($fp);
curl_close($ch);

echo 'انتقال فایل با موفقیت انجام شد!';
http_response_code(200); // ارسال کد موفقیت HTTP
?>
