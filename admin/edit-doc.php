
<?php
    // Import database
    include("../connection.php");

    // Xử lý khi có yêu cầu POST được gửi đi
    if($_POST){
        // Lấy thông tin từ form POST
        $name=$_POST['name'];
        $nic=$_POST['nic'];
        $oldemail=$_POST["oldemail"];
        $spec=$_POST['spec'];
        $email=$_POST['email'];
        $tele=$_POST['Tele'];
        $password=$_POST['password'];
        $cpassword=$_POST['cpassword'];
        $id=$_POST['id00'];
        
        // Kiểm tra xem mật khẩu và mật khẩu xác nhận có khớp nhau không
        if ($password==$cpassword){
            $error='3';
            
            // Truy vấn để lấy id của bác sĩ
            $result= $database->query("select doctor.docid from doctor inner join webuser on doctor.docemail=webuser.email where webuser.email='$email';");
            if($result->num_rows==1){
                // Nếu email đã tồn tại cho một bác sĩ khác, gán error và lưu id của bác sĩ đó
                $id2=$result->fetch_assoc()["docid"];
            }else{
                // Nếu email chưa được sử dụng bởi bác sĩ khác, gán id2 bằng id của bác sĩ hiện tại
                $id2=$id;
            }
            
            // Nếu id của bác sĩ thay đổi (tức là email mới đã tồn tại trong hệ thống)
            if($id2!=$id){
                $error='1';
            }else{
                // Cập nhật thông tin bác sĩ trong cơ sở dữ liệu
                $sql1="update doctor set docemail='$email',docname='$name',docpassword='$password',docnic='$nic',doctel='$tele',specialties=$spec where docid=$id ;";
                $database->query($sql1);
                
                // Cập nhật email trong bảng webuser
                $sql1="update webuser set email='$email' where email='$oldemail' ;";
                $database->query($sql1);
                
                $error= '4';
            }
            
        }else{
            $error='2';
        }
    }else{
        $error='3';
    }

    // Chuyển hướng đến trang doctors sau khi xử lý
    header("location: doctors.php?action=edit&error=".$error."&id=".$id);
?>

