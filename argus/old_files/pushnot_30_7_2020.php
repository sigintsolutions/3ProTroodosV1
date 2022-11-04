<?php
	error_reporting(E_ALL);
	ini_set('display_errors', 1);
	$conn=mysqli_connect("localhost", "payloader", "wY#UcYxpo659$6jzsHg","mqttdata") or die(mysqli_error()); 

//$sensorslist=DB::table('algorithm_sensor')->join('sensors', 'algorithm_sensor.sensor', '=', 'sensors.id')->get();
$result = mysqli_query($conn, "SELECT * FROM algorithm_sensor join sensors on algorithm_sensor.sensor=sensors.id");
$slarr=array();
while( $row = $result->fetch_array() )
{
    //echo $row['FirstName'] . " " . $row['LastName'];
    //echo "<br />";
    $slarr[]="'".$row["sensor_id"]."'";
}

print_r($slarr);
//die();
/*foreach($sensorslist as $sl){
$slarr[]=$sl->sensor_id;
}*/
	/*$data = mysqli_query($conn, "SELECT * FROM dbo_payloaderalgorithmtemp WHERE processedflag = '0' WHERE sensor_id IN (".implode(',',$slarr).") ORDER BY id ASC LIMIT 1");*/
	echo $ids = implode(', ', $slarr);
	
	
	//echo $sql = "SELECT *FROM dbo_payloaderalgorithmtemp WHERE processedflag = 0 and sensor_id IN ($ids) ORDER BY id ASC LIMIT 1";

echo $sql = "SELECT *FROM dbo_payloaderalgorithmtemp WHERE processedflag = 0 and sensor_id IN ($ids) ORDER BY id ASC";


	$data = mysqli_query($conn,$sql);
	
while($gd = mysqli_fetch_assoc($data)){
	$value = $gd["value"];
	print_r($gd);
	//die;
	$firstval = $value;
	$sensorname = $gd["sensor_id"];
	$gdid=$gd["id"];
	$sql = mysqli_query($conn, "SELECT * FROM algorithm JOIN algorithm_sensor ON algorithm_sensor.algorithm_id = algorithm.id WHERE algorithm.moreconditionflag = '0'");
	while($nd = mysqli_fetch_assoc($sql))
	{
		if($nd['choose'] == 1)
		{
			$minvalue = $nd['min_value'];
			$maxvalue = $nd['max_value'];
			$algid = $nd['algorithm_id'];
			$sensid = $nd['sensor'];
			$firstcondor = 0;
			$fcondgrp = $nd['groupid'];
			$fcondhub = $nd['hub'];
			$fcondsens = $nd['sensor'];
			$sensdts = mysqli_query($conn, "SELECT * FROM sensors WHERE id = '".$sensid."' ORDER BY id ASC LIMIT 1");
			$sensdt = mysqli_fetch_assoc($sensdts);
			$sensornamecond = $sensdt['sensor_id'];
			$formula = "None-Min,Max";
			if(($value >= $nd['min_value']) && ($value <= $nd['max_value']) && ( $sensorname==$sensornamecond))
			{
				$algdatas = mysqli_query($conn, "SELECT * FROM algorithm WHERE id = '".$algid."' ORDER BY id ASC LIMIT 1");
				$algdata = mysqli_fetch_assoc($algdatas);
				$userid = $algdata['userid'];
				$sql = mysqli_query($conn, "INSERT INTO userdatamessages (userid, algorithmid, payloaderid, sensreading, formula, noofcond, firstcondor, fcondgrp, fcondhub, fcondsens) VALUES ('".$userid."', '".$algid."', '".$gdid."', '".$firstval."', '".$formula."', '1', '".$firstcondor."', '".$fcondgrp."', '".$fcondhub."', '".$fcondsens."','".$sensid."')");
			}
		}
		else 
		{
			$sensid = $nd['sensor'];
			$sensdts = mysqli_query($conn, "SELECT * FROM sensors WHERE id = '".$sensid."' ORDER BY id ASC LIMIT 1");
			$sensdt = mysqli_fetch_assoc($sensdts);
			$firstcondor = 0;
			$fcondgrp = $nd['groupid'];
			$fcondhub = $nd['hub'];
			$fcondsens = $nd['sensor'];
			$sensornamecond = $sensdt['sensor_id'];
			if(($nd['condition1'] == 1) && ($sensorname == $sensornamecond)) 
			{
				if($value < $nd['value'])
				{
					$algid = $nd['algorithm_id'];
					$algdatas = mysqli_query($conn, "SELECT * FROM algorithm WHERE id = '".$algid."' ORDER BY id ASC LIMIT 1");
					$algdata = mysqli_fetch_assoc($algdatas);
					$userid = $algdata['userid'];
					$formula = "None-<";
					$insertmsg = mysqli_query($conn, "INSERT INTO userdatamessages (userid, algorithmid, payloaderid, sensreading, formula, noofcond, firstcondor, fcondgrp, fcondhub, fcondsens,user_sensor_id) VALUES ('".$userid."', '".$algid."', '".$gdid."', '".$firstval."', '".$formula."', '1', '".$firstcondor."', '".$fcondgrp."', '".$fcondhub."', '".$fcondsens."','".$sensid."')");
				}
			}
			if(($nd['condition1'] == 2) && ($sensorname == $sensornamecond)) 
			{
				echo $formula = "None->";
				if ($value > $nd['value'])
				{

					//die();
					$algid = $nd['algorithm_id'];
					$algdatas = mysqli_query($conn, "SELECT * FROM algorithm WHERE id = '".$algid."' ORDER BY id ASC LIMIT 1");
					$algdata = mysqli_fetch_assoc($algdatas);
					echo $userid = $algdata['userid'];

					//die();
					echo $inssql="INSERT INTO userdatamessages (userid, algorithmid, payloaderid, sensreading, formula, noofcond, firstcondor, fcondgrp, fcondhub, fcondsens,user_sensor_id) VALUES ('".$userid."', '".$algid."', '".$gdid."', '".$firstval."', '".$formula."', '1', '".$firstcondor."', '".$fcondgrp."', '".$fcondhub."', '".$fcondsens."','".$sensid."')";
					//die();
					$insertmsg = mysqli_query($conn, "INSERT INTO userdatamessages (userid, algorithmid, payloaderid, sensreading, formula, noofcond, firstcondor, fcondgrp, fcondhub, fcondsens,user_sensor_id) VALUES ('".$userid."', '".$algid."', '".$gdid."', '".$firstval."', '".$formula."', '1', '".$firstcondor."', '".$fcondgrp."', '".$fcondhub."', '".$fcondsens."','".$sensid."')");
				}
			}
			if(($nd['condition1'] == 3) && ($sensorname == $sensornamecond)) 
			{
				$formula = "None-<=";
				if ($value <= $nd['value'])
				{
					$algid = $nd['algorithm_id'];
					$algdatas = mysqli_query($conn, "SELECT * FROM algorithm WHERE id = '".$algid."' ORDER BY id ASC LIMIT 1");
					$algdata = mysqli_fetch_assoc($algdatas);
					$userid = $algdata['userid'];
					$insertmsg = mysqli_query($conn, "INSERT INTO userdatamessages (userid, algorithmid, payloaderid, sensreading, formula, noofcond, firstcondor, fcondgrp, fcondhub, fcondsens,user_sensor_id) VALUES ('".$userid."', '".$algid."', '".$gdid."', '".$firstval."', '".$formula."', '1', '".$firstcondor."', '".$fcondgrp."', '".$fcondhub."', '".$fcondsens."','".$sensid."')");
				}
			}
			if(($nd['condition1'] == 4) && ($sensorname == $sensornamecond)) 
			{
				$formula = "None->=";
				if ($value >= $nd['value'])
				{
					$algid = $nd['algorithm_id'];
					$algdatas = mysqli_query($conn, "SELECT * FROM algorithm WHERE id = '".$algid."' ORDER BY id ASC LIMIT 1");
					$algdata = mysqli_fetch_assoc($algdatas);
					$userid = $algdata['userid'];
					$insertmsg = mysqli_query($conn, "INSERT INTO userdatamessages (userid, algorithmid, payloaderid, sensreading, formula, noofcond, firstcondor, fcondgrp, fcondhub, fcondsens,user_sensor_id) VALUES ('".$userid."', '".$algid."', '".$gdid."', '".$firstval."', '".$formula."', '1', '".$firstcondor."', '".$fcondgrp."', '".$fcondhub."', '".$fcondsens."','".$sensid."')");
				}
			}
			if(($nd['condition1'] == 5) && ($sensorname == $sensornamecond)) 
			{
				$formula = "None-==";
				if ($value == $nd['value'])
				{
					$algid = $nd['algorithm_id'];
					$algdatas = mysqli_query($conn, "SELECT * FROM algorithm WHERE id = '".$algid."' ORDER BY id ASC LIMIT 1");
					$algdata = mysqli_fetch_assoc($algdatas);
					$userid = $algdata['userid'];
					$insertmsg = mysqli_query($conn, "INSERT INTO userdatamessages (userid, algorithmid, payloaderid, sensreading, formula, noofcond, firstcondor, fcondgrp, fcondhub, fcondsens,user_sensor_id) VALUES ('".$userid."', '".$algid."', '".$gdid."', '".$firstval."', '".$formula."', '1', '".$firstcondor."', '".$fcondgrp."', '".$fcondhub."', '".$fcondsens."','".$sensid."')");
				}
			}
		}
	}
	$dbovalue = $gd['id'];
	//$updata = mysqli_query($conn, "UPDATE dbo_payloaderalgorithmtemp SET processedflag = '1' WHERE id = '".$dbovalue."'");


$deldata=mysqli_query($conn, "delete from  dbo_payloaderalgorithmtemp WHERE id = '".$dbovalue."'");

}

//$deldata=DB::table('dbo_payloaderalgorithmtemp')->where('id',$dbovalue)->delete();
//$getdatadel=DB::table('dbo_payloaderalgorithmtemp')->whereNotIn('sensor_id',$slarr)->where('processedflag',0)->delete();
//$getdatadel=mysqli_query($conn, "delete from  dbo_payloaderalgorithmtemp WHERE sensor_id not in = '".$slarr."'");
$sql = "delete FROM dbo_payloaderalgorithmtemp WHERE sensor_id not IN (".implode(',',$slarr).")";
$getdatadel=mysqli_query($conn,$sql);

	echo "1";
?>