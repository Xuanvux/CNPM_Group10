
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Liên kết các tệp CSS -->
    <link rel="stylesheet" href="css/animations.css">  
    <link rel="stylesheet" href="css/main.css">  
    <link rel="stylesheet" href="css/signup.css">
    <title>Tạo tài khoản</title>
    <!-- Định dạng CSS trực tiếp -->
    <style>
        .container{
            animation: transitionIn-X 0.5s;
        }
    </style>
</head>
<body>
<?php
// Bắt đầu phiên làm việc
session_start();

// Gán các biến session thành chuỗi rỗng
$_SESSION["user"]="";
$_SESSION["usertype"]="";

// Set múi giờ mới
date_default_timezone_set('Asia/Ho_Chi_Minh');
$date = date('Y-m-d');

// Lưu ngày vào session
$_SESSION["date"]=$date;

// Import tệp kết nối đến cơ sở dữ liệu
include("connection.php");

// Xử lý khi form được gửi đi
if($_POST){
    // Truy xuất tất cả thông tin từ bảng webuser
    $result= $database->query("select * from webuser");

    // Lấy thông tin cá nhân từ session
    $fname=$_SESSION['personal']['fname'];
    $lname=$_SESSION['personal']['lname'];
    $name=$fname." ".$lname;
    $address=$_SESSION['personal']['address'];
    $nic=$_SESSION['personal']['nic'];
    $dob=$_SESSION['personal']['dob'];
    $email=$_POST['newemail'];
    $tele=$_POST['tele'];
    $newpassword=$_POST['newpassword'];
    $cpassword=$_POST['cpassword'];
    
    // Kiểm tra mật khẩu mới và mật khẩu xác nhận có khớp nhau không
    if ($newpassword==$cpassword){
        // Truy vấn kiểm tra xem email đã tồn tại trong cơ sở dữ liệu chưa
        $sqlmain= "select * from webuser where email=?;";
        $stmt = $database->prepare($sqlmain);
        $stmt->bind_param("s",$email);
        $stmt->execute();
        $result = $stmt->get_result();
        if($result->num_rows==1){
            // Thông báo lỗi nếu email đã tồn tại trong cơ sở dữ liệu
            $error='<label for="promter" class="form-label" style="color:rgb(255, 62, 62);text-align:center;">Email đã tồn tại.</label>';
        }else{
            // Nếu không có lỗi, thêm thông tin của bệnh nhân vào cơ sở dữ liệu
            $database->query("insert into patient(pemail,pname,ppassword, paddress, pnic,pdob,ptel) values('$email','$name','$newpassword','$address','$nic','$dob','$tele');");
            $database->query("insert into webuser values('$email','p')");

            // Gán session và chuyển hướng đến trang dashboard của bệnh nhân
            $_SESSION["user"]=$email;
            $_SESSION["usertype"]="p";
            $_SESSION["username"]=$fname;

            header('Location: patient/index.php');
            $error='<label for="promter" class="form-label" style="color:rgb(255, 62, 62);text-align:center;"></label>';
        }
    }else{
        // Thông báo lỗi nếu mật khẩu không khớp nhau
        $error='<label for="promter" class="form-label" style="color:rgb(255, 62, 62);text-align:center;">Lỗi cấu hình mật khẩu! Sửa lại mật khẩu</label>';
    }
}else{
    // Gán chuỗi rỗng vào biến lỗi nếu không có dữ liệu POST
    $error='<label for="promter" class="form-label"></label>';
}
?>
<!-- Phần trung tâm của trang -->
<center>
<div class="container">
    <table border="0" style="width: 69%;">
        <tr>
            <td colspan="2">
                <!-- Tiêu đề của form -->
                <p class="header-text">Hãy bắt đầu</p>
                <p class="sub-text">Được rồi, bây giờ hãy tạo tài khoản người dùng.</p>
            </td>
        </tr>
        <tr>
            <!-- Form tạo tài khoản -->
            <form action="" method="POST" >
                <td class="label-td" colspan="2">
                    <!-- Nhập email mới -->
                    <label for="newemail" class="form-label">Email: </label>
                </td>
        </tr>
        <tr>
            <td class="label-td" colspan="2">
                <!-- Ô nhập email mới -->
                <input type="email" name="newemail" class="input-text" placeholder="Email" required>
            </td>
        </tr>
        <tr>
            <td class="label-td" colspan="2">
                <!-- Nhập số điện thoại -->
                <label for="tele" class="form-label">Số điện thoại: </label>
            </td>
        </tr>
        <tr>
            <td class="label-td" colspan="2">
                <!-- Ô nhập số điện thoại...-->
                <input type="tel" name="tele" class="input-text"  placeholder="ex: 0712345678" pattern="[0]{1}[0-9]{9}" >
            </td>
        </tr>
        <tr>
            <td class="label-td" colspan="2">
                <!-- Nhập mật khẩu mới -->
                <label for="newpassword" class="form-label">Tạo mật khẩu mới: </label>
            </td>
        </tr>
        <tr>
            <td class="label-td" colspan="2">
                <!-- Ô nhập mật khẩu mới -->
                <input type="password" name="newpassword" class="input-text" placeholder="Mật khẩu mới" required>
            </td>
        </tr>
        <tr>
            <td class="label-td" colspan="2">
                <!-- Xác nhận mật khẩu mới -->
                <label for="cpassword" class="form-label">Xác nhâ

̣n mật khẩu: </label>
            </td>
        </tr>
        <tr>
            <td class="label-td" colspan="2">
                <!-- Ô nhập xác nhận mật khẩu -->
                <input type="password" name="cpassword" class="input-text" placeholder="Xác nhận mật khẩu" required>
            </td>
        </tr>
        <tr>
            <td colspan="2">
                <!-- Hiển thị thông báo lỗi -->
                <?php echo $error ?>
            </td>
        </tr>
        <tr>
            <!-- Nút làm mới và nút đăng ký -->
            <td>
                <input type="reset" value="Làm mới" class="login-btn btn-primary-soft btn" >
            </td>
            <td>
                <input type="submit" value="Đăng ký" class="login-btn btn-primary btn">
            </td>
        </tr>
        <tr>
            <td colspan="2">
                <!-- Phần nếu đã có tài khoản -->
                <br>
                <label for="" class="sub-text" style="font-weight: 280;">Đã có tài khoản&#63; </label>
                <a href="login.php" class="hover-link1 non-style-link">Đăng nhập</a>
                <br><br><br>
            </td>
        </tr>
        </form>
    </table>
</div>
</center>
</body>
</html>
