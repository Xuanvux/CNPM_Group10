<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Đường dẫn tới các file CSS -->
    <link rel="stylesheet" href="../css/animations.css">  
    <link rel="stylesheet" href="../css/main.css">  
    <link rel="stylesheet" href="../css/admin.css">
        
    <title>Cuộc hẹn</title>
    <!-- CSS inline cho một số phần tử -->
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

    // Bắt đầu phiên làm việc
    session_start();

    // Kiểm tra xem người dùng đã đăng nhập chưa
    if(isset($_SESSION["user"])){
        // Nếu đã đăng nhập
        if(($_SESSION["user"])=="" or $_SESSION['usertype']!='p'){
            // Chuyển hướng người dùng về trang đăng nhập nếu chưa đăng nhập hoặc không phải là bệnh nhân
            header("location: ../login.php");
        }else{
            // Lấy thông tin người dùng từ session
            $useremail=$_SESSION["user"];
        }

    }else{
        // Chuyển hướng người dùng về trang đăng nhập nếu không có session
        header("location: ../login.php");
    }
    

    // Import file kết nối cơ sở dữ liệu
    include("../connection.php");

    // Truy vấn để lấy thông tin bệnh nhân dựa trên email
    $sqlmain= "select * from patient where pemail=?";
    $stmt = $database->prepare($sqlmain);
    $stmt->bind_param("s",$useremail);
    $stmt->execute();
    $userrow = $stmt->get_result();
    $userfetch=$userrow->fetch_assoc();
    $userid= $userfetch["pid"];
    $username=$userfetch["pname"];


    // Truy vấn chính để lấy thông tin cuộc hẹn của bệnh nhân
    $sqlmain= "select appointment.appoid,schedule.scheduleid,schedule.title,doctor.docname,patient.pname,schedule.scheduledate,schedule.scheduletime,appointment.apponum,appointment.appodate from schedule inner join appointment on schedule.scheduleid=appointment.scheduleid inner join patient on patient.pid=appointment.pid inner join doctor on schedule.docid=doctor.docid  where  patient.pid=$userid ";

    if($_POST){
        // Xử lý dữ liệu gửi đi từ form lọc (nếu có)
        if(!empty($_POST["sheduledate"])){
            $sheduledate=$_POST["sheduledate"];
            $sqlmain.=" and schedule.scheduledate='$sheduledate' ";
        };

    }

    // Kết thúc truy vấn
    $sqlmain.="order by appointment.appodate  asc";
    $result= $database->query($sqlmain);
    ?>
    <!-- Phần menu bên trái -->
    <div class="container">
        <div class="menu">
            <!-- Thẻ bảng chứa các nút điều hướng -->
            <table class="menu-container" border="0">
                <tr>
                    <td style="padding:10px" colspan="2">
                        <!-- Thẻ bảng chứa thông tin người dùng -->
                        <table border="0" class="profile-container">
                            <tr>
                                <td width="30%" style="padding-left:20px" >
                                    <!-- Ảnh đại diện của người dùng -->
                                    <img src="../img/user.png" alt="" width="100%" style="border-radius:50%">
                                </td>
                                <td style="padding:0px;margin:0px;">
                                    <!-- Thông tin người dùng -->
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
                <!-- Các nút điều hướng -->
                <tr class="menu-row" >
                    <td class="menu-btn menu-icon-home" >
                        <!-- Đường dẫn đến trang chủ -->
                        <a href="index.php" class="non-style-link-menu "><div><p class="menu-text">Trang chủ</p></a></div></a>
                    </td>
                </tr>
                <tr class="menu-row">
                    <td class="menu-btn menu-icon-doctor">
                        <!-- Đường dẫn đến trang danh sách bác sĩ -->
                        <a href="doctors.php" class="non-style-link-menu"><div><p class="menu-text">Tất cả bác sĩ</p></a></div>
                    </td>
                </tr>
                <tr class="menu-row" >
                    <td class="menu-btn menu-icon-session">
                        <!-- Đường dẫn đến trang lịch hẹn -->
                        <a href="schedule.php" class="non-style-link-menu"><div><p class="menu-text">Phiên đã lên lịch</p></div></a>
                    </td>
                </tr>
                <tr class="menu-row" >
                    <td class="menu-btn menu-icon-appoinment  menu-active menu-icon-appoinment-active">
                        <!-- Đường dẫn đến trang cuộc hẹn của người dùng -->
                        <a href="appointment.php" class="non-style-link-menu non-style-link-menu-active"><div><p class="menu-text">Cuộc hẹn của tôi</p></a></div>
                    </td>
                </tr>
                <tr class="menu-row" >
                    <td class="menu-btn menu-icon-settings">
                        <!-- Đường dẫn đến trang cài đặt -->
                        <a href="settings.php" class="non-style-link-menu"><div><p class="menu-text">Cài đặt</p></a></div>
                    </td>
                </tr>
            </table>
        </div>
        <!-- Phần nội dung chính -->
        <div class="dash-body">
            <!-- Bảng chứa nội dung -->
            <table border="0" width="100%" style=" border-spacing: 0;margin:0;padding:0;margin-top:25px; ">
                <tr >
                    <!-- Nút trở lại -->
                    <td width="13%" >
                    <a href="appointment.php" ><button  class="login-btn btn-primary-soft btn btn-icon-back"  style="padding-top:11px;padding-bottom:11px;margin-left:20px;width:125px"><font class="tn-in-text">Trở lại</font></button></a>
                    </td>
                    <td>
                        <!-- Tiêu đề trang -->
                        <p style="font-size: 23px;padding-left:12px;font-weight: 600;">Lịch sử cuộc hẹn của tôi</p>        
                    </td>
                    <td width="15%">
                        <!-- Hiển thị ngày hiện tại -->
                        <p style="font-size: 14px;color: rgb(119, 119, 119);padding: 0;margin: 0;text-align: right;">
                            Ngày hôm nay
                        </p>
                        <p class="heading-sub12" style="padding: 0;margin: 0;">
                            <?php 

                        date_default_timezone_set('Asia/Ho_Chi_Minh');

                        $today = date('Y-m-d');
                        echo $today;

                        
                        ?>
                        </p>
                    </td>
                    <td width="10%">
                        <!-- Biểu tượng lịch -->
                        <button  class="btn-label"  style="display: flex;justify-content: center;align-items: center;"><img src="../img/calendar.svg" width="100%"></button>
                    </td>


                </tr>
                <!-- Tiêu đề cuộc hẹn -->
                <tr>
                    <td colspan="4" style="padding-top:10px;width: 100%;" >
                    
                        <p class="heading-main12" style="margin-left: 45px;font-size:18px;color:rgb(49, 49, 49)">Cuộc hẹn của tôi (<?php echo $result->num_rows; ?>)</p>
                    </td>
                    
                </tr>
                <!-- Form lọc -->
                <tr>
                    <td colspan="4" style="padding-top:0px;width: 100%;" >
                        <center>
                        <table class="filter-container" border="0" >
                        <tr>
                           <td width="10%">

                           </td> 
                        <td width="5%" style="text-align: center;">
                        Ngày:
                        </td>
                        <td width="30%">
                        <!-- Form để lọc theo ngày -->
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
                <!-- Kết quả cuộc hẹn -->
                <tr>
                   <td colspan="4">
                       <center>
                        <!-- Khung hiển thị kết quả cuộc hẹn -->
                        <div class="abc scroll">
                        <table width="93%" class="sub-table scrolldown" border="0" style="border:none">
                        
                        <tbody>
                        
                            <?php

                                // Nếu không có cuộc hẹn nào
                                if($result->num_rows==0){
                                    echo '<tr>
                                    <td colspan="7">
                                    <br><br><br><br>
                                    <center>
                                    <img src="../img/notfound.svg" width="25%">
                                    
                                    <br>
                                    <!-- Thông báo không tìm thấy -->
                                    <p class="heading-main12" style="margin-left: 45px;font-size:20px;color:rgb(49, 49, 49)">Chúng tôi không thể tìm thấy bất cứ điều gì liên quan đến từ khóa của bạn!</p>
                                    <!-- Đường dẫn đến trang cuộc hẹn -->
                                    <a class="non-style-link" href="appointment.php"><button  class="login-btn btn-primary-soft btn"  style="display: flex;justify-content: center;align-items: center;margin-left:20px;">&nbsp; Hiển thị tất cả các cuộc hẹn &nbsp;</font></button>
                                    </a>
                                    </center>
                                    <br><br><br><br>
                                    </td>
                                    </tr>';
                                    
                                }
                                else{
                                    // Lặp qua từng cuộc hẹn và hiển thị thông tin
                                    for ( $x=0; $x<($result->num_rows);$x++){
                                        echo "<tr>";
                                        for($q=0;$q<3;$q++){
                                            $row=$result->fetch_assoc();
                                            if (!isset($row)){
                                            break;
                                            };
                                            $scheduleid=$row["scheduleid"];
                                            $title=$row["title"];
                                            $docname=$row["docname"];
                                            $scheduledate=$row["scheduledate"];
                                            $scheduletime=$row["scheduletime"];
                                            $apponum=$row["apponum"];
                                            $appodate=$row["appodate"];
                                            $appoid=$row["appoid"];
    
                                            if($scheduleid==""){
                                                break;
                                            }
    
                                            echo '
                                            <td style="width: 25%;">
                                                    <div  class="dashboard-items search-items"  >
                                                    
                                                        <div style="width:100%;">
                                                        <div class="h3-search">
                                                                    Ngày hẹn: '.substr($appodate,0,30).'<br>
                                                                    Số tham chiếu: OC-000-'.$appoid.'
                                                                </div>
                                                                <div class="h1-search">
                                                                    '.substr($title,0,21).'<br>
                                                                </div>
                                                                <div class="h3-search">
                                                                Số cuộc hẹn:<div class="h1-search">0'.$apponum.'</div>
                                                                </div>
                                                                <div class="h3-search">
                                                                    '.substr($docname,0,30).'
                                                                </div>
                                                                
                                                                
                                                                <div class="h4-search">
                                                                    Scheduled Date: '.$scheduledate.'<br>Bắt đầu: <b>@'.substr($scheduletime,0,5).'</b> (24h)
                                                                </div>
                                                                <br>
                                                                <!-- Nút hủy hẹn -->
                                                                <a href="?action=drop&id='.$appoid.'&title='.$title.'&doc='.$docname.'" ><button  class="login-btn btn-primary-soft btn "  style="padding-top:11px;padding-bottom:11px;width:100%"><font class="tn-in-text">Hủy hẹn</font></button></a>
                                                        </div>
                                                                
                                                    </div>
                                                </td>';
    
                                        }
                                        echo "</tr>";
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
    <!-- Hiển thị popup thông báo. -->
    <?php
    
    if($_GET){
        $id=$_GET["id"];
        $action=$_GET["action"];
        if($action=='booking-added'){
            
            echo '
            <div id="popup1" class="overlay">
                    <div class="popup">
                    <center>
                    <br><br>
                        <h2>Booking Successfully.</h2>
                        <a class="close" href="appointment.php">&times;</a>
                        <div class="content">
                        Số cuộc hẹn của bạn là '.$id.'.<br><br>
                            
                        </div>
                        <div style="display: flex;justify-content: center;">
                        
                        <a href="appointment.php" class="non-style-link"><button  class="btn-primary btn"  style="display: flex;justify-content: center;align-items: center;margin:10px;padding:10px;"><font class="tn-in-text">&nbsp;&nbsp;OK&nbsp;&nbsp;</font></button></a>
                        <br><br><br><br>
                        </div>
                    </center>
            </div>
            </div>
            ';
        }elseif($action=='drop'){
            $title=$_GET["title"];
            $docname=$_GET["doc"];
            
            echo '
            <div id="popup1" class="overlay">
                    <div class="popup">
                    <center>
                        <h2>Are you sure?</h2>
                        <a class="close" href="appointment.php">&times;</a>
                        <div class="content">
                             Bạn muốn hủy cuộc hẹn này?<br><br>
                            Tên phiên: &nbsp;<b>'.substr($title,0,40).'</b><br>
                           Tên bác sĩ&nbsp; : <b>'.substr($docname,0,40).'</b><br><br>
                            
                        </div>
                        <div style="display: flex;justify-content: center;">
                        <!-- Nút xác nhận hủy -->
                        <a href="delete-appointment.php?id='.$id.'" class="non-style-link"><button  class="btn-primary btn"  style="display: flex;justify-content: center;align-items: center;margin:10px;padding:10px;"<font class="tn-in-text">&nbsp;Yes&nbsp;</font></button></a>&nbsp;&nbsp;&nbsp;
                        <!-- Nút hủy -->
                        <a href="appointment.php" class="non-style-link"><button  class="btn-primary btn"  style="display: flex;justify-content: center;align-items: center;margin:10px;padding:10px;"><font class="tn-in-text">&nbsp;&nbsp;No&nbsp;&nbsp;</font></button></a>

                        </div>
                    </center>
            </div>
            </div>
            ';

        }
    }
    ?>

    <script src="../js/popup.js"></script>
</body>
</html>
