<?php
	error_reporting(E_ALL);
	ini_set('display_errors', 1);
	$conn=mysqli_connect("localhost", "payloader", "wY#UcYxpo659$6jzsHg","mqttdata") or die(mysqli_error()); 
$resultusers = mysqli_query($conn, "SELECT * FROM users");
while($rs = mysqli_fetch_assoc($resultusers)){
$agentid=$rs['id'];
$table='dbo_payloaderalgorithmtemp'.$agentid;

$result = mysqli_query($conn, "SELECT * FROM algorithm_sensor join sensors on algorithm_sensor.sensor=sensors.id  JOIN algorithm ON algorithm_sensor.algorithm_id = algorithm.id where userid=$agentid");
echo "SELECT * FROM algorithm_sensor join sensors on algorithm_sensor.sensor=sensors.id  JOIN algorithm ON algorithm_sensor.algorithm_id = algorithm.id where userid=$agentid";
$slarr=array();
while( $row = $result->fetch_array() )
{
    
    $slarr[]="'".$row["sensor_id"]."'";
}

print_r($slarr);

	echo $ids = implode(', ', $slarr);
	
	
	
//echo $sql = "SELECT *FROM dbo_payloaderalgorithmtemp WHERE processedflag = 0 and sensor_id IN ($ids) ORDER BY id ASC";
$sql = "SELECT *FROM $table WHERE processedflag = 0 and sensor_id IN ($ids) ORDER BY id ASC";

	$data = mysqli_query($conn,$sql);
	
while($gd = mysqli_fetch_assoc($data)){
	$value = $gd["value"];
	$datatime=$gd["time"];
	//print_r($gd);
	//die;
	$firstval = $value;
	$sensorname = $gd["sensor_id"];
	$gdid=$gd["id"];
	//$sql = mysqli_query($conn, "SELECT * FROM algorithm JOIN algorithm_sensor ON algorithm_sensor.algorithm_id = algorithm.id WHERE algorithm.moreconditionflag = '0' and userid=$agentid");
$sql1 = mysqli_query($conn, "SELECT algorithm.id,userid,created_at,choose,min_value,max_value,algorithm_id,sensor,hub,groupid,value,condition1,algorithm_id FROM algorithm JOIN algorithm_sensor ON algorithm_sensor.algorithm_id = algorithm.id WHERE algorithm.moreconditionflag = '0' and userid=$agentid");


	while($nd = mysqli_fetch_assoc($sql1))
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
			$algtime=$nd['created_at'];
            if (strtotime($datatime)>=strtotime($algtime)){
			if(($value >= $nd['min_value']) && ($value <= $nd['max_value']) && ( $sensorname==$sensornamecond))
			{
				$algdatas = mysqli_query($conn, "SELECT * FROM algorithm WHERE id = '".$algid."' ORDER BY id ASC LIMIT 1");
				$algdata = mysqli_fetch_assoc($algdatas);
				$userid = $algdata['userid'];
				$sql = mysqli_query($conn, "INSERT INTO userdatamessagesagent (userid, algorithmid, payloaderid, sensreading, formula, noofcond, firstcondor, fcondgrp, fcondhub, fcondsens) VALUES ('".$userid."', '".$algid."', '".$gdid."', '".$firstval."', '".$formula."', '1', '".$firstcondor."', '".$fcondgrp."', '".$fcondhub."', '".$fcondsens."','".$sensid."')");
			}
			}
//new code brace;

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

					$algtime=$nd['created_at'];
            if (strtotime($datatime)>=strtotime($algtime)){
					$algid = $nd['algorithm_id'];
					$algdatas = mysqli_query($conn, "SELECT * FROM algorithm WHERE id = '".$algid."' ORDER BY id ASC LIMIT 1");
					$algdata = mysqli_fetch_assoc($algdatas);
					$userid = $algdata['userid'];
					$formula = "None-<";
					$insertmsg = mysqli_query($conn, "INSERT INTO userdatamessagesagent (userid, algorithmid, payloaderid, sensreading, formula, noofcond, firstcondor, fcondgrp, fcondhub, fcondsens,user_sensor_id) VALUES ('".$userid."', '".$algid."', '".$gdid."', '".$firstval."', '".$formula."', '1', '".$firstcondor."', '".$fcondgrp."', '".$fcondhub."', '".$fcondsens."','".$sensid."')");

}

				}
			}
			if(($nd['condition1'] == 2) && ($sensorname == $sensornamecond)) 
			{
				echo $formula = "None->";
				if ($value > $nd['value'])
				{
$algtime=$nd['created_at'];
            if (strtotime($datatime)>=strtotime($algtime)){
					//die();
					$algid = $nd['algorithm_id'];
					$algdatas = mysqli_query($conn, "SELECT * FROM algorithm WHERE id = '".$algid."' ORDER BY id ASC LIMIT 1");
					$algdata = mysqli_fetch_assoc($algdatas);
					echo $userid = $algdata['userid'];

					
					$insertmsg = mysqli_query($conn, "INSERT INTO userdatamessagesagent (userid, algorithmid, payloaderid, sensreading, formula, noofcond, firstcondor, fcondgrp, fcondhub, fcondsens,user_sensor_id) VALUES ('".$userid."', '".$algid."', '".$gdid."', '".$firstval."', '".$formula."', '1', '".$firstcondor."', '".$fcondgrp."', '".$fcondhub."', '".$fcondsens."','".$sensid."')");
				}
				}
			}
			if(($nd['condition1'] == 3) && ($sensorname == $sensornamecond)) 
			{
				$formula = "None-<=";
				if ($value <= $nd['value'])
				{

					$algtime=$nd['created_at'];
            if (strtotime($datatime)>=strtotime($algtime)){
					$algid = $nd['algorithm_id'];
					$algdatas = mysqli_query($conn, "SELECT * FROM algorithm WHERE id = '".$algid."' ORDER BY id ASC LIMIT 1");
					$algdata = mysqli_fetch_assoc($algdatas);
					$userid = $algdata['userid'];
					$insertmsg = mysqli_query($conn, "INSERT INTO userdatamessagesagent (userid, algorithmid, payloaderid, sensreading, formula, noofcond, firstcondor, fcondgrp, fcondhub, fcondsens,user_sensor_id) VALUES ('".$userid."', '".$algid."', '".$gdid."', '".$firstval."', '".$formula."', '1', '".$firstcondor."', '".$fcondgrp."', '".$fcondhub."', '".$fcondsens."','".$sensid."')");
				}
				}
			}
			if(($nd['condition1'] == 4) && ($sensorname == $sensornamecond)) 
			{
				$formula = "None->=";
				if ($value >= $nd['value'])
				{
					$algtime=$nd['created_at'];
            if (strtotime($datatime)>=strtotime($algtime)){
					$algid = $nd['algorithm_id'];
					$algdatas = mysqli_query($conn, "SELECT * FROM algorithm WHERE id = '".$algid."' ORDER BY id ASC LIMIT 1");
					$algdata = mysqli_fetch_assoc($algdatas);
					$userid = $algdata['userid'];
					$insertmsg = mysqli_query($conn, "INSERT INTO userdatamessagesagent (userid, algorithmid, payloaderid, sensreading, formula, noofcond, firstcondor, fcondgrp, fcondhub, fcondsens,user_sensor_id) VALUES ('".$userid."', '".$algid."', '".$gdid."', '".$firstval."', '".$formula."', '1', '".$firstcondor."', '".$fcondgrp."', '".$fcondhub."', '".$fcondsens."','".$sensid."')");
				}
				}
			}
			if(($nd['condition1'] == 5) && ($sensorname == $sensornamecond)) 
			{
				$formula = "None-==";
				if ($value == $nd['value'])
				{
					$algtime=$nd['created_at'];
            if (strtotime($datatime)>=strtotime($algtime)){
					$algid = $nd['algorithm_id'];
					$algdatas = mysqli_query($conn, "SELECT * FROM algorithm WHERE id = '".$algid."' ORDER BY id ASC LIMIT 1");
					$algdata = mysqli_fetch_assoc($algdatas);
					$userid = $algdata['userid'];
					$insertmsg = mysqli_query($conn, "INSERT INTO userdatamessagesagent (userid, algorithmid, payloaderid, sensreading, formula, noofcond, firstcondor, fcondgrp, fcondhub, fcondsens,user_sensor_id) VALUES ('".$userid."', '".$algid."', '".$gdid."', '".$firstval."', '".$formula."', '1', '".$firstcondor."', '".$fcondgrp."', '".$fcondhub."', '".$fcondsens."','".$sensid."')");
}

				}
			}
		}
	}
	$dbovalue = $gd['id'];
	


//$deldata=mysqli_query($conn, "delete from  dbo_payloaderalgorithmtemp WHERE id = '".$dbovalue."'");

$deldata=mysqli_query($conn, "delete from $table WHERE id = '".$dbovalue."'");

}


//$sql = "delete FROM dbo_payloaderalgorithmtemp WHERE sensor_id not IN (".implode(',',$slarr).")";

$sql = "delete FROM $table WHERE sensor_id not IN (".implode(',',$slarr).")";

$getdatadel=mysqli_query($conn,$sql);
//new loop end;

}
	echo "1";
?>