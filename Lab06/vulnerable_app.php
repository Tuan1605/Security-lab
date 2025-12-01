<?php
if(isset($_GET['ip'])) {
    $target = $_GET['ip'];
    // LỖI: Nối chuỗi trực tiếp
    $cmd = shell_exec('ping -c 3 ' . $target);
    echo "<pre>$cmd</pre>";
} else {
    echo "<h1>Vulnerable Ping Service</h1><form>IP: <input name='ip'><input type='submit'></form>";
}
?>
