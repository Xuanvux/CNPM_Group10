<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Liên kết CSS. -->
    <link rel="stylesheet" href="css/animations.css">  
    <link rel="stylesheet" href="css/main.css">  
    <link rel="stylesheet" href="css/signup.css">
        
    <title>Đăng ký</title>
    
</head>
<body>
<?php

// Bắt đầu phiên làm việc PHP
// Unset tất cả các biến session server-side
session_start();

$_SESSION["user"]="";
$_SESSION["usertype"]="";

// Set múi giờ mới cho phiên làm việc
date_default_timezone_set('Asia/Ho_Chi_Minh');
$date = date('Y-m-d');

$_SESSION["date"]=$date;

// Xử lý dữ liệu từ form khi được submit
if($_POST){
    $_SESSION["personal"]=array(
        'fname'=>$_POST['fname'],
        'lname'=>$_POST['lname'],
        'address'=>$_POST['address'],
        'nic'=>$_POST['nic'],
        'dob'=>$_POST['dob']
    );

    print_r($_SESSION["personal"]);
    header("location: create-account.php");
}

?>

    <!-- Phần HTML của trang -->
    <center>
    <div class="container">
        <table border="0">
            <tr>
                <td colspan="2">
                    <!-- Tiêu đề và mô tả -->
                    <p class="header-text">Hãy bắt đầu</p>
                    <p class="sub-text">Thêm thông tin cá nhân của bạn để tiếp tục</p>
                </td>
            </tr>
            <tr>
                <form action="" method="POST" >
                    <!-- Form nhập thông tin -->
                    <td class="label-td" colspan="2">
                        <label for="name" class="form-label">Tên: </label>
                    </td>
            </tr>
            <tr>
                <td class="label-td">
                    <!-- Ô nhập họ -->
                    <input type="text" name="fname" class="input-text" placeholder="Họ" required>
                </td>
                <td class="label-td">
                    <!-- Ô nhập tên -->
                    <input type="text" name="lname" class="input-text" placeholder="Tên" required>
                </td>
            </tr>
            <!-- Các trường nhập thông tin khác -->
            <tr>
                <td class="label-td" colspan="2">
                    <label for="address" class="form-label">Địa chỉ: </label>
                </td>
            </tr>
            <tr>
                <td class="label-td" colspan="2">
                    <input type="text" name="address" class="input-text" placeholder="Địa chỉ" required>
                </td>
            </tr>
            <tr>
                <td class="label-td" colspan="2">
                    <label for="nic" class="form-label">Số CCCD: </label>
                </td>
            </tr>
            <tr>
                <td class="label-td" colspan="2">
                    <input type="text" name="nic" class="input-text" placeholder="Số CCCD" required>
                </td>
            </tr>
            <tr>
                <td class="label-td" colspan="2">
                    <label for="dob" class="form-label">Ngày sinh: </label>
                </td>
            </tr>
            <tr>
                <td class="label-td" colspan="2">
                    <input type="date" name="dob" class="input-text" required>
                </td>
            </tr>
            <!-- Nút gửi và làm mới form -->
            <tr>
                <td class="label-td" colspan="2"></td>
            </tr>
            <tr>
                <td>
                    <input type="reset" value="Làm mới" class="login-btn btn-primary-soft btn" >
                </td>
                <td>
                    <input type="submit" value="Tiếp tục" class="login-btn btn-primary btn">
                </td>
            </tr>
            <!-- Liên kết đến trang đăng nhập nếu đã có tài khoản -->
            <tr>
                <td colspan="2">
                    <br>
                    <label for="" class="sub-text" style="font-weight: 280;">Bạn đã có tài khoản&#63; </label>
                    <a href="login.php" class="hover-link1 non-style-link">Đăng nhập</a>
                    <br><br><br>
                </td>
            </tr>
        </table>
        <!-- Kết thúc form -->
    </div>
    <!-- Kết thúc div container -->
</center>
<!-- Kết thúc trang -->
</body>
</html>
