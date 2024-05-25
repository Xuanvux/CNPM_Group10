<?php
    // Bắt đầu hoặc tiếp tục một phiên làm việc
    session_start();

    // Kiểm tra xem phiên đã được xác định và người dùng đã đăng nhập chưa
    if(isset($_SESSION["user"])){
        // Nếu người dùng chưa đăng nhập hoặc không phải là quản trị viên, chuyển hướng đến trang đăng nhập1
        if(($_SESSION["user"])=="" or $_SESSION['usertype']!='a'){
            header("location: ../login.php");
        }
    }else{
        header("location: ../login.php");
    }
    
    // Xử lý khi form được gửi đi
    if($_POST){
        // Import database
        include("../connection.php");
        
        // Lấy dữ liệu từ form
        $title=$_POST["title"];
        $docid=$_POST["docid"];
        $nop=$_POST["nop"];
        $date=$_POST["date"];
        $time=$_POST["time"];
        
        // Tạo câu lệnh SQL để thêm phiên hẹn mới vào cơ sở dữ liệu
        $sql="insert into schedule (docid,title,scheduledate,scheduletime,nop) values ($docid,'$title','$date','$time',$nop);";
        
        // Thực thi câu lệnh SQL và chuyển hướng đến trang lịch hẹn sau khi thêm
        $result= $database->query($sql);
        header("location: schedule.php?action=session-added&title=$title");
    }
?>
