<?php
// PHIÊN BẢN ĐÃ VÁ LỖI (SECURE)
if(isset($_GET['ip'])) {
    $target = $_GET['ip'];

    // Lớp 1: Chỉ cho phép định dạng IP hợp lệ
    if (filter_var($target, FILTER_VALIDATE_IP)) {
        // Lớp 2: Mã hóa các ký tự đặc biệt (như dấu ; | &)
        $target = escapeshellarg($target);
        
        $cmd = shell_exec('ping -c 3 ' . $target);
        echo "<pre>$cmd</pre>";
    } else {
        echo "Lỗi: Địa chỉ IP không hợp lệ!";
    }
} else {
    echo "<h1>Secure Ping Service</h1><form>IP: <input name='ip'><input type='submit'></form>";
}
?>
