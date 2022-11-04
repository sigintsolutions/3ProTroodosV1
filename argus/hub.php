#!/usr/bin/php
<?php
	$conn=mysqli_connect("localhost", "payloader", "wY#UcYxpo659$6jzsHg","mqttdata") or die(mysqli_error()); 
	$data = mysqli_query($conn, "SELECT hub FROM dbo_payloader GROUP BY hub");
	
	//$i = 0;
	while($row = mysqli_fetch_assoc($data)) 
	{
		foreach($row as $key=>$value)
		{
			$s[] = $value;
		}		
	}
	echo $sval = implode(',', $s);
	//$data  = array('hub'=>$sval);
	//$value = DB::table('hubdata')->where('id', '1')->update($sval);
	$data = mysqli_query($conn, "UPDATE hubdata SET hub = '".$sval."' WHERE id = '1'");
?>