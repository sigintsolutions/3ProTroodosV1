<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyProductRequest;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;

use App\Exports\ReportExport;
use Maatwebsite\Excel\Facades\Excel;

use Illuminate\Http\Request;
use Session;
use Hash;
//use App\Group;
use DB;


class HomeController
{

public function multilogin()
    {
echo "hai";
}

    public function index()
    {
	//DB::enableQueryLog();
		$agents = DB::table('users')
			->join('role_user', 'role_user.user_id', '=', 'users.id')
			->where('role_user.role_id', 2)
			->get();
		$agents_count=count($agents);
		$sensors = DB::table('sensors')
			->get();
		$sensors_count=count($sensors);
		$groups = DB::table('gateway_groups')
		        ->join('users', 'users.id', '=', 'gateway_groups.agent')
		        ->get();
		$groups_count=count($groups);
		$hubs = DB::table('sensor_hubs')
			->get();
		$hubs_count=count($hubs);
		
		$loginagents = DB::table('users')
			->join('role_user', 'role_user.user_id', '=', 'users.id')
			->where('role_user.role_id', 2)
			->where('users.log_status', 1)
			->get();
// 		$logoutagents = DB::table('users')
// 			->join('role_user', 'role_user.user_id', '=', 'users.id')
// 			->where('role_user.role_id', 2)
// 			->where('users.log_status', 0)
// 			->get();
		$logoutagents = DB::table('users')
			->join('role_user', 'role_user.user_id', '=', 'users.id')
			->where('role_user.role_id', 2)
			->get();
		$total=count($loginagents)+count($logoutagents);
		if($total != '0')
		{
		    $perlogin=(count($loginagents)/$total)*100;
		    $perlogout=(count($logoutagents)/$total)*100;
		}
		else
		{
		    $perlogin = '';
		    $perlogout = '';
		}
// 		$perlogin=(count($loginagents)/$total)*100;
// 		$perlogout=(count($logoutagents)/$total)*100;
		$logs = DB::table('log_details')
		->join('users', 'users.id', '=', 'log_details.userid')		
		->orderBy('id', 'desc')->offset(0)->limit(15)
		->select('log_details.*','users.fname','users.lname')
		->get();
        //return view('home')->with(['logs' => $logs]);
        //dd("hai");
        return view('home')->with(['agents_count'=>$agents_count,'agents'=>$agents,'sensors_count'=>$sensors_count,'groups_count'=>$groups_count,'hubs_count'=>$hubs_count,'perlogin'=>$perlogin,'perlogout'=>$perlogout,'loginagents'=>count($loginagents),'logoutagents'=>count($logoutagents),'logs'=> $logs]);
	}
	public function getpushnotmsg()
	{
		$getdata=DB::table('dbo_payloader')->where('processedflag',0)->take(1)->get();
		foreach ($getdata as $gd) 
		{
			$value=$gd->value;
			$firstval=$value;
			$sensorname=$gd->sensor_id;
			$nondata=DB::table('algorithm')
				->join('algorithm_sensor', 'algorithm_sensor.algorithm_id', '=', 'algorithm.id')
				->where('algorithm.moreconditionflag',0)
				->get();
			foreach ($nondata as $nd) 
			{
				if ($nd->choose==1)
				{
					$minvalue=$nd->min_value;
					$maxvalue=$nd->max_value;
					$algid=$nd->algorithm_id;
					$sensid=$nd->sensor;
					$firstcondor=0;
					$fcondgrp=$nd->groupid;
					$fcondhub=$nd->hub;
					$fcondsens=$nd->sensor;
					$sensdt=DB::table('sensors')->where('id',$sensid)->first();
					$sensornamecond=$sensdt->sensor_id;
					$formula="None-Min,Max";
					if ( ($value >= $nd->min_value) && ($value <= $nd->min_value) && ( $sensorname==$sensornamecond))
					{
						$algdata=DB::table('algorithm')->where('id',$algid)->first();
						$userid=$algdata->userid;
						$data=array('userid'=>$userid,'algorithmid'=>$algid,'payloaderid'=>$gd->id,'sensreading'=>$firstval,'formula'=>$formula,'noofcond'=>1,'firstcondor'=>$firstcondor,'fcondgrp'=>$fcondgrp,'fcondhub'=>$fcondhub,'fcondsens'=>$fcondsens);
						$insertmsg=DB::table('userdatamessagesagent')->insert($data);
					}
				}
				else 
				{
					$sensid=$nd->sensor;
					$sensdt=DB::table('sensors')->where('id',$sensid)->first();
					$sensornamecond=$sensdt->sensor_id;
					$firstcondor=0;
					$fcondgrp=$nd->groupid;
					$fcondhub=$nd->hub;
					$fcondsens=$nd->sensor;

				//if (($nd->condition1values==5) && ($sensorname==$sensornamecond)){
					if (($nd->condition1==1) && ($sensorname==$sensornamecond)) {
					//$getdata=DB::table('dbo_payloader')->where('processedflag',0)->where('value',$nd->value)->get();

							if ($value < $nd->value){
							$algid=$nd->algorithm_id;
							$algdata=DB::table('algorithm')->where('id',$algid)->first();
							$userid=$algdata->userid;
							$formula="None-<";
							$data=array('userid'=>$userid,'algorithmid'=>$algid,'payloaderid'=>$gd->id,'sensreading'=>$firstval,'formula'=>$formula,'noofcond'=>1,'firstcondor'=>$firstcondor,'fcondgrp'=>$fcondgrp,'fcondhub'=>$fcondhub,'fcondsens'=>$fcondsens);
					$insertmsg=DB::table('userdatamessagesagent')->insert($data);
					}


			}

		if (($nd->condition1==2) && ($sensorname==$sensornamecond)) {
		//$getdata=DB::table('dbo_payloader')->where('processedflag',0)->where('value',$nd->value)->get();
		$formula="None->";
				if ($value > $nd->value){
				$algid=$nd->algorithm_id;
				$algdata=DB::table('algorithm')->where('id',$algid)->first();
				$userid=$algdata->userid;
				$data=array('userid'=>$userid,'algorithmid'=>$algid,'payloaderid'=>$gd->id,'sensreading'=>$firstval,'formula'=>$formula,'noofcond'=>1,'firstcondor'=>$firstcondor,'fcondgrp'=>$fcondgrp,'fcondhub'=>$fcondhub,'fcondsens'=>$fcondsens);
		$insertmsg=DB::table('userdatamessages')->insert($data);
		}


			}

		if (($nd->condition1==3) && ($sensorname==$sensornamecond)){
		//$getdata=DB::table('dbo_payloader')->where('processedflag',0)->where('value',$nd->value)->get();
		$formula="None-<=";
				if ($value <= $nd->value){
				$algid=$nd->algorithm_id;
				$algdata=DB::table('algorithm')->where('id',$algid)->first();
				$userid=$algdata->userid;
				$data=array('userid'=>$userid,'algorithmid'=>$algid,'payloaderid'=>$gd->id,'sensreading'=>$firstval,'formula'=>$formula,'noofcond'=>1,'firstcondor'=>$firstcondor,'fcondgrp'=>$fcondgrp,'fcondhub'=>$fcondhub,'fcondsens'=>$fcondsens);
		$insertmsg=DB::table('userdatamessages')->insert($data);
		}


			}

		if (($nd->condition1==4) && ($sensorname==$sensornamecond)) {
		//$getdata=DB::table('dbo_payloader')->where('processedflag',0)->where('value',$nd->value)->get();
		$formula="None->=";
				if ($value >= $nd->value){
				$algid=$nd->algorithm_id;
				$algdata=DB::table('algorithm')->where('id',$algid)->first();
				$userid=$algdata->userid;
				$data=array('userid'=>$userid,'algorithmid'=>$algid,'payloaderid'=>$gd->id,'sensreading'=>$firstval,'formula'=>$formula,'noofcond'=>1,'firstcondor'=>$firstcondor,'fcondgrp'=>$fcondgrp,'fcondhub'=>$fcondhub,'fcondsens'=>$fcondsens);
		$insertmsg=DB::table('userdatamessages')->insert($data);
		}


			}




			if (($nd->condition1==5) && ($sensorname==$sensornamecond)) {
		//$getdata=DB::table('dbo_payloader')->where('processedflag',0)->where('value',$nd->value)->get();
		$formula="None-==";
				if ($nd->value==$value){
				$algid=$nd->algorithm_id;
				$algdata=DB::table('algorithm')->where('id',$algid)->first();
				$userid=$algdata->userid;
				$data=array('userid'=>$userid,'algorithmid'=>$algid,'payloaderid'=>$gd->id,'sensreading'=>$firstval,'formula'=>$formula,'noofcond'=>1,'firstcondor'=>$firstcondor,'fcondgrp'=>$fcondgrp,'fcondhub'=>$fcondhub,'fcondsens'=>$fcondsens);
		$insertmsg=DB::table('userdatamessages')->insert($data);
		}



			}
		}

		}
		$dbovalue=$gd->id;
		$dtup=array('processedflag'=>1);
		$updata=DB::table('dbo_payloader')->where('id',$dbovalue)->update($dtup);


		}
		echo "1";
	}
	public function getpushnotmsgandor(){
		//$getdata=DB::table('dbo_payloader')->where('processedflagall',0)->take(1)->get();
			$getdata=DB::table('dbo_payloader')->where('processedflagall',0)->where('sensor_id','DL3_Temperature Sensor 1')->take(1)->get();
		foreach ($getdata as $gd) {
			$value=$gd->value;
			$firstval=$gd->value;
			$secondval=$gd->value;
			$thirdval=$gd->value;
			$sensorname=$gd->sensor_id;
			$firstcondor=0;
		$fcondgrp=0;
		$fcondhub=0;
		$fcondsens=0;
		$secondcondor=0;
		$scondgrp=0;
		$scondhub=0;
		$scondsens=0;
		$tcondgrp=0;
		$tcondhub=0;
		$tcondsens=0;
		$nondata=DB::table('algorithm')->where('moreconditionflag',1)->get();
		foreach ($nondata as $nd) 
		{
		$allcond=DB::table('algorithm_sensor')->where('algorithm_id',$nd->id)->get();
		$algid=$nd->id;
		$userid=$nd->userid;
		$noofconditions=count($allcond);
		$i=0;
		if ($noofconditions==2){
			//dd("entered 2");
			$condfirst="";
		$opfirst=0;
		$opfirstop=0;
		$opsecondop=0;
		$payval2=0;
		$sensornamecondfirst=0;
		$sensornamecondsecond=0;
		foreach ($allcond as $ac) {
			//dd("hai",$i);
			if ($i==0){
				//dd("hello");
			$condfirst=$ac->condition2;
			$opfirst=$ac->condition1;
			$choosefirst=$ac->choose;
			$minf=$ac->min_value;
			$maxf=$ac->max_value;
		$sensid=$ac->sensor;
		$firstgroup=$ac->groupid;
		$firsthub=$ac->hub;
		$firstsensor=$ac->sensor;
			$sensdt=DB::table('sensors')->where('id',$sensid)->first();
			$sensornamecondfirst=$sensdt->sensor_id;
		
		
			}
		//$condfirst=$condfirst;
		if ($i==0){
			$payval1=$ac->value;
		if ($opfirst==1){
		$opfirstop='<';
		}
		if ($opfirst==2){
		$opfirstop='>';
		}
		if ($opfirst==3){
		$opfirstop='<=';
		}
		
		if ($opfirst==4){
		$opfirstop='>=';
		}
		if ($opfirst==5){
		$opfirstop='=';
		}
		}
		if ($i==1){
			$payval2=$ac->value;
			$opsecond=$ac->condition1;
			$choosesecond=$ac->choose;
			$mins=$ac->min_value;
			$maxs=$ac->max_value;
		$sensid=$ac->sensor;
			$sensdt=DB::table('sensors')->where('id',$sensid)->first();
			$sensornamecondsecond=$sensdt->sensor_id;
		$secondgroup=$ac->groupid;
		$secondhub=$ac->hub;
		$secondsensor=$ac->sensor;
		
		
		if ($opsecond==1){
		$opsecondop='<';
		}
		if ($opsecond==2){
		$opsecondop='>';
		}
		if ($opsecond==3){
		$opsecondop='<=';
		}
		
		if ($opsecond==4){
		$opsecondop='>=';
		}
		if ($opsecond==5){
		$opsecondop='=';
		}
		}
		$i++;
		}
		
		//dd($condfirst,$opfirstop,$opsecondop,$firstval,$secondval,$payval1,$payval2);
		if ($condfirst=='Or'){
			//dd("enter or");
		//if (eval("return \$firstval $opfirstop \$payval1") || (eval("return \$secondval $opsecondop \$payval2")) )
		//{
		//$fcond=eval("return \$firstval $opfirstop \$payval1;");
		//$scond=eval("return \$secondval $opsecondop \$payval2;");
		$fflag=0;
			$sflag=0;
			if ($choosefirst==0){
		$fcond=eval("return \$firstval $opfirstop \$payval1;");
		}
		else{
		if (($firstval >=$minf) && ($firstval <=$maxf)){
		$fflag=1;
		$fcond=1;
		}
		}
		
		if ($choosesecond==0){
		$scond=eval("return \$secondval $opsecondop \$payval2;");
		}
		else{
		if (($secondval >=$mins) && ($secondval <=$maxs))
		$sflag=1;
		$scond=1;
		}
		
		$firstcondor=0;
		$secondcondor=0;
		//dd($firstval,$opfirstop,$payval1,$fcond,$sensorname,$sensornamecondfirst);
		if ( (($fcond) && ($sensorname==$sensornamecondfirst)) || (($scond) && ($sensorname==$sensornamecondsecond))){
		
		
			//if (($fcond) || ($scond)){
		//dd("Inside exp");
				//$userid=$algdata->userid;
			if ((($fcond) && ($sensorname==$sensornamecondfirst)))
			{
		$firstcondor=1;
		$fcondgrp=$firstgroup;
		$fcondhub=$firsthub;
		$fcondsens=$firstsensor;
		
				}
		
				if ((($scond) && ($sensorname==$sensornamecondsecond))){
					//$secondcondor=1;
		$secondcondor=1;
		$scondgrp=$secondgroup;
		$scondhub=$secondhub;
		$scondsens=$secondsensor;
		
		
				}
				//dd("msg");
				$formula="Or";
		
				$data=array('userid'=>$userid,'algorithmid'=>$algid,'payloaderid'=>$gd->id,'orflag'=>1,'noofcond'=>2,'firstcondor'=>$firstcondor,'seccondor'=>$secondcondor,'fcondgrp'=>$fcondgrp,'fcondhub'=>$fcondhub,'fcondsens'=>$fcondsens,'scondgrp'=>$scondgrp,'scondhub'=>$scondhub,'scondsens'=>$scondsens,'sensreading'=>$firstval,'formula'=>$formula);
			
		$insertmsg=DB::table('userdatamessages')->insert($data);
		
		$dbovalue=$gd->id;
		$dtup=array('processedflagall'=>1);
		$updata=DB::table('dbo_payloader')->where('id',$dbovalue)->update($dtup);
		
		
		
		}
		}
		/* 15-7-20 end */
		if ($condfirst=='And'){
		//if (eval("return \$firstval $opfirstop \$payval1") && (eval("return \$secondval $opsecondtop \$payval2")) )
		//{
		//$fcond=eval("return \$firstval $opfirstop \$payval1;");
		//$scond=eval("return \$secondval $opsecondop \$payval2;");
		$fflag=0;
			$sflag=0;
			if ($choosefirst==0){
		$fcond=eval("return \$firstval $opfirstop \$payval1;");
		}
		else{
		if (($firstval >=$minf) && ($firstval <=$maxf)){
		$fflag=1;
		$fcond=1;
		}
		}
		
		if ($choosesecond==0){
		$scond=eval("return \$secondval $opsecondop \$payval2;");
		}
		else{
		if (($secondval >=$mins) && ($secondval <=$maxs))
		$sflag=1;
		$scond=1;
		}
		
		
		if ( (($fcond) && ($sensorname==$sensornamecondfirst)) && (($scond) && ($sensorname==$sensornamecondsecond)) ){
		
		//if (($fcond) && ($scond)){
		
				//$userid=$algdata->userid;
				//$data=array('userid'=>$userid,'algorithmid'=>$algid,'payloaderid'=>$gd->id);
		$fcondgrp=$firstgroup;
		$fcondhub=$firsthub;
		$fcondsens=$firstsensor;
		$scondgrp=$secondgroup;
		$scondhub=$secondhub;
		$scondsens=$secondsensor;
		
		$formula="And";
		$data=array('userid'=>$userid,'algorithmid'=>$algid,'payloaderid'=>$gd->id,'orflag'=>0,'noofcond'=>2,'firstcondor'=>$firstcondor,'seccondor'=>$secondcondor,'fcondgrp'=>$fcondgrp,'fcondhub'=>$fcondhub,'fcondsens'=>$fcondsens,'scondgrp'=>$scondgrp,'scondhub'=>$scondhub,'scondsens'=>$scondsens,'sensreading'=>$firstval,'formula'=>$formula);
		
		$insertmsg=DB::table('userdatamessages')->insert($data);
		
		$dbovalue=$gd->id;
		$dtup=array('processedflagall'=>1);
		$updata=DB::table('dbo_payloader')->where('id',$dbovalue)->update($dtup);
		
		}
		}
		//Loop of condition 2
		//2nd phase
		}
		//condition 2 end
		//condition 3 st
		
		$j=0;
		if ($noofconditions==3){
			//dd("entered 3");
			$condfirst="";
		$opfirst=0;
		$opfirstop=0;
		$opsecondop=0;
		$payval2=0;
		$sensornamecondfirst=0;
		$sensornamecondsecond=0;
		$sensornamecondthird=0;
		foreach ($allcond as $ac) {
			//dd("hai",$i);
			if ($j==0){
				//dd("hello");
			$condfirst=$ac->condition2;
			$opfirst=$ac->condition1;
			$choosefirst=$ac->choose;
			$minf=$ac->min_value;
			$maxf=$ac->max_value;
		
		$sensid=$ac->sensor;
		//$sensid=$ac->sensor;
		$firstgroup=$ac->groupid;
		$firsthub=$ac->hub;
		$firstsensor=$ac->sensor;
			$sensdt=DB::table('sensors')->where('id',$sensid)->first();
			$sensornamecondfirst=$sensdt->sensor_id;
		
		
			}
		//$condfirst=$condfirst;
		if ($j==0){
			$payval1=$ac->value;
		if ($opfirst==1){
		$opfirstop='<';
		}
		if ($opfirst==2){
		$opfirstop='>';
		}
		if ($opfirst==3){
		$opfirstop='<=';
		}
		
		if ($opfirst==4){
		$opfirstop='>=';
		}
		if ($opfirst==5){
		$opfirstop='=';
		}
		}
		if ($j==1){
			$payval2=$ac->value;
			$opsecond=$ac->condition1;
			$condsecond=$ac->condition2;
			$choosesecond=$ac->choose;
			$mins=$ac->min_value;
			$maxs=$ac->max_value;
			$secondgroup=$ac->groupid;
		$secondhub=$ac->hub;
		$secondsensor=$ac->sensor;
		
		$sensid=$ac->sensor;
			$sensdt=DB::table('sensors')->where('id',$sensid)->first();
			$sensornamecondsecond=$sensdt->sensor_id;
		
		if ($opsecond==1){
		$opsecondop='<';
		}
		if ($opsecond==2){
		$opsecondop='>';
		}
		if ($opsecond==3){
		$opsecondop='<=';
		}
		
		if ($opsecond==4){
		$opsecondop='>=';
		}
		if ($opsecond==5){
		$opsecondop='=';
		}
		}
		
		if ($j==2){
			$payval3=$ac->value;
			$opthird=$ac->condition1;
			$condthird=$ac->condition2;
			$choosethird=$ac->choose;
			$mins=$ac->min_value;
			$maxs=$ac->max_value;
			$sensid=$ac->sensor;
			$thirdgroup=$ac->groupid;
		$thirdhub=$ac->hub;
		$thirdsensor=$ac->sensor;
			$sensdt=DB::table('sensors')->where('id',$sensid)->first();
			$sensornamecondthird=$sensdt->sensor_id;
		if ($opthird==1){
		$opthirdop='<';
		}
		if ($opthird==2){
		$opthirdop='>';
		}
		if ($opthird==3){
		$opthirdop='<=';
		}
		
		if ($opthird==4){
		$opthirdop='>=';
		}
		if ($opthird==5){
		$opthirdop='=';
		}
		}
		
		$j++;
		}
		if (($condfirst=='Or') && ($condsecond=='Or') ){
			
		$fflag=0;
		$sflag=0;
			if ($choosefirst==0){
		$fcond=eval("return \$firstval $opfirstop \$payval1;");
		}
		else{
		if (($firstval >=$minf) && ($firstval <=$maxf)){
		$fflag=1;
		$fcond=1;
		}
		}
		//dd($fcond);
		if ($choosesecond==0){
		$scond=eval("return \$secondval $opsecondop \$payval2;");
		}
		else{
		if (($secondval >=$mins) && ($secondval <=$maxs))
		$sflag=1;
		$scond=1;
		}
		
		
		if ($choosethird==0){
		$tcond=eval("return \$thirdval $opthirdop \$payval3;");
		}
		else{
		if (($thirdval >=$mins) && ($thirdval <=$maxs))
		$tflag=1;
		$tcond=1;
		}
		//dd("$fcond,$sensorname,$sensornamecondfirst,$scond,$sensornamecondsecond,$tcond,$sensornamecondthird");
		if ( (($fcond) && ($sensorname==$sensornamecondfirst)) || (($scond) && ($sensorname==$sensornamecondsecond)) || (($tcond) && ($sensorname==$sensornamecondthird)) ){
		//dd("me----");
			//if (($fcond) || ($scond) || ($tcond)){
		$formula="OR-OR";
		
		if ((($fcond) && ($sensorname==$sensornamecondfirst)))
			{
		$firstcondor=0;
		$fcondgrp=$firstgroup;
		$fcondhub=$firsthub;
		$fcondsens=$firstsensor;
		
				}
		
				if ((($scond) && ($sensorname==$sensornamecondsecond))){
					//$secondcondor=1;
		$secondcondor=0;
		$scondgrp=$secondgroup;
		$scondhub=$secondhub;
		$scondsens=$secondsensor;
		
		
				}
		
		
		if ((($tcond) && ($sensorname==$sensornamecondthird))){
					//$secondcondor=1;
		$thirdcondor=0;
		$tcondgrp=$thirdgroup;
		$tcondhub=$thirdhub;
		$tcondsens=$thirdsensor;
		
		
		
		
				}
		
		
		
		
				$data=array('userid'=>$userid,'algorithmid'=>$algid,'payloaderid'=>$gd->id,'sensreading'=>$firstval,'formula'=>$formula,'fcondgrp'=>$fcondgrp,'fcondhub'=>$fcondhub,'fcondsens'=>$fcondsens,'scondgrp'=>$scondgrp,'scondhub'=>$scondhub,'scondsens'=>$scondsens,'tcondgrp'=>$tcondgrp,'tcondhub'=>$tcondhub,'tcondsens'=>$tcondsens,'noofcond'=>3);
		$insertmsg=DB::table('userdatamessages')->insert($data);
		
		$dbovalue=$gd->id;
		$dtup=array('processedflagall'=>1);
		$updata=DB::table('dbo_payloader')->where('id',$dbovalue)->update($dtup);
		
		
		
		}
		}
		if (($condfirst=='And') && ($condsecond=='And'))
		{
		
		$fflag=0;
			$sflag=0;
			if ($choosefirst==0){
		$fcond=eval("return \$firstval $opfirstop \$payval1;");
		}
		else{
		if (($firstval >=$minf) && ($firstval <=$maxf)){
		$fflag=1;
		$fcond=1;
		}
		}
		
		if ($choosesecond==0){
		$scond=eval("return \$secondval $opsecondop \$payval2;");
		}
		else{
		if (($secondval >=$mins) && ($secondval <=$maxs))
		$sflag=1;
		$scond=1;
		}
		
		
		if ($choosethird==0){
		$tcond=eval("return \$thirdval $opthirdop \$payval3;");
		}
		else{
		if (($thirdval >=$mins) && ($thirdval <=$maxs))
		$tflag=1;
		$tcond=1;
		}
		//dd("and-and");
		if ( (($fcond) && ($sensorname==$sensornamecondfirst)) && (($scond) && ($sensorname==$sensornamecondsecond)) && (($tcond) && ($sensorname==$sensornamecondthird)) ){
		
		//if (($fcond) && ($scond) && ($tcond)){
		
		if ((($fcond) && ($sensorname==$sensornamecondfirst)))
			{
		$firstcondor=0;
		$fcondgrp=$firstgroup;
		$fcondhub=$firsthub;
		$fcondsens=$firstsensor;
		
				}
		
				if ((($scond) && ($sensorname==$sensornamecondsecond))){
					//$secondcondor=1;
		$secondcondor=0;
		$scondgrp=$secondgroup;
		$scondhub=$secondhub;
		$scondsens=$secondsensor;
		
		
				}
		
		
		if ((($tcond) && ($sensorname==$sensornamecondthird))){
					//$secondcondor=1;
		$thirdcondor=0;
		$tcondgrp=$thirdgroup;
		$tcondhub=$thirdhub;
		$tcondsens=$thirdsensor;
		
		
		
		
				}
		
		
		
		
		
				$formula="AND-AND";
				$data=array('userid'=>$userid,'algorithmid'=>$algid,'payloaderid'=>$gd->id,'sensreading'=>$firstval,'formula'=>$formula,'fcondgrp'=>$fcondgrp,'fcondhub'=>$fcondhub,'fcondsens'=>$fcondsens,'scondgrp'=>$scondgrp,'scondhub'=>$scondhub,'scondsens'=>$scondsens,'tcondgrp'=>$tcondgrp,'tcondhub'=>$tcondhub,'tcondsens'=>$tcondsens,'noofcond'=>3);
		$insertmsg=DB::table('userdatamessages')->insert($data);
		
		$dbovalue=$gd->id;
		$dtup=array('processedflagall'=>1);
		$updata=DB::table('dbo_payloader')->where('id',$dbovalue)->update($dtup);
		
		}
		
		}
		
		
		if (($condfirst=='Or') && ($condsecond=='And'))
		{
		
		$fflag=0;
			$sflag=0;
			if ($choosefirst==0){
		$fcond=eval("return \$firstval $opfirstop \$payval1;");
		}
		else{
		if (($firstval >=$minf) && ($firstval <=$maxf)){
		$fflag=1;
		$fcond=1;
		}
		}
		
		if ($choosesecond==0){
		$scond=eval("return \$secondval $opsecondop \$payval2;");
		}
		else{
		if (($secondval >=$mins) && ($secondval <=$maxs))
		$sflag=1;
		$scond=1;
		}
		
		
		if ($choosethird==0){
		$tcond=eval("return \$thirdval $opthirdop \$payval3;");
		}
		else{
		if (($thirdval >=$mins) && ($thirdval <=$maxs))
		$tflag=1;
		$tcond=1;
		}
		
		if ( (($fcond) && ($sensorname==$sensornamecondfirst)) || (($scond) && ($sensorname==$sensornamecondsecond)) && (($tcond) && ($sensorname==$sensornamecondthird)) ){
		
		//if (($fcond) || ($scond) && ($tcond)){
		
				$formula="OR-AND";
		
		if ((($fcond) && ($sensorname==$sensornamecondfirst)))
			{
		$firstcondor=0;
		$fcondgrp=$firstgroup;
		$fcondhub=$firsthub;
		$fcondsens=$firstsensor;
		
				}
		
				if ((($scond) && ($sensorname==$sensornamecondsecond))){
					//$secondcondor=1;
		$secondcondor=0;
		$scondgrp=$secondgroup;
		$scondhub=$secondhub;
		$scondsens=$secondsensor;
		
		
				}
		
		
		if ((($tcond) && ($sensorname==$sensornamecondthird))){
					//$secondcondor=1;
		$thirdcondor=0;
		$tcondgrp=$thirdgroup;
		$tcondhub=$thirdhub;
		$tcondsens=$thirdsensor;
		
		
		
		
				}
		
		
		
				$data=array('userid'=>$userid,'algorithmid'=>$algid,'payloaderid'=>$gd->id,'sensreading'=>$firstval,'formula'=>$formula,'fcondgrp'=>$fcondgrp,'fcondhub'=>$fcondhub,'fcondsens'=>$fcondsens,'scondgrp'=>$scondgrp,'scondhub'=>$scondhub,'scondsens'=>$scondsens,'tcondgrp'=>$tcondgrp,'tcondhub'=>$tcondhub,'tcondsens'=>$tcondsens,'noofcond'=>3);
		$insertmsg=DB::table('userdatamessages')->insert($data);
		
		$dbovalue=$gd->id;
		$dtup=array('processedflagall'=>1);
		$updata=DB::table('dbo_payloader')->where('id',$dbovalue)->update($dtup);
		
		}
		
		}
		
		
		if (($condfirst=='And') && ($condsecond=='Or'))
		{
		
		$fflag=0;
			$sflag=0;
			if ($choosefirst==0){
		$fcond=eval("return \$firstval $opfirstop \$payval1;");
		}
		else{
		if (($firstval >=$minf) && ($firstval <=$maxf)){
		$fflag=1;
		$fcond=1;
		}
		}
		
		if ($choosesecond==0){
		$scond=eval("return \$secondval $opsecondop \$payval2;");
		}
		else{
		if (($secondval >=$mins) && ($secondval <=$maxs))
		$sflag=1;
		$scond=1;
		}
		
		
		if ($choosethird==0){
		$tcond=eval("return \$thirdval $opthirdop \$payval3;");
		}
		else{
		if (($thirdval >=$mins) && ($thirdval <=$maxs))
		$tflag=1;
		$tcond=1;
		}
		
		if ( (($fcond) && ($sensorname==$sensornamecondfirst)) && (($scond) && ($sensorname==$sensornamecondsecond)) || (($tcond) && ($sensorname==$sensornamecondthird)) ){
		
		//if (($fcond) && ($scond) || ($tcond)){
		
		if ((($fcond) && ($sensorname==$sensornamecondfirst)))
			{
		$firstcondor=0;
		$fcondgrp=$firstgroup;
		$fcondhub=$firsthub;
		$fcondsens=$firstsensor;
		
				}
		
				if ((($scond) && ($sensorname==$sensornamecondsecond))){
					//$secondcondor=1;
		$secondcondor=0;
		$scondgrp=$secondgroup;
		$scondhub=$secondhub;
		$scondsens=$secondsensor;
		
		
				}
		
		
		if ((($tcond) && ($sensorname==$sensornamecondthird))){
					//$secondcondor=1;
		$thirdcondor=0;
		$tcondgrp=$thirdgroup;
		$tcondhub=$thirdhub;
		$tcondsens=$thirdsensor;
		
		
		
		
				}
		
		
		
		
				$formula="AND-OR";
				$data=array('userid'=>$userid,'algorithmid'=>$algid,'payloaderid'=>$gd->id,'sensreading'=>$firstval,'formula'=>$formula,'fcondgrp'=>$fcondgrp,'fcondhub'=>$fcondhub,'fcondsens'=>$fcondsens,'scondgrp'=>$scondgrp,'scondhub'=>$scondhub,'scondsens'=>$scondsens,'tcondgrp'=>$tcondgrp,'tcondhub'=>$tcondhub,'tcondsens'=>$tcondsens,'noofcond'=>3);
		$insertmsg=DB::table('userdatamessages')->insert($data);
		
		$dbovalue=$gd->id;
		$dtup=array('processedflagall'=>1);
		$updata=DB::table('dbo_payloader')->where('id',$dbovalue)->update($dtup);
		
		}
		
		}
		
		//Loop of condition 3
		//3nd phase
		}
		
		//Condition 3 st
		}}
		
		echo "1";
		}
}
