<?php 
	// Bắt đầu phiên làm việc
	session_start();

	// Gán mảng $_SESSION thành mảng rỗng để xóa tất cả các biến session
	$_SESSION = array();

	// Kiểm tra xem session có tồn tại trong cookie không, nếu có thì xóa cookie
	if (isset($_COOKIE[session_name()])) {
		setcookie(session_name(), '', time()-86400, '/');
	}

	// Hủy phiên làm việc
	session_destroy();

	// Chuyển hướng người dùng đến trang đăng nhập với action=logout trong URL
	header('Location: login.php?action=logout');
 ?>
