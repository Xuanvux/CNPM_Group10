<!-- Phần giao diện của trang web -->
<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Thẻ meta định nghĩa thông tin về trang web -->
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Liên kết với các file CSS -->
    <link rel="stylesheet" href="../css/animations.css">  
    <link rel="stylesheet" href="../css/main.css">  
    <link rel="stylesheet" href="../css/admin.css">
        
    <!-- Tiêu đề trang web -->
    <title>Bác sĩ</title>
    <!-- CSS nội bộ cho phần Popup -->
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
    <!-- PHP phía server -->
    <?php
        // Bắt đầu phiên làm việc
        session_start();

        // Kiểm tra xem đã đăng nhập hay chưa
        if(isset($_SESSION["user"])){
            if(($_SESSION["user"])=="" or $_SESSION['usertype']!='a'){
                // Chuyển hướng nếu chưa đăng nhập hoặc loại tài khoản không đúng
                // header("location: ../login.php");
            }else{
                $useremail=$_SESSION["user"];
            }

        }else{
            // Chuyển hướng nếu chưa đăng nhập
            header("location: ../login.php");
        }

        // Kết nối đến cơ sở dữ liệu
        include("../connection.php");
    ?>

    <!-- Phần nội dung trang web -->
    <div class="container">
        <!-- Menu bên trái -->
        <div class="menu">
            <!-- Menu chính -->
            <table class="menu-container" border="0">
                <!-- Thông tin người dùng -->
                <tr>
                    <td style="padding:10px" colspan="2">
                        <!-- Hình ảnh và thông tin người dùng -->
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
                                <!-- Đăng xuất -->
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
                        <a href="index.php" class="non-style-link-menu"><div><p class="menu-text">Dashboard</p></a></div></a>
                    </td>
                </tr>
                <tr class="menu-row">
                    <td class="menu-btn menu-icon-doctor menu-active menu-icon-doctor-active">
                        <a href="doctors.php" class="non-style-link-menu non-style-link-menu-active"><div><p class="menu-text">Bác sĩ</p></a></div>
                    </td>
                </tr>
                <tr class="menu-row" >
                    <td class="menu-btn menu-icon-schedule">
                        <a href="schedule.php" class="non-style-link-menu"><div><p class="menu-text">Lịch trình</p></div></a>
                    </td>
                </tr>
                <tr class="menu-row">
                    <td class="menu-btn menu-icon-appoinment">
                        <a href="appointment.php" class="non-style-link-menu"><div><p class="menu-text">Cuộc hẹn</p></a></div>
                    </td>
                </tr>
                <tr class="menu-row" >
                    <td class="menu-btn menu-icon-patient">
                        <a href="patient.php" class="non-style-link-menu"><div><p class="menu-text">Bệnh nhân</p></a></div>
                    </td>
                </tr>
            </table>
        </div>
        <!-- Phần thân trang web -->
        <div class="dash-body">
            <!-- Phần tiêu đề -->
            <table border="0" width="100%" style=" border-spacing: 0;margin:0;padding:0;margin-top:25px; ">
                <!-- Phần điều hướng -->
                <tr >
                    <!-- Nút trở lại -->
                    <td width="13%">
                        <a href="doctors.php" ><button  class="login-btn btn-primary-soft btn btn-icon-back"  style="padding-top:11px;padding-bottom:11px;margin-left:20px;width:125px"><font class="tn-in-text">Trở lại</font></button></a>
                    </td>
                    <!-- Ô tìm kiếm -->
                    <td>
                        <!-- Form tìm kiếm -->
                        <form action="" method="post" class="header-search">
                            <!-- Ô nhập từ khóa -->
                            <input type="search" name="search" class="input-text header-searchbar" placeholder="Tìm kiếm tên bác sĩ hoặc Email" list="doctors">&nbsp;&nbsp;
                            <!-- Danh sách tùy chọn -->
                            <?php
                                echo '<datalist id="doctors">';
                                $list11 = $database->query("select  docname,docemail from  doctor;");

                                for ($y=0;$y<$list11->num_rows;$y++){
                                    $row00=$list11->fetch_assoc();
                                    $d=$row00["docname"];
                                    $c=$row00["docemail"];
                                    echo "<option value='$d'><br/>";
                                    echo "<option value='$c'><br/>";
                                };

                            echo ' </datalist>';
                            ?>
                            <!-- Nút tìm kiếm -->
                            <input type="Submit" value="Tìm kiếm" class="login-btn btn-primary btn" style="padding-left: 25px;padding-right: 25px;padding-top: 10px;padding-bottom: 10px;">
                        </form>
                    </td>
                    <!-- Thông tin ngày -->
                    <td width="15%">
                        <p style="font-size: 14px;color: rgb(119, 119, 119);padding: 0;margin: 0;text-align: right;">
                            Ngày hôm nay
                        </p>
                        <p class="heading-sub12" style="padding: 0;margin: 0;">
                            <?php 
                                date_default_timezone_set('Asia/Ho_Chi_Minh');
                                $date = date('Y-m-d');
                                echo $date;
                            ?>
                        </p>
                    </td>
                    <!-- Nút hiển thị lịch -->
                    <td width="10%">
                        <button  class="btn-label"  style="display: flex;justify-content: center;align-items: center;"><img src="../img/calendar.svg" width="100%"></button>
                    </td>
                </tr>
                <!-- Phần tiêu đề danh sách bác sĩ -->
                <tr >
                    <td colspan="2" style="padding-top:30px;">
                        <p class="heading-main12" style="margin-left: 45px;font-size:20px;color:rgb(49, 49, 49)">Thêm mới</p>
                    </td>
                    <td colspan="2">
                        <!-- Nút thêm mới -->
                        <a href="?action=add&id=none&error=0" class="non-style-link"><button  class="login-btn btn-primary btn button-icon"  style="display: flex;justify-content: center;align-items: center;margin-left:75px;background-image: url('../img/icons/add.svg');">Thêm mới</font></button></a>
                    </td>
                </tr>
                <!-- Phần danh sách bác sĩ -->
                <tr>
                    <td colspan="4" style="padding-top:10px;">
                        <!-- Tiêu đề danh sách -->
                        <p class="heading-main12" style="margin-left: 45px;font-size:18px;color:rgb(49, 49, 49)">Tất cả bác sĩ (<?php echo $list11->num_rows; ?>)</p>
                    </td>
                </tr>
                <?php
                    // Kiểm tra nếu có dữ liệu từ form tìm kiếm
                    if($_POST){
                        $keyword=$_POST["search"];
                        // Tạo câu truy vấn SQL
                        $sqlmain= "select * from doctor where docemail='$keyword' or docname='$keyword' or docname like '$keyword%' or docname like '%$keyword' or docname like '%$keyword%'";
                    }else{
                        // Câu truy vấn mặc định
                        $sqlmain= "select * from doctor order by docid desc";

                    }
                ?>
                <tr>
                    <td colspan="4">
                        <center>
                            <!-- Bảng hiển thị danh sách bác sĩ -->
                            <div class="abc scroll">
                                <table width="93%" class="sub-table scrolldown" border="0">
                                    <thead>
                                        <tr>
                                            <!-- Tiêu đề cột -->
                                            <th class="table-headin">Tên bác sĩ</th>
                                            <th class="table-headin">Email</th>
                                            <th class="table-headin">Chuyên khoa</th>
                                            <th class="table-headin">Sự kiện</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                            // Thực hiện truy vấn SQL
                                            $result= $database->query($sqlmain);
                                            // Kiểm tra kết quả trả về
                                            if($result->num_rows==0){
                                                // Hiển thị thông báo nếu không tìm thấy kết quả
                                                echo '<tr>
                                                    <td colspan="4">
                                                        <br><br><br><br>
                                                        <center>
                                                            <img src="../img/notfound.svg" width="25%">
                                                            <br>
                                                            <p class="heading-main12" style="margin-left: 45px;font-size:20px;color:rgb(49, 49, 49)">Chúng tôi không thể tìm thấy bất cứ điều gì liên quan đến từ khóa của bạn!</p>
                                                            <a class="non-style-link" href="doctors.php"><button  class="login-btn btn-primary-soft btn"  style="display: flex;justify-content: center;align-items: center;margin-left:20px;">&nbsp; Hiển thị tất cả bác sĩ &nbsp;</font></button></a>
                                                        </center>
                                                        <br><br><br><br>
                                                    </td>
                                                </tr>';
                                            } else {
                                                // Hiển thị dữ liệu nếu có
                                                for ($x=0; $x<$result->num_rows;$x++){
                                                    $row=$result->fetch_assoc();
                                                    $docid=$row["docid"];
                                                    $name=$row["docname"];
                                                    $email=$row["docemail"];
                                                    $spe=$row["specialties"];
                                                    // Truy vấn để lấy tên chuyên khoa
                                                    $spcil_res= $database->query("select sname from specialties where id='$spe'");
                                                    $spcil_array= $spcil_res->fetch_assoc();
                                                    $spcil_name=$spcil_array["sname"];
                                                    // Lấy thông tin khác
                                                    $nic=$row['docnic'];
                                                    $tele=$row['doctel'];
                                                    // Hiển thị dữ liệu trong bảng
                                                    echo '<tr>
                                                        <td> &nbsp;'.substr($name,0,30).'</td>
                                                        <td>'.substr($email,0,20).'</td>
                                                        <td>'.substr($spcil_name,0,20).'</td>
                                                        <td>
                                                            <div style="display:flex;justify-content: center;">
                                                                <!-- Các nút điều hướng -->
                                                                <a href="?action=edit&id='.$docid.'&error=0" class="non-style-link">
                                                                    <button  class="btn-primary-soft btn button-icon btn-edit"  style="padding-left: 40px;padding-top: 12px;padding-bottom: 12px;margin-top: 10px;">
                                                                        <font class="tn-in-text">Sửa</font>
                                                                    </button>
                                                                </a>
                                                                &nbsp;&nbsp;&nbsp;
                                                                <a href="?action=view&id='.$docid.'" class="non-style-link">
                                                                    <button  class="btn-primary-soft btn button-icon btn-view"  style="padding-left: 40px;padding-top: 12px;padding-bottom: 12px;margin-top: 10px;">
                                                                        <font class="tn-in-text">Xem</font>
                                                                    </button>
                                                                </a>
                                                                &nbsp;&nbsp;&nbsp;
                                                                <a href="?action=drop&id='.$docid.'&name='.$name.'" class="non-style-link">
                                                                    <button  class="btn-primary-soft btn button-icon btn-delete"  style="padding-left: 40px;padding-top: 12px;padding-bottom: 12px;margin-top: 10px;">
                                                                        <font class="tn-in-text">Xóa</font>
                                                                    </button>
                                                                </a>
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
        // Kiểm tra nếu có yêu cầu từ URL
        if($_GET){
            // Lấy dữ liệu từ URL
            $id=$_GET["id"];
            $action=$_GET["action"];
            // Kiểm tra hành động
            if($action=='drop'){
                $nameget=$_GET["name"];
                echo '
                <!-- Hiển thị hộp thoại xác nhận xóa -->
                <div id="popup1" class="overlay">
                    <div class="popup">
                        <center>
                            <h2>Bạn có chắc?</h2>
                            <a class="close" href="doctors.php">&times;</a>
                            <div class="content">
                                Bạn muốn xóa bản ghi này?<br>('.substr($nameget,0,40).').    
                            </div>
                            <div style="display: flex;justify-content: center;">
                                <a href="delete-doctor.php?id='.$id.'" class="non-style-link">
                                    <button  class="btn-primary btn"  style="display: flex;justify-content: center;align-items: center;margin:10px;padding:10px;">
                                        <font class="tn-in-text">&nbsp;Yes&nbsp;
                                        </font>
                                    </button>
                                </a>&nbsp;&nbsp;&nbsp;
                                <a href="doctors.php" class="non-style-link">
                                    <button  class="btn-primary btn"  style="display: flex;justify-content: center;align-items: center;margin:10px;padding:10px;">
                                        <font class="tn-in-text">&nbsp;&nbsp;No&nbsp;&nbsp;
                                        </font>
                                    </button>
                                </a>
                            </div>
                        </center>
                    </div>
                </div>
                ';
            } elseif($action=='view'){
                // Lấy thông tin của bác sĩ để xem
                $sqlmain= "select * from doctor where docid='$id'";
                $result= $database->query($sqlmain);
                $row=$result->fetch_assoc();
                $name=$row["docname"];
                $email=$row["docemail"];
                $spe=$row["specialties"];
                $spcil_res= $database->query("select sname from specialties where id='$spe'");
                $spcil_array= $spcil_res->fetch_assoc();
                $spcil_name=$spcil_array["sname"];
                $nic=$row['docnic'];
                $tele=$row['doctel'];
                // Hiển thị thông tin trong hộp thoại
                echo '
                <div id="popup1" class="overlay">
                    <div class="popup">
                        <center>
                            <h2></h2>
                            <a class="close" href="doctors.php">&times;</a>
                            <div class="content">
                                Hệ thống quản lý bệnh viện<br>    
                            </div>
                            <div style="display: flex;justify-content: center;">
                                <table width="80%" class="sub-table scrolldown add-doc-form-container" border="0">
                                    <tr>
                                        <td>
                                            <p style="padding: 0;margin: 0;text-align: left;font-size: 25px;font-weight: 500;">Xem chi tiết</p><br><br>
                                        </td>
                                    </tr>
                                    <!-- Hiển thị thông tin của bác sĩ -->
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
                                            <label for="spec" class="form-label">Chuyên khoa: </label>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="label-td" colspan="2">
                                            '.$spcil_name.'<br><br>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="2">
                                            <!-- Nút đóng -->
                                            <a href="doctors.php">
                                                <input type="button" value="OK" class="login-btn btn-primary-soft btn">
                                            </a>
                                        </td>
                                    </tr>
                                </table>
                            </div>
                        </center>
                        <br><br>
                    </div>
                </div>
                ';
            } elseif($action=='add'){
                // Lấy thông tin lỗi từ URL
                $error_1=$_GET["error"];
                // Mảng thông báo lỗi
                $errorlist= array(
                    '1'=>'<label for="promter" class="form-label" style="color:rgb(255, 62, 62);text-align:center;">Đã có tài khoản cho địa chỉ Email này.</label>',
                    '2'=>'<label for="promter" class="form-label" style="color:rgb(255, 62, 62);text-align:center;">Có lỗi xảy ra khi thêm bản ghi mới.</label>',
                    '3'=>'<label for="promter" class="form-label" style="color:rgb(255, 62, 62);text-align:center;">Hình ảnh không hợp lệ.</label>'
                );
                // Lấy thông tin họ và tên từ URL
                $name_1=$_GET["name"];
                // Hiển thị hộp thoại thêm mới
                echo '
                <div id="popup1" class="overlay">
                    <div class="popup">
                        <center>
                            <h2></h2>
                            <a class="close" href="doctors.php">&times;</a>
                            <div class="content">
                                Hệ thống quản lý bệnh viện<br>    
                            </div>
                            <div style="display: flex;justify-content: center;">
                                <table width="80%" class="sub-table scrolldown add-doc-form-container" border="0">
                                    <tr>
                                        <td>
                                            <p style="padding: 0;margin: 0;text-align: left;font-size: 25px;font-weight: 500;">Thêm mới</p><br><br>
                                        </td>
                                    </tr>
                                    <!-- Form thêm mới -->
                                    <tr>   
                                        <td class="label-td" colspan="2">
                                            <label for="name" class="form-label">Tên: </label>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="input-td" colspan="2">
                                            <input type="text" name="name" id="name" class="input-text input" value="'.$name_1.'" readonly>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="2">
                                            '.$errorlist[$error_1].'
                                        </td>
                                    </tr>
                                    <!-- Nút đóng -->
                                    <tr>
                                        <td colspan="2">
                                            <a href="doctors.php">
                                                <input type="button" value="OK" class="login-btn btn-primary-soft btn">
                                            </a>
                                        </td>
                                    </tr>
                                </table>
                            </div>
                        </center>
                        <br><br>
                    </div>
                </div>
                ';
            } elseif($action=='edit'){
                // Lấy thông tin lỗi từ URL
                $error_1=$_GET["error"];
                // Mảng thông báo lỗi
                $errorlist= array(
                    '1'=>'<label for="promter" class="form-label" style="color:rgb(255, 62, 62);text-align:center;">Đã có tài khoản cho địa chỉ Email này.</label>',
                    '2'=>'<label for="promter" class="form-label" style="color:rgb(255, 62, 62);text-align:center;">Có lỗi xảy ra khi thêm bản ghi mới.</label>',
                    '3'=>'<label for="promter" class="form-label" style="color:rgb(255, 62, 62);text-align:center;">Hình ảnh không hợp lệ.</label>'
                );
                // Lấy thông tin họ và tên từ URL
                $id_1=$_GET["id"];
                // Hiển thị hộp thoại chỉnh sửa
                echo '
                <div id="popup1" class="overlay">
                    <div class="popup">
                        <center>
                            <h2></h2>
                            <a class="close" href="doctors.php">&times;</a>
                            <div class="content">
                                Hệ thống quản lý bệnh viện<br>    
                            </div>
                            <div style="display: flex;justify-content: center;">
                                <table width="80%" class="sub-table scrolldown add-doc-form-container" border="0">
                                    <tr>
                                        <td>
                                            <p style="padding: 0;margin: 0;text-align: left;font-size: 25px;font-weight: 500;">Chỉnh sửa</p><br><br>
                                        </td>
                                    </tr>
                                    <!-- Form chỉnh sửa -->
                                    <tr>   
                                        <td class="label-td" colspan="2">
                                            <label for="name" class="form-label">Tên: </label>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="input-td" colspan="2">
                                            <input type="text" name="name" id="name" class="input-text input" value="'.$name_1.'">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="2">
                                            '.$errorlist[$error_1].'
                                        </td>
                                    </tr>
                                    <!-- Nút đóng -->
                                    <tr>
                                        <td colspan="2">
                                            <a href="doctors.php">
                                                <input type="button" value="OK" class="login-btn btn-primary-soft btn">
                                            </a>
                                        </td>
                                    </tr>
                                </table>
                            </div>
                        </center>
                        <br><br>
                    </div>
                </div>
                ';

            }else{
                echo '
                    <div id="popup1" class="overlay">
                        <div class="popup">
                            <center>
                                <br><br><br><br>
                                <h2>Thêm thành công!</h2>
                                <a class="close" href="doctors.php">&times;</a>
                                <div class="content">
                                    
                                    
                                </div>
                                <div style="display: flex;justify-content: center;">
                                    <a href="doctors.php" class="non-style-link">
                                        <button  class="btn-primary btn" style="display: flex;justify-content: center;align-items: center;margin:10px;padding:10px;">
                                            <font class="tn-in-text">&nbsp;&nbsp;OK&nbsp;&nbsp;</font>
                                        </button>
                                    </a>
                                </div>
                                <br><br>
                            </center>
                        </div>
                    </div>
                ';
            }
            
            
        }elseif($action=='edit'){
            $sqlmain= "select * from doctor where docid='$id'";
            $result= $database->query($sqlmain);
            $row=$result->fetch_assoc();
            $name=$row["docname"];
            $email=$row["docemail"];
            $spe=$row["specialties"];
            
            // Lấy thông tin về chuyên khoa của bác sĩ
            $spcil_res= $database->query("select sname from specialties where id='$spe'");
            $spcil_array= $spcil_res->fetch_assoc();
            $spcil_name=$spcil_array["sname"];
            $nic=$row['docnic'];
            $tele=$row['doctel'];
        
            // Lấy mã lỗi từ URL
            $error_1=$_GET["error"];
            // Mảng chứa các thông báo lỗi tương ứng với mã lỗi
            $errorlist= array(
                '1'=>'<label for="promter" class="form-label" style="color:rgb(255, 62, 62);text-align:center;">Đã có tài khoản cho địa chỉ Email này.</label>',
                '2'=>'<label for="promter" class="form-label" style="color:rgb(255, 62, 62);text-align:center;">Lỗi cấu hình mật khẩu! Sửa lại mật khẩu</label>',
                '3'=>'<label for="promter" class="form-label" style="color:rgb(255, 62, 62);text-align:center;"></label>',
                '4'=>"",
                '0'=>'',
        
            );
        
            if($error_1!='4'){
                // Hiển thị form chỉnh sửa thông tin bác sĩ và thông báo lỗi (nếu có)
                echo '
                <div id="popup1" class="overlay">
                    <div class="popup">
                        <center>
                            <a class="close" href="doctors.php">&times;</a> 
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
                                                <p style="padding: 0;margin: 0;text-align: left;font-size: 25px;font-weight: 500;">Sửa chi tiết</p>
                                                ID bác sĩ: '.$id.' (Tự động xuất)<br><br>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="label-td" colspan="2">
                                                <form action="edit-doc.php" method="POST" class="add-new-form">
                                                    <label for="Email" class="form-label">Email: </label>
                                                    <input type="hidden" value="'.$id.'" name="id00">
                                            </td>
                                        </tr>
                                        <!-- Các trường thông tin khác để chỉnh sửa -->
                                        <!-- ... -->
                                        <tr>
                                            <td colspan="2">
                                                <input type="reset" value="Làm mới" class="login-btn btn-primary-soft btn">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                <input type="submit" value="Lưu" class="login-btn btn-primary btn">
                                            </td>
                                        </tr>
                                    </form>
                                </tr>
                            </table>
                        </div>
                    </div>
                </center>
                <br><br>
            </div>
            </div>
            ';
        }else{
            // Hiển thị thông báo khi sửa thành công
            echo '
            <div id="popup1" class="overlay">
                <div class="popup">
                    <center>
                        <br><br><br><br>
                        <h2>Sửa thành công!</h2>
                        <a class="close" href="doctors.php">&times;</a>
                        <div class="content">
                            
                        </div>
                        <div style="display: flex;justify-content: center;">
                            <a href="doctors.php" class="non-style-link">
                                <button  class="btn-primary btn"  style="display: flex;justify-content: center;align-items: center;margin:10px;padding:10px;">
                                    <font class="tn-in-text">&nbsp;&nbsp;OK&nbsp;&nbsp;</font>
                                </button>
                            </a>
                        </div>
                        <br><br>
                    </center>
                </div>
            </div>
            ';
        };
        };
        };
        

?>
</div>

</body>
</html>