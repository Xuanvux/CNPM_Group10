<?php

    // Bắt đầu session
    session_start();

    // Kiểm tra nếu session user đã được tạo
    if(isset($_SESSION["user"])){
        // Nếu session user rỗng hoặc không phải là người dùng loại p (patient), chuyển hướng đến trang đăng nhập
        if(($_SESSION["user"])=="" or $_SESSION['usertype']!='p'){
            header("location: ../login.php");
        }else{
            $useremail=$_SESSION["user"];
        }

    }else{
        header("location: ../login.php");
    }
    

    // Import database
    include("../connection.php");
    
    // Truy vấn thông tin bệnh nhân từ database
    $sqlmain= "select * from patient where pemail=?";
    $stmt = $database->prepare($sqlmain);
    $stmt->bind_param("s",$useremail);
    $stmt->execute();
    $userrow = $stmt->get_result();
    $userfetch=$userrow->fetch_assoc();
    $userid= $userfetch["pid"];
    $username=$userfetch["pname"];

    // Kiểm tra nếu có dữ liệu được gửi đi từ form
    if($_POST){
        if(isset($_POST["booknow"])){
            // Lấy thông tin từ form
            $apponum=$_POST["apponum"];
            $scheduleid=$_POST["scheduleid"];
            $date=$_POST["date"];
            $scheduleid=$_POST["scheduleid"];
            // Thêm thông tin cuộc hẹn vào database
            $sql2="insert into appointment(pid,apponum,scheduleid,appodate) values ($userid,$apponum,$scheduleid,'$date')";
            $result= $database->query($sql2);
            // Chuyển hướng đến trang đặt chỗ với thông báo cuộc hẹn đã được thêm vào
            header("location: appointment.php?action=booking-added&id=".$apponum."&titleget=none");

        }
    }
 ?>
