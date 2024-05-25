<?php

    // Bắt đầu phiên làm việc
    session_start();

    // Kiểm tra xem phiên đăng nhập đã tồn tại chưa
    if(isset($_SESSION["user"])){
        // Kiểm tra xem phiên đăng nhập có hợp lệ không và có phải là quản trị viên không
        if(($_SESSION["user"])=="" or $_SESSION['usertype']!='a'){
            // Nếu không hợp lệ hoặc không phải là quản trị viên, chuyển hướng đến trang đăng nhập
            header("location: ../login.php");
        }

    }else{
        // Nếu phiên không tồn tại, chuyển hướng đến trang đăng nhập
        header("location: ../login.php");
    }
    
    // Xử lý yêu cầu GET
    if($_GET){
        // Import file kết nối đến cơ sở dữ liệu
        include("../connection.php");
        
        // Lấy ID cuộc hẹn cần xóa từ tham số truyền vào
        $id=$_GET["id"];
        
        // Xóa cuộc hẹn có ID tương ứng khỏi cơ sở dữ liệu
        $sql= $database->query("delete from appointment where appoid='$id';");
        
        // Chuyển hướng về trang quản lý cuộc hẹn
        header("location: appointment.php");
    }
?>
