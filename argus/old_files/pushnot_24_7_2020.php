<?php
	error_reporting(E_ALL);
	ini_set('display_errors', 1);
	$conn=mysqli_connect("localhost", "payloader", "wY#UcYxpo659$6jzsHg","mqttdata") or die(mysqli_error()); 
	$data = mysqli_query($conn, "SELECT * FROM dbo_payloader WHERE processedflag = '0' ORDER BY id ASC LIMIT 1");
	$gd = mysqli_fetch_assoc($data);
	$value = $gd["value"];
	$firstval = $value;
	$sensorname = $gd["sensor_id"];
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
			if(($value >= $nd['min_value']) && ($value <= $nd['min_value']) && ( $sensorname==$sensornamecond))
			{
				$algdatas = mysqli_query($conn, "SELECT * FROM algorithm WHERE id = '".$algid."' ORDER BY id ASC LIMIT 1");
				$algdata = mysqli_fetch_assoc($algdatas);
				$userid = $algdata['userid'];
				$sql = mysqli_query($conn, "INSERT INTO userdatamessages (userid, algorithmid, payloaderid, sensreading, formula, noofcond, firstcondor, fcondgrp, fcondhub, fcondsens) VALUES ('".$userid."', '".$algid."', '".$gd->id."', '".$firstval."', '".$formula."', '1', '".$firstcondor."', '".$fcondgrp."', '".$fcondhub."', '".$fcondsens."')");
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
					$insertmsg = mysqli_query($conn, "INSERT INTO userdatamessages (userid, algorithmid, payloaderid, sensreading, formula, noofcond, firstcondor, fcondgrp, fcondhub, fcondsens) VALUES ('".$userid."', '".$algid."', '".$gd->id."', '".$firstval."', '".$formula."', '1', '".$firstcondor."', '".$fcondgrp."', '".$fcondhub."', '".$fcondsens."')");
				}
			}
			if(($nd['condition1'] == 2) && ($sensorname == $sensornamecond)) 
			{
				$formula = "None->";
				if ($value > $nd['value'])
				{
					$algid = $nd['algorithm_id'];
					$algdatas = mysqli_query($conn, "SELECT * FROM algorithm WHERE id = '".$algid."' ORDER BY id ASC LIMIT 1");
					$algdata = mysqli_fetch_assoc($algdatas);
					$userid = $algdata['userid'];
					$insertmsg = mysqli_query($conn, "INSERT INTO userdatamessages (userid, algorithmid, payloaderid, sensreading, formula, noofcond, firstcondor, fcondgrp, fcondhub, fcondsens) VALUES ('".$userid."', '".$algid."', '".$gd->id."', '".$firstval."', '".$formula."', '1', '".$firstcondor."', '".$fcondgrp."', '".$fcondhub."', '".$fcondsens."')");
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
					$insertmsg = mysqli_query($conn, "INSERT INTO userdatamessages (userid, algorithmid, payloaderid, sensreading, formula, noofcond, firstcondor, fcondgrp, fcondhub, fcondsens) VALUES ('".$userid."', '".$algid."', '".$gd->id."', '".$firstval."', '".$formula."', '1', '".$firstcondor."', '".$fcondgrp."', '".$fcondhub."', '".$fcondsens."')");
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
					$insertmsg = mysqli_query($conn, "INSERT INTO userdatamessages (userid, algorithmid, payloaderid, sensreading, formula, noofcond, firstcondor, fcondgrp, fcondhub, fcondsens) VALUES ('".$userid."', '".$algid."', '".$gd->id."', '".$firstval."', '".$formula."', '1', '".$firstcondor."', '".$fcondgrp."', '".$fcondhub."', '".$fcondsens."')");
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
					$insertmsg = mysqli_query($conn, "INSERT INTO userdatamessages (userid, algorithmid, payloaderid, sensreading, formula, noofcond, firstcondor, fcondgrp, fcondhub, fcondsens) VALUES ('".$userid."', '".$algid."', '".$gd->id."', '".$firstval."', '".$formula."', '1', '".$firstcondor."', '".$fcondgrp."', '".$fcondhub."', '".$fcondsens."')");
				}
			}
		}
	}
	$dbovalue = $gd['id'];
	$updata = mysqli_query($conn, "UPDATE dbo_payloader SET processedflag = '1' WHERE id = '".$dbovalue."'");
	echo "1";
?>