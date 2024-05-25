<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Liên kết các tệp CSS -->
    <link rel="stylesheet" href="css/animations.css">  
    <link rel="stylesheet" href="css/main.css">  
    <link rel="stylesheet" href="css/login.css">
    <title>Đăng nhập</title>
</head>
<body>
    <?php
    // Bắt đầu phiên làm việc...sss
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
        $email=$_POST['useremail'];
        $password=$_POST['userpassword'];
        
        $error='<label for="promter" class="form-label"></label>';

        // Truy vấn kiểm tra thông tin đăng nhập
        $result= $database->query("select * from webuser where email='$email'");
        if($result->num_rows==1){
            $utype=$result->fetch_assoc()['usertype'];
            if ($utype=='p'){
                // Kiểm tra đăng nhập cho bệnh nhân
                $checker = $database->query("select * from patient where pemail='$email' and ppassword='$password'");
                if ($checker->num_rows==1){
                    // Đăng nhập thành công, chuyển hướng đến trang dashboard của bệnh nhân
                    $_SESSION['user']=$email;
                    $_SESSION['usertype']='p';
                    header('location: patient/index.php');
                }else{
                    // Thông báo lỗi nếu thông tin đăng nhập không chính xác
                    $error='<label for="promter" class="form-label" style="color:rgb(255, 62, 62);text-align:center;">Thông tin xác thực sai: Email hoặc mật khẩu không hợp lệ</label>';
                }
            }elseif($utype=='a'){
                // Kiểm tra đăng nhập cho admin
                $checker = $database->query("select * from admin where aemail='$email' and apassword='$password'");
                if ($checker->num_rows==1){
                    // Đăng nhập thành công, chuyển hướng đến trang dashboard của admin
                    $_SESSION['user']=$email;
                    $_SESSION['usertype']='a';
                    header('location: admin/index.php');
                }else{
                    // Thông báo lỗi nếu thông tin đăng nhập không chính xác
                    $error='<label for="promter" class="form-label" style="color:rgb(255, 62, 62);text-align:center;">Thông tin xác thực sai: Email hoặc mật khẩu không hợp lệ</label>';
                }
            }elseif($utype=='d'){
                // Kiểm tra đăng nhập cho bác sĩ
                $checker = $database->query("select * from doctor where docemail='$email' and docpassword='$password'");
                if ($checker->num_rows==1){
                    // Đăng nhập thành công, chuyển hướng đến trang dashboard của bác sĩ
                    $_SESSION['user']=$email;
                    $_SESSION['usertype']='d';
                    header('location: doctor/index.php');
                }else{
                    // Thông báo lỗi nếu thông tin đăng nhập không chính xác
                    $error='<label for="promter" class="form-label" style="color:rgb(255, 62, 62);text-align:center;">Thông tin xác thực sai: Email hoặc mật khẩu không hợp lệ</label>';
                }
            }
        }else{
            // Thông báo lỗi nếu không tìm thấy tài khoản đăng ký với email
            $error='<label for="promter" class="form-label" style="color:rgb(255, 62, 62);text-align:center;">Chúng tôi không thể tìm thấy tài khoản đăng ký bởi email.</label>';
        }
    }else{
        // Gán chuỗi rỗng vào biến lỗi nếu không có dữ liệu POST
        $error='<label for="promter" class="form-label">&nbsp;</label>';
    }
    ?>
    <!-- Phần trung tâm của trang -->
    <center>
    <div class="container">
        <table border="0" style="margin: 0;padding: 0;width: 60%;">
            <tr>
                <td>
                    <!-- Tiêu đề của form -->
                    <p class="header-text">Chào mừng quay trở lại!</p>
                </td>
            </tr>
            <div class="form-body">
                <tr>
                    <td>
                        <!-- Phụ đề của form -->
                        <p class="sub-text">Đăng nhập để tiếp tục</p>
                    </td>
                </tr>
                <tr>
                    <!-- Form đăng nhập -->
                    <form action="" method="POST" >
                        <td class="label-td">
                            <!-- Nhập email -->
                            <label for="useremail" class="form-label">Email: </label>
                        </td>
                </tr>
                <tr>
                    <td class="label-td">
                        <!-- Ô nhập email -->
                        <input type="email" name="useremail" class="input-text" placeholder="Email" required>
                    </td>
                </tr>
                <tr>
                    <td class="label-td">
                        <!-- Nhập mật khẩu -->
                        <label for="userpassword" class="form-label">Mật khẩu: </label>
                    </td>
                </tr>
                <tr>
                    <td class="label-td">
                        <!-- Ô nhập mật khẩu -->
                        <input type="Password" name="userpassword" class="input-text" placeholder="Mật khẩu" required>
                    </td>
                </tr>
                <tr>
                    <td><br>
                        <!-- Hiển thị thông báo lỗi -->
                        <?php echo $error ?>
                    </td>
                </tr>
                <tr>
                    <td>
                        <!-- Nút đăng nhập -->
                        <input type="submit" value="Login" class="login-btn btn-primary btn">
                    </td>
                </tr>
            </div>
            <tr>
                <td>
                    <!-- Phần đăng ký nếu chưa có tài khoản -->
                    <br>
                    <label for="" class="sub-text" style="font-weight: 280;">Bạn chưa có tài khoản&#63; </label>
                    <a href="signup.php" class="hover-link1 non-style-link">Đăng ký</a>
                    <br><br><br>
                </td>
            </tr>
            </form>
        </table>
    </div>
    </center>
</body>
</html>
