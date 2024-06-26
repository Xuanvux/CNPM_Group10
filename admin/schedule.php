<!-- Mở đầu mã HTML -->
<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Khai báo các thông tin về trang web -->
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Liên kết đến các file CSS -->
    <link rel="stylesheet" href="../css/animations.css">  
    <link rel="stylesheet" href="../css/main.css">  
    <link rel="stylesheet" href="../css/admin.css">
    <!-- Tiêu đề trang -->
    <title>Lịch trình</title>
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
    // Bắt đầu phiên làm việc PHP
    // Kiểm tra phiên đăng nhập
    session_start();
    if(isset($_SESSION["user"])){
        if(($_SESSION["user"])=="" or $_SESSION['usertype']!='a'){
            header("location: ../login.php");
        }
    }else{
        header("location: ../login.php");
    }
    // Import file kết nối đến cơ sở dữ liệu
    include("../connection.php");
    ?>
    <!-- Cấu trúc phần nội dung của trang -->
    <div class="container">
        <!-- Menu bên trái -->
        <div class="menu">
            <!-- Bảng menu -->
            <table class="menu-container" border="0">
                <!-- Thông tin người dùng -->
                <tr>
                    <td style="padding:10px" colspan="2">
                        <table border="0" class="profile-container">
                            <!-- Hiển thị hình ảnh và thông tin người dùng -->
                            <tr>
                                <td width="30%" style="padding-left:20px" >
                                    <img src="../img/user.png" alt="" width="100%" style="border-radius:50%">
                                </td>
                                <td style="padding:0px;margin:0px;">
                                    <p class="profile-title">Admin</p>
                                    <p class="profile-subtitle">admin@gmail.com</p>
                                </td>
                            </tr>
                            <!-- Nút logout -->
                            <tr>
                                <td colspan="2">
                                    <a href="../logout.php" ><input type="button" value="Log out" class="logout-btn btn-primary-soft btn"></a>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
                <!-- Các nút điều hướng -->
                <tr class="menu-row" >
                    <td class="menu-btn menu-icon-dashbord" >
                        <a href="index.php" class="non-style-link-menu"><div><p class="menu-text">Dashboard</p></a></div></a>
                    </td>
                </tr>
                <tr class="menu-row">
                    <td class="menu-btn menu-icon-doctor ">
                        <a href="doctors.php" class="non-style-link-menu "><div><p class="menu-text">Bác sĩ</p></a></div>
                    </td>
                </tr>
                <tr class="menu-row" >
                    <td class="menu-btn menu-icon-schedule menu-active menu-icon-schedule-active">
                        <a href="schedule.php" class="non-style-link-menu non-style-link-menu-active"><div><p class="menu-text">Lịch trình</p></div></a>
                    </td>
                </tr>
                <tr class="menu-row">
                    <td class="menu-btn menu-icon-appoinment">
                        <a href="appointment.php" class="non-style-link-menu"><div><p class="menu-text">Cuộc hẹn</p></div></a>
                    </td>
                </tr>
                <tr class="menu-row" >
                    <td class="menu-btn menu-icon-patient">
                        <a href="patient.php" class="non-style-link-menu"><div><p class="menu-text">Bệnh nhân</p></div></a>
                    </td>
                </tr>
            </table>
        </div>
        <!-- Phần nội dung chính -->
        <div class="dash-body">
            <!-- Bảng lịch trình -->
            <table border="0" width="100%" style=" border-spacing: 0;margin:0;padding:0;margin-top:25px; ">
                <!-- Dòng tiêu đề -->
                <tr >
                    <td width="13%" >
                        <!-- Nút quay lại trang trước -->
                        <a href="schedule.php" ><button  class="login-btn btn-primary-soft btn btn-icon-back"  style="padding-top:11px;padding-bottom:11px;margin-left:20px;width:125px"><font class="tn-in-text">Trở về</font></button></a>
                    </td>
                    <td>
                        <!-- Tiêu đề trang -->
                        <p style="font-size: 23px;padding-left:12px;font-weight: 600;">Quản lý lịch trình</p>           
                    </td>
                    <td width="15%">
                        <!-- Hiển thị ngày hôm nay -->
                        <p style="font-size: 14px;color: rgb(119, 119, 119);padding: 0;margin: 0;text-align: right;">
                            Ngày hôm nay
                        </p>
                        <p class="heading-sub12" style="padding: 0;margin: 0;">
                            <?php 
                                // Thiết lập múi giờ
                                date_default_timezone_set('Asia/Ho_Chi_Minh');
                                $today = date('Y-m-d');
                                echo $today;
                                // Truy vấn danh sách lịch trình
                                $list110 = $database->query("select  * from  schedule;");
                            ?>
                        </p>
                    </td>
                    <td width="10%">
                        <!-- Biểu tượng lịch -->
                        <button  class="btn-label"  style="display: flex;justify-content: center;align-items: center;"><img src="../img/calendar.svg" width="100%"></button>
                    </td>
                </tr>
                <!-- Dòng thêm mới phiên -->
                <tr>
                    <td colspan="4" >
                        <div style="display: flex;margin-top: 40px;">
                            <div class="heading-main12" style="margin-left: 45px;font-size:20px;color:rgb(49, 49, 49);margin-top: 5px;">Lên lịch một phiên</div>
                            <!-- Nút thêm mới phiên -->
                            <a href="?action=add-session&id=none&error=0" class="non-style-link"><button  class="login-btn btn-primary btn button-icon"  style="margin-left:25px;background-image: url('../img/icons/add.svg');">Thêm một phiên</font></button></a>
                        </div>
                    </td>
                </tr>
                <!-- Dòng tiêu đề -->
                <tr>
                    <td colspan="4" style="padding-top:10px;width: 100%;" >
                        <p class="heading-main12" style="margin-left: 45px;font-size:18px;color:rgb(49, 49, 49)">Tất cả các phiên (<?php echo $list110->num_rows; ?>)</p>
                    </td>
                </tr>
                <!-- Dòng bộ lọc -->
                <tr>
                    <td colspan="4" style="padding-top:0px;width: 100%;" >
                        <center>
                            <table class="filter-container" border="0" >
                                <tr>
                                    <td width="10%"></td> 
                                    <td width="5%" style="text-align: center;">Ngày:</td>
                                    <!-- Form lọc theo ngày -->
                                    <td width="30%">
                                        <form action="" method="post">
                                            <input type="date" name="sheduledate" id="date" class="input-text filter-container-items" style="margin: 0;width: 95%;">
                                        </form>
                                    </td>
                                    <td width="5%" style="text-align: center;">Bác sĩ:</td>
                                    <!-- Form lọc theo bác sĩ -->
                                    <td width="30%">
                                        <select name="docid" id="" class="box filter-container-items" style="width:90% ;height: 37px;margin: 0;" >
                                            <option value="" disabled selected hidden>Chọn tên bác sĩ trong danh sách</option><br/>
                                            <?php 
                                                // Truy vấn danh sách bác sĩ
                                                $list11 = $database->query("select  * from  doctor order by docname asc;");
                                                for ($y=0;$y<$list11->num_rows;$y++){
                                                    $row00=$list11->fetch_assoc();
                                                    $sn=$row00["docname"];
                                                    $id00=$row00["docid"];
                                                    echo "<option value=".$id00.">$sn</option><br/>";
                                                };
                                            ?>
                                        </select>
                                    </td>
                                    <td width="12%">
                                        <!-- Nút lọc -->
                                        <input type="submit"  name="filter" value=" Lọc" class=" btn-primary-soft btn button-icon btn-filter"  style="padding: 15px; margin :0;width:100%">
                                    </td>
                                </tr>
                            </table>
                        </center>
                    </td>
                </tr>
                <!-- PHP: Kiểm tra và xử lý dữ liệu post -->
                <?php
                    if($_POST){
                        $sqlpt1="";
                        // Kiểm tra ngày lên lịch
                        if(!empty($_POST["sheduledate"])){
                            $sheduledate=$_POST["sheduledate"];
                            $sqlpt1=" schedule.scheduledate='$sheduledate' ";
                        }
                        $sqlpt2="";
                        // Kiểm tra bác sĩ
                        if(!empty($_POST["docid"])){
                            $docid=$_POST["docid"];
                            $sqlpt2=" doctor.docid=$docid ";
                        }
                        // Tạo câu truy vấn chính
                        $sqlmain= "select schedule.scheduleid,schedule.title,doctor.docname,schedule.scheduledate,schedule.scheduletime,schedule.nop from schedule inner join doctor on schedule.docid=doctor.docid ";
                        $sqllist=array($sqlpt1,$sqlpt2);
                        $sqlkeywords=array(" where "," and ");
                        $key2=0;
                        foreach($sqllist as $key){
                            if(!empty($key)){
                                $sqlmain.=$sqlkeywords[$key2].$key;
                                $key2++;
                            };
                        };
                    }else{
                        // Truy vấn mặc định
                        $sqlmain= "select schedule.scheduleid,schedule.title,doctor.docname,schedule.scheduledate,schedule.scheduletime,schedule.nop from schedule inner join doctor on schedule.docid=doctor.docid  order by schedule.scheduledate desc";
                    }
                ?>
                <!-- Kết thúc PHP -->
                <!-- Tiêu đề bảng -->
                <tr>
                    <td colspan="4">
                        <center>
                            <div class="abc scroll">
                                <table width="93%" class="sub-table scrolldown" border="0">
                                    <thead>
                                        <tr>
                                            <th class="table-headin">Tiêu đề phiên</th>
                                            <th class="table-headin">Bác sĩ</th>
                                            <th class="table-headin">Ngày & Giờ đã lên lịch</th>
                                            <th class="table-headin">Số lượng tối đa có thể đặt trước</th>
                                            <th class="table-headin">Sự kiện</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    <?php
    // Lặp qua kết quả truy vấn và hiển thị dữ liệu
    $result= $database->query($sqlmain);
    if($result->num_rows==0){
        // Hiển thị thông báo khi không tìm thấy dữ liệu
        echo '<tr>
                <td colspan="4">
                    <br><br><br><br>
                    <center>
                        <img src="../img/notfound.svg" width="25%">
                        <br>
                        <p class="heading-main12" style="margin-left: 45px;font-size:20px;color:rgb(49, 49, 49)">Chúng tôi không thể tìm thấy bất cứ điều gì liên quan đến từ khóa của bạn!</p>
                        <a class="non-style-link" href="schedule.php"><button  class="login-btn btn-primary-soft btn"  style="display: flex;justify-content: center;align-items: center;margin-left:20px;">&nbsp; Hiển thị tất cả các phiên &nbsp;</font></button></a>
                    </center>
                    <br><br><br><br>
                </td>
            </tr>';
    } else {
        // Hiển thị dữ liệu
        for ($x = 0; $x < $result->num_rows; $x++){
            $row = $result->fetch_assoc();
            $scheduleid = $row["scheduleid"];
            $title = $row["title"];
            $docname = $row["docname"];
            $scheduledate = $row["scheduledate"];
            $scheduletime = $row["scheduletime"];
            $nop = $row["nop"];
            echo '<tr>
                    <td> &nbsp;'.substr($title,0,30).'</td>
                    <td>'.substr($docname,0,20).'</td>
                    <td style="text-align:center;">'.substr($scheduledate,0,10).' '.substr($scheduletime,0,5).'</td>
                    <td style="text-align:center;">'.$nop.'</td>
                    <td>
                        <div style="display:flex;justify-content: center;">
                            <a href="?action=view&id='.$scheduleid.'" class="non-style-link"><button  class="btn-primary-soft btn button-icon btn-view"  style="padding-left: 40px;padding-top: 12px;padding-bottom: 12px;margin-top: 10px;"><font class="tn-in-text">Xem</font></button></a>
                            &nbsp;&nbsp;&nbsp;
                            <a href="?action=drop&id='.$scheduleid.'&name='.$title.'" class="non-style-link"><button  class="btn-primary-soft btn button-icon btn-delete"  style="padding-left: 40px;padding-top: 12px;padding-bottom: 12px;margin-top: 10px;"><font class="tn-in-text">Gỡ</font></button></a>
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
    
    // Kiểm tra nếu có dữ liệu được gửi đi qua phương thức GET
    if($_GET){
        $id=$_GET["id"]; // Lấy giá trị của tham số "id" từ query string
        $action=$_GET["action"]; // Lấy giá trị của tham số "action" từ query string
        
        // Nếu action là 'add-session'
        if($action=='add-session'){

            // In ra HTML của popup thêm phiên mới
            echo '
            <div id="popup1" class="overlay">
                <div class="popup">
                    <center>
                        <a class="close" href="schedule.php">&times;</a> 
                        <div style="display: flex;justify-content: center;">
                            <div class="abc">
                                <table width="80%" class="sub-table scrolldown add-doc-form-container" border="0">
                                    <tr>
                                        <td class="label-td" colspan="2">'.
                                           "".
                                        '</td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <p style="padding: 0;margin: 0;text-align: left;font-size: 25px;font-weight: 500;">Thêm mới phiên.</p><br>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="label-td" colspan="2">
                                            <form action="add-session.php" method="POST" class="add-new-form">
                                                <label for="title" class="form-label">Tiêu đề phiên: </label>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="label-td" colspan="2">
                                            <input type="text" name="title" class="input-text" placeholder="Tên phiên này" required><br>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="label-td" colspan="2">
                                            <label for="docid" class="form-label">Chọn bác sĩ: </label>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="label-td" colspan="2">
                                            <select name="docid" id="" class="box" >
                                                <option value="" disabled selected hidden>Chọn tên bác sĩ trong danh sách</option><br/>';

            // Truy vấn để lấy danh sách bác sĩ từ cơ sở dữ liệu và tạo các tùy chọn
            $list11 = $database->query("select  * from  doctor order by docname asc;");
            for ($y=0;$y<$list11->num_rows;$y++){
                $row00=$list11->fetch_assoc();
                $sn=$row00["docname"];
                $id00=$row00["docid"];
                echo "<option value=".$id00.">$sn</option><br/>";
            };

            // Kết thúc form và HTML của popup thêm phiên mới
            echo '      </select><br><br>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="label-td" colspan="2">
                                            <label for="nop" class="form-label">Số lượng bệnh nhân/số cuộc hẹn: </label>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="label-td" colspan="2">
                                            <input type="number" name="nop" class="input-text" min="0"  placeholder="Số hẹn cuối cùng của buổi này phụ thuộc vào số này" required><br>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="label-td" colspan="2">
                                            <label for="date" class="form-label">Ngày phiên: </label>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="label-td" colspan="2">
                                            <input type="date" name="date" class="input-text" min="'.date('Y-m-d').'" required><br>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="label-td" colspan="2">
                                            <label for="time" class="form-label">Thời gian biểu: </label>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="label-td" colspan="2">
                                            <input type="time" name="time" class="input-text" placeholder="Thời gian" required><br>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="2">
                                            <input type="reset" value="Làm mới" class="login-btn btn-primary-soft btn" >&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                            <input type="submit" value="Thay thế phiên" class="login-btn btn-primary btn" name="shedulesubmit">
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

        }
        // Nếu action là 'session-added'
        elseif($action=='session-added'){
            $titleget=$_GET["title"];

            // In ra HTML của popup xác nhận phiên đã được thêm thành công
            echo '
            <div id="popup1" class="overlay">
                <div class="popup">
                    <center>
                        <br><br>
                        <h2>Phiên đã thay thế.</h2>
                        <a class="close" href="schedule.php">&times;</a>
                        <div class="content">
                            '.substr($titleget,0,40).' đã được lên lịch.<br><br>
                        </div>
                        <div style="display: flex;justify-content: center;">
                            <a href="schedule.php" class="non-style-link"><button  class="btn-primary btn"  style="display: flex;justify-content: center;align-items: center;margin:10px;padding:10px;"><font class="tn-in-text">&nbsp;&nbsp;OK&nbsp;&nbsp;</font></button></a>
                            <br><br><br><br>
                        </div>
                    </center>
                </div>
            </div>
            ';
        }
        // Nếu action là 'drop'
        elseif($action=='drop'){
            $nameget=$_GET["name"];

            // In ra HTML của popup xác nhận xóa bản ghi
            echo '
            <div id="popup1" class="overlay">
                <div class="popup">
                    <center>
                        <h2>Are you sure?</h2>
                        <a class="close" href="schedule.php">&times;</a>
                        <div class="content">
                            Bạn muốn xóa bản ghi này<br>('.substr($nameget,0,40).').
                        </div>
                        <div style="display: flex;justify-content: center;">
                            <a href="delete-session.php?id='.$id.'" class="non-style-link"><button  class="btn-primary btn"  style="display: flex;justify-content: center;align-items: center;margin:10px;padding:10px;"<font class="tn-in-text">&nbsp;Yes&nbsp;</font></button></a>&nbsp;&nbsp;&nbsp;
                            <a href="schedule.php" class="non-style-link"><button  class="btn-primary btn"  style="display: flex;justify-content: center;align-items: center;margin:10px;padding:10px;"><font class="tn-in-text">&nbsp;&nbsp;No&nbsp;&nbsp;</font></button></a>
                        </div>
                    </center>
                </div>
            </div>
            '; 
        }
        // Nếu action là 'view'
        elseif($action=='view'){
            // Truy vấn để lấy thông tin chi tiết của phiên theo id
            $sqlmain= "select schedule.scheduleid,schedule.title,doctor.docname,schedule.scheduledate,schedule.scheduletime,schedule.nop from schedule inner join doctor on schedule.docid=doctor.docid  where  schedule.scheduleid=$id";
            $result= $database->query($sqlmain);
            $row=$result->fetch_assoc();
            $docname=$row["docname"];
            $scheduleid=$row["scheduleid"];
            $title=$row["title"];
            $scheduledate=$row["scheduledate"];
            $scheduletime=$row["scheduletime"];
            $nop=$row['nop'];

            // Truy vấn để lấy danh sách các cuộc hẹn của phiên
            $sqlmain12= "select * from appointment inner join patient on patient.pid=appointment.pid inner join schedule on schedule.scheduleid=appointment.scheduleid where schedule.scheduleid=$id;";
            $result12= $database->query($sqlmain12);

            // In ra HTML của popup hiển thị chi tiết phiên và danh sách bệnh nhân đã đăng ký
            echo '
            <div id="popup1" class="overlay">
                <div class="popup" style="width: 70%;">
                    <center>
                        <h2></h2>
                        <a class="close" href="schedule.php">&times;</a>
                        <div class="content">
                        </div>
                        <div class="abc scroll" style="display: flex;justify-content: center;">
                            <table width="80%" class="sub-table scrolldown add-doc-form-container" border="0">
                                <tr>
                                    <td>
                                        <p style="padding: 0;margin: 0;text-align: left;font-size: 25px;font-weight: 500;">Xem chi tiết.</p><br><br>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="label-td" colspan="2">
                                        <label for="name" class="form-label">Tiêu đề phiên: </label>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="label-td" colspan="2">
                                        '.$title.'<br><br>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="label-td" colspan="2">
                                        <label for="Email" class="form-label">Bác sĩ của buổi này: </label>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="label-td" colspan="2">
                                    '.$docname.'<br><br>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="label-td" colspan="2">
                                        <label for="nic" class="form-label">Lịch hẹn: </label>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="label-td" colspan="2">
                                    '.$scheduledate.'<br><br>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="label-td" colspan="2">
                                        <label for="Tele" class="form-label">Thời gian dự kiến: </label>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="label-td" colspan="2">
                                    '.$scheduletime.'<br><br>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="label-td" colspan="2">
                                        <label for="spec" class="form-label"><b>Những bệnh nhân đã đăng ký buổi này:</b> ('.$result12->num_rows."/".$nop.')</label>
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
                                                        <th class="table-headin">
                                                            Mã bệnh nhân
                                                        </th>
                                                        <th class="table-headin">
                                                            Tên bệnh nhân
                                                        </th>
                                                        <th class="table-headin">
                                                        Số cuộc hẹn
                                                        </th>
                                                        <th class="table-headin">
                                                            SĐT
                                                        </th>
                                                    </tr>
                                                </thead>
                                                <tbody>';

            // Duyệt kết quả của truy vấn và in ra từng dòng thông tin bệnh nhân
            $result= $database->query($sqlmain12);
            if($result->num_rows==0){
                // In ra thông báo nếu không có bệnh nhân nào đăng ký
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
            } else {
                // In ra thông tin của từng bệnh nhân
                for ($x=0; $x<$result->num_rows;$x++){
                    $row=$result->fetch_assoc();
                    $apponum=$row["apponum"];
                    $pid=$row["pid"];
                    $pname=$row["pname"];
                    $ptel=$row["ptel"];
                    echo '<tr style="text-align:center;">
                            <td>'.substr($pid,0,15).'</td>
                            <td style="font-weight:600;padding:25px">'.substr($pname,0,25).'</td >
                            <td style="text-align:center;font-size:23px;font-weight:500; color: var(--btnnicetext);">'.$apponum.'</td>
                            <td>'.substr($ptel,0,25).'</td>
                        </tr>';
                }
            }        

            // Kết thúc bảng và HTML của popup hiển thị chi tiết phiên và danh sách bệnh nhân đã đăng ký
            echo '              </tbody>
                                </table>
                            </div>
                        </center>
                    </td> 
                </tr>
            </table>
            </div>
        </center>
        <br><br>
        </div>
        </div>
        ';  
    }
}
?>
</div>
</body>
</html>
