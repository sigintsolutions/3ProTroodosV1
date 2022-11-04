<?php

namespace App\Exports;

//use App\Sensor;
use DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromQuery;

class SensorExport implements FromCollection, WithHeadings
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
			
			$items=DB::table('sensors')
			->join('sensor_hubs', 'sensors.hub_id', '=', 'sensor_hubs.id')
			->join('sensor_groups', 'sensor_hubs.sensor_group_id', '=', 'sensor_groups.id')
			->join('hubs', 'sensor_hubs.hub_id', '=', 'hubs.id')
			->join('users', 'sensor_hubs.agent', '=', 'users.id')
			->join('espdata', 'espdata.MAC', '=', 'sensors.sensor_id')
			->whereRaw('espdata.RecordedDate between "'.$this->data['start'].'" and "'.$this->data['end'].'"')
			->where('users.id', $this->data['agent'])
			->whereRaw('sensor_groups.id in ('.$this->data['group'].')')
			->whereRaw('hubs.id in ('.$this->data['hub'].')')
			->whereRaw('sensors.sensor_id in ('.$this->data['sensor'].')')
			->select(array('espdata.MAC','espdata.RecordedDate','espdata.Value'))
			->groupBy("espdata.MAC")
			->get();			
			
			//dd(DB::getQueryLog());die();
        	return $items;
    }
	
	public function headings(): array
    {
        return [
            'Sensor Id',
			'Time Stamp',
            'value'
        ];
    }
}
