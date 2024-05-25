<?php
    // Tạo kết nối mới tới cơ sở dữ liệu MySQL
    $database= new mysqli("localhost","root","","hospital");

    // Kiểm tra nếu kết nối gặp lỗi
    if ($database->connect_error){
        // Hiển thị thông báo lỗi và kết thúc chương trình
        die("Connection failed:  ".$database->connect_error);
    }
?>
