<?php
	error_reporting(E_ALL);
	ini_set('display_errors', 1);
	$conn=mysqli_connect("localhost", "payloader", "wY#UcYxpo659$6jzsHg","mqttdata") or die(mysqli_error()); 
	$sqltime="SELECT * FROM dbo_payloadercharttemphub WHERE time BETWEEN now() - INTERVAL 30 DAY AND now()";
	$query = mysqli_query($conn,$sqltime); 
	while($rows = mysqli_fetch_array($query)) 
	{
		$sql = mysqli_query($conn, "SELECT * FROM dbo_payloadercharttemphub WHERE id != '".$rows["id"]."'");
        $fetch = mysqli_fetch_assoc($query);     
        {
            //echo $fetch['id'];
            $sql = mysqli_query($conn, "DELETE FROM dbo_payloaderalgorithmtemp WHERE id = '".$fetch['id']."'");
        }
	}
?>