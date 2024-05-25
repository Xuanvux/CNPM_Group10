<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/animations.css">  
    <link rel="stylesheet" href="../css/main.css">  
    <link rel="stylesheet" href="../css/admin.css">
        
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

    // Kiểm tra xem người dùng đã đăng nhập chưa
    if(isset($_SESSION["user"])){
        if(($_SESSION["user"])=="" or $_SESSION['usertype']!='a'){
            header("location: ../login.php");
        }

    }else{
        header("location: ../login.php");
    }
    
    // Import database
    include("../connection.php");

    
    ?>
    <div class="container">
        <div class="menu">
            <!-- Phần menu -->
            <table class="menu-container" border="0">
                <!-- Phần container chứa menu -->
                <tr>
                    <td style="padding:10px" colspan="2">
                        <!-- Phần tiêu đề và thông tin người dùng -->
                        <table border="0" class="profile-container">
                            <!-- Container chứa hình ảnh người dùng và thông tin -->
                            <tr>
                                <td width="30%" style="padding-left:20px" >
                                    <!-- Hình ảnh người dùng -->
                                    <img src="../img/user.png" alt="" width="100%" style="border-radius:50%">
                                </td>
                                <td style="padding:0px;margin:0px;">
                                    <!-- Thông tin người dùng -->
                                    <p class="profile-title">Admin</p>
                                    <p class="profile-subtitle">admin@gmail.com</p>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="2">
                                    <!-- Nút logout -->
                                    <a href="../logout.php" ><input type="button" value="Log out" class="logout-btn btn-primary-soft btn"></a>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
                <!-- Các dòng menu -->
                <tr class="menu-row" >
                    <td class="menu-btn menu-icon-dashbord" >
                        <!-- Đường dẫn đến trang Dashboard -->
                        <a href="index.php" class="non-style-link-menu"><div><p class="menu-text">Dashboard</p></a></div></a>
                    </td>
                </tr>
                <tr class="menu-row">
                    <td class="menu-btn menu-icon-doctor ">
                        <!-- Đường dẫn đến trang Quản lý bác sĩ -->
                        <a href="doctors.php" class="non-style-link-menu "><div><p class="menu-text">Bác sĩ</p></a></div>
                    </td>
                </tr>
                <tr class="menu-row" >
                    <td class="menu-btn menu-icon-schedule ">
                        <!-- Đường dẫn đến trang Quản lý lịch trình -->
                        <a href="schedule.php" class="non-style-link-menu"><div><p class="menu-text">Lịch trình</p></div></a>
                    </td>
                </tr>
                <tr class="menu-row">
                    <td class="menu-btn menu-icon-appoinment menu-active menu-icon-appoinment-active">
                        <!-- Đường dẫn đến trang Quản lý cuộc hẹn -->
                        <a href="appointment.php" class="non-style-link-menu non-style-link-menu-active"><div><p class="menu-text">Lịch hẹn</p></a></div>
                    </td>
                </tr>
                <tr class="menu-row" >
                    <td class="menu-btn menu-icon-patient">
                        <!-- Đường dẫn đến trang Quản lý bệnh nhân -->
                        <a href="patient.php" class="non-style-link-menu"><div><p class="menu-text">Bệnh nhân</p></a></div>
                    </td>
                </tr>

            </table>
        </div>
        <!-- Phần thân trang web -->
        <div class="dash-body">
            <!-- Phần thân trang Dashboard -->
            <table border="0" width="100%" style=" border-spacing: 0;margin:0;padding:0;margin-top:25px; ">
                <!-- Container chứa các phần của trang Dashboard -->
                <tr >
                    <td width="13%" >
                    <!-- Nút trở lại -->
                    <a href="appointment.php" ><button  class="login-btn btn-primary-soft btn btn-icon-back"  style="padding-top:11px;padding-bottom:11px;margin-left:20px;width:125px"><font class="tn-in-text">Trở lại</font></button></a>
                    </td>
                    <td>
                        <!-- Tiêu đề -->
                        <p style="font-size: 23px;padding-left:12px;font-weight: 600;">Quản lý lịch hẹn</p>                  
                    </td>
                    <td width="15%">
                        <!-- Hiển thị ngày hiện tại -->
                        <p style="font-size: 14px;color: rgb(119, 119, 119);padding: 0;margin: 0;text-align: right;">
                            Ngày hôm nay
                        </p>
                        <p class="heading-sub12" style="padding: 0;margin: 0;">
                            <?php 

                        date_default_timezone_set('Asia/Ho_Chi_Minh');

                        $today = date('Y-m-d');
                        echo $today;

                        $list110 = $database->query("select  * from  appointment;");

                        ?>
                        </p>
                    </td>
                    <td width="10%">
                        <!-- Nút hiển thị lịch -->
                        <button  class="btn-label"  style="display: flex;justify-content: center;align-items: center;"><img src="../img/calendar.svg" width="100%"></button>
                    </td>
                </tr>
                <!-- Phần tiêu đề -->
                <tr>
                    <td colspan="4" style="padding-top:10px;width: 100%;" >
                    
                        <p class="heading-main12" style="margin-left: 45px;font-size:18px;color:rgb(49, 49, 49)">Tất cả lịch hẹn (<?php echo $list110->num_rows; ?>)</p>
                    </td>
                    
                </tr>
                <!-- Phần lọc -->
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
                        <form action="" method="post">
                            
                            <input type="date" name="sheduledate" id="date" class="input-text filter-container-items" style="margin: 0;width: 95%;">

                        </td>
                        <td width="5%" style="text-align: center;">
                        Bác sĩ:
                        </td>
                        <td width="30%">
                        <select name="docid" id="" class="box filter-container-items" style="width:90% ;height: 37px;margin: 0;" >
                            <option value="" disabled selected hidden>Chọn tên bác sĩ trong danh sách</option><br/>
                                
                            <?php 
                             
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
                        </form>
                    </td>

                    </tr>
                            </table>

                        </center>
                    </td>
                    
                </tr>
                
                <?php
                    // Kiểm tra nếu có dữ liệu được gửi đi từ form
                    if($_POST){
                        //print_r($_POST);
                        $sqlpt1="";
                        if(!empty($_POST["sheduledate"])){
                            $sheduledate=$_POST["sheduledate"];
                            $sqlpt1=" schedule.scheduledate='$sheduledate' ";
                        }


                        $sqlpt2="";
                        if(!empty($_POST["docid"])){
                            $docid=$_POST["docid"];
                            $sqlpt2=" doctor.docid=$docid ";
                        }
                        //echo $sqlpt2;
                        //echo $sqlpt1;
                        $sqlmain= "select appointment.appoid,schedule.scheduleid,schedule.title,doctor.docname,patient.pname,schedule.scheduledate,schedule.scheduletime,appointment.apponum,appointment.appodate from schedule inner join appointment on schedule.scheduleid=appointment.scheduleid inner join patient on patient.pid=appointment.pid inner join doctor on schedule.docid=doctor.docid";
                        $sqllist=array($sqlpt1,$sqlpt2);
                        $sqlkeywords=array(" where "," and ");
                        $key2=0;
                        foreach($sqllist as $key){

                            if(!empty($key)){
                                $sqlmain.=$sqlkeywords[$key2].$key;
                                $key2++;
                            };
                        };
                        //echo $sqlmain;

                        
                        
                        //
                    }else{
                        $sqlmain= "select appointment.appoid,schedule.scheduleid,schedule.title,doctor.docname,patient.pname,schedule.scheduledate,schedule.scheduletime,appointment.apponum,appointment.appodate from schedule inner join appointment on schedule.scheduleid=appointment.scheduleid inner join patient on patient.pid=appointment.pid inner join doctor on schedule.docid=doctor.docid  order by schedule.scheduledate desc";

                    }



                ?>
                  
                <tr>
                   <td colspan="4">
                       <center>
                        <!-- Bảng danh sách lịch hẹn -->
                        <div class="abc scroll">
                        <table width="93%" class="sub-table scrolldown" border="0">
                        <thead>
                        <tr>
                                <th class="table-headin">
                                    Tên bệnh nhân
                                </th>
                                <th class="table-headin">
                                    
                                Số cuộc hẹn
                                    
                                </th>
                               
                                
                                <th class="table-headin">
                                    Bác sĩ
                                </th>
                                <th class="table-headin">
                                    
                                
                                Tiêu đề phiên
                                    
                                    </th>
                                
                                <th class="table-headin" style="font-size:10px">
                                    
                                Ngày và giờ của phiên
                                    
                                </th>
                                
                                <th class="table-headin">
                                    
                                Ngày hẹn
                                    
                                </th>
                                
                                <th class="table-headin">
                                    
                                    Sự kiện
                                    
                                </tr>
                        </thead>
                        <tbody>
                        
                            <?php

                                
                                $result= $database->query($sqlmain);

                                if($result->num_rows==0){
                                    // Hiển thị thông báo khi không tìm thấy dữ liệu
                                    echo '<tr>
                                    <td colspan="7">
                                    <br><br><br><br>
                                    <center>
                                    <img src="../img/notfound.svg" width="25%">
                                    
                                    <br>
                                    <p class="heading-main12" style="margin-left: 45px;font-size:20px;color:rgb(49, 49, 49)">Chúng tôi không thể tìm thấy bất cứ điều gì liên quan đến từ khóa của bạn !</p>
                                    <a class="non-style-link" href="appointment.php"><button  class="login-btn btn-primary-soft btn"  style="display: flex;justify-content: center;align-items: center;margin-left:20px;">&nbsp; Xem tất cả cuộc hẹn &nbsp;</font></button>
                                    </a>
                                    </center>
                                    <br><br><br><br>
                                    </td>
                                    </tr>';
                                    
                                }
                                else{
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
                                    // Hiển thị thông tin lịch hẹn
                                    echo '<tr >
                                        <td style="font-weight:600;"> &nbsp;'.
                                        
                                        substr($pname,0,25)
                                        .'</td >
                                        <td style="text-align:center;font-size:23px;font-weight:500; color: var(--btnnicetext);">
                                        '.$apponum.'
                                        
                                        </td>
                                        <td>
                                        '.substr($docname,0,25).'
                                        </td>
                                        <td>
                                        '.substr($title,0,15).'
                                        </td>
                                        <td style="text-align:center;font-size:12px;">
                                            '.substr($scheduledate,0,10).' <br>'.substr($scheduletime,0,5).'
                                        </td>
                                        
                                        <td style="text-align:center;">
                                            '.$appodate.'
                                        </td>

                                        <td>
                                        <div style="display:flex;justify-content: center;">
                                        
                                        <!--<a href="?action=view&id='.$appoid.'" class="non-style-link"><button  class="btn-primary-soft btn button-icon btn-view"  style="padding-left: 40px;padding-top: 12px;padding-bottom: 12px;margin-top: 10px;"><font class="tn-in-text">Xem</font></button></a>
                                       &nbsp;&nbsp;&nbsp;-->
                                       <!-- Nút hủy lịch hẹn -->
                                       <a href="?action=drop&id='.$appoid.'&name='.$pname.'&session='.$title.'&apponum='.$apponum.'" class="non-style-link"><button  class="btn-primary-soft btn button-icon btn-delete"  style="padding-left: 40px;padding-top: 12px;padding-bottom: 12px;margin-top: 10px;"><font class="tn-in-text">Hủy</font></button></a>
                                       &nbsp;&nbsp;&nbsp;</div>
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
        if($action=='add-session'){

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
                                   ""
                                
                                .'</td>
                            </tr>

                            <tr>
                                <td>
                                    <p style="padding: 0;margin: 0;text-align: left;font-size: 25px;font-weight: 500;">Thêm phiên mới.</p><br>
                                </td>
                            </tr>
                            <tr>
                                <td class="label-td" colspan="2">
                                <form action="add-session.php" method="POST" class="add-new-form">
                                    <label for="title" class="form-label">Tiêu đề phiên : </label>
                                </td>
                            </tr>
                            <tr>
                                <td class="label-td" colspan="2">
                                    <input type="text" name="title" class="input-text" placeholder="Tên của phiên này" required><br>
                                </td>
                            </tr>
                            <tr>
                                
                                <td class="label-td" colspan="2">
                                    <label for="docid" class="form-label">Chọn Bác sĩ: </label>
                                </td>
                            </tr>
                            <tr>
                                <td class="label-td" colspan="2">
                                    <select name="docid" id="" class="box" >
                                    <option value="" disabled selected hidden>Chọn tên Bác sĩ từ danh sách</option><br/>';
                                        
        
                                        $list11 = $database->query("select  * from  doctor;");
        
                                        for ($y=0;$y<$list11->num_rows;$y++){
                                            $row00=$list11->fetch_assoc();
                                            $sn=$row00["docname"];
                                            $id00=$row00["docid"];
                                            echo "<option value=".$id00.">$sn</option><br/>";
                                        };
        
        
        
                                        
                        echo     '       </select><br><br>
                                </td>
                            </tr>
                            <tr>
                                <td class="label-td" colspan="2">
                                    <label for="nop" class="form-label">Số bệnh nhân/Số cuộc hẹn : </label>
                                </td>
                            </tr>
                            <tr>
                                <td class="label-td" colspan="2">
                                    <input type="number" name="nop" class="input-text" required><br>
                                </td>
                            </tr>
                            
                            <tr>
                                <td>
                                <button type="submit" class="login-btn btn-primary-soft btn btn-add-new" style="margin-top: 20px;padding-top: 10px;padding-bottom: 10px;width: 40%;"><font class="tn-in-text">Thêm</font></button>
                                </form>
                                </td>
                                <td>
                                <a href="appointment.php"><button  class="login-btn btn-primary-soft btn btn-cancel"  style="margin-top: 20px;padding-top: 10px;padding-bottom: 10px;width: 40%;"><font class="tn-in-text">Hủy</font></button></a>
                                
                                </td>
                            </tr>
                            <tr>
                                <td class="label-td" colspan="2">
                                </td>
                            </tr>
                            
                        </table>
                        </div>
                        </div>
                        
                    
                    </center>
                    </div>
                </div>
            ';

        }

        if($action=='drop'){
            $name=$_GET["name"];
            $session=$_GET["session"];
            $apponum=$_GET["apponum"];
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
                                   ""
                                
                                .'</td>
                            </tr>

                            <tr>
                                <td>
                                    <p style="padding: 0;margin: 0;text-align: left;font-size: 25px;font-weight: 500;">Bạn chắc chắn muốn hủy cuộc hẹn này chứ?</p><br>
                                    <p style="padding: 0;margin: 0;text-align: left;font-size: 17px;font-weight: 500;color:grey">Cuộc hẹn với bệnh nhân: '.$name.'</p><br>
                                    <p style="padding: 0;margin: 0;text-align: left;font-size: 17px;font-weight: 500;color:grey">Phiên: '.$session.'</p><br>
                                </td>
                            </tr>
                            
                            <tr>
                                <td>
                                <a href="add-session.php?action=drop&name='.$name.'&session='.$session.'&id='.$id.'&apponum='.$apponum.'"><button  class="login-btn btn-primary-soft btn btn-add-new"  style="margin-top: 20px;padding-top: 10px;padding-bottom: 10px;width: 40%;"><font class="tn-in-text">Hủy</font></button></a>
                                
                                <a href="appointment.php"><button  class="login-btn btn-primary-soft btn btn-cancel"  style="margin-top: 20px;padding-top: 10px;padding-bottom: 10px;width: 40%;"><font class="tn-in-text">Quay lại</font></button></a>
                                </td>
                            </tr>
                            <tr>
                                <td class="label-td" colspan="2">
                                </td>
                            </tr>
                            
                        </table>
                        </div>
                        </div>
                        
                    
                    </center>
                    </div>
                </div>
            ';

        }

        if($action=='view'){
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
                                   ""
                                
                                .'</td>
                            </tr>

                            <tr>
                                <td>
                                    <p style="padding: 0;margin: 0;text-align: left;font-size: 25px;font-weight: 500;">Viewing appointment</p><br>
                                </td>
                            </tr>
                            
                            <tr>
                                <td class="label-td" colspan="2">
                                </td>
                            </tr>
                            
                        </table>
                        </div>
                        </div>
                        
                    
                    </center>
                    </div>
                </div>
            ';
        }

        if($action=='drop'){
            $appoid=$_GET["id"];
            //echo $appoid;
            $sqlmain= "delete from appointment where appoid=".$appoid;
            $result= $database->query($sqlmain);
            if($result){
                echo "<script>alert('Hủy cuộc hẹn thành công');window.location='appointment.php'</script>";
            }
            else{
                echo "<script>alert('Có lỗi xảy ra trong quá trình hủy cuộc hẹn');</script>";
            }
        }
    }
    

    ?>
    
</body>
</html>
