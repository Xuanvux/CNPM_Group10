<?php
    // Bắt đầu hoặc tiếp tục một phiên làm việc
    session_start();

    // Kiểm tra xem phiên đã được xác định và người dùng đã đăng nhập chưa
    if(isset($_SESSION["user"])){
        // Nếu người dùng chưa đăng nhập hoặc không phải là quản trị viên, chuyển hướng đến trang đăng nhập.
        if(($_SESSION["user"])=="" or $_SESSION['usertype']!='a'){
            header("location: ../login.php");
        }
    }else{
        header("location: ../login.php");
    }
    
    // Xử lý khi có yêu cầu GET được gửi đi
    if($_GET){
        // Import database
        include("../connection.php");
        
        // Lấy id từ yêu cầu GET
        $id=$_GET["id"];
        
        // Xóa bản ghi tương ứng từ bảng schedule
        $sql= $database->query("delete from schedule where scheduleid='$id';");
        
        // Chuyển hướng đến trang schedule sau khi xóa bản ghi
        header("location: schedule.php");
    }
?>
