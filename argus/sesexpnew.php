<?php 
	$conn=mysqli_connect("localhost", "payloader", "wY#UcYxpo659$6jzsHg","mqttdata") or die(mysqli_error()); 
	date_default_timezone_set('Asia/Kolkata');
	$data = mysqli_query($conn, "SELECT * FROM users WHERE status = '1' AND log_status = '1'");
	$row = mysqli_fetch_assoc($data); 
	$date = $row['logintoken']; 	
	$firstdate = date('Y-m-d H:i:s', time());
	
	$minutes = round(abs(strtotime($date) - strtotime($firstdate)) / 60);	
	if($minutes > 10)
	{
		echo $row['id']; 
		$data = mysqli_query($conn, "UPDATE users SET log_status = '0' WHERE id = '".$row['id']."'");
		$logouttime=strtotime($firstdate);
		$datalog = mysqli_query($conn, "UPDATE log_details SET updated_at=$logouttime WHERE userid = '".$row['id']."'");
	}
	
//echo "UPDATE log_details SET updated_at=$logouttime WHERE userid = '".$row['id']."'";	
?>