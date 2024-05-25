<?php
    //import database
    include("../connection.php");

    // Kiểm tra nếu có yêu cầu POST được gửi đi.
    if($_POST){
        // Lấy tất cả thông tin từ form POST
        $result= $database->query("select * from webuser");
        $name=$_POST['name'];
        $oldemail=$_POST["oldemail"];
        $nic=$_POST['nic'];
        $spec=$_POST['spec'];
        $email=$_POST['email'];
        $tele=$_POST['Tele'];
        $password=$_POST['password'];
        $cpassword=$_POST['cpassword'];
        $id=$_POST['id00'];
        
        // Kiểm tra xem mật khẩu và xác nhận mật khẩu có trùng khớp không
        if ($password==$cpassword){
            $error='3';
            // Kiểm tra xem email đã tồn tại trong bảng doctor chưa
            $result= $database->query("select doctor.docid from doctor inner join webuser on doctor.docemail=webuser.email where webuser.email='$email';");
            if($result->num_rows==1){
                // Nếu email đã tồn tại trong bảng doctor, lấy id của bác sĩ
                $id2=$result->fetch_assoc()["docid"];
            }else{
                // Nếu email chưa tồn tại trong bảng doctor, sử dụng id từ form
                $id2=$id;
            }
            
            echo $id2."jdfjdfdh";
            // Kiểm tra xem id từ form và id lấy từ bảng có giống nhau không
            if($id2!=$id){
                $error='1';
            }else{
                // Cập nhật thông tin của bác sĩ và người dùng trong cơ sở dữ liệu
                $sql1="update doctor set docemail='$email',docname='$name',docpassword='$password',docnic='$nic',doctel='$tele',specialties=$spec where docid=$id ;";
                $database->query($sql1);

                $sql1="update webuser set email='$email' where email='$oldemail' ;";
                $database->query($sql1);

                echo $sql1;
                $error= '4';
                
            }
            
        }else{
            $error='2';
        }
    }else{
        // Nếu không có yêu cầu POST, set giá trị lỗi là 3
        $error='3';
    }

    // Chuyển hướng đến trang cài đặt với thông báo lỗi và id của bác sĩ
    header("location: settings.php?action=edit&error=".$error."&id=".$id);
?>
