<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <!-- Thiết lập mã hóa ký tự -->
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!-- Tương thích với các phiên bản IE -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Đảm bảo trang web hiển thị tốt trên mọi thiết bị -->
    <link rel="stylesheet" href="../css/animations.css">
    <!-- Liên kết đến file CSS chứa các animation -->
    <link rel="stylesheet" href="../css/main.css">
    <!-- Liên kết đến file CSS chính -->
    <link rel="stylesheet" href="../css/admin.css">
    <!-- Liên kết đến file CSS dành cho admin -->
    <title>Cuộc hẹn</title>
    <style>
        .popup{
            animation: transitionIn-Y-bottom 0.5s;
        }
        .sub-table{
            animation: transitionIn-Y-bottom 0.5s;
        }
    </style>
</head>
<body>
    <?php
    // Bắt đầu session
    session_start();

    // Kiểm tra nếu session user đã được tạo
    if(isset($_SESSION["user"])){
        // Nếu session user rỗng hoặc không phải là người dùng loại d (doctor), chuyển hướng đến trang đăng nhập
        if(($_SESSION["user"])=="" or $_SESSION['usertype']!='d'){
            header("location: ../login.php");
        }else{
            $useremail=$_SESSION["user"];
        }
    }else{
        header("location: ../login.php");
    }
    
    // Import database
    include("../connection.php");
    // Lấy thông tin của bác sĩ từ database
    $userrow = $database->query("select * from doctor where docemail='$useremail'");
    $userfetch=$userrow->fetch_assoc();
    $userid= $userfetch["docid"];
    $username=$userfetch["docname"];
    ?>
    <div class="container">
        <div class="menu">
            <table class="menu-container" border="0">
                <tr>
                    <td style="padding:10px" colspan="2">
                        <table border="0" class="profile-container">
                            <tr>
                                <td width="30%" style="padding-left:20px" >
                                    <!-- Hình ảnh của user -->
                                    <img src="../img/user.png" alt="" width="100%" style="border-radius:50%">
                                </td>
                                <td style="padding:0px;margin:0px;">
                                    <!-- Hiển thị tên và email của user. -->
                                    <p class="profile-title"><?php echo substr($username,0,13)  ?>..</p>
                                    <p class="profile-subtitle"><?php echo substr($useremail,0,22)  ?></p>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="2">
                                    <!-- Nút đăng xuất -->
                                    <a href="../logout.php" ><input type="button" value="Log out" class="logout-btn btn-primary-soft btn"></a>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
                <!-- Các mục trong menu -->
                <tr class="menu-row" >
                    <td class="menu-btn menu-icon-dashbord" >
                        <a href="index.php" class="non-style-link-menu"><div><p class="menu-text">Bảng điều khiển</p></a></div>
                    </td>
                </tr>
                <tr class="menu-row">
                    <td class="menu-btn menu-icon-appoinment menu-active menu-icon-appoinment-active">
                        <a href="appointment.php" class="non-style-link-menu non-style-link-menu-active"><div><p class="menu-text">Cuộc hẹn của tôi</p></a></div>
                    </td>
                </tr>
                <tr class="menu-row" >
                    <td class="menu-btn menu-icon-session">
                        <a href="schedule.php" class="non-style-link-menu"><div><p class="menu-text">Phiên của tôi</p></div></a>
                    </td>
                </tr>
                <tr class="menu-row" >
                    <td class="menu-btn menu-icon-patient">
                        <a href="patient.php" class="non-style-link-menu"><div><p class="menu-text">Bệnh nhân của tôi</p></a></div>
                    </td>
                </tr>
                <tr class="menu-row" >
                    <td class="menu-btn menu-icon-settings">
                        <a href="settings.php" class="non-style-link-menu"><div><p class="menu-text">Cài đặt</p></a></div>
                    </td>
                </tr>
            </table>
        </div>
        <div class="dash-body">
            <table border="0" width="100%" style=" border-spacing: 0;margin:0;padding:0;margin-top:25px;">
                <tr >
                    <td width="13%">
                        <!-- Nút quay lại trang cuộc hẹn -->
                        <a href="appointment.php"><button class="login-btn btn-primary-soft btn btn-icon-back" style="padding-top:11px;padding-bottom:11px;margin-left:20px;width:125px"><font class="tn-in-text">Quay lại</font></button></a>
                    </td>
                    <td>
                        <p style="font-size: 23px;padding-left:12px;font-weight: 600;">Người quản lý cuộc hẹn</p>
                    </td>
                    <td width="15%">
                        <p style="font-size: 14px;color: rgb(119, 119, 119);padding: 0;margin: 0;text-align: right;">
                            Ngày hôm nay
                        </p>
                        <p class="heading-sub12" style="padding: 0;margin: 0;">
                            <?php
                            date_default_timezone_set('Asia/Ho_Chi_Minh');
                            $today = date('Y-m-d');
                            echo $today;
                            $list110 = $database->query("select * from schedule inner join appointment on schedule.scheduleid=appointment.scheduleid inner join patient on patient.pid=appointment.pid inner join doctor on schedule.docid=doctor.docid where doctor.docid=$userid");
                            ?>
                        </p>
                    </td>
                    <td width="10%">
                        <!-- Nút hiển thị lịch -->
                        <button class="btn-label" style="display: flex;justify-content: center;align-items: center;"><img src="../img/calendar.svg" width="100%"></button>
                    </td>
                </tr>
                <tr>
                    <td colspan="4" style="padding-top:10px;width: 100%;" >
                        <p class="heading-main12" style="margin-left: 45px;font-size:18px;color:rgb(49, 49, 49)">Cuộc hẹn của tôi (<?php echo $list110->num_rows; ?>)</p>
                    </td>
                </tr>
                <tr>
                    <td colspan="4" style="padding-top:0px;width: 100%;" >
                        <center>
                        <!-- Form lọc cuộc hẹn theo ngày -->
                        <table class="filter-container" border="0" >
                            <tr>
                                <td width="10%">
                                </td>
                                <td width="5%" style="text-align: center;">
                                    Ngày:
                                </td>
                                <td width="30%">
                                    <form action="" method="post">
                                        <input type="date" name="sheduledate" id="date" class="input-text filter-container-items" style="margin: 0;width: 95%;">
                                </td>
                                <td width="12%">
                                    <input type="submit" name="filter" value="Lọc" class="btn-primary-soft btn button-icon btn-filter" style="padding: 15px; margin: 0;width:100%">
                                    </form>
                                </td>
                            </tr>
                        </table>
                        </center>
                    </td>
                </tr>
                <?php
                // Tạo câu truy vấn lấy thông tin cuộc hẹn
                $sqlmain= "select appointment.appoid,schedule.scheduleid,schedule.title,doctor.docname,patient.pname,schedule.scheduledate,schedule.scheduletime,appointment.apponum,appointment.appodate from schedule inner join appointment on schedule.scheduleid=appointment.scheduleid inner join patient on patient.pid=appointment.pid inner join doctor on schedule.docid=doctor.docid where doctor.docid=$userid ";
                if($_POST){
                    if(!empty($_POST["sheduledate"])){
                        $sheduledate=$_POST["sheduledate"];
                        $sqlmain.=" and schedule.scheduledate='$sheduledate' ";
                    }
                }
                ?>
                <tr>
                   <td colspan="4">
                       <center>
                       <!-- Bảng hiển thị danh sách cuộc hẹn -->
                        <div class="abc scroll">
                        <table width="93%" class="sub-table scrolldown" border="0">
                        <thead>
                            <tr>
                                <th class="table-headin">Tên bệnh nhân</th>
                                <th class="table-headin">Số cuộc hẹn</th>
                                <th class="table-headin">Tiêu đề phiên</th>
                                <th class="table-headin">Ngày và giờ của phiên</th>
                                <th class="table-headin">Ngày hẹn</th>
                                <th class="table-headin">Hành động</th>
                            </tr>
                        </thead>
                        <tbody>
                        
                            <?php
                            $result= $database->query($sqlmain);
                            if($result->num_rows==0){
                                echo '<tr>
                                <td colspan="7">
                                <br><br><br><br>
                                <center>
                                <img src="../img/notfound.svg" width="25%">
                                <br>
                                <p class="heading-main12" style="font-size:20px;color:rgb(49, 49, 49)">Không tìm thấy gì cả!</p>
                                <a class="non-style-link" href="appointment.php"><button class="login-btn btn-primary-soft btn" style="display: flex;justify-content: center;align-items: center;margin-left:20px;">Hiển thị tất cả cuộc hẹn</button></a>
                                </center>
                                <br><br><br><br>
                                </td>
                                </tr>';
                            }else{
                                for ( $x=0; $x<$result->num_rows;$x++){
                                    $row=$result->fetch_assoc();
                                    $appoid=$row["appoid"];
                                    $scheduleid=$row["scheduleid"];
                                    $title=$row["title"];
                                    $docname=$row["docname"];
                                    $scheduledate=$row["scheduledate"];
                                    $scheduletime=$row["scheduletime"];
                                    $pname=$row["pname"];
                                    $apponum=$row["apponum"];
                                    $appodate=$row["appodate"];
                                    echo '<tr >
                                        <td style="padding:20px;"> &nbsp;'.
                                        substr($pname,0,25)
                                        .'</td >
                                        <td style="padding:20px;"> &nbsp;'.
                                        substr($apponum,0,25)
                                        .'</td >
                                        <td style="padding:20px;"> &nbsp;'.
                                        substr($title,0,25)
                                        .'</td>
                                        <td>
                                            '.substr($scheduledate,0,10).' @'.substr($scheduletime,0,5).'
                                        </td>
                                        <td style="text-align:center;">
                                            '.substr($appodate,0,10).'
                                        </td>

                                        <td>
                                        <div style="display:flex;justify-content: center;">
                                        <!-- Nút xem chi tiết -->
                                        <a href="?action=view&id='.$appoid.'" class="non-style-link"><button  class="btn-primary-soft btn button-icon btn-view"  style="padding:12px 40px;margin-top:10px;">Xem</button></a>
                                        &nbsp;&nbsp;&nbsp;
                                        <!-- Nút hủy cuộc hẹn -->
                                        <a href="?action=drop&id='.$appoid.'&title='.$title.'&pname='.$pname.'" class="non-style-link"><button  class="btn-primary-soft btn button-icon btn-delete"  style="padding:12px 40px;margin-top:10px;">Hủy</button></a>
                                        </div>
                                        </td>
                                    </tr>';
                                }
                            }
                            ?>

                        </tbody>

                        </table>
                        </div>
                       </center>
                   </td> 
                </tr>
            </table>
        </div>
    </div>
    
    <?php 
    if($_GET){
        $id=$_GET["id"];
        $action=$_GET["action"];
        if($action=='drop'){
            $title=$_GET["title"];
            $pname=$_GET["pname"];
            echo '
            <div id="popup1" class="overlay">
                <div class="popup">
                <center>
                    <!-- Thông báo xác nhận hủy cuộc hẹn -->
                    <h2>Bạn có chắc không?</h2>
                    <p>Bạn muốn hủy cuộc hẹn này<br>(Tên bệnh nhân: &nbsp;'.$pname.' <br>Số cuộc hẹn:&nbsp;'.$id.' <br>Tiêu đề:&nbsp;'.$title.')</p>
                    <a href="appointment.php" class="non-style-link"><button class="btn-primary btn" style="display: flex;justify-content: center;align-items: center;margin:10px;padding:10px;">No</button></a>
                    <a href="delete-appointment.php?id='.$id.'" class="non-style-link"><button class="btn-primary btn" style="display: flex;justify-content: center;align-items: center;margin:10px;padding:10px;">Yes</button></a>
                </center>
            </div>
            </div>
            ';
        }elseif($action=='view'){
            $sqlmain= "select appointment.appoid,schedule.scheduleid,schedule.title,doctor.docname,doctor.docemail,doctor.docnic,doctor.doctel,doctor.specialties,patient.pname,patient.pnic,patient.ptel,patient.paddress,schedule.scheduledate,schedule.scheduletime,appointment.apponum,appointment.appodate,appointment.apptime from schedule inner join appointment on schedule.scheduleid=appointment.scheduleid inner join patient on patient.pid=appointment.pid inner join doctor on schedule.docid=doctor.docid where doctor.docid=$userid and appointment.appoid=$id";
            $result= $database->query($sqlmain);
            $row=$result->fetch_assoc();
            $docname=$row["docname"];
            $docemail=$row["docemail"];
            $docnic=$row['docnic'];
            $doctel=$row['doctel'];
            $docname=$row['docname'];
            $specialties=$row['specialties'];
            $pname=$row["pname"];
            $pnic=$row['pnic'];
            $ptel=$row['ptel'];
            $paddress=$row['paddress'];
            $title=$row["title"];
            $scheduledate=$row["scheduledate"];
            $scheduletime=$row["scheduletime"];
            $apponum=$row["apponum"];
            $appodate=$row["appodate"];
            $apptime=$row["apptime"];
            echo '
            <div id="popup1" class="overlay">
                <div class="popup">
                    <center>
                        <!-- Hiển thị chi tiết cuộc hẹn -->
                        <h2>Chi tiết cuộc hẹn</h2>
                        <a class="close" href="appointment.php">&times;</a>
                        <div class="content">
                            Healthcare Appointment Management System<br>
                        </div>
                        <div style="display: flex;justify-content: center;">
                        <table width="80%" class="sub-table scrolldown add-doc-form-container" border="0">
                        
                            <tr>
                                <td>
                                    <p style="font-size:25px;font-weight:500;">Thông tin cuộc hẹn.</p><br><br>
                                </td>
                            </tr>
                        
                            <tr>
                                <td class="label-td" colspan="2">
                                    <label for="title" class="form-label">Tiêu đề phiên: </label>
                                </td>
                            </tr>
                            <tr>
                                <td class="label-td" colspan="2">
                                    '.$title.'<br><br>
                                </td>
                            </tr>
                        
                            <tr>
                                <td class="label-td" colspan="2">
                                    <label for="docname" class="form-label">Bác sĩ phụ trách: </label>
                                </td>
                            </tr>
                            <tr>
                                <td class="label-td" colspan="2">
                                    '.$docname.'<br><br>
                                </td>
                            </tr>
                            <tr>
                                <td class="label-td" colspan="2">
                                    <label for="docemail" class="form-label">Email của bác sĩ: </label>
                                </td>
                            </tr>
                            <tr>
                                <td class="label-td" colspan="2">
                                    '.$docemail.'<br><br>
                                </td>
                            </tr>
                            <tr>
                                <td class="label-td" colspan="2">
                                    <label for="docnic" class="form-label">NIC của bác sĩ: </label>
                                </td>
                            </tr>
                            <tr>
                                <td class="label-td" colspan="2">
                                    '.$docnic.'<br><br>
                                </td>
                            </tr>
                            <tr>
                                <td class="label-td" colspan="2">
                                    <label for="doctel" class="form-label">SĐT của bác sĩ: </label>
                                </td>
                            </tr>
                            <tr>
                                <td class="label-td" colspan="2">
                                    '.$doctel.'<br><br>
                                </td>
                            </tr>
                            <tr>
                                <td class="label-td" colspan="2">
                                    <label for="specialties" class="form-label">Chuyên môn của bác sĩ: </label>
                                </td>
                            </tr>
                            <tr>
                                <td class="label-td" colspan="2">
                                    '.$specialties.'<br><br>
                                </td>
                            </tr>
                            <tr>
                                <td class="label-td" colspan="2">
                                    <label for="scheduledate" class="form-label">Ngày diễn ra phiên: </label>
                                </td>
                            </tr>
                            <tr>
                                <td class="label-td" colspan="2">
                                    '.$scheduledate.'<br><br>
                                </td>
                            </tr>
                            <tr>
                                <td class="label-td" colspan="2">
                                    <label for="scheduletime" class="form-label">Thời gian diễn ra phiên: </label>
                                </td>
                            </tr>
                            <tr>
                                <td class="label-td" colspan="2">
                                    '.$scheduletime.'<br><br>
                                </td>
                            </tr>
                            <tr>
                                <td class="label-td" colspan="2">
                                    <label for="pname" class="form-label">Tên bệnh nhân: </label>
                                </td>
                            </tr>
                            <tr>
                                <td class="label-td" colspan="2">
                                    '.$pname.'<br><br>
                                </td>
                            </tr>
                            <tr>
                                <td class="label-td" colspan="2">
                                    <label for="pnic" class="form-label">NIC bệnh nhân: </label>
                                </td>
                            </tr>
                            <tr>
                                <td class="label-td" colspan="2">
                                    '.$pnic.'<br><br>
                                </td>
                            </tr>
                            <tr>
                                <td class="label-td" colspan="2">
                                    <label for="ptel" class="form-label">Số điện thoại: </label>
                                </td>
                            </tr>
                            <tr>
                                <td class="label-td" colspan="2">
                                    '.$ptel.'<br><br>
                                </td>
                            </tr>
                            <tr>
                                <td class="label-td" colspan="2">
                                    <label for="paddress" class="form-label">Địa chỉ bệnh nhân: </label>
                                </td>
                            </tr>
                            <tr>
                                <td class="label-td" colspan="2">
                                    '.$paddress.'<br><br>
                                </td>
                            </tr>
                            <tr>
                                <td class="label-td" colspan="2">
                                    <label for="apponum" class="form-label">Số cuộc hẹn: </label>
                                </td>
                            </tr>
                            <tr>
                                <td class="label-td" colspan="2">
                                    '.$apponum.'<br><br>
                                </td>
                            </tr>
                            <tr>
                                <td class="label-td" colspan="2">
                                    <label for="appodate" class="form-label">Ngày tạo: </label>
                                </td>
                            </tr>
                            <tr>
                                <td class="label-td" colspan="2">
                                    '.$appodate.'<br><br>
                                </td>
                            </tr>
                            <tr>
                                <td class="label-td" colspan="2">
                                    <label for="apptime" class="form-label">Thời gian tạo: </label>
                                </td>
                            </tr>
                            <tr>
                                <td class="label-td" colspan="2">
                                    '.$apptime.'<br><br>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="2">
                                    <a href="appointment.php"><input type="button" value="OK" class="login-btn btn-primary-soft btn"></a>
                                </td>
                            </tr>
                            </div>
                            </div>
                            </center>
                        </table>
                        </div>
                    </div>
                </div>
            </div>';
        }
    }
    ?>
</div>
</body>
</html>
