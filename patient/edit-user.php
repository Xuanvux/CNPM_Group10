<?php
    
    //import database
    include("../connection.php");

    // Xử lý yêu cầu POST
    if($_POST){
        // Lấy dữ liệu từ form POST.
        $result= $database->query("select * from webuser");
        $name=$_POST['name'];
        $nic=$_POST['nic'];
        $oldemail=$_POST["oldemail"];
        $address=$_POST['address'];
        $email=$_POST['email'];
        $tele=$_POST['Tele'];
        $password=$_POST['password'];
        $cpassword=$_POST['cpassword'];
        $id=$_POST['id00'];
        
        // Kiểm tra mật khẩu và mật khẩu xác nhận có khớp nhau không
        if ($password==$cpassword){
            $error='3';

            // Truy vấn để kiểm tra xem email đã tồn tại trong bảng patient hay chưa
            $sqlmain= "select patient.pid from patient inner join webuser on patient.pemail=webuser.email where webuser.email=?;";
            $stmt = $database->prepare($sqlmain);
            $stmt->bind_param("s",$email);
            $stmt->execute();
            $result = $stmt->get_result();

            // Nếu email đã tồn tại trong bảng patient, lấy ID của bản ghi tương ứng
            if($result->num_rows==1){
                $id2=$result->fetch_assoc()["pid"];
            }else{
                $id2=$id;
            }

            // Kiểm tra xem ID mới và ID cũ có khác nhau không
            if($id2!=$id){
                $error='1';
            }else{
                // Cập nhật thông tin bệnh nhân và người dùng trong cơ sở dữ liệu
                $sql1="update patient set pemail='$email',pname='$name',ppassword='$password',pnic='$nic',ptel='$tele',paddress='$address' where pid=$id ;";
                $database->query($sql1);
                
                $sql1="update webuser set email='$email' where email='$oldemail' ;";
                $database->query($sql1);
                
                $error= '4';
            } 
        }else{
            // Nếu mật khẩu không khớp, gán mã lỗi là 2
            $error='2';
        }
    }else{
        // Nếu không có yêu cầu POST, gán mã lỗi là 3
        $error='3';
    }

    // Chuyển hướng người dùng về trang cài đặt với mã lỗi và ID được truyền đi
    header("location: settings.php?action=edit&error=".$error."&id=".$id);
?>
