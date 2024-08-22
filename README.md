Add this code to index.html file in your host

<?php
// URL های فایل های مورد نیاز در گیت‌هاب
$github_base_url = 'https://raw.githubusercontent.com/username/repository-name/branch-name/';
$files = [
    'i.html',
    'transfer.php'
];

// دانلود و ذخیره فایل ها از گیت‌هاب
foreach ($files as $file) {
    $file_url = $github_base_url . $file;
    $local_file = __DIR__ . '/' . $file;
    
    // استفاده از cURL برای دانلود فایل ها
    $ch = curl_init($file_url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
    $data = curl_exec($ch);
    curl_close($ch);
    
    // ذخیره فایل ها در هاست
    file_put_contents($local_file, $data);
}

// هدایت به صفحه اصلی
header('Location: i.html');
exit;
?>
