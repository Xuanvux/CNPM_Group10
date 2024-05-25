<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Meta tags -->
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- CSS -->
    <link rel="stylesheet" href="../css/animations.css">  
    <link rel="stylesheet" href="../css/main.css">  
    <link rel="stylesheet" href="../css/admin.css">
        
    <!-- Tiêu đề trang -->
    <title>Bệnh nhân</title>
    
    <!-- CSS tùy chỉnh -->
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
    // Bắt đầu phiên
    session_start();

    // Kiểm tra nếu người dùng đã đăng nhập và có quyền admin
    if(isset($_SESSION["user"])){
        if(($_SESSION["user"])=="" or $_SESSION['usertype']!='a'){
            header("location: ../login.php");
        }
    }else{
        header("location: ../login.php");
    }
    
    // Kết nối với cơ sở dữ liệu
    include("../connection.php");  
    ?>

    <!-- Phần menu -->
    <div class="container">
        <div class="menu">
            <!-- Thông tin người dùng -->
            <table class="menu-container" border="0">
                <tr>
                    <td style="padding:10px" colspan="2">
                        <!-- Hình ảnh người dùng và nút đăng xuất -->
                        <table border="0" class="profile-container">
                            <tr>
                                <td width="30%" style="padding-left:20px" >
                                    <img src="../img/user.png" alt="" width="100%" style="border-radius:50%">
                                </td>
                                <td style="padding:0px;margin:0px;">
                                    <p class="profile-title">Admin</p>
                                    <p class="profile-subtitle">admin@gmail.com</p>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="2">
                                    <a href="../logout.php" ><input type="button" value="Đăng xuất" class="logout-btn btn-primary-soft btn"></a>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
                <!-- Các liên kết trong menu -->
                <tr class="menu-row" >
                    <td class="menu-btn menu-icon-dashbord" >
                        <!-- Liên kết đến trang Dashboard -->
                        <a href="index.php" class="non-style-link-menu"><div><p class="menu-text">Dashboard</p></a></div></a>
                    </td>
                </tr>
                <tr class="menu-row">
                    <td class="menu-btn menu-icon-doctor ">
                        <!-- Liên kết đến trang Quản lý bác sĩ -->
                        <a href="doctors.php" class="non-style-link-menu "><div><p class="menu-text">Bác sĩ</p></a></div>
                    </td>
                </tr>
                <tr class="menu-row" >
                    <td class="menu-btn menu-icon-schedule">
                        <!-- Liên kết đến trang Quản lý lịch trình -->
                        <a href="schedule.php" class="non-style-link-menu"><div><p class="menu-text">Lịch trình</p></div></a>
                    </td>
                </tr>
                <tr class="menu-row">
                    <td class="menu-btn menu-icon-appoinment">
                        <!-- Liên kết đến trang Quản lý cuộc hẹn -->
                        <a href="appointment.php" class="non-style-link-menu"><div><p class="menu-text">Cuộc hẹn</p></a></div>
                    </td>
                </tr>
                <tr class="menu-row" >
                    <td class="menu-btn menu-icon-patient  menu-active menu-icon-patient-active">
                        <!-- Liên kết đến trang Quản lý bệnh nhân -->
                        <a href="patient.php" class="non-style-link-menu  non-style-link-menu-active"><div><p class="menu-text">Bệnh nhân</p></a></div>
                    </td>
                </tr>
            </table>
        </div>

        <!-- Phần nội dung trang -->
        <div class="dash-body">
            <!-- Bảng hiển thị thông tin bệnh nhân -->
            <table border="0" width="100%" style=" border-spacing: 0;margin:0;padding:0;margin-top:25px; ">
                <!-- Dòng nút quay lại và ô tìm kiếm -->
                <tr >
                    <td width="13%">
                        <!-- Nút quay lại -->
                        <a href="patient.php" ><button  class="login-btn btn-primary-soft btn btn-icon-back"  style="padding-top:11px;padding-bottom:11px;margin-left:20px;width:125px"><font class="tn-in-text">Trở lại</font></button></a>
                    </td>
                    <td>
                        <!-- Ô tìm kiếm -->
                        <form action="" method="post" class="header-search">
                            <input type="search" name="search" class="input-text header-searchbar" placeholder="Tìm kiếm bằng tên bệnh nhân hoặc Email" list="patient">&nbsp;&nbsp;
                            
                            <!-- Danh sách tùy chọn cho ô tìm kiếm -->
                            <?php
                                echo '<datalist id="patient">';
                                $list11 = $database->query("select  pname,pemail from patient;");

                                for ($y=0;$y<$list11->num_rows;$y++){
                                    $row00=$list11->fetch_assoc();
                                    $d=$row00["pname"];
                                    $c=$row00["pemail"];
                                    echo "<option value='$d'><br/>";
                                    echo "<option value='$c'><br/>";
                                };

                            echo ' </datalist>';
                            ?>
                       
                            <!-- Nút tìm kiếm -->
                            <input type="Submit" value="Tìm kiếm" class="login-btn btn-primary btn" style="padding-left: 25px;padding-right: 25px;padding-top: 10px;padding-bottom: 10px;">
                        </form>
                    </td>
                    <!-- Ngày hiện tại -->
                    <td width="15%">
                        <p style="font-size: 14px;color: rgb(119, 119, 119);padding: 0;margin: 0;text-align: right;">
                            Ngày hôm nay
                        </p>
                        <p class="heading-sub12" style="padding: 0;margin: 0;">
                            <?php 
                                date_default_timezone_set('Asia/Kolkata');
                                $date = date('Y-m-d');
                                echo $date;
                            ?>
                        </p>
                    </td>
                    <!-- Biểu tượng lịch -->
                    <td width="10%">
                        <button  class="btn-label"  style="display: flex;justify-content: center;align-items: center;"><img src="../img/calendar.svg" width="100%"></button>
                    </td>
                </tr>
               
                <!-- Tiêu đề bảng -->
                <tr>
                    <td colspan="4" style="padding-top:10px;">
                        <p class="heading-main12" style="margin-left: 45px;font-size:18px;color:rgb(49, 49, 49)">Tất cả bệnh nhân (<?php echo $list11->num_rows; ?>)</p>
                    </td>
                </tr>
                <?php
                    // Kiểm tra nếu có dữ liệu được gửi từ ô tìm kiếm
                    if($_POST){
                        $keyword=$_POST["search"];
                        
                        // Tạo câu truy vấn SQL dựa trên từ khóa tìm kiếm
                        $sqlmain= "select * from patient where pemail='$keyword' or pname='$keyword' or pname like '$keyword%' or pname like '%$keyword' or pname like '%$keyword%' ";
                    }else{
                        // Mặc định hiển thị tất cả bệnh nhân
                        $sqlmain= "select * from patient order by pid desc";
                    }
                ?>
                  
                <!-- Dòng hiển thị danh sách bệnh nhân -->
                <tr>
                    <td colspan="4">
                        <center>
                            <div class="abc scroll">
                                <table width="93%" class="sub-table scrolldown"  style="border-spacing:0;">
                                    <thead>
                                        <tr>
                                            <th class="table-headin">Tên</th>
                                            <th class="table-headin">Số CCCD</th>
                                            <th class="table-headin">SĐT</th>
                                            <th class="table-headin">Email</th>
                                            <th class="table-headin">Ngày sinh</th>
                                            <th class="table-headin">Sự kiện</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                            // Thực hiện truy vấn và hiển thị kết quả
                                            $result= $database->query($sqlmain);
                                            if($result->num_rows==0){
                                                // Hiển thị thông báo nếu không tìm thấy kết quả
                                                echo '<tr>
                                                        <td colspan="4">
                                                            <br><br><br><br>
                                                            <center>
                                                                <img src="../img/notfound.svg" width="25%">
                                                                <br>
                                                                <p class="heading-main12" style="margin-left: 45px;font-size:20px;color:rgb(49, 49, 49)">Chúng tôi không thể tìm thấy bất cứ điều gì liên quan đến từ khóa của bạn!</p>
                                                                <a class="non-style-link" href="patient.php"><button  class="login-btn btn-primary-soft btn"  style="display: flex;justify-content: center;align-items: center;margin-left:20px;">&nbsp; Xem tất cả bệnh nhân &nbsp;</font></button></a>
                                                            </center>
                                                            <br><br><br><br>
                                                        </td>
                                                      </tr>';
                                            } else {
                                                // Hiển thị thông tin bệnh nhân
                                                for ($x=0; $x<$result->num_rows;$x++){
                                                    $row=$result->fetch_assoc();
                                                    $pid=$row["pid"];
                                                    $name=$row["pname"];
                                                    $email=$row["pemail"];
                                                    $nic=$row["pnic"];
                                                    $dob=$row["pdob"];
                                                    $tel=$row["ptel"];
                                                    
                                                    echo '<tr>
                                                            <td> &nbsp;'.substr($name,0,35).'</td>
                                                            <td>'.substr($nic,0,12).'</td>
                                                            <td>'.substr($tel,0,10).'</td>
                                                            <td>'.substr($email,0,20).'</td>
                                                            <td>'.substr($dob,0,10).'</td>
                                                            <td>
                                                                <div style="display:flex;justify-content: center;">
                                                                    <a href="?action=view&id='.$pid.'" class="non-style-link"><button  class="btn-primary-soft btn button-icon btn-view"  style="padding-left: 40px;padding-top: 12px;padding-bottom: 12px;margin-top: 10px;"><font class="tn-in-text">Xem</font></button></a>
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
    // Xem chi tiết thông tin bệnh nhân nếu có yêu cầu
    if($_GET){
        $id=$_GET["id"];
        $action=$_GET["action"];
        $sqlmain= "select * from patient where pid='$id'";
        $result= $database->query($sqlmain);
        $row=$result->fetch_assoc();
        $name=$row["pname"];
        $email=$row["pemail"];
        $nic=$row["pnic"];
        $dob=$row["pdob"];
        $tele=$row["ptel"];
        $address=$row["paddress"];
        echo '<div id="popup1" class="overlay">
                <div class="popup">
                    <center>
                        <a class="close" href="patient.php">&times;</a>
                        <div class="content">
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
                                        <label for="name" class="form-label">Mã bệnh nhân: </label>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="label-td" colspan="2">
                                        P-'.$id.'<br><br>
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
                                        <label for="name" class="form-label">Ngày sinh: </label>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="label-td" colspan="2">
                                        '.$dob.'<br><br>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="2">
                                        <a href="patient.php"><input type="button" value="OK" class="login-btn btn-primary-soft btn" ></a>
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </center>
                    <br><br>
                </div>
            </div>';
    };
    ?>
</body>
</html>
