<?php

namespace App\Exports;

//use App\Sensor;
use DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromQuery;

use Carbon\Carbon;

class Reportadminhub implements FromCollection, WithHeadings
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
			/*$items = DB::table('dbo_payloader')
			->join('sensor_hubs', 'sensor_hubs.hub_id', '=', 'dbo_payloader.hub')
			->join('gateway_groups', 'sensor_hubs.group_id', '=', 'gateway_groups.id')
			->join('sensor_groups', 'sensor_groups.id', '=', 'gateway_groups.sensor_group_id')
			->join('users', 'sensor_hubs.agent', '=', 'users.id')
			->join('sensors', 'sensors.sensor_id', '=', 'dbo_payloader.sensor_id')
			->whereRaw('dbo_payloader.time between "'.$start_week.'" and "'.$end_week.'"')
			->whereRaw('users.id = "'.$this->data['agent'].'"')
			->whereRaw('gateway_groups.id = "'.$this->data['group'].'"')
			->where('dbo_payloader.hub', $this->data['hub'])
			->orderBy('dbo_payloader.sensor_id')
			->select('users.fname', 'sensor_groups.name', 'dbo_payloader.hub', 'dbo_payloader.unit','dbo_payloader.sensor_id', 'dbo_payloader.time', 'dbo_payloader.value')
			->paginate(5000);*/
//dd("hai");
/*$items = DB::table('dbo_payloadercharttemphub')
			->join('sensor_hubs', 'sensor_hubs.hub_id', '=', 'dbo_payloadercharttemphub.hub')
			->join('gateway_groups', 'sensor_hubs.group_id', '=', 'gateway_groups.id')
			->join('sensor_groups', 'sensor_groups.id', '=', 'gateway_groups.sensor_group_id')
			->join('users', 'sensor_hubs.agent', '=', 'users.id')
			->join('sensors', 'sensors.sensor_id', '=', 'dbo_payloadercharttemphub.sensor_id')
			->whereRaw('dbo_payloadercharttemphub.time between "'.$start_week.'" and "'.$end_week.'"')
			->whereRaw('users.id = "'.$this->data['agent'].'"')
			->whereRaw('gateway_groups.id = "'.$this->data['group'].'"')
			->where('dbo_payloadercharttemphub.hub', $this->data['hub'])
			->orderBy('dbo_payloadercharttemphub.sensor_id')
			
			->select('users.fname', 'sensor_groups.name', 'dbo_payloadercharttemphub.hub', 'dbo_payloadercharttemphub.unit','dbo_payloadercharttemphub.sensor_id', 'dbo_payloadercharttemphub.time', 'dbo_payloadercharttemphub.value')
			->paginate(5000);*/

$items = DB::table('dbo_payloader as dph')
			->join('sensor_hubs', 'sensor_hubs.hub_id', '=', 'dph.hub')
			->join('gateway_groups', 'sensor_hubs.group_id', '=', 'gateway_groups.id')
			->join('sensor_groups', 'sensor_groups.id', '=', 'gateway_groups.sensor_group_id')
			->join('users', 'sensor_hubs.agent', '=', 'users.id')
			->join('sensors', 'sensors.sensor_id', '=', 'dph.sensor_id')
			->whereRaw('users.id = "'.$this->data['agent'].'"')
			->whereRaw('gateway_groups.id = "'.$this->data['group'].'"')
			->where('dph.hub', $this->data['hub'])
			->whereRaw('dph.time between "'.$start_week.'" and "'.$end_week.'"')
			->orderBy('dph.sensor_id')
			->select('users.fname', 'sensor_groups.name', 'dph.hub', 'dph.unit','dph.sensor_id', 'dph.time', 'dph.value')->get();





		}
		if($this->data['tme']=='day')
		{
			/*$items = DB::table('dbo_payloader')
			->join('sensor_hubs', 'sensor_hubs.hub_id', '=', 'dbo_payloader.hub')
			->join('gateway_groups', 'sensor_hubs.group_id', '=', 'gateway_groups.id')
			->join('sensor_groups', 'sensor_groups.id', '=', 'gateway_groups.sensor_group_id')
			->join('users', 'sensor_hubs.agent', '=', 'users.id')
			->join('sensors', 'sensors.sensor_id', '=', 'dbo_payloader.sensor_id')
			->whereRaw('users.id = "'.$this->data['agent'].'"')
			->whereRaw('gateway_groups.id = "'.$this->data['group'].'"')
			->where('dbo_payloader.hub', $this->data['hub'])
			->whereDate('dbo_payloader.time', Carbon::today())
			->orderBy('dbo_payloader.sensor_id')
			->select('users.fname', 'sensor_groups.name', 'dbo_payloader.hub', 'dbo_payloader.unit','dbo_payloader.sensor_id', 'dbo_payloader.time', 'dbo_payloader.value')
			->paginate(5000);*/



/*$items = DB::table('dbo_payloadercharttemphub')
			->join('sensor_hubs', 'sensor_hubs.hub_id', '=', 'dbo_payloadercharttemphub.hub')
			->join('gateway_groups', 'sensor_hubs.group_id', '=', 'gateway_groups.id')
			->join('sensor_groups', 'sensor_groups.id', '=', 'gateway_groups.sensor_group_id')
			->join('users', 'sensor_hubs.agent', '=', 'users.id')
			->join('sensors', 'sensors.sensor_id', '=', 'dbo_payloadercharttemphub.sensor_id')
			->whereRaw('users.id = "'.$this->data['agent'].'"')
			->whereRaw('gateway_groups.id = "'.$this->data['group'].'"')
			->where('dbo_payloadercharttemphub.hub', $this->data['hub'])
			->whereDate('dbo_payloadercharttemphub.time', Carbon::today())
			->orderBy('dbo_payloadercharttemphub.sensor_id')
			->select('users.fname', 'sensor_groups.name', 'dbo_payloadercharttemphub.hub', 'dbo_payloadercharttemphub.unit','dbo_payloadercharttemphub.sensor_id', 'dbo_payloadercharttemphub.time', 'dbo_payloadercharttemphub.value')->get();*/
			//->paginate(5000);

$items = DB::table('dbo_payloader as dph')
			->join('sensor_hubs', 'sensor_hubs.hub_id', '=', 'dph.hub')
			->join('gateway_groups', 'sensor_hubs.group_id', '=', 'gateway_groups.id')
			->join('sensor_groups', 'sensor_groups.id', '=', 'gateway_groups.sensor_group_id')
			->join('users', 'sensor_hubs.agent', '=', 'users.id')
			->join('sensors', 'sensors.sensor_id', '=', 'dph.sensor_id')
			->whereRaw('users.id = "'.$this->data['agent'].'"')
			->whereRaw('gateway_groups.id = "'.$this->data['group'].'"')
			->where('dph.hub', $this->data['hub'])
			->whereDate('dph.time', Carbon::today())
			->orderBy('dph.sensor_id')
			->select('users.fname', 'sensor_groups.name', 'dph.hub', 'dph.unit','dph.sensor_id', 'dph.time', 'dph.value')->get();

		}		
		if($this->data['tme']=='month')
		{
			$start_month = strtotime("-29 day");
			$end_month = strtotime("+1 day");
			$start_month = date("Y-m-d",$start_month);
			$end_month = date("Y-m-d",$end_month);
			/*$items = DB::table('dbo_payloader')
			->join('sensor_hubs', 'sensor_hubs.hub_id', '=', 'dbo_payloader.hub')
			->join('gateway_groups', 'sensor_hubs.group_id', '=', 'gateway_groups.id')
			->join('sensor_groups', 'sensor_groups.id', '=', 'gateway_groups.sensor_group_id')
			->join('users', 'sensor_hubs.agent', '=', 'users.id')
			->join('sensors', 'sensors.sensor_id', '=', 'dbo_payloader.sensor_id')
			->whereRaw('users.id = "'.$this->data['agent'].'"')
			->whereRaw('gateway_groups.id = "'.$this->data['group'].'"')
			->where('dbo_payloader.hub', $this->data['hub'])
			->whereRaw('dbo_payloader.time between "'.$start_month.'" and "'.$end_month.'"')
			->orderBy('dbo_payloader.sensor_id')
			->select('users.fname', 'sensor_groups.name', 'dbo_payloader.hub', 'dbo_payloader.unit','dbo_payloader.sensor_id', 'dbo_payloader.time', 'dbo_payloader.value')
			->paginate(5000);*/
/*$items = DB::table('dbo_payloadercharttemphub')
			->join('sensor_hubs', 'sensor_hubs.hub_id', '=', 'dbo_payloadercharttemphub.hub')
			->join('gateway_groups', 'sensor_hubs.group_id', '=', 'gateway_groups.id')
			->join('sensor_groups', 'sensor_groups.id', '=', 'gateway_groups.sensor_group_id')
			->join('users', 'sensor_hubs.agent', '=', 'users.id')
			->join('sensors', 'sensors.sensor_id', '=', 'dbo_payloadercharttemphub.sensor_id')
			->whereRaw('users.id = "'.$this->data['agent'].'"')
			->whereRaw('gateway_groups.id = "'.$this->data['group'].'"')
			->where('dbo_payloadercharttemphub.hub', $this->data['hub'])
			->whereRaw('dbo_payloadercharttemphub.time between "'.$start_month.'" and "'.$end_month.'"')
			->orderBy('dbo_payloadercharttemphub.sensor_id')
			->select('users.fname', 'sensor_groups.name', 'dbo_payloadercharttemphub.hub', 'dbo_payloadercharttemphub.unit','dbo_payloadercharttemphub.sensor_id', 'dbo_payloadercharttemphub.time', 'dbo_payloadercharttemphub.value')
			->paginate(5000);*/
$items = DB::table('dbo_payloader as dph')
			->join('sensor_hubs', 'sensor_hubs.hub_id', '=', 'dph.hub')
			->join('gateway_groups', 'sensor_hubs.group_id', '=', 'gateway_groups.id')
			->join('sensor_groups', 'sensor_groups.id', '=', 'gateway_groups.sensor_group_id')
			->join('users', 'sensor_hubs.agent', '=', 'users.id')
			->join('sensors', 'sensors.sensor_id', '=', 'dph.sensor_id')
			->whereRaw('users.id = "'.$this->data['agent'].'"')
			->whereRaw('gateway_groups.id = "'.$this->data['group'].'"')
			->where('dph.hub', $this->data['hub'])
			//->whereDate('dph.time', Carbon::today())
			->whereRaw('dph.time between "'.$start_month.'" and "'.$end_month.'"')
			->orderBy('dph.sensor_id')
			->select('users.fname', 'sensor_groups.name', 'dph.hub', 'dph.unit','dph.sensor_id', 'dph.time', 'dph.value')->get();



			
		}
		if($this->data['tme']=='one')
		{
			$start = date("Y-m-d",strtotime($this->data['from']));
			$end = date("Y-m-d",strtotime($this->data['to']."+1 day"));
			/*$items = DB::table('dbo_payloader')
			->join('sensor_hubs', 'sensor_hubs.hub_id', '=', 'dbo_payloader.hub')
			->join('gateway_groups', 'sensor_hubs.group_id', '=', 'gateway_groups.id')
			->join('sensor_groups', 'sensor_groups.id', '=', 'gateway_groups.sensor_group_id')
			->join('users', 'sensor_hubs.agent', '=', 'users.id')
			->join('sensors', 'sensors.sensor_id', '=', 'dbo_payloader.sensor_id')
			->whereRaw('dbo_payloader.time between "'.$start.'" and "'.$end.'"')
			->whereRaw('users.id = "'.$this->data['agent'].'"')
			->whereRaw('gateway_groups.id = "'.$this->data['group'].'"')
			->where('dbo_payloader.hub', $this->data['hub'])
			->orderBy('dbo_payloader.sensor_id')
			->select('users.fname', 'sensor_groups.name', 'dbo_payloader.hub', 'dbo_payloader.unit','dbo_payloader.sensor_id', 'dbo_payloader.time', 'dbo_payloader.value')
			->paginate(5000);*/

/*$items = DB::table('dbo_payloadercharttemphub')
			->join('sensor_hubs', 'sensor_hubs.hub_id', '=', 'dbo_payloadercharttemphub.hub')
			->join('gateway_groups', 'sensor_hubs.group_id', '=', 'gateway_groups.id')
			->join('sensor_groups', 'sensor_groups.id', '=', 'gateway_groups.sensor_group_id')
			->join('users', 'sensor_hubs.agent', '=', 'users.id')
			->join('sensors', 'sensors.sensor_id', '=', 'dbo_payloadercharttemphub.sensor_id')
			->whereRaw('dbo_payloadercharttemphub.time between "'.$start.'" and "'.$end.'"')
			->whereRaw('users.id = "'.$this->data['agent'].'"')
			->whereRaw('gateway_groups.id = "'.$this->data['group'].'"')
			->where('dbo_payloadercharttemphub.hub', $this->data['hub'])
			->orderBy('dbo_payloadercharttemphub.sensor_id')
			->select('users.fname', 'sensor_groups.name', 'dbo_payloadercharttemphub.hub', 'dbo_payloadercharttemphub.unit','dbo_payloadercharttemphub.sensor_id', 'dbo_payloadercharttemphub.time', 'dbo_payloadercharttemphub.value')
			->paginate(5000);*/


$items = DB::table('dbo_payloader as dph')
			->join('sensor_hubs', 'sensor_hubs.hub_id', '=', 'dph.hub')
			->join('gateway_groups', 'sensor_hubs.group_id', '=', 'gateway_groups.id')
			->join('sensor_groups', 'sensor_groups.id', '=', 'gateway_groups.sensor_group_id')
			->join('users', 'sensor_hubs.agent', '=', 'users.id')
			->join('sensors', 'sensors.sensor_id', '=', 'dph.sensor_id')
			->whereRaw('users.id = "'.$this->data['agent'].'"')
			->whereRaw('gateway_groups.id = "'.$this->data['group'].'"')
			->where('dph.hub', $this->data['hub'])
			//->whereDate('dph.time', Carbon::today())
			->whereRaw('dph.time between "'.$start.'" and "'.$end.'"')
			->orderBy('dph.sensor_id')
			->select('users.fname', 'sensor_groups.name', 'dph.hub', 'dph.unit','dph.sensor_id', 'dph.time', 'dph.value')->get();







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
			'Time Stamp',
            'value'
        ];
    }
}
