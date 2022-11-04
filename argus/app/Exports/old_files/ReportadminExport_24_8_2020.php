<?php

namespace App\Exports;

//use App\Sensor;
use DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromQuery;

use Carbon\Carbon;

class ReportadminExport implements FromCollection, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
	private $data;

    public function __construct($data)
    {
        $this->data = $data;
		//print_r($this->data);die();
    }
    public function collection()
    {	
		if($this->data['tme']=='week')
		{
			$start_week = strtotime("-6 day");
			$end_week = strtotime("+1 day");
			$start_week = date("Y-m-d",$start_week);
			$end_week = date("Y-m-d",$end_week);


/*$items=DB::table('dbo_payloadercharttemp')->where('dbo_payloadercharttemp.unit', $this->data['unit'])->whereIn('dbo_payloadercharttemp.hub',$this->data['hub'])->whereRaw('dbo_payloadercharttemp.time between "'.$start_week.'" and "'.$end_week.'"')->where('loginid',$this->data['loginid'])->whereIn('dbo_payloadercharttemp.sensor_id', $this->data['sensor'])->select('agentname','gatewaygrp','hub','unit','sensor_id','value','time')->take(1000)->get();*/


/*$items=DB::table('dbo_payloadercharttemp as db')->where('db.unit', $this->data['unit'])->whereIn('db.hub',$this->data['hub'])->whereRaw('db.time between "'.$start_week.'" and "'.$end_week.'"')->where('loginid',$this->data['loginid'])->whereIn('db.sensor_id', $this->data['sensor'])->select('agentname','gatewaygrp','hub','unit','sensor_id','value','utc')->get();*/


$items=DB::table('dbo_payloadercharttemp as db')->where('db.unit', $this->data['unit'])->whereRaw('db.time between "'.$start_week.'" and "'.$end_week.'"')->where('loginid',$this->data['loginid'])->select('agentname','gatewaygrp','hub','unit','sensor_id','value','utc')->get();

			/*$items = DB::table('sensors')
			->join('sensor_hubs', 'sensors.hub_id', '=', 'sensor_hubs.id')
			->join('gateway_groups', 'sensor_hubs.group_id', '=', 'gateway_groups.id')
			->join('sensor_groups', 'sensor_groups.id', '=', 'gateway_groups.sensor_group_id')
			->join('users', 'sensor_hubs.agent', '=', 'users.id')
			->join('dbo_payloader', 'dbo_payloader.sensor_id', '=', 'sensors.sensor_id')
			->whereRaw('dbo_payloader.time between "'.$start_week.'" and "'.$end_week.'"')
			->whereRaw('users.id = "'.$this->data['agent'].'"')
			->where('dbo_payloader.unit', $this->data['unit'])
			->whereRaw('gateway_groups.id in ("'.$this->data['group'].'")')
			->whereIn('dbo_payloader.hub', $this->data['hub'])
			->whereIn('dbo_payloader.sensor_id', $this->data['sensor'])
			->orderBy('dbo_payloader.sensor_id')
			->select('users.fname', 'sensor_groups.name', 'dbo_payloader.hub', 'dbo_payloader.unit','dbo_payloader.sensor_id', 'dbo_payloader.time', 'dbo_payloader.value')
			->get();*/
		}
		if($this->data['tme']=='day')
		{
			/*$items = DB::table('sensors')
			->join('sensor_hubs', 'sensors.hub_id', '=', 'sensor_hubs.id')
			->join('gateway_groups', 'sensor_hubs.group_id', '=', 'gateway_groups.id')
			->join('sensor_groups', 'sensor_groups.id', '=', 'gateway_groups.sensor_group_id')
			->join('users', 'sensor_hubs.agent', '=', 'users.id')
			->join('dbo_payloader', 'dbo_payloader.sensor_id', '=', 'sensors.sensor_id')
			->whereRaw('users.id = "'.$this->data['agent'].'"')
			->where('dbo_payloader.unit', $this->data['unit'])
			->whereRaw('gateway_groups.id in ("'.$this->data['group'].'")')
			->whereIn('dbo_payloader.hub', $this->data['hub'])
			->whereIn('dbo_payloader.sensor_id', $this->data['sensor'])
			->whereDate('dbo_payloader.time', Carbon::today())
			->orderBy('dbo_payloader.sensor_id')
			->select('users.fname', 'sensor_groups.name', 'dbo_payloader.hub', 'dbo_payloader.unit','dbo_payloader.sensor_id', 'dbo_payloader.time', 'dbo_payloader.value')
			->get();*/

$loginid=$this->data['loginid'];
//$loginid=session()->get('userid');
			//->where('loginid',$this->data['loginid'])
/*$items=DB::table('dbo_payloadercharttemp')->where('dbo_payloadercharttemp.unit', $this->data['unit'])->whereIn('dbo_payloadercharttemp.hub',$this->data['hub'])->whereDate('dbo_payloadercharttemp.time', Carbon::today())->where('loginid',$this->data['loginid'])->whereIn('dbo_payloadercharttemp.sensor_id', $this->data['sensor'])->select('agentname','gatewaygrp','hub','unit','sensor_id','value','time')->take(1000)->get();*/
			
/*$items=DB::table('dbo_payloadercharttemp as db')->where('db.unit', $this->data['unit'])->whereIn('db.hub',$this->data['hub'])->whereDate('db.time', Carbon::today())->where('loginid',$this->data['loginid'])->whereIn('db.sensor_id', $this->data['sensor'])->select('agentname','gatewaygrp','hub','unit','sensor_id','value','utc')->get();*/

$items=DB::table('dbo_payloadercharttemp as db')->where('db.unit', $this->data['unit'])->whereDate('db.time', Carbon::today())->where('loginid',$this->data['loginid'])->select('agentname','gatewaygrp','hub','unit','sensor_id','value','utc')->get();


		}		
		if($this->data['tme']=='month')
		{
			$start_month = strtotime("-29 day");
			$end_month = strtotime("+1 day");
			$start_month = date("Y-m-d",$start_month);
			$end_month = date("Y-m-d",$end_month);


			/*$items = DB::table('sensors')
			->join('sensor_hubs', 'sensors.hub_id', '=', 'sensor_hubs.id')
			->join('gateway_groups', 'sensor_hubs.group_id', '=', 'gateway_groups.id')
			->join('sensor_groups', 'sensor_groups.id', '=', 'gateway_groups.sensor_group_id')
			->join('users', 'sensor_hubs.agent', '=', 'users.id')
			->join('dbo_payloader', 'dbo_payloader.sensor_id', '=', 'sensors.sensor_id')
			->whereRaw('users.id = "'.$this->data['agent'].'"')
			->where('dbo_payloader.unit', $this->data['unit'])
			->whereRaw('gateway_groups.id in ("'.$this->data['group'].'")')
			->whereIn('dbo_payloader.hub', $this->data['hub'])
			->whereIn('dbo_payloader.sensor_id', $this->data['sensor'])
			->orderBy('dbo_payloader.sensor_id')
			->whereRaw('dbo_payloader.time between "'.$start_month.'" and "'.$end_month.'"')
			->select('users.fname', 'sensor_groups.name', 'dbo_payloader.hub', 'dbo_payloader.unit','dbo_payloader.sensor_id', 'dbo_payloader.time', 'dbo_payloader.value')
			->get();*/

//#00a9dc

$loginid=$this->data['loginid'];
//$loginid=session()->get('userid');
			//->where('loginid',$this->data['loginid'])
/*$items=DB::table('dbo_payloadercharttemp')->where('dbo_payloadercharttemp.unit', $this->data['unit'])->whereIn('dbo_payloadercharttemp.hub',$this->data['hub'])->whereRaw('dbo_payloadercharttemp.time between "'.$start_month.'" and "'.$end_month.'"')->where('loginid',$this->data['loginid'])->whereIn('dbo_payloadercharttemp.sensor_id', $this->data['sensor'])->select('agentname','gatewaygrp','hub','unit','sensor_id','value','time')->take(1000)->get();*/
/*$items=DB::table('dbo_payloadercharttemp as db')->where('db.unit', $this->data['unit'])->whereIn('db.hub',$this->data['hub'])->whereRaw('db.time between "'.$start_month.'" and "'.$end_month.'"')->where('loginid',$this->data['loginid'])->whereIn('db.sensor_id', $this->data['sensor'])->select('agentname','gatewaygrp','hub','unit','sensor_id','value','utc')->get();*/

$items=DB::table('dbo_payloadercharttemp as db')->where('db.unit', $this->data['unit'])->whereRaw('db.time between "'.$start_month.'" and "'.$end_month.'"')->where('loginid',$this->data['loginid'])->select('agentname','gatewaygrp','hub','unit','sensor_id','value','utc')->get();



			
		}
		if($this->data['tme']=='one')
		{
			$start = date("Y-m-d",strtotime($this->data['from']));
			$end = date("Y-m-d",strtotime($this->data['to']."+1 day"));
			/*$items = DB::table('sensors')
			->join('sensor_hubs', 'sensors.hub_id', '=', 'sensor_hubs.id')
			->join('gateway_groups', 'sensor_hubs.group_id', '=', 'gateway_groups.id')
			->join('sensor_groups', 'sensor_groups.id', '=', 'gateway_groups.sensor_group_id')
			->join('users', 'sensor_hubs.agent', '=', 'users.id')
			->join('dbo_payloader', 'dbo_payloader.sensor_id', '=', 'sensors.sensor_id')
			->whereRaw('dbo_payloader.time between "'.$start.'" and "'.$end.'"')
			->whereRaw('users.id = "'.$this->data['agent'].'"')
			->where('dbo_payloader.unit', $this->data['unit'])
			->whereRaw('gateway_groups.id in ("'.$this->data['group'].'")')
			->whereIn('dbo_payloader.hub', $this->data['hub'])
			->whereIn('dbo_payloader.sensor_id', $this->data['sensor'])
			->orderBy('dbo_payloader.sensor_id')
			->select('users.fname', 'sensor_groups.name', 'dbo_payloader.hub', 'dbo_payloader.unit','dbo_payloader.sensor_id', 'dbo_payloader.time', 'dbo_payloader.value')
			->get();*/

/*$items=DB::table('dbo_payloadercharttemp as db')->where('db.unit', $this->data['unit'])->whereIn('db.hub',$this->data['hub'])->whereRaw('db.time between "'.$start.'" and "'.$end.'"')->where('loginid',$this->data['loginid'])->whereIn('db.sensor_id', $this->data['sensor'])->select('agentname','gatewaygrp','hub','unit','sensor_id','value','utc')->get();*/
			$items=DB::table('dbo_payloadercharttemp as db')->where('db.unit', $this->data['unit'])->whereRaw('db.time between "'.$start.'" and "'.$end.'"')->where('loginid',$this->data['loginid'])->select('agentname','gatewaygrp','hub','unit','sensor_id','value','utc')->get();



		}
        return $items;
    }
	
	public function headings(): array
    {
        return [
			'Agent Name',
			'Gateway Group Name',
			'Sensor Hub Name',
			'Unit',
            'Sensor',			
            'value',
            'Time Stamp',
        ];
    }
}
