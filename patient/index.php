<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/animations.css">  
    <link rel="stylesheet" href="../css/main.css">  
    <link rel="stylesheet" href="../css/admin.css">
        
    <title>Dashboard</title>
    <style>
        /* CSS styles */
        .dashbord-tables{
            animation: transitionIn-Y-over 0.5s;
        }
        .filter-container{
            animation: transitionIn-Y-bottom  0.5s;
        }
        .sub-table,.anime{
            animation: transitionIn-Y-bottom 0.5s;
        }
    </style>
</head>
<body>
    <?php
    // Bắt đầu phiên
    session_start();

    // Kiểm tra nếu phiên người dùng đã được thiết lập
    if(isset($_SESSION["user"])){
        // Kiểm tra nếu người dùng đã đăng nhập và có quyền là bệnh nhân
        if(($_SESSION["user"])=="" or $_SESSION['usertype']!='p'){
            // Chuyển hướng đến trang đăng nhập nếu không phải là bệnh nhân
            header("location: ../login.php");
        }else{
            $useremail=$_SESSION["user"];
        }

    }else{
        // Chuyển hướng đến trang đăng nhập nếu phiên không được thiết lập
        header("location: ../login.php");
    }
    

    // Nhúng kết nối đến cơ sở dữ liệu
    include("../connection.php");

    // Truy vấn thông tin người dùng từ cơ sở dữ liệu
    $sqlmain= "select * from patient where pemail=?";
    $stmt = $database->prepare($sqlmain);
    $stmt->bind_param("s",$useremail);
    $stmt->execute();
    $userrow = $stmt->get_result();
    $userfetch=$userrow->fetch_assoc();

    $userid= $userfetch["pid"];
    $username=$userfetch["pname"];
    ?>
    <div class="container">
        <!-- Menu -->
        <div class="menu">
            <table class="menu-container" border="0">
                <tr>
                    <td style="padding:10px" colspan="2">
                        <!-- Profile -->
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
                <!-- Các nút menu -->
                <tr class="menu-row" >
                    <td class="menu-btn menu-icon-home menu-active menu-icon-home-active" >
                        <a href="index.php" class="non-style-link-menu non-style-link-menu-active"><div><p class="menu-text">Trang chủ</p></a></div></a>
                    </td>
                </tr>
                <tr class="menu-row">
                    <td class="menu-btn menu-icon-doctor">
                        <a href="doctors.php" class="non-style-link-menu"><div><p class="menu-text">Tất cả bác sĩ</p></a></div>
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
                    <td class="menu-btn menu-icon-settings">
                        <a href="settings.php" class="non-style-link-menu"><div><p class="menu-text">Cài đặt</p></a></div>
                    </td>
                </tr>
            </table>
        </div>
        <!-- Thân trang -->
        <div class="dash-body" style="margin-top: 15px">
            <table border="0" width="100%" style=" border-spacing: 0;margin:0;padding:0;" >
                <tr >
                    <!-- Thanh điều hướng -->
                    <td colspan="1" class="nav-bar" >
                        <p style="font-size: 23px;padding-left:12px;font-weight: 600;margin-left:20px;">Trang chủ</p>
                    </td>
                    <td width="25%"></td>
                    <!-- Hiển thị ngày hiện tại -->
                    <td width="15%">
                        <p style="font-size: 14px;color: rgb(119, 119, 119);padding: 0;margin: 0;text-align: right;">
                            Ngày hôm nay
                        </p>
                        <p class="heading-sub12" style="padding: 0;margin: 0;">
                            <?php 
                                // Hiển thị ngày hiện tại
                                date_default_timezone_set('Asia/Kolkata');
                                $today = date('Y-m-d');
                                echo $today;

                                // Truy vấn số liệu từ cơ sở dữ liệu
                                $patientrow = $database->query("select  * from  patient;");
                                $doctorrow = $database->query("select  * from  doctor;");
                                $appointmentrow = $database->query("select  * from  appointment where appodate>='$today';");
                                $schedulerow = $database->query("select  * from  schedule where scheduledate='$today';");
                            ?>
                        </p>
                    </td>
                    <td width="10%">
                        <!-- Nút hiển thị lịch -->
                        <button  class="btn-label"  style="display: flex;justify-content: center;align-items: center;"><img src="../img/calendar.svg" width="100%"></button>
                    </td>
                </tr>
                <!-- Nội dung trang -->
                <tr>
                    <td colspan="4" >
                        <center>
                            <!-- Thông tin trang chủ -->
                            <table class="filter-container doctor-header patient-header" style="border: none;width:95%" border="0" >
                                <tr>
                                    <td >
                                        <h3>Chào mừng!</h3>
                                        <h1><?php echo $username  ?>.</h1>
                                        <p>Không có ý kiến ​​​​gì về bác sĩ? không vấn đề gì, hãy chuyển sang 
                                            <a href="doctors.php" class="non-style-link"><b>"Tất cả bác sĩ"</b></a> phần hoặc
                                            <a href="schedule.php" class="non-style-link"><b>"Phiên"</b> </a><br>
                                            Theo dõi lịch sử các cuộc hẹn trong quá khứ và tương lai của bạn.<br>Đồng thời tìm hiểu thời gian đến dự kiến ​​của bác sĩ hoặc chuyên gia tư vấn y tế của bạn.<br><br>
                                        </p>
                                        <h3>Kênh một bác sĩ ở đây</h3>
                                        <!-- Form tìm kiếm bác sĩ -->
                                        <form action="schedule.php" method="post" style="display: flex">
                                            <input type="search" name="search" class="input-text " placeholder="Tìm kiếm Bác sĩ và chúng tôi sẽ tìm thấy phiên có sẵn" list="doctors" style="width:45%;">&nbsp;&nbsp;
                                            <?php
                                                // Tạo danh sách tìm kiếm bác sĩ
                                                echo '<datalist id="doctors">';
                                                $list11 = $database->query("select  docname,docemail from  doctor;");
                                                for ($y=0;$y<$list11->num_rows;$y++){
                                                    $row00=$list11->fetch_assoc();
                                                    $d=$row00["docname"];
                                                    echo "<option value='$d'><br/>";
                                                };
                                                echo ' </datalist>';
                                            ?>
                                            <!-- Nút tìm kiếm -->
                                            <input type="Submit" value="Tìm kiếm" class="login-btn btn-primary btn" style="padding-left: 25px;padding-right: 25px;padding-top: 10px;padding-bottom: 10px;">
                                        </form>
                                        <br><br>
                                    </td>
                                </tr>
                            </table>
                        </center>
                    </td>
                </tr>
                <!-- Thống kê số liệu -->
                <tr>
                    <td colspan="4">
                        <table border="0" width="100%"">
                            <tr>
                                <!-- Thống kê số liệu -->
                                <td width="50%">
                                    <center>
                                        <table class="filter-container" style="border: none;" border="0">
                                            <tr>
                                                <td colspan="4">
                                                    <p style="font-size: 20px;font-weight:600;padding-left: 12px;">Status</p>
                                                </td>
                                            </tr>
                                            <tr>
                                                <!-- Số liệu về bác sĩ -->
                                                <td style="width: 25%;">
                                                    <div  class="dashboard-items"  style="padding:20px;margin:auto;width:95%;display: flex">
                                                        <div>
                                                            <div class="h1-dashboard">
                                                                <?php    echo $doctorrow->num_rows  ?>
                                                            </div><br>
                                                            <div class="h3-dashboard">
                                                                Tất cả bác sĩ &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                            </div>
                                                        </div>
                                                        <div class="btn-icon-back dashboard-icons" style="background-image: url('../img/icons/doctors-hover.svg');"></div>
                                                    </div>
                                                </td>
                                                <!-- Số liệu về bệnh nhân -->
                                                <td style="width: 25%;">
                                                    <div  class="dashboard-items"  style="padding:20px;margin:auto;width:95%;display: flex;">
                                                        <div>
                                                            <div class="h1-dashboard">
                                                                <?php    echo $patientrow->num_rows  ?>
                                                            </div><br>
                                                            <div class="h3-dashboard">
                                                                Tất cả bệnh nhân &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                            </div>
                                                        </div>
                                                        <div class="btn-icon-back dashboard-icons" style="background-image: url('../img/icons/patients-hover.svg');"></div>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <!-- Số liệu về cuộc hẹn mới -->
                                                <td style="width: 25%;">
                                                    <div  class="dashboard-items"  style="padding:20px;margin:auto;width:95%;display: flex; ">
                                                        <div>
                                                            <div class="h1-dashboard" >
                                                                <?php    echo $appointmentrow ->num_rows  ?>
                                                            </div><br>
                                                            <div class="h3-dashboard" >
                                                                Đặt chỗ mới &nbsp;&nbsp;
                                                            </div>
                                                        </div>
                                                        <div class="btn-icon-back dashboard-icons" style="margin-left: 0px;background-image: url('../img/icons/book-hover.svg');"></div>
                                                    </div>
                                                </td>
                                                <!-- Số liệu về các phiên hôm nay -->
                                                <td style="width: 25%;">
                                                    <div  class="dashboard-items"  style="padding:20px;margin:auto;width:95%;display: flex;padding-top:21px;padding-bottom:21px;">
                                                        <div>
                                                            <div class="h1-dashboard">
                                                                <?php    echo $schedulerow ->num_rows  ?>
                                                            </div><br>
                                                            <div class="h3-dashboard" style="font-size: 15px">
                                                                Phiên hôm nays
                                                            </div>
                                                        </div>
                                                        <div class="btn-icon-back dashboard-icons" style="background-image: url('../img/icons/session-iceblue.svg');"></div>
                                                    </div>
                                                </td>
                                            </tr>
                                        </table>
                                    </center>
                                </td>
                                <!-- Danh sách các cuộc hẹn sắp tới -->
                                <td>
                                    <p style="font-size: 20px;font-weight:600;padding-left: 40px;" class="anime">Đặt phòng sắp tới của bạn</p>
                                    <center>
                                        <!-- Bảng danh sách các cuộc hẹn -->
                                        <div class="abc scroll" style="height: 250px;padding: 0;margin: 0;">
                                            <table width="85%" class="sub-table scrolldown" border="0" >
                                                <thead>
                                                    <tr>
                                                        <th class="table-headin">Số cuộc hẹn</th>
                                                        <th class="table-headin">Tiêu đề phiên</th>
                                                        <th class="table-headin">Bác sĩ</th>
                                                        <th class="table-headin">Ngày & Giờ đã lên lịch</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                    // Truy vấn các cuộc hẹn sắp tới của bệnh nhân
                                                    $nextweek=date("Y-m-d",strtotime("+1 week"));
                                                    $sqlmain= "select * from schedule inner join appointment on schedule.scheduleid=appointment.scheduleid inner join patient on patient.pid=appointment.pid inner join doctor on schedule.docid=doctor.docid  where  patient.pid=$userid  and schedule.scheduledate>='$today' order by schedule.scheduledate asc";
                                                    $result= $database->query($sqlmain);

                                                    // Hiển thị thông tin các cuộc hẹn
                                                    if($result->num_rows==0){
                                                        echo '<tr>
                                                            <td colspan="4">
                                                                <br><br><br><br>
                                                                <center>
                                                                    <img src="../img/notfound.svg" width="25%">
                                                                    <br>
                                                                    <p class="heading-main12" style="margin-left: 45px;font-size:20px;color:rgb(49, 49, 49)">Không có gì để hiển thị ở đây!</p>
                                                                    <a class="non-style-link" href="schedule.php"><button  class="login-btn btn-primary-soft btn"  style="display: flex;justify-content: center;align-items: center;margin-left:20px;">&nbsp; Kênh một bác sĩ &nbsp;</font></button></a>
                                                                </center>
                                                                <br><br><br><br>
                                                            </td>
                                                        </tr>';
                                                    } else {
                                                        for ($x=0; $x<$result->num_rows;$x++){
                                                            $row=$result->fetch_assoc();
                                                            $scheduleid=$row["scheduleid"];
                                                            $title=$row["title"];
                                                            $apponum=$row["apponum"];
                                                            $docname=$row["docname"];
                                                            $scheduledate=$row["scheduledate"];
                                                            $scheduletime=$row["scheduletime"];
                                                            echo '<tr>
                                                                <td style="padding:30px;font-size:25px;font-weight:700;"> &nbsp;'.$apponum.'</td>
                                                                <td style="padding:20px;"> &nbsp;'.substr($title,0,30).'</td>
                                                                <td>'.substr($docname,0,20).'</td>
                                                                <td style="text-align:center;">'.substr($scheduledate,0,10).' '.substr($scheduletime,0,5).'</td>
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
                    </td>
                </tr>
            </table>
        </div>
    </div>
    <br><br>
</body>
</html>
