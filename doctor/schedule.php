<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Import các file CSS -->
    <link rel="stylesheet" href="../css/animations.css">  
    <link rel="stylesheet" href="../css/main.css">  
    <link rel="stylesheet" href="../css/admin.css">
        
    <title>Lịch trình</title>
    <!-- CSS inline -->
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
    // Bắt đầu phiên làm việc của người dùng
    session_start();

    // Kiểm tra nếu người dùng chưa đăng nhập, chuyển hướng về trang đăng nhập
    if(isset($_SESSION["user"])){
        if(($_SESSION["user"])=="" or $_SESSION['usertype']!='d'){
            header("location: ../login.php");
        }else{
            $useremail=$_SESSION["user"];
        }

    }else{
        header("location: ../login.php");
    }
    
    // Import file kết nối CSDL
    include("../connection.php");

    // Lấy thông tin người dùng từ CSDL
    $userrow = $database->query("select * from doctor where docemail='$useremail'");
    $userfetch=$userrow->fetch_assoc();
    $userid= $userfetch["docid"];
    $username=$userfetch["docname"];
 ?>
 <!-- Phần giao diện chính -->
 <div class="container">
     <!-- Menu dọc -->
     <div class="menu">
        <!-- Phần hiển thị thông tin người dùng -->
        <table class="menu-container" border="0">
            <tr>
                <td style="padding:10px" colspan="2">
                    <table border="0" class="profile-container">
                        <tr>
                            <!-- Hiển thị hình ảnh và tên người dùng -->
                            <td width="30%" style="padding-left:20px" >
                                <img src="../img/user.png" alt="" width="100%" style="border-radius:50%">
                            </td>
                            <td style="padding:0px;margin:0px;">
                                <p class="profile-title"><?php echo substr($username,0,13)  ?>..</p>
                                <p class="profile-subtitle"><?php echo substr($useremail,0,22)  ?></p>
                            </td>
                        </tr>
                        <tr>
                            <!-- Nút đăng xuất -->
                            <td colspan="2">
                                <a href="../logout.php" ><input type="button" value="Đăng xuất" class="logout-btn btn-primary-soft btn"></a>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
            <!-- Các liên kết đến các trang khác nhau -->
            <tr class="menu-row" >
                <td class="menu-btn menu-icon-dashbord " >
                    <a href="index.php" class="non-style-link-menu "><div><p class="menu-text">Dashboard</p></a></div></a>
                </td>
            </tr>
            <tr class="menu-row">
                <td class="menu-btn menu-icon-appoinment  ">
                    <a href="appointment.php" class="non-style-link-menu"><div><p class="menu-text">Cuộc hẹn của tôi</p></a></div>
                </td>
            </tr>
            <tr class="menu-row" >
                <td class="menu-btn menu-icon-session menu-active menu-icon-session-active">
                    <a href="schedule.php" class="non-style-link-menu non-style-link-menu-active"><div><p class="menu-text">Phiên của tôi</p></div></a>
                </td>
            </tr>
            <tr class="menu-row" >
                <td class="menu-btn menu-icon-patient">
                    <a href="patient.php" class="non-style-link-menu"><div><p class="menu-text">Bệnh nhân của tôi</p></a></div>
                </td>
            </tr>
            <tr class="menu-row" >
                <td class="menu-btn menu-icon-settings">
                    <a href="settings.php" class="non-style-link-menu"><div><p class="menu-text">Cài đặt</p></a></div>
                </td>
            </tr>
        </table>
    </div>
    <!-- Phần thân trang -->
    <div class="dash-body">
        <!-- Bảng hiển thị thông tin lịch trình -->
        <table border="0" width="100%" style=" border-spacing: 0;margin:0;padding:0;margin-top:25px; ">
            <!-- Dòng tiêu đề -->
            <tr >
                <td width="13%" >
                    <!-- Nút trở lại -->
                    <a href="schedule.php" ><button  class="login-btn btn-primary-soft btn btn-icon-back"  style="padding-top:11px;padding-bottom:11px;margin-left:20px;width:125px"><font class="tn-in-text">Trở lại</font></button></a>
                </td>
                <td>
                    <!-- Tiêu đề trang -->
                    <p style="font-size: 23px;padding-left:12px;font-weight: 600;">Phiên của tôi</p>           
                </td>
                <td width="15%">
                    <!-- Hiển thị ngày hôm nay -->
                    <p style="font-size: 14px;color: rgb(119, 119, 119);padding: 0;margin: 0;text-align: right;">
                        Ngày hôm nay
                    </p>
                    <!-- Lấy ngày hiện tại từ PHP -->
                    <p class="heading-sub12" style="padding: 0;margin: 0;">
                        <?php 
                        date_default_timezone_set('Asia/Ho_Chi_Minh');
                        $today = date('Y-m-d');
                        echo $today;
                        $list110 = $database->query("select  * from  schedule where docid=$userid;");
                        ?>
                    </p>
                </td>
                <td width="10%">
                    <!-- Icon lịch -->
                    <button  class="btn-label"  style="display: flex;justify-content: center;align-items: center;"><img src="../img/calendar.svg" width="100%"></button>
                </td>
            </tr>
            <!-- Dòng tiêu đề bảng -->
            <tr>
                <td colspan="4" style="padding-top:10px;width: 100%;" >
                    <!-- Tiêu đề bảng -->
                    <p class="heading-main12" style="margin-left: 45px;font-size:18px;color:rgb(49, 49, 49)">Phiên của tôi (<?php echo $list110->num_rows; ?>) </p>
                </td>
            </tr>
            <!-- Dòng chứa các bộ lọc -->
            <tr>
                <td colspan="4" style="padding-top:0px;width: 100%;" >
                    <center>
                        <table class="filter-container" border="0" >
                            <tr>
                                <td width="10%"></td> 
                                <!-- Lọc theo ngày -->
                                <td width="5%" style="text-align: center;">Date:</td>
                                <td width="30%">
                                    <form action="" method="post">
                                        <input type="date" name="sheduledate" id="date" class="input-text filter-container-items" style="margin: 0;width: 95%;">
                                </td>
                                <td width="12%">
                                    <!-- Nút lọc -->
                                    <input type="submit"  name="filter" value=" Lọc" class=" btn-primary-soft btn button-icon btn-filter"  style="padding: 15px; margin :0;width:100%">
                                    </form>
                                </td>
                            </tr>
                        </table>
                    </center>
                </td>
            </tr>
            <?php
            // Xây dựng câu truy vấn chính
            $sqlmain= "select schedule.scheduleid,schedule.title,doctor.docname,schedule.scheduledate,schedule.scheduletime,schedule.nop from schedule inner join doctor on schedule.docid=doctor.docid where doctor.docid=$userid ";
            if($_POST){
                $sqlpt1="";
                // Kiểm tra và thêm điều kiện lọc theo ngày vào câu truy vấn
                if(!empty($_POST["sheduledate"])){
                    $sheduledate=$_POST["sheduledate"];
                    $sqlmain.=" and schedule.scheduledate='$sheduledate' ";
                }
            }
            ?>
            <!-- Dòng hiển thị dữ liệu -->
            <tr>
                <td colspan="4">
                    <center>
                        <!-- Bảng hiển thị danh sách lịch trình -->
                        <div class="abc scroll">
                            <table width="93%" class="sub-table scrolldown" border="0">
                                <thead>
                                    <tr>
                                        <th class="table-headin">
                                            Tiêu đề phiên
                                        </th>
                                        <th class="table-headin">
                                            Ngày & Giờ đã lên lịch
                                        </th>
                                        <th class="table-headin">
                                            Số lượng tối đa có thể đặt trước
                                        </th>
                                        <th class="table-headin">
                                            Sự kiện
                                        </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    // Thực thi câu truy vấn
                                    $result= $database->query($sqlmain);
                                    // Kiểm tra số lượng kết quả trả về
                                    if($result->num_rows==0){
                                        // Hiển thị thông báo nếu không có dữ liệu
                                        echo '<tr>
                                                <td colspan="4">
                                                    <br><br><br><br>
                                                    <center>
                                                        <img src="../img/notfound.svg" width="25%">
                                                        <br>
                                                        <p class="heading-main12" style="margin-left: 45px;font-size:20px;color:rgb(49, 49, 49)">Chúng tôi không thể tìm thấy bất cứ điều gì liên quan đến từ khóa của bạn!</p>
                                                        <a class="non-style-link" href="schedule.php"><button  class="login-btn btn-primary-soft btn"  style="display: flex;justify-content: center;align-items: center;margin-left:20px;">&nbsp; Xem tất cả các phiên &nbsp;</font></button></a>
                                                    </center>
                                                    <br><br><br><br>
                                                </td>
                                            </tr>';
                                    }
                                    else{
                                        // Hiển thị dữ liệu nếu có
                                        for ($x=0; $x<$result->num_rows;$x++){
                                            $row=$result->fetch_assoc();
                                            $scheduleid=$row["scheduleid"];
                                            $title=$row["title"];
                                            $docname=$row["docname"];
                                            $scheduledate=$row["scheduledate"];
                                            $scheduletime=$row["scheduletime"];
                                            $nop=$row["nop"];
                                            echo '<tr>
                                                    <td> &nbsp;'.substr($title,0,30).'</td>
                                                    <td style="text-align:center;">'.substr($scheduledate,0,10).' '.substr($scheduletime,0,5).'</td>
                                                    <td style="text-align:center;">'.$nop.'</td>
                                                    <td>
                                                        <div style="display:flex;justify-content: center;">
                                                            <!-- Nút xem và nút hủy phiên -->
                                                            <a href="?action=view&id='.$scheduleid.'" class="non-style-link"><button  class="btn-primary-soft btn button-icon btn-view"  style="padding-left: 40px;padding-top: 12px;padding-bottom: 12px;margin-top: 10px;"><font class="tn-in-text">Xem</font></button></a>
                                                            &nbsp;&nbsp;&nbsp;
                                                            <a href="?action=drop&id='.$scheduleid.'&name='.$title.'" class="non-style-link"><button  class="btn-primary-soft btn button-icon btn-delete"  style="padding-left: 40px;padding-top: 12px;padding-bottom: 12px;margin-top: 10px;"><font class="tn-in-text">Hủy phiên</font></button></a>
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
<!-- Phần xử lý các thao tác khi click vào các nút xem và hủy phiên -->
<?php
// Kiểm tra nếu có tham số truyền vào từ URL
if($_GET){
    $id=$_GET["id"];
    $action=$_GET["action"];
    if($action=='drop'){
        $nameget=$_GET["name"];
        // Hiển thị popup xác nhận khi muốn hủy phiên
        echo '
        <div id="popup1" class="overlay">
            <div class="popup">
                <center>
                    <h2>Bạn có chắc chắn?</h2>
                    <a class="close" href="schedule.php">&times;</a>
                    <div class="content">
                        Bạn muốn xóa bản ghi này<br>('.substr($nameget,0,40).').
                    </div>
                    <div style="display: flex;justify-content: center;">
                        <!-- Nút xác nhận và nút hủy -->
                        <a href="delete-session.php?id='.$id.'" class="non-style-link"><button  class="btn-primary btn"  style="display: flex;justify-content: center;align-items: center;margin:10px;padding:10px;"<font class="tn-in-text">&nbsp;Yes&nbsp;</font></button></a>&nbsp;&nbsp;&nbsp;
                        <a href="schedule.php" class="non-style-link"><button  class="btn-primary btn"  style="display: flex;justify-content: center;align-items: center;margin:10px;padding:10px;"><font class="tn-in-text">&nbsp;&nbsp;No&nbsp;&nbsp;</font></button></a>
                    </div>
                </center>
            </div>
        </div>'; 
    }elseif($action=='view'){
        // Xây dựng câu truy vấn để hiển thị thông tin chi tiết của phiên
        $sqlmain= "select schedule.scheduleid,schedule.title,doctor.docname,schedule.scheduledate,schedule.scheduletime,schedule.nop from schedule inner join doctor on schedule.docid=doctor.docid  where  schedule.scheduleid=$id";
        $result= $database->query($sqlmain);
        $row=$result->fetch_assoc();
        $docname=$row["docname"];
        $scheduleid=$row["scheduleid"];
        $title=$row["title"];
        $scheduledate=$row["scheduledate"];
        $scheduletime=$row["scheduletime"];
        $nop=$row['nop'];
        // Xây dựng câu truy vấn để hiển thị danh sách bệnh nhân đã đăng ký vào phiên này
        $sqlmain12= "select * from appointment inner join patient on patient.pid=appointment.pid inner join schedule on schedule.scheduleid=appointment.scheduleid where schedule.scheduleid=$id;";
        $result12= $database->query($sqlmain12);
        // Hiển thị popup thông tin chi tiết
        echo '
        <div id="popup1" class="overlay">
            <div class="popup" style="width: 70%;">
                <center>
                    <h2></h2>
                    <a class="close" href="schedule.php">&times;</a>
                    <div class="content"></div>
                    <div class="abc scroll" style="display: flex;justify-content: center;">
                        <table width="80%" class="sub-table scrolldown add-doc-form-container" border="0">
                            <tr>
                                <td>
                                    <p style="padding: 0;margin: 0;text-align: left;font-size: 25px;font-weight: 500;">Xem chi tiết</p><br><br>
                                </td>
                            </tr>
                            <tr>
                                <td class="label-td" colspan="2">
                                    <label for="name" class="form-label">Tiêu đề phiên: </label>
                                </td>
                            </tr>
                            <tr>
                                <td class="label-td" colspan="2">'.$title.'<br><br></td>
                            </tr>
                            <tr>
                                <td class="label-td" colspan="2">
                                    <label for="Email" class="form-label">Bác sĩ của phiên này: </label>
                                </td>
                            </tr>
                            <tr>
                                <td class="label-td" colspan="2">'.$docname.'<br><br></td>
                            </tr>
                            <tr>
                                <td class="label-td" colspan="2">
                                    <label for="nic" class="form-label">Lịch hẹn: </label>
                                </td>
                            </tr>
                            <tr>
                                <td class="label-td" colspan="2">'.$scheduledate.'<br><br></td>
                            </tr>
                            <tr>
                                <td class="label-td" colspan="2">
                                    <label for="Tele" class="form-label">Thời gian hẹn: </label>
                                </td>
                            </tr>
                            <tr>
                                <td class="label-td" colspan="2">'.$scheduletime.'<br><br></td>
                            </tr>
                            <tr>
                                <td class="label-td" colspan="2">
                                    <label for="spec" class="form-label"><b>Bệnh nhân đã đăng ký buổi này:</b> ('.$result12->num_rows."/".$nop.')</label>
                                    <br><br>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="4">
                                    <center>
                                        <div class="abc scroll">
                                            <table width="100%" class="sub-table scrolldown" border="0">
                                                <thead>
                                                    <tr>   
                                                        <th class="table-headin">ID bệnh nhân</th>
                                                        <th class="table-headin">Tên bệnh nhân</th>
                                                        <th class="table-headin">Số cuộc hẹn</th>
                                                        <th class="table-headin">SĐT</th>
                                                    </tr>
                                                </thead>
                                                <tbody>';
                                                    // Hiển thị danh sách bệnh nhân
                                                    $result= $database->query($sqlmain12);
                                                    if($result->num_rows==0){
                                                        echo '<tr>
                                                                <td colspan="7">
                                                                    <br><br><br><br>
                                                                    <center>
                                                                        <img src="../img/notfound.svg" width="25%">
                                                                        <br>
                                                                        <p class="heading-main12" style="margin-left: 45px;font-size:20px;color:rgb(49, 49, 49)">Chúng tôi không thể tìm thấy bất cứ điều gì liên quan đến từ khóa của bạn!</p>
                                                                        <a class="non-style-link" href="appointment.php"><button  class="login-btn btn-primary-soft btn"  style="display: flex;justify-content: center;align-items: center;margin-left:20px;">&nbsp; Hiển thị tất cả các cuộc hẹn &nbsp;</font></button></a>
                                                                    </center>
                                                                    <br><br><br><br>
                                                                </td>
                                                            </tr>';
                                                    }else{
                                                        for ($x=0; $x<$result->num_rows;$x++){
                                                            $row=$result->fetch_assoc();
                                                            $name=$row["pname"];
                                                            $nameid=$row["pid"];
                                                            $tel=$row["ptel"];
                                                            $nop=$row['nop'];
                                                            echo '<tr>
                                                                    <td style="text-align:center;">'.$nameid.'</td>
                                                                    <td style="text-align:center;">'.$name.'</td>
                                                                    <td style="text-align:center;">'.$nop.'</td>
                                                                    <td style="text-align:center;">'.$tel.'</td>
                                                                </tr>';
                                                        }
                                                    }
                                                echo '</tbody>
                                            </table>
                                        </div>
                                    </center>
                                </td>
                            </tr>
                        </table>
                    </div>
                </center>
            </div>
        </div>'; 
    }
}
?>
</body>
</html>
