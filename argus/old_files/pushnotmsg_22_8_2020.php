<?php
	//error_reporting(0);
	ini_set('display_errors', 1);
	$conn=mysqli_connect("localhost", "payloader", "wY#UcYxpo659$6jzsHg","mqttdata") or die(mysqli_error());
$result = mysqli_query($conn, "SELECT * FROM algorithm_sensor join sensors on algorithm_sensor.sensor=sensors.id");
$slarr=array();
while( $row = $result->fetch_array() )
{
    //echo $row['FirstName'] . " " . $row['LastName'];
    //echo "<br />";
    $slarr[]="'".$row["sensor_id"]."'";
}
echo $ids = implode(', ', $slarr);

	//$data = mysqli_query($conn, "SELECT * FROM dbo_payloaderalgorithmtempandor WHERE processedflagall = '0' ORDER BY id ASC LIMIT 1");
echo $sql = "SELECT *FROM dbo_payloaderalgorithmtempandor WHERE processedflagall = 0 and sensor_id IN ($ids) ORDER BY id ASC";
$data = mysqli_query($conn,$sql);
//while($data = mysqli_query($conn,$sql)){


	while($gd = mysqli_fetch_assoc($data)){
	print_r($gd);
	//die();
	$value = $gd["value"];
	$firstval = $value;
	$secondval = $value;
	$thirdval = $value;
	$sensorname = $gd["sensor_id"];
	echo "sss-$sensorname--sss";
	$firstcondor = 0;
	$fcondgrp = 0;
	$fcondhub = 0;
	$fcondsens = 0;
	$secondcondor  =0;
	$scondgrp = 0;
	$scondhub = 0;
	$scondsens = 0;
	$tcondgrp = 0;
	$tcondhub = 0;
	$tcondsens = 0;
	$sql = mysqli_query($conn, "SELECT * FROM algorithm WHERE moreconditionflag =1");
	print_r($sql);
	//die();
	while($nd = mysqli_fetch_assoc($sql))
	{
		$allcond = mysqli_query($conn, "SELECT * FROM algorithm_sensor WHERE algorithm_id = '".$nd['id']."'");
		$algid=$nd['id'];
		$userid=$nd['userid'];
		$noofconditions = mysqli_num_rows($allcond);
		$i=0;
		if ($noofconditions==2)
		{
			echo "en---2";
//die();
			$condfirst = "";
			$opfirst = 0;
			$opfirstop = 0;
			$opsecondop = 0;
			$payval2 = 0;
			$sensornamecondfirst = 0;
			$sensornamecondsecond = 0;
			while($ac = mysqli_fetch_assoc($allcond))
			{
				if($i==0)
				{
					$condfirst = $ac['condition2'];
					$opfirst  = $ac['condition1'];
					$choosefirst = $ac['choose'];
					$minf = $ac['min_value'];
					$maxf = $ac['max_value'];
					$sensid = $ac['sensor'];
					$firstgroup = $ac['groupid'];
					$firsthub = $ac['hub'];
					$firstsensor = $ac['sensor'];
					$sensdts = mysqli_query($conn, "SELECT * FROM sensors WHERE id = '".$sensid."' ORDER BY id ASC LIMIT 1");
					$sensdt = mysqli_fetch_assoc($sensdts);
					$sensornamecondfirst=$sensdt['sensor_id'];
				}
				if($i==0)
				{
					$payval1 = $ac['value'];
					if ($opfirst==1)
					{
						$opfirstop='<';
					}
					if ($opfirst==2)
					{
						$opfirstop='>';
					}
					if ($opfirst==3)
					{
						$opfirstop='<=';
					}				
					if ($opfirst==4)
					{
						$opfirstop='>=';
					}
					if ($opfirst==5)
					{
						$opfirstop='=';
					}
				}
				if ($i==1)
				{
					$payval2 = $ac['value'];
					$opsecond = $ac['condition1'];
					$choosesecond = $ac['choose'];
					$mins = $ac['min_value'];
					$maxs = $ac['max_value'];
					$sensid = $ac['sensor'];
					$sensdts = mysqli_query($conn, "SELECT * FROM sensors WHERE id = '".$sensid."' ORDER BY id ASC LIMIT 1");
					$sensdt = mysqli_fetch_assoc($sensdts);
					$sensornamecondsecond = $sensdt['sensor_id'];
					$secondgroup = $ac['groupid'];
					$secondhub = $ac['hub'];
					$secondsensor = $ac['sensor'];
					if($opsecond == 1)
					{
						$opsecondop = '<';
					}
					if($opsecond == 2)
					{
						$opsecondop = '>';
					}
					if($opsecond == 3)
					{
						$opsecondop = '<=';
					}					
					if($opsecond == 4)
					{
						$opsecondop = '>=';
					}
					if($opsecond == 5)
					{
						$opsecondop = '=';
					}
				}
				$i++;
			}
			if($condfirst=='Or')
			{
				$fflag=0;
				$sflag=0;
				if($choosefirst==0)
				{
					$fcond=eval("return \$firstval $opfirstop \$payval1;");
				}
				else
				{
					if(($firstval >=$minf) && ($firstval <=$maxf))
					{
						$fflag=1;
						$fcond=1;
					}
				}
				if ($choosesecond==0)
				{
					$scond=eval("return \$secondval $opsecondop \$payval2;");
				}
				else
				{
					if (($secondval >=$mins) && ($secondval <=$maxs))
					$sflag=1;
					$scond=1;
				}
				$firstcondor=0;
				$secondcondor=0;
				if((($fcond) && ($sensorname==$sensornamecondfirst)) || (($scond) && ($sensorname==$sensornamecondsecond)))
				{
					if ((($fcond) && ($sensorname==$sensornamecondfirst)))
					{
						$firstcondor=1;
						$fcondgrp=$firstgroup;
						$fcondhub=$firsthub;
						$fcondsens=$firstsensor;				
					}				
					if((($scond) && ($sensorname==$sensornamecondsecond)))
					{
						$secondcondor=1;
						$scondgrp=$secondgroup;
						$scondhub=$secondhub;
						$scondsens=$secondsensor;			
					}
					$formula="Or";
					$sql = mysqli_query($conn, "INSERT INTO userdatamessages (userid, algorithmid, payloaderid, orflag, noofcond, firstcondor, seccondor, fcondgrp, fcondhub, fcondsens, scondgrp, scondhub, scondsens, sensreading, formula) VALUES ('".$userid."', '".$algid."', '".$gd['id']."', '1', '2', '".$firstcondor."', '".$secondcondor."', '".$fcondgrp."', '".$fcondhub."', '".$fcondsens."', '".$scondgrp."', '".$scondhub."', '".$scondsens."', '".$firstval."', '".$formula."')");


					$dbovalue = $gd['id'];
					//$updata = mysqli_query($conn, "UPDATE dbo_payloaderalgorithmtempandor SET processedflagall = '1' WHERE id = '".$dbovalue."'");
				}
			}
echo "$condfirst";
			//die();
			if ($condfirst == 'And')
			{
				$fflag = 0;
				$sflag = 0;
				if($choosefirst == 0)
				{
					$fcond=eval("return \$firstval $opfirstop \$payval1;");
				}
				else
				{
					if (($firstval >=$minf) && ($firstval <=$maxf))
					{
						$fflag=1;
						$fcond=1;
					}
				}				
				if($choosesecond==0)
				{
					$scond=eval("return \$secondval $opsecondop \$payval2;");
				}
				else
				{
			if (($secondval >=$mins) && ($secondval <=$maxs))
					{
						$sflag=1;
						$scond=1;
					}
				}
				echo "---$sensorname---";
				echo "before cond and-$fcond,$sensorname,$sensornamecondfirst";

				//die();
					if((($fcond) && ($sensorname==$sensornamecondfirst)) && (($scond) && ($sensorname==$sensornamecondsecond)) )
					{
						$fcondgrp = $firstgroup;
						$fcondhub = $firsthub;
						$fcondsens = $firstsensor;
						$scondgrp = $secondgroup;
						$scondhub = $secondhub;
						$scondsens = $secondsensor;			
						echo $formula="And";
						//die();
						$insertmsg = mysqli_query($conn, "INSERT INTO userdatamessages (userid, algorithmid, payloaderid, orflag, noofcond, firstcondor, seccondor, fcondgrp, fcondhub, fcondsens, scondgrp, scondhub, scondsens, sensreading, formula) VALUES ('".$userid."', '".$algid."', '".$gd['id']."', '0', '2', '".$firstcondor."', '".$secondcondor."', '".$fcondgrp."', '".$fcondhub."', '".$fcondsens."', '".$scondgrp."', '".$scondhub."', '".$scondsens."', '".$firstval."', '".$formula."')");

						echo "INSERT INTO userdatamessages (userid, algorithmid, payloaderid, orflag, noofcond, firstcondor, seccondor, fcondgrp, fcondhub, fcondsens, scondgrp, scondhub, scondsens, sensreading, formula) VALUES ('".$userid."', '".$algid."', '".$gd['id']."', '0', '2', '".$firstcondor."', '".$secondcondor."', '".$fcondgrp."', '".$fcondhub."', '".$fcondsens."', '".$scondgrp."', '".$scondhub."', '".$scondsens."', '".$firstval."', '".$formula."')";
						$dbovalue=$gd['id'];
						$dbovalue = $gd['id'];
						//$updata = mysqli_query($conn, "UPDATE dbo_payloaderalgorithmtempandor SET processedflagall = '1' WHERE id = '".$dbovalue."'");						
					}
				}
			//}
		}
		$j=0;
		if ($noofconditions==3)
		{
echo $noofconditions;
			//die();
			$condfirst="";
			$opfirst=0;
			$opfirstop=0;
			$opsecondop=0;
			$payval2=0;
			$sensornamecondfirst=0;
			$sensornamecondsecond=0;
			$sensornamecondthird=0;
			foreach ($allcond as $ac) 
			{
				if ($j==0)
				{
					$condfirst=$ac['condition2'];
					$opfirst=$ac['condition1'];
					$choosefirst=$ac['choose'];
					$minf=$ac['min_value'];
					$maxf=$ac['max_value'];		
					$sensid=$ac['sensor'];
					$firstgroup=$ac['groupid'];
					$firsthub=$ac['hub'];
					$firstsensor=$ac['sensor'];
					$sensdts = mysqli_query($conn, "SELECT * FROM sensors WHERE id = '".$sensid."' ORDER BY id ASC LIMIT 1");
					$sensdt = mysqli_fetch_assoc($sensdts);
					$sensornamecondfirst=$sensdt['sensor_id'];
				}
				if ($j==0)
				{
					$payval1 = $ac['value'];
					if($opfirst==1)
					{
						$opfirstop='<';
					}
					if ($opfirst==2)
					{
						$opfirstop='>';
					}
					if ($opfirst==3)
					{
						$opfirstop='<=';
					}				
					if ($opfirst==4)
					{
						$opfirstop='>=';
					}
					if ($opfirst==5)
					{
						$opfirstop='=';
					}
				}
				if ($j==1)
				{
					$payval2=$ac['value'];
					$opsecond=$ac['condition1'];
					$condsecond=$ac['condition2'];
					$choosesecond=$ac['choose'];
					$mins=$ac['min_value'];
					$maxs=$ac['max_value'];
					$secondgroup=$ac['groupid'];
					$secondhub=$ac['hub'];
					$secondsensor=$ac['sensor'];				
					$sensid=$ac['sensor'];
					$sensdts = mysqli_query($conn, "SELECT * FROM sensors WHERE id = '".$sensid."' ORDER BY id ASC LIMIT 1");
					$sensdt = mysqli_fetch_assoc($sensdts);
					$sensornamecondsecond=$sensdt['sensor_id'];				
					if ($opsecond==1)
					{
						$opsecondop='<';
					}
					if ($opsecond==2)
					{
						$opsecondop='>';
					}
					if ($opsecond==3)
					{
						$opsecondop='<=';
					}					
					if ($opsecond==4)
					{
						$opsecondop='>=';
					}
					if ($opsecond==5)
					{
						$opsecondop='=';
					}
				}
				if ($j==2)
				{
					$payval3=$ac['value'];
					$opthird=$ac['condition1'];
					$condthird=$ac['condition2'];
					$choosethird=$ac['choose'];
					$mins=$ac['min_value'];
					$maxs=$ac['max_value'];
					$sensid=$ac['sensor'];
					$thirdgroup=$ac['groupid'];
					$thirdhub=$ac['hub'];
					$thirdsensor=$ac['sensor'];
					$sensdts = mysqli_query($conn, "SELECT * FROM sensors WHERE id = '".$sensid."' ORDER BY id ASC LIMIT 1");
					$sensdt = mysqli_fetch_assoc($sensdts);
					$sensornamecondthird=$sensdt['sensor_id'];
					if ($opthird==1)
					{
						$opthirdop='<';
					}
					if ($opthird==2)
					{
						$opthirdop='>';
					}
					if ($opthird==3)
					{
						$opthirdop='<=';
					}					
					if ($opthird==4)
					{
						$opthirdop='>=';
					}
					if ($opthird==5)
					{
						$opthirdop='=';
					}
				}
				$j++;
			}
			if (($condfirst=='Or') && ($condsecond=='Or') )
			{		
				$fflag=0;
				$sflag=0;
				if ($choosefirst==0)
				{
					$fcond=eval("return \$firstval $opfirstop \$payval1;");
				}
				else
				{
					if (($firstval >=$minf) && ($firstval <=$maxf))
					{
						$fflag=1;
						$fcond=1;
					}
				}
				if ($choosesecond==0)
				{
					$scond=eval("return \$secondval $opsecondop \$payval2;");
				}
				else
				{
					if (($secondval >=$mins) && ($secondval <=$maxs))
					$sflag=1;
					$scond=1;
				}					
				if ($choosethird==0)
				{
					$tcond=eval("return \$thirdval $opthirdop \$payval3;");
				}
				else
				{
					if (($thirdval >=$mins) && ($thirdval <=$maxs))
					$tflag=1;
					$tcond=1;
				}
				if ( (($fcond) && ($sensorname==$sensornamecondfirst)) || (($scond) && ($sensorname==$sensornamecondsecond)) || (($tcond) && ($sensorname==$sensornamecondthird)) )
				{
					echo $formula="OR-OR";

//die;
					if ((($fcond) && ($sensorname==$sensornamecondfirst)))
					{
						$firstcondor=0;
						$fcondgrp=$firstgroup;
						$fcondhub=$firsthub;
						$fcondsens=$firstsensor;					
					}				
					if ((($scond) && ($sensorname==$sensornamecondsecond)))
					{
						$secondcondor=0;
						$scondgrp=$secondgroup;
						$scondhub=$secondhub;
						$scondsens=$secondsensor;					
					}				
					if ((($tcond) && ($sensorname==$sensornamecondthird)))
					{
						$thirdcondor=0;
						$tcondgrp=$thirdgroup;
						$tcondhub=$thirdhub;
						$tcondsens=$thirdsensor;					
					}			

echo "INSERT INTO userdatamessages (userid, algorithmid, payloaderid, sensreading, formula, fcondgrp, fcondhub, fcondsens, scondgrp, scondhub, scondsens, tcondgrp, tcondhub, tcondsens, noofcond) VALUES ('".$userid."', '".$algid."', '".$gd['id']."', '".$firstval."', '".$formula."', '".$fcondgrp."', '".$fcondhub."',  '".$fcondsens."', '".$scondgrp."', '".$scondhub."', '".$scondsens."', '".$tcondgrp."', '".$tcondhub."', '".$tcondsens."', '3')";


					$insertmsg = mysqli_query($conn, "INSERT INTO userdatamessages (userid, algorithmid, payloaderid, sensreading, formula, fcondgrp, fcondhub, fcondsens, scondgrp, scondhub, scondsens, tcondgrp, tcondhub, tcondsens, noofcond) VALUES ('".$userid."', '".$algid."', '".$gd['id']."', '".$firstval."', '".$formula."', '".$fcondgrp."', '".$fcondhub."',  '".$fcondsens."', '".$scondgrp."', '".$scondhub."', '".$scondsens."', '".$tcondgrp."', '".$tcondhub."', '".$tcondsens."', '3')");						
					$dbovalue = $gd['id'];
					//$updata = mysqli_query($conn, "UPDATE dbo_payloaderalgorithmtempandor SET processedflagall = '1' WHERE id = '".$dbovalue."'");
				}
			}
			if (($condfirst=='And') && ($condsecond=='And'))
			{			
				$fflag=0;
				$sflag=0;
				if ($choosefirst==0)
				{
					$fcond=eval("return \$firstval $opfirstop \$payval1;");
				}
				else
				{
					if (($firstval >=$minf) && ($firstval <=$maxf))
					{
						$fflag=1;
						$fcond=1;
					}
				}			
				if ($choosesecond==0)
				{
					$scond=eval("return \$secondval $opsecondop \$payval2;");
				}
				else
				{
					if (($secondval >=$mins) && ($secondval <=$maxs))
					$sflag=1;
					$scond=1;
				}			
				if ($choosethird==0)
				{
					$tcond=eval("return \$thirdval $opthirdop \$payval3;");
				}
				else
				{
					if (($thirdval >=$mins) && ($thirdval <=$maxs))
					$tflag=1;
					$tcond=1;
				}
				if ( (($fcond) && ($sensorname==$sensornamecondfirst)) && (($scond) && ($sensorname==$sensornamecondsecond)) && (($tcond) && ($sensorname==$sensornamecondthird)) )
				{
					if ((($fcond) && ($sensorname==$sensornamecondfirst)))
					{
						$firstcondor=0;
						$fcondgrp=$firstgroup;
						$fcondhub=$firsthub;
						$fcondsens=$firstsensor;			
					}			
					if ((($scond) && ($sensorname==$sensornamecondsecond)))
					{
						$secondcondor=0;
						$scondgrp=$secondgroup;
						$scondhub=$secondhub;
						$scondsens=$secondsensor;	
					}			
					if ((($tcond) && ($sensorname==$sensornamecondthird)))
					{
						$thirdcondor=0;
						$tcondgrp=$thirdgroup;
						$tcondhub=$thirdhub;
						$tcondsens=$thirdsensor;
					}
					$formula="AND-AND";
					$insertmsg = mysqli_query($conn, "INSERT INTO userdatamessages (userid, algorithmid, payloaderid, sensreading, formula, fcondgrp, fcondhub, fcondsens, scondgrp, scondhub, scondsens, tcondgrp, tcondhub, tcondsens, noofcond) VALUES ('".$userid."', '".$algid."', '".$gd['id']."', '".$firstval."', '".$formula."', '".$fcondgrp."', '".$fcondhub."', '".$fcondsens."', '".$scondgrp."', '".$scondhub."', '".$scondsens."', '".$tcondgrp."', '".$tcondhub."', '".$tcondsens."', '3')");						
					$dbovalue = $gd['id'];
					//$updata = mysqli_query($conn, "UPDATE dbo_payloaderalgorithmtempandor SET processedflagall = '1' WHERE id = '".$dbovalue."'");
				}
			}
			if (($condfirst=='Or') && ($condsecond=='And'))
			{			
				$fflag=0;
				$sflag=0;
				if ($choosefirst==0)
				{
					$fcond=eval("return \$firstval $opfirstop \$payval1;");
				}
				else
				{
					if (($firstval >=$minf) && ($firstval <=$maxf))
					{
						$fflag=1;
						$fcond=1;
					}
				}			
				if ($choosesecond==0)
				{
					$scond=eval("return \$secondval $opsecondop \$payval2;");
				}
				else
				{
					if (($secondval >=$mins) && ($secondval <=$maxs))
					$sflag=1;
					$scond=1;
				}
				if ($choosethird==0)
				{
					$tcond=eval("return \$thirdval $opthirdop \$payval3;");
				}
				else
				{
					if (($thirdval >=$mins) && ($thirdval <=$maxs))
					$tflag=1;
					$tcond=1;
				}	
				if ( (($fcond) && ($sensorname==$sensornamecondfirst)) || (($scond) && ($sensorname==$sensornamecondsecond)) && (($tcond) && ($sensorname==$sensornamecondthird)) )
				{
					$formula="OR-AND";				
					if ((($fcond) && ($sensorname==$sensornamecondfirst)))
					{
						$firstcondor=0;
						$fcondgrp=$firstgroup;
						$fcondhub=$firsthub;
						$fcondsens=$firstsensor;			
					}				
					if ((($scond) && ($sensorname==$sensornamecondsecond)))
					{
						$secondcondor=0;
						$scondgrp=$secondgroup;
						$scondhub=$secondhub;
						$scondsens=$secondsensor;				
					}			
					if ((($tcond) && ($sensorname==$sensornamecondthird)))
					{
						$thirdcondor=0;
						$tcondgrp=$thirdgroup;
						$tcondhub=$thirdhub;
						$tcondsens=$thirdsensor;
					}
					$insertmsg = mysqli_query($conn, "INSERT INTO userdatamessages (userid, algorithmid, payloaderid, sensreading, formula, fcondgrp, fcondhub, fcondsens, scondgrp, scondhub, scondsens, tcondgrp, tcondhub, tcondsens, noofcond) VALUES ('".$userid."', '".$algid."', '".$gd['id']."', '".$firstval."', '".$formula."', '".$fcondgrp."', '".$fcondhub."', '".$fcondsens."', '".$scondgrp."', '".$scondhub."', '".$scondsens."', '".$tcondgrp."', '".$tcondhub."', '".$tcondsens."', '3')");						
					$dbovalue = $gd['id'];
					//$updata = mysqli_query($conn, "UPDATE dbo_payloaderalgorithmtempandor SET processedflagall = '1' WHERE id = '".$dbovalue."'");
				}			
			}
			if (($condfirst=='And') && ($condsecond=='Or'))
			{			
				$fflag=0;
				$sflag=0;
				if ($choosefirst==0)
				{
					$fcond=eval("return \$firstval $opfirstop \$payval1;");
				}
				else
				{
					if (($firstval >=$minf) && ($firstval <=$maxf))
					{
						$fflag=1;
						$fcond=1;
					}
				}			
				if ($choosesecond==0)
				{
					$scond=eval("return \$secondval $opsecondop \$payval2;");
				}
				else
				{
					if (($secondval >=$mins) && ($secondval <=$maxs))
					$sflag=1;
					$scond=1;
				}
				if ($choosethird==0)
				{
					$tcond=eval("return \$thirdval $opthirdop \$payval3;");
				}
				else
				{
					if (($thirdval >=$mins) && ($thirdval <=$maxs))
					$tflag=1;
					$tcond=1;
				}				
				if ( (($fcond) && ($sensorname==$sensornamecondfirst)) && (($scond) && ($sensorname==$sensornamecondsecond)) || (($tcond) && ($sensorname==$sensornamecondthird)) )
				{
					if ((($fcond) && ($sensorname==$sensornamecondfirst)))
					{
						$firstcondor=0;
						$fcondgrp=$firstgroup;
						$fcondhub=$firsthub;
						$fcondsens=$firstsensor;	
					}				
					if ((($scond) && ($sensorname==$sensornamecondsecond)))
					{
						$secondcondor=0;
						$scondgrp=$secondgroup;
						$scondhub=$secondhub;
						$scondsens=$secondsensor;
					}
					if ((($tcond) && ($sensorname==$sensornamecondthird)))
					{
						$thirdcondor=0;
						$tcondgrp=$thirdgroup;
						$tcondhub=$thirdhub;
						$tcondsens=$thirdsensor;
					}
					$formula="AND-OR";
					$insertmsg = mysqli_query($conn, "INSERT INTO userdatamessages (userid, algorithmid, payloaderid, sensreading, formula, fcondgrp, fcondhub, fcondsens, scondgrp, scondhub, scondsens, tcondgrp, tcondhub, tcondsens, noofcond) VALUES ('".$userid."', '".$algid."', '".$gd['id']."', '".$firstval."', '".$formula."', '".$fcondgrp."', '".$fcondhub."','".$fcondsens."', '".$scondgrp."', '".$scondhub."', '".$scondsens."', '".$tcondgrp."', '".$tcondhub."', '".$tcondsens."', '3')");						
					$dbovalue = $gd['id'];
					//$updata = mysqli_query($conn, "UPDATE dbo_payloaderalgorithmtempandor SET processedflagall = '1' WHERE id = '".$dbovalue."'");
				}				
		

			}





		}
	}

	$dbovalue=$gd['id'];
//$updata=DB::table('dbo_payloaderalgorithmtempandor')->where('id',$dbovalue)->delete();

$deldata=mysqli_query($conn, "delete from  dbo_payloaderalgorithmtempandor WHERE id = '".$dbovalue."'");

}
$sql = "delete FROM dbo_payloaderalgorithmtempandor WHERE sensor_id not IN (".implode(',',$slarr).")";
$getdatadel=mysqli_query($conn,$sql);
	echo "1";
?>