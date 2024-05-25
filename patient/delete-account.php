<?php
    // Bắt đầu phiên làm việc
    session_start();

    // Kiểm tra xem phiên đăng nhập đã tồn tại chưa
    if(isset($_SESSION["user"])){
        // Kiểm tra xem phiên đăng nhập có hợp lệ không
        if(($_SESSION["user"])=="" or $_SESSION['usertype']!='p'){
            // Nếu không hợp lệ, chuyển hướng đến trang đăng nhập
            header("location: ../login.php");
        }else{
            // Nếu hợp lệ, lấy email người dùng từ phiên
            $useremail=$_SESSION["user"];
        }

    }else{
        // Nếu phiên không tồn tại, chuyển hướng đến trang đăng nhập
        header("location: ../login.php");
    }
    
    // Import file kết nối đến cơ sở dữ liệu
    include("../connection.php");

    // Truy vấn để lấy thông tin của người dùng đang đăng nhập
    $sqlmain= "select * from patient where pemail=?";
    $stmt = $database->prepare($sqlmain);
    $stmt->bind_param("s",$useremail);
    $stmt->execute();
    $userrow = $stmt->get_result();
    $userfetch=$userrow->fetch_assoc();
    $userid= $userfetch["pid"];
    $username=$userfetch["pname"];

    // Xử lý yêu cầu GET để xóa tài khoản bệnh nhân
    if($_GET){
        // Import file kết nối đến cơ sở dữ liệu
        include("../connection.php");

        // Lấy ID của bệnh nhân từ yêu cầu GET
        $id=$_GET["id"];

        // Truy vấn để lấy email của bệnh nhân cần xóa
        $sqlmain= "select * from patient where pid=?";
        $stmt = $database->prepare($sqlmain);
        $stmt->bind_param("i",$id);
        $stmt->execute();
        $result001 = $stmt->get_result();
        $email=($result001->fetch_assoc())["pemail"];

        // Xóa tài khoản bệnh nhân khỏi bảng 'webuser'
        $sqlmain= "delete from webuser where email=?;";
        $stmt = $database->prepare($sqlmain);
        $stmt->bind_param("s",$email);
        $stmt->execute();
        $result = $stmt->get_result();

        // Xóa thông tin của bệnh nhân khỏi bảng 'patient'
        $sqlmain= "delete from patient where pemail=?";
        $stmt = $database->prepare($sqlmain);
        $stmt->bind_param("s",$email);
        $stmt->execute();
        $result = $stmt->get_result();

        // Chuyển hướng về trang đăng xuất
        header("location: ../logout.php");
    }
?>
