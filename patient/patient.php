<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Khai báo các thẻ meta -->
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Liên kết các file CSS -->
    <link rel="stylesheet" href="../css/animations.css">  
    <link rel="stylesheet" href="../css/main.css">  
    <link rel="stylesheet" href="../css/admin.css">
        
    <title>Bệnh nhân</title>
    <!-- CSS tùy chỉnh.ssss -->
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

    // Kiểm tra nếu người dùng đã đăng nhập
    if(isset($_SESSION["user"])){
        // Kiểm tra quyền người dùng
        if(($_SESSION["user"])=="" or $_SESSION['usertype']!='d'){
            // Chuyển hướng đến trang đăng nhập nếu không có quyền hoặc không đăng nhập
            header("location: ../login.php");
        }else{
            // Lấy email người dùng đăng nhập
            $useremail=$_SESSION["user"];
        }

    }else{
        // Chuyển hướng đến trang đăng nhập nếu chưa đăng nhập
        header("location: ../login.php");
    }
    

    // Import file kết nối CSDL
    include("../connection.php");
    // Truy vấn lấy thông tin bác sĩ dựa trên email đăng nhập
    $sqlmain= "select * from doctor where docemail=?";
    $stmt = $database->prepare($sqlmain);
    $stmt->bind_param("s",$useremail);
    $stmt->execute();
    $userrow = $stmt->get_result();
    $userfetch=$userrow->fetch_assoc();
    $userid= $userfetch["docid"];
    $username=$userfetch["docname"];


    //echo $userid;
    //echo $username;
    ?>
    <div class="container">
        <!-- Menu bên trái -->
        <div class="menu">
            <table class="menu-container" border="0">
                <tr>
                    <!-- Thông tin cá nhân của bác sĩ -->
                    <td style="padding:10px" colspan="2">
                        <table border="0" class="profile-container">
                            <tr>
                                <td width="30%" style="padding-left:20px" >
                                    <!-- Ảnh đại diện -->
                                    <img src="../img/user.png" alt="" width="100%" style="border-radius:50%">
                                </td>
                                <td style="padding:0px;margin:0px;">
                                    <!-- Tên và email của bác sĩ -->
                                    <p class="profile-title"><?php echo substr($username,0,13)  ?>..</p>
                                    <p class="profile-subtitle"><?php echo substr($useremail,0,22)  ?></p>
                                </td>
                            </tr>
                            <tr>
                                <!-- Nút đăng xuất -->
                                <td colspan="2">
                                    <a href="../logout.php" ><input type="button" value="Đăng xuất" class="logout-btn btn-primary-soft btn"></a>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
                <tr class="menu-row" >
                    <!-- Menu Dashboard -->
                    <td class="menu-btn menu-icon-dashbord" >
                        <a href="index.php" class="non-style-link-menu "><div><p class="menu-text">Dashboard</p></a></div></a>
                    </td>
                </tr>
                <tr class="menu-row">
                    <!-- Menu Appointment -->
                    <td class="menu-btn menu-icon-appoinment">
                        <a href="appointment.php" class="non-style-link-menu"><div><p class="menu-text">Cuộc hẹn của tôi</p></a></div>
                    </td>
                </tr>
                <tr class="menu-row" >
                    <!-- Menu Schedule -->
                    <td class="menu-btn menu-icon-session">
                        <a href="schedule.php" class="non-style-link-menu"><div><p class="menu-text">Phiên của tôi</p></div></a>
                    </td>
                </tr>
                <tr class="menu-row" >
                    <!-- Menu Patients -->
                    <td class="menu-btn menu-icon-patient menu-active menu-icon-patient-active">
                        <a href="patient.php" class="non-style-link-menu  non-style-link-menu-active"><div><p class="menu-text">Bệnh nhân của tôi</p></a></div>
                    </td>
                </tr>
                <tr class="menu-row" >
                    <!-- Menu Settings -->
                    <td class="menu-btn menu-icon-settings   ">
                        <a href="settings.php" class="non-style-link-menu"><div><p class="menu-text">Cài đặt</p></a></div>
                    </td>
                </tr>
            </table>
        </div>
        <?php       
            // Khởi tạo biến chứa thông tin tìm kiếm và lọc
            $selecttype="My";
            $current="Chỉ bệnh nhân của tôi";
            if($_POST){

                // Xử lý khi người dùng tìm kiếm
                if(isset($_POST["search"])){
                    $keyword=$_POST["search12"];
                    // Tìm kiếm bệnh nhân theo tên hoặc email
                    $sqlmain= "select * from patient where pemail='$keyword' or pname='$keyword' or pname like '$keyword%' or pname like '%$keyword' or pname like '%$keyword%' ";
                    $selecttype="my";
                }
                
                // Xử lý khi người dùng lọc
                if(isset($_POST["filter"])){
                    if($_POST["showonly"]=='all'){
                        // Hiển thị tất cả bệnh nhân
                        $sqlmain= "select * from patient";
                        $selecttype="All";
                        $current="Tất cả bệnh nhân";
                    }else{
                        // Hiển thị chỉ bệnh nhân của bác sĩ hiện tại
                        $sqlmain= "select * from appointment inner join patient on patient.pid=appointment.pid inner join schedule on schedule.scheduleid=appointment.scheduleid where schedule.docid=$userid;";
                        $selecttype="My";
                        $current="Chỉ bệnh nhân của tôi";
                    }
                }
            }else{
                // Mặc định hiển thị bệnh nhân của bác sĩ hiện tại
                $sqlmain= "select * from appointment inner join patient on patient.pid=appointment.pid inner join schedule on schedule.scheduleid=appointment.scheduleid where schedule.docid=$userid;";
                $selecttype="My";
            }
        ?>
        <!-- Phần nội dung -->
        <div class="dash-body">
            <table border="0" width="100%" style=" border-spacing: 0;margin:0;padding:0;margin-top:25px; ">
                <tr >
                    <td width="13%">
                        <!-- Nút trở lại -->
                        <a href="patient.php" ><button  class="login-btn btn-primary-soft btn btn-icon-back"  style="padding-top:11px;padding-bottom:11px;margin-left:20px;width:125px"><font class="tn-in-text">Trở lại</font></button></a>
                    </td>
                    <td>
                        <!-- Form tìm kiếm -->
                        <form action="" method="post" class="header-search">
                            <!-- Ô nhập từ khóa tìm kiếm -->
                            <input type="search" name="search12" class="input-text header-searchbar" placeholder="Tìm kiếm tên bệnh nhân hoặc Email" list="patient">&nbsp;&nbsp;
                            <?php
                                // Hiển thị danh sách bệnh nhân để chọn từ khóa tìm kiếm
                                echo '<datalist id="patient">';
                                $list11 = $database->query($sqlmain);
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
                            <input type="Submit" value="Tìm kiếm" name="search" class="login-btn btn-primary btn" style="padding-left: 25px;padding-right: 25px;padding-top: 10px;padding-bottom: 10px;">
                        </form>
                    </td>
                    <td width="15%">
                        <!-- Hiển thị ngày hiện tại -->
                        <p style="font-size: 14px;color: rgb(119, 119, 119);padding: 0;margin: 0;text-align: right;">Ngày hôm nay</p>
                        <p class="heading-sub12" style="padding: 0;margin: 0;">
                            <?php 
                                date_default_timezone_set('Asia/Ho_Chi_Minh');
                                $date = date('Y-m-d');
                                echo $date;
                            ?>
                        </p>
                    </td>
                    <td width="10%">
                        <!-- Icon lịch -->
                        <button  class="btn-label"  style="display: flex;justify-content: center;align-items: center;"><img src="../img/calendar.svg" width="100%"></button>
                    </td>
                </tr>
                <tr>
                    <td colspan="4" style="padding-top:10px;">
                        <!-- Tiêu đề hiển thị số lượng bệnh nhân -->
                        <p class="heading-main12" style="margin-left: 45px;font-size:18px;color:rgb(49, 49, 49)"><?php echo $selecttype." Patients (".$list11->num_rows.")"; ?></p>
                    </td>
                </tr>
                <tr>
                    <td colspan="4" style="padding-top:0px;width: 100%;" >
                        <center>
                            <!-- Form lọc -->
                            <table class="filter-container" border="0" >
                                <form action="" method="post">
                                    <td  style="text-align: right;">
                                        Hiển thị chi tiết: &nbsp;
                                    </td>
                                    <td width="30%">
                                        <!-- Dropdown lọc -->
                                        <select name="showonly" id="" class="box filter-container-items" style="width:90% ;height: 37px;margin: 0;" >
                                            <option value="" disabled selected hidden><?php echo $current   ?></option><br/>
                                            <option value="my">Chỉ bệnh nhân của tôi</option><br/>
                                            <option value="all">Tất cả bệnh nhân</option><br/>
                                        </select>
                                    </td>
                                    <td width="12%">
                                        <!-- Nút lọc -->
                                        <input type="submit"  name="filter" value="Lọc" class=" btn-primary-soft btn button-icon btn-filter"  style="padding: 15px; margin :0;width:100%">
                                    </td>
                                </form>
                            </table>
                        </center>
                    </td>
                </tr>
                <tr>
                    <td colspan="4">
                        <center>
                            <div class="abc scroll">
                                <!-- Bảng danh sách bệnh nhân -->
                                <table width="93%" class="sub-table scrolldown"  style="border-spacing:0;">
                                    <thead>
                                        <tr>
                                            <th class="table-headin">
                                                Tên
                                            </th>
                                            <th class="table-headin">
                                                Số CCCD
                                            </th>
                                            <th class="table-headin">
                                                SĐT
                                            </th>
                                            <th class="table-headin">
                                                Email
                                            </th>
                                            <th class="table-headin">
                                                Ngày sinh
                                            </th>
                                            <th class="table-headin">
                                                Sự kiện
                                            </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                            $result= $database->query($sqlmain);
                                            if($result->num_rows==0){
                                                // Hiển thị thông báo khi không tìm thấy kết quả
                                                echo '<tr>
                                                        <td colspan="4">
                                                            <br><br><br><br>
                                                            <center>
                                                                <img src="../img/notfound.svg" width="25%">
                                                                <br>
                                                                <p class="heading-main12" style="margin-left: 45px;font-size:20px;color:rgb(49, 49, 49)">Chúng tôi không thể tìm thấy bất cứ điều gì liên quan đến từ khóa của bạn!</p>
                                                                <a class="non-style-link" href="patient.php"><button  class="login-btn btn-primary-soft btn"  style="display: flex;justify-content: center;align-items: center;margin-left:20px;">&nbsp; Hiển thị tất cả bệnh nhân &nbsp;</font></button></a>
                                                            </center>
                                                            <br><br><br><br>
                                                        </td>
                                                      </tr>';
                                            } else {
                                                // Hiển thị danh sách bệnh nhân
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
        // Xử lý khi có yêu cầu xem chi tiết bệnh nhân
        if($_GET){
            $id=$_GET["id"];
            $action=$_GET["action"];
            // Truy vấn lấy thông tin bệnh nhân dựa trên ID
            $sqlmain= "select * from patient where pid=?";
            $stmt = $database->prepare($sqlmain);
            $stmt->bind_param("i",$id);
            $stmt->execute();
            $result = $stmt->get_result();
            $row=$result->fetch_assoc();
            $name=$row["pname"];
            $email=$row["pemail"];
            $nic=$row["pnic"];
            $dob=$row["pdob"];
            $tele=$row["ptel"];
            $address=$row["paddress"];
            // Hiển thị popup xem chi tiết bệnh nhân
            echo '
                <div id="popup1" class="overlay">
                    <div class="popup">
                        <center>
                            <a class="close" href="patient.php">&times;</a>
                            <div class="content"></div>
                            <div style="display: flex;justify-content: center;">
                                <table width="80%" class="sub-table scrolldown add-doc-form-container" border="0">
                                    <tr>
                                        <td>
                                            <p style="padding: 0;margin: 0;text-align: left;font-size: 25px;font-weight: 500;">Xem chi tiết</p><br><br>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="label-td" colspan="2">
                                            <label for="name" class="form-label">ID bệnh nhân: </label>
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
                                            <label for="address" class="form-label">Địa chỉ: </label>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="label-td" colspan="2">
                                            '.$address.'<br><br>
                                        </td>
                                    </tr>
                                </table>
                            </div>
                        </center>
                    </div>
                </div>';
        }
    ?>
</body>
</html>
