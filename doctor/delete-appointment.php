<?php
    // Bắt đầu phiên làm việc
    session_start();

    // Kiểm tra nếu phiên đã tồn tại
    if(isset($_SESSION["user"])){
        // Nếu không có người dùng đăng nhập hoặc người dùng không phải là quản trị viên, chuyển hướng đến trang đăng nhập
        if(($_SESSION["user"])=="" or $_SESSION['usertype']!='a'){
            header("location: ../login.php");
        }
    }else{
        // Nếu không có phiên tồn tại, chuyển hướng đến trang đăng nhập
        header("location: ../login.php");
    }
    
    // Xử lý khi có yêu cầu GET được gửi đi
    if($_GET){
        // Import database
        include("../connection.php");
        
        // Lấy id từ yêu cầu GET
        $id=$_GET["id"];
        
        // Xóa lịch hẹn có id tương ứng
        $sql= $database->query("delete from appointment where appoid='$id';");
        
        // Chuyển hướng đến trang danh sách lịch hẹn
        header("location: appointment.php");
    }
?>
