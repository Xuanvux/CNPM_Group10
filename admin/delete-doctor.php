<?php
    // Bắt đầu hoặc tiếp tục một phiên làm việc
    session_start();

    // Kiểm tra xem phiên đã được xác định và người dùng đã đăng nhập chưa
    if(isset($_SESSION["user"])){
        // Nếu người dùng chưa đăng nhập hoặc không phải là quản trị viên, chuyển hướng đến trang đăng nhập
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
        
        // Truy vấn để lấy thông tin bác sĩ từ id
        $result001= $database->query("select * from doctor where docid=$id;");
        
        // Lấy email từ kết quả truy vấn
        $row = $result001->fetch_assoc();
        $email = $row["docemail"];

        
        // Xóa bản ghi tương ứng từ bảng webuser và doctor
        $sql= $database->query("delete from webuser where email='$email';");
        $sql= $database->query("delete from doctor where docemail='$email';");
        
        // Chuyển hướng đến trang doctors sau khi xóa bản ghi
        header("location: doctors.php");
    }
?>
