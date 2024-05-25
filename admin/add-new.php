<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/animations.css">  
    <link rel="stylesheet" href="../css/main.css">  
    <link rel="stylesheet" href="../css/admin.css">
        
    <title>Bác Sĩ</title>
    <style>
        /* Định dạng hiệu ứng cho popups */
        .popup{
            animation: transitionIn-Y-bottom 0.5s;
        }
    </style>
</head>
<body>
    <?php
    // Bắt đầu phiên làm việc PHP

    // Bắt đầu hoặc tiếp tục một phiên
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

    // Import database
    include("../connection.php");

    // Xử lý khi form được gửi đi
    if($_POST){
        $result= $database->query("select * from webuser");
        $name=$_POST['name'];
        $nic=$_POST['nic'];
        $spec=$_POST['spec'];
        $email=$_POST['email'];
        $tele=$_POST['Tele'];
        $password=$_POST['password'];
        $cpassword=$_POST['cpassword'];
        
        // Kiểm tra mật khẩu và xác nhận mật khẩu có khớp nhau hay không
        if ($password==$cpassword){
            $error='3';
            // Kiểm tra xem email đã được sử dụng chưa
            $result= $database->query("select * from webuser where email='$email';");
            if($result->num_rows==1){
                $error='1';
            }else{
                // Nếu chưa, thêm thông tin bác sĩ vào cơ sở dữ liệu
                $sql1="insert into doctor(docemail,docname,docpassword,docnic,doctel,specialties) values('$email','$name','$password','$nic','$tele',$spec);";
                $sql2="insert into webuser values('$email','d')";
                $database->query($sql1);
                $database->query($sql2);

                // Chuyển hướng đến trang danh sách bác sĩ sau khi thêm
                header("location: doctors.php?action=add&error=4");
                exit(); // Kết thúc script
            }
        }else{
            $error='2'; // Mã lỗi cho trường hợp mật khẩu không khớp nhau
        }
    }else{
        $error='3'; // Mã lỗi mặc định khi không nhận được dữ liệu từ form
    }

    // Chuyển hướng đến trang danh sách bác sĩ với mã lỗi
    header("location: doctors.php?action=add&error=".$error);
    ?>
</body>
</html>
