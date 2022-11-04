<?php

namespace App\Exports;

//use App\Sensor;
use DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromQuery;

use Carbon\Carbon;

class ReportExport implements FromCollection, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
	private $data;

    public function __construct($data)
    {
        $this->data = $data;
		//print_r($this->data);
    }
    public function collection()
    {	
		if($this->data['tme']=='week')
		{
			$start_week = strtotime("-6 day");
			$end_week = strtotime("+1 day");
			$start_week = date("Y-m-d",$start_week);
			$end_week = date("Y-m-d",$end_week);	
			/*$items = DB::table('sensors')
			->join('sensor_hubs', 'sensors.hub_id', '=', 'sensor_hubs.id')
			->join('gateway_groups', 'sensor_hubs.group_id', '=', 'gateway_groups.id')
			->join('users', 'sensor_hubs.agent', '=', 'users.id')
			->join('dbo_payloader', 'dbo_payloader.sensor_id', '=', 'sensors.sensor_id')
			->whereRaw('dbo_payloader.time between "'.$start_week.'" and "'.$end_week.'"')
			->where('users.id', $this->data['agent'])
			->where('gateway_groups.id', $this->data['group'])
			->where('sensor_hubs.id', $this->data['hub'])
			->whereRaw('dbo_payloader.sensor_id = "'.$this->data['sensor'].'"')
			//->groupBy(DB::raw('Date(time)'))
			->select('users.fname','dbo_payloader.sensor_id','dbo_payloader.time','dbo_payloader.value')
			->get();*/
			$loginid=$this->data['loginid'];
$items=DB::table('dbo_payloadercharttemp')->where('dbo_payloadercharttemp.unit', $this->data['unit'])->whereIn('dbo_payloadercharttemp.hub',$this->data['hub'])->whereRaw('dbo_payloadercharttemp.time between "'.$start_week.'" and "'.$end_week.'"')->where('loginid',$this->data['loginid'])->whereIn('dbo_payloadercharttemp.sensor_id', $this->data['sensor'])->select('agentname','gatewaygrp','hub','unit','sensor_id','value','time')->take(1000)->get();





		}
		if($this->data['tme']=='day')
		{
			/*$items = DB::table('sensors')
			->join('sensor_hubs', 'sensors.hub_id', '=', 'sensor_hubs.id')
			->join('gateway_groups', 'sensor_hubs.group_id', '=', 'gateway_groups.id')
			->join('users', 'sensor_hubs.agent', '=', 'users.id')
			->join('dbo_payloader', 'dbo_payloader.sensor_id', '=', 'sensors.sensor_id')
			->where('users.id', $this->data['agent'])
			->where('gateway_groups.id', $this->data['group'])
			->where('sensor_hubs.id', $this->data['hub'])
			->whereRaw('dbo_payloader.sensor_id = "'.$this->data['sensor'].'"')
			->whereDate('dbo_payloader.time', Carbon::today())
			->orderBy('dbo_payloader.sensor_id')
			->select('users.fname','dbo_payloader.sensor_id','dbo_payloader.time','dbo_payloader.value')
			->get();*/
$loginid=$this->data['loginid'];
//$loginid=session()->get('userid');
			//->where('loginid',$this->data['loginid'])
$items=DB::table('dbo_payloadercharttemp')->where('dbo_payloadercharttemp.unit', $this->data['unit'])->whereIn('dbo_payloadercharttemp.hub',$this->data['hub'])->whereDate('dbo_payloadercharttemp.time', Carbon::today())->where('loginid',$this->data['loginid'])->whereIn('dbo_payloadercharttemp.sensor_id', $this->data['sensor'])->select('agentname','gatewaygrp','hub','unit','sensor_id','value','time')->take(1000)->get();





		}		
		if($this->data['tme']=='month')
		{
			$start_month = strtotime("-29 day");
			$end_month = strtotime("+1 day");
			$start_month = date("Y-m-d",$start_month);
			$end_month = date("Y-m-d",$end_month);
		/*	$items = DB::table('sensors')
			->join('sensor_hubs', 'sensors.hub_id', '=', 'sensor_hubs.id')
			->join('gateway_groups', 'sensor_hubs.group_id', '=', 'gateway_groups.id')
			->join('users', 'sensor_hubs.agent', '=', 'users.id')
			->join('dbo_payloader', 'dbo_payloader.sensor_id', '=', 'sensors.sensor_id')
			->where('users.id', $this->data['agent'])
			->where('gateway_groups.id', $this->data['group'])
			->where('sensor_hubs.id', $this->data['hub'])
			->whereRaw('dbo_payloader.sensor_id = "'.$this->data['sensor'].'"')
			->whereRaw('dbo_payloader.time between "'.$start_month.'" and "'.$end_month.'"')
			
			->select('users.fname','dbo_payloader.sensor_id','dbo_payloader.time','dbo_payloader.Value')
			->get();*/
$loginid=$this->data['loginid'];
//$loginid=session()->get('userid');
			//->where('loginid',$this->data['loginid'])
$items=DB::table('dbo_payloadercharttemp')->where('dbo_payloadercharttemp.unit', $this->data['unit'])->whereIn('dbo_payloadercharttemp.hub',$this->data['hub'])->whereRaw('dbo_payloadercharttemp.time between "'.$start_month.'" and "'.$end_month.'"')->where('loginid',$this->data['loginid'])->whereIn('dbo_payloadercharttemp.sensor_id', $this->data['sensor'])->select('agentname','gatewaygrp','hub','unit','sensor_id','value','time')->take(1000)->get();





			
		}
		if($this->data['tme']=='one')
		{
			$start = date("Y-m-d",strtotime($this->data['from']));
			$end = date("Y-m-d",strtotime($this->data['to']."+1 day"));
			/*$items = DB::table('sensors')
			->join('sensor_hubs', 'sensors.hub_id', '=', 'sensor_hubs.id')
			->join('gateway_groups', 'sensor_hubs.group_id', '=', 'gateway_groups.id')
			->join('users', 'sensor_hubs.agent', '=', 'users.id')
			->join('dbo_payloader', 'dbo_payloader.sensor_id', '=', 'sensors.sensor_id')
			->whereRaw('dbo_payloader.time between "'.$start.'" and "'.$end.'"')
			->where('users.id', $this->data['agent'])
			->where('gateway_groups.id', $this->data['group'])
			->where('sensor_hubs.id', $this->data['hub'])
			->whereRaw('dbo_payloader.sensor_id = "'.$this->data['sensor'].'"')
			->orderBy('dbo_payloader.sensor_id')
			->select('users.fname','dbo_payloader.sensor_id','dbo_payloader.time','dbo_payloader.value')
			->get();*/
$loginid=$this->data['loginid'];
$items=DB::table('dbo_payloadercharttemp')->where('dbo_payloadercharttemp.unit', $this->data['unit'])->whereIn('dbo_payloadercharttemp.hub',$this->data['hub'])->whereRaw('dbo_payloadercharttemp.time between "'.$start.'" and "'.$end.'"')->where('loginid',$this->data['loginid'])->whereIn('dbo_payloadercharttemp.sensor_id', $this->data['sensor'])->select('agentname','gatewaygrp','hub','unit','sensor_id','value','time')->take(1000)->get();




		}
        return $items;
    }
	
	public function headings(): array
    {
       /* return [
            'Agent Name',
            'Sensor',
			'Time Stamp',
            'value'
        ];*/

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
