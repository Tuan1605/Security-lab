🛡️ Lab 06: Command Injection - Attack & Defense

Dự án này là một bài thực hành (Lab) mô phỏng lỗ hổng OS Command Injection trên môi trường web server giả lập. Dự án bao gồm cả mã nguồn chứa lỗ hổng để thực hành tấn công và mã nguồn đã được vá lỗi để nghiên cứu các biện pháp phòng thủ an toàn thông tin.

📂 Cấu trúc dự án (Project Structure)

File

Mô tả

vulnerable_app.php

Ứng dụng Web chứa lỗ hổng (Sử dụng shell_exec không an toàn).

secure_app.php

Phiên bản đã được vá lỗi (Sử dụng Input Validation & Escaping).

exploit.py

Script Python tự động hóa việc khai thác lỗ hổng (PoC).

Dockerfile

File cấu hình để dựng môi trường ảo hóa với Docker.

🚀 Hướng dẫn cài đặt (Installation)

Yêu cầu: Máy tính đã cài đặt Docker.

1. Dựng Lab (Build)

Mở terminal tại thư mục dự án và chạy lệnh sau để đóng gói container:

docker build -t lab06 .


2. Khởi chạy (Run)

Chạy container và map cổng 8000 của máy thật vào cổng 80 của container:

docker run -d -p 8000:80 lab06


Sau khi chạy xong, truy cập trình duyệt tại: http://localhost:8000

⚔️ Kịch bản tấn công (Exploitation)

Lỗ hổng nằm ở việc ứng dụng không kiểm soát đầu vào người dùng khi gọi lệnh hệ thống ping. Kẻ tấn công có thể chèn các ký tự ngắt lệnh (như ;, |, &) để thực thi lệnh tùy ý.

Chạy Tool khai thác tự động

Sử dụng script Python đi kèm để đọc file mật khẩu /etc/passwd của server:

python3 exploit.py


Kết quả mong đợi: Script sẽ in ra nội dung file /etc/passwd chứng minh đã thực thi mã từ xa (RCE) thành công.

Payload sử dụng:

127.0.0.1; cat /etc/passwd


🛡️ Phân tích & Phòng thủ (Defense)

Nguyên nhân lỗ hổng (Root Cause)

Trong file vulnerable_app.php:

$cmd = shell_exec('ping -c 3 ' . $target);


Biến $target được nối chuỗi trực tiếp vào lệnh shell mà không qua bất kỳ bộ lọc nào.

Giải pháp khắc phục (Mitigation)

Trong file secure_app.php, tôi đã áp dụng chiến lược phòng thủ chiều sâu (Defense in Depth):

Input Validation (Kiểm tra đầu vào):
Sử dụng filter_var($target, FILTER_VALIDATE_IP) để đảm bảo dữ liệu nhập vào bắt buộc phải là định dạng địa chỉ IP.

Command Escaping (Mã hóa ký tự đặc biệt):
Sử dụng hàm escapeshellarg($target) để bao bọc chuỗi đầu vào trong dấu nháy đơn, biến mọi ký tự đặc biệt thành chuỗi văn bản vô hại đối với Shell.
