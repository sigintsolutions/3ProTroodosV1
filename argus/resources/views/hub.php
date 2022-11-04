<?php
	$conn=mysqli_connect("localhost", "payloader", "wY#UcYxpo659$6jzsHg","mqttdata") or die(mysqli_error()); 
	$data = mysqli_query($conn, "SELECT hub FROM dbo_payloader GROUP BY hub");
	//$rows = array();
	while($row  = mysqli_fetch_array($data)) 
	{ 
		echo $my_array = $row['hub'];
		//print_r($my_array);
		//echo $ename = implode(',', $my_array);
		//$val = explode(',', $rows);
		//$ex = explode('')
		//echo $ename = implode(',', $val);
		// foreach($rows as $row)
		// { 
			
		// 	$ename = implode(',', $row);
		// 	//$data = mysqli_query($conn, "INSERT INTO hubdata (hub) VALUES ('".$ename."')");
		//$data = mysqli_query($conn, "UPDATE hubdata SET hub = '".$ename."' WHERE id = '1'");
		// }
	}
?>