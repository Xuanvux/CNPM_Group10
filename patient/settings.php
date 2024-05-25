<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/animations.css">  
    <link rel="stylesheet" href="../css/main.css">  
    <link rel="stylesheet" href="../css/admin.css">  
    <title>Settings</title>
    <!-- Định dạng CSS. -->
    <style>
        .dashbord-tables{
            animation: transitionIn-Y-over 0.5s;
        }
        .filter-container{
            animation: transitionIn-X  0.5s;
        }
        .sub-table{
            animation: transitionIn-Y-bottom 0.5s;
        }
    </style>
</head>
<body>
    <?php
    // Bắt đầu phiên làm việc PHP
    session_start();
    // Kiểm tra xem người dùng đã đăng nhập chưa
    if(isset($_SESSION["user"])){
        if(($_SESSION["user"])=="" or $_SESSION['usertype']!='p'){
            header("location: ../login.php");
        }else{
            $useremail=$_SESSION["user"];
        }

    }else{
        header("location: ../login.php");
    }
    // Kết nối với cơ sở dữ liệu
    include("../connection.php");
    $sqlmain= "select * from patient where pemail=?";
    $stmt = $database->prepare($sqlmain);
    $stmt->bind_param("s",$useremail);
    $stmt->execute();
    $result = $stmt->get_result();
    $userfetch=$result->fetch_assoc();
    $userid= $userfetch["pid"];
    $username=$userfetch["pname"];
    ?>
    <!-- HTML cho phần menu -->
    <div class="container">
        <div class="menu">
            <table class="menu-container" border="0">
                <tr>
                    <!-- Thông tin người dùng -->
                    <td style="padding:10px" colspan="2">
                        <table border="0" class="profile-container">
                            <tr>
                                <td width="30%" style="padding-left:20px" >
                                    <img src="../img/user.png" alt="" width="100%" style="border-radius:50%">
                                </td>
                                <td style="padding:0px;margin:0px;">
                                    <p class="profile-title"><?php echo substr($username,0,13)  ?>..</p>
                                    <p class="profile-subtitle"><?php echo substr($useremail,0,22)  ?></p>
                                </td>
                            </tr>
                            <tr>
                                <!-- Đăng xuất -->
                                <td colspan="2">
                                <a href="../logout.php" ><input type="button" value="Log out" class="logout-btn btn-primary-soft btn"></a>
                                </td>
                            </tr>
                    </table>
                    </td>
                </tr>
                <!-- Các liên kết menu -->
                <tr class="menu-row" >
                    <td class="menu-btn menu-icon-home " >
                        <a href="index.php" class="non-style-link-menu "><div><p class="menu-text">Trang chủ</p></a></div></a>
                    </td>
                </tr>
                <tr class="menu-row">
                    <td class="menu-btn menu-icon-doctor">
                        <a href="doctors.php" class="non-style-link-menu"><div><p class="menu-text">Tất cả bác sĩ</p></a></div>
                    </td>
                </tr>
                <tr class="menu-row" >
                    <td class="menu-btn menu-icon-session">
                        <a href="schedule.php" class="non-style-link-menu"><div><p class="menu-text">Phiên đã lên lịch</p></div></a>
                    </td>
                </tr>
                <tr class="menu-row" >
                    <td class="menu-btn menu-icon-appoinment">
                        <a href="appointment.php" class="non-style-link-menu"><div><p class="menu-text">Đặt chỗ của tôi</p></a></div>
                    </td>
                </tr>
                <tr class="menu-row" >
                    <!-- Liên kết đến trang cài đặt -->
                    <td class="menu-btn menu-icon-settings  menu-active menu-icon-settings-active">
                        <a href="settings.php" class="non-style-link-menu  non-style-link-menu-active"><div><p class="menu-text">Cài đặt</p></a></div>
                    </td>
                </tr>
            </table>
        </div>
        <!-- Nội dung trang cài đặt -->
        <div class="dash-body" style="margin-top: 15px">
            <table border="0" width="100%" style=" border-spacing: 0;margin:0;padding:0;" >
                <tr >
                    <!-- Nút trở lại -->
                    <td width="13%" >
                        <a href="settings.php" ><button  class="login-btn btn-primary-soft btn btn-icon-back"  style="padding-top:11px;padding-bottom:11px;margin-left:20px;width:125px"><font class="tn-in-text">Trở lại</font></button></a>
                    </td>
                    <td>
                        <!-- Tiêu đề -->
                        <p style="font-size: 23px;padding-left:12px;font-weight: 600;">Cài đặt</p> 
                    </td>
                    <td width="15%">
                        <!-- Hiển thị ngày hôm nay -->
                        <p style="font-size: 14px;color: rgb(119, 119, 119);padding: 0;margin: 0;text-align: right;">
                            Ngày hôm nay
                        </p>
                        <p class="heading-sub12" style="padding: 0;margin: 0;">
                            <?php 
                            date_default_timezone_set('Asia/Kolkata');
                            $today = date('Y-m-d');
                            echo $today;
                            // Lấy số liệu từ cơ sở dữ liệu
                            $patientrow = $database->query("select  * from  patient;");
                            $doctorrow = $database->query("select  * from  doctor;");
                            $appointmentrow = $database->query("select  * from  appointment where appodate>='$today';");
                            $schedulerow = $database->query("select  * from  schedule where scheduledate='$today';");
                            ?>
                        </p>
                    </td>
                    <td width="10%">
                        <!-- Biểu tượng lịch -->
                        <button  class="btn-label"  style="display: flex;justify-content: center;align-items: center;"><img src="../img/calendar.svg" width="100%"></button>
                    </td>
                </tr>
                <tr>
                    <td colspan="4">
                        <center>
                            <!-- Các liên kết cài đặt -->
                            <table class="filter-container" style="border: none;" border="0">
                                <tr>
                                    <td colspan="4">
                                        <p style="font-size: 20px">&nbsp;</p>
                                    </td>
                                </tr>
                                <tr>
                                    <!-- Liên kết cài đặt tài khoản -->
                                    <td style="width: 25%;">
                                        <a href="?action=edit&id=<?php echo $userid ?>&error=0" class="non-style-link">
                                            <div  class="dashboard-items setting-tabs"  style="padding:20px;margin:auto;width:95%;display: flex">
                                                <div class="btn-icon-back dashboard-icons-setting" style="background-image: url('../img/icons/doctors-hover.svg');"></div>
                                                <div>
                                                    <div class="h1-dashboard">
                                                        Cài đặt tài khoản  &nbsp;
                                                    </div><br>
                                                    <div class="h3-dashboard" style="font-size: 15px;">
                                                        Sửa tài khoản & Thay đổi mật khẩu
                                                    </div>
                                                </div>
                                            </div>
                                        </a>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="4">
                                        <p style="font-size: 5px">&nbsp;</p>
                                    </td>
                                </tr>
                                <tr>
                                    <!-- Liên kết xem chi tiết tài khoản -->
                                    <td style="width: 25%;">
                                        <a href="?action=view&id=<?php echo $userid ?>" class="non-style-link">
                                            <div  class="dashboard-items setting-tabs"  style="padding:20px;margin:auto;width:95%;display: flex;">
                                                <div class="btn-icon-back dashboard-icons-setting " style="background-image: url('../img/icons/view-iceblue.svg');"></div>
                                                <div>
                                                    <div class="h1-dashboard" >
                                                        Xem chi tiết tài khoản
                                                    </div><br>
                                                    <div class="h3-dashboard"  style="font-size: 15px;">
                                                        Xem thông tin cá nhân về tài khoản của bạn
                                                    </div>
                                                </div>
                                            </div>
                                        </a>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="4">
                                        <p style="font-size: 5px">&nbsp;</p>
                                    </td>
                                </tr>
                                <tr>
                                    <!-- Liên kết xoá tài khoản -->
                                    <td style="width: 25%;">
                                        <a href="?action=drop&id=<?php echo $userid.'&name='.$username ?>" class="non-style-link">
                                            <div  class="dashboard-items setting-tabs"  style="padding:20px;margin:auto;width:95%;display: flex;">
                                                <div class="btn-icon-back dashboard-icons-setting" style="background-image: url('../img/icons/patients-hover.svg');"></div>
                                                <div>
                                                    <div class="h1-dashboard" style="color: #ff5050;">
                                                        Xoá tài khoản
                                                    </div><br>
                                                    <div class="h3-dashboard"  style="font-size: 15px;">
                                                        Sẽ xoá vĩnh viễn tài khoản của bạn
                                                    </div>
                                                </div>
                                            </div>
                                        </a>
                                    </td>
                                </tr>
                            </table>
                        </center>
                    </td>
                </tr>
            </table>
        </div>
    </div>
    <?php 
    if($_GET){
        // Xử lý các yêu cầu được gửi qua phương thức GET
        $id=$_GET["id"];
        $action=$_GET["action"];
        if($action=='drop'){
            $nameget=$_GET["name"];
            echo '
            <!-- Popup xác nhận xoá tài khoản -->
            <div id="popup1" class="overlay">
                <div class="popup">
                    <center>
                        <h2>Bạn có chắc chắn?</h2>
                        <a class="close" href="settings.php">&times;</a>
                        <div class="content">
                            Bạn muốn xoá tài khoản của bạn?<br>('.substr($nameget,0,40).'). 
                        </div>
                        <div style="display: flex;justify-content: center;">
                            <a href="delete-account.php?id='.$id.'" class="non-style-link"><button  class="btn-primary btn"  style="display: flex;justify-content: center;align-items: center;margin:10px;padding:10px;"<font class="tn-in-text">&nbsp;Có&nbsp;</font></button></a>&nbsp;&nbsp;&nbsp;
                            <a href="settings.php" class="non-style-link"><button  class="btn-primary btn"  style="display: flex;justify-content: center;align-items: center;margin:10px;padding:10px;"><font class="tn-in-text">&nbsp;&nbsp;Không&nbsp;&nbsp;</font></button></a>
                        </div>
                    </center>
                </div>
            </div>
            ';
        }elseif($action=='view'){
            // Xem thông tin chi tiết tài khoản
            $sqlmain= "select * from patient where pid=?";
            $stmt = $database->prepare($sqlmain);
            $stmt->bind_param("i", $id);
            $stmt->execute();
            $result = $stmt->get_result();
            $row=$result->fetch_assoc();
            $name=$row["pname"];
            $email=$row["pemail"];
            $address=$row["paddress"];
            $dob=$row["pdob"];
            $nic=$row['pnic'];
            $tele=$row['ptel'];
            echo '
            <!-- Popup hiển thị thông tin chi tiết tài khoản -->
            <div id="popup1" class="overlay">
                <div class="popup">
                    <center>
                        <h2></h2>
                        <a class="close" href="settings.php">&times;</a>
                        <div class="content">
                            Hệ thống quản lý bệnh viện App<br> 
                        </div>
                        <div style="display: flex;justify-content: center;">
                            <table width="80%" class="sub-table scrolldown add-doc-form-container" border="0">
                                <tr>
                                    <td>
                                        <p style="padding: 0;margin: 0;text-align: left;font-size: 25px;font-weight: 500;">Xem chi tiết.</p><br><br>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="label-td" colspan="2">
                                        <label for="name" class="form-label">Tên: </label>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="label-td" colspan="2">
                                        '.$name.'<br><br>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="label-td" colspan="2">
                                        <label for="Email" class="form-label">Email: </label>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="label-td" colspan="2">
                                        '.$email.'<br><br>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="label-td" colspan="2">
                                        <label for="nic" class="form-label">Số CCCD: </label>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="label-td" colspan="2">
                                        '.$nic.'<br><br>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="label-td" colspan="2">
                                        <label for="Tele" class="form-label">SĐT: </label>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="label-td" colspan="2">
                                        '.$tele.'<br><br>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="label-td" colspan="2">
                                        <label for="spec" class="form-label">Địa chỉ: </label>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="label-td" colspan="2">
                                        '.$address.'<br><br>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="label-td" colspan="2">
                                        <label for="spec" class="form-label">Ngày sinh: </label>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="label-td" colspan="2">
                                        '.$dob.'<br><br>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="2">
                                        <a href="settings.php"><input type="button" value="OK" class="login-btn btn-primary-soft btn" ></a>
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </center>
                    <br><br>
                </div>
            </div>
            ';
        }elseif($action=='edit'){
            // Hiển thị form chỉnh sửa tài khoản
            $sqlmain= "select * from patient where pid=?";
            $stmt = $database->prepare($sqlmain);
            $stmt->bind_param("i", $id);
            $stmt->execute();
            $result = $stmt->get_result();
            $row=$result->fetch_assoc();
            $name=$row["pname"];
            $email=$row["pemail"];
            $address=$row["paddress"];
            $nic=$row['pnic'];
            $tele=$row['ptel'];
            $error_1=$_GET["error"];
            $errorlist= array(
                '1'=>'<label for="promter" class="form-label" style="color:rgb(255, 62, 62);text-align:center;">Đã có tài khoản cho địa chỉ Email này.</label>',
                '2'=>'<label for="promter" class="form-label" style="color:rgb(255, 62, 62);text-align:center;">Lỗi cấu hình mật khẩu! Sửa lại mật khẩu</label>',
                '3'=>'<label for="promter" class="form-label" style="color:rgb(255, 62, 62);text-align:center;"></label>',
                '4'=>"",
                '0'=>'',
            );
            if($error_1!='4'){
                echo '
                <!-- Popup hiển thị lỗi hoặc form chỉnh sửa -->
                <div id="popup1" class="overlay">
                    <div class="popup">
                        <center>
                            <a class="close" href="settings.php">&times;</a> 
                            <div style="display: flex;justify-content: center;">
                                <div class="abc">
                                    <table width="80%" class="sub-table scrolldown add-doc-form-container" border="0">
                                        <tr>
                                            <td class="label-td" colspan="2">'.
                                                $errorlist[$error_1]
                                            .'</td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <p style="padding: 0;margin: 0;text-align: left;font-size: 25px;font-weight: 500;">Sửa chi tiết tài khoản người dùng.</p>
                                                ID người dùng: '.$id.' (Auto Generated)<br><br>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="label-td" colspan="2">
                                                <form action="edit-user.php" method="POST" class="add-new-form">
                                                    <label for="Email" class="form-label">Email: </label>
                                                    <input type="hidden" value="'.$id.'" name="id00">
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="label-td" colspan="2">
                                                <input type="hidden" name="oldemail" value="'.$email.'" >
                                                <input type="email" name="email" class="input-text" placeholder="Email" value="'.$email.'" required><br>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="label-td" colspan="2">
                                                <label for="name" class="form-label">Tên: </label>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="label-td" colspan="2">
                                                <input type="text" name="name" class="input-text" placeholder="Tên bác sĩ" value="'.$name.'" required><br>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="label-td" colspan="2">
                                                <label for="nic" class="form-label">Số CCCD: </label>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="label-td" colspan="2">
                                                <input type="text" name="nic" class="input-text" placeholder="Số CCCD" value="'.$nic.'" required><br>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="label-td" colspan="2">
                                                <label for="tele" class="form-label">SĐT: </label>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="label-td" colspan="2">
                                                <input type="tel" name="tele" class="input-text" placeholder="Số điện thoại" value="'.$tele.'" required><br>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="label-td" colspan="2">
                                                <label for="spec" class="form-label">Địa chỉ: </label>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="label-td" colspan="2">
                                                <input type="text" name="address" class="input-text" placeholder="Địa chỉ" value="'.$address.'" required><br>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan="2">
                                                <input type="submit" value="Cập nhật" class="login-btn btn-primary-soft btn" style="margin-top:20px;">
                                                <a href="settings.php" class="non-style-link"><button  class="btn-primary btn"  style="display: flex;justify-content: center;align-items: center;margin-top:20px;padding:10px;"><font class="tn-in-text">&nbsp;&nbsp;Hủy&nbsp;&nbsp;</font></button></a>
                                            </td>
                                        </tr>
                                    </form>
                                    </table>
                                </div>
                            </div>
                        </center>
                    </div>
                </div>
                ';
            }else{
                echo '
                <!-- Redirect back -->
                <script>
                    window.location.href="settings.php";
                </script>
                ';
            }
        }
    }
    ?>
</body>
</html>
