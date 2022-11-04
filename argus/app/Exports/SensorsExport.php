<?php
	namespace App\Exports;
	use DB;
	use Maatwebsite\Excel\Concerns\FromCollection;
	use Maatwebsite\Excel\Concerns\WithHeadings;
	use Maatwebsite\Excel\Concerns\FromQuery;
	class SensorsExport implements FromCollection, WithHeadings
	{
		private $data;
		public function __construct($data)
		{
			$this->data = $data;
		}
		public function collection()
		{
			//echo $this->data['sensor'];die();
			$lists = explode(',', $this->data['sensor']);
			//print_r($lists);die();
			$items = DB::table('sensors')
			->join('sensor_hubs', 'sensor_hubs.id', '=', 'sensors.hub_id')
			//->join('hubs', 'hubs.id', '=', 'sensor_hubs.hub_id')
			->join('users', 'users.id', '=', 'sensor_hubs.agent')
			->join('types', 'types.id', '=', 'sensors.type')
			->whereIn('sensors.id', $lists)
			//->select('sensors.sensor_id', 'types.sname', 'types.modal', 'types.brand', 'sensors.sensor_type as typename', 'sensors.unit', 'sensors.value', 'types.min', 'types.max', 'sensors.sensor_inform', 'sensors.id')
			->select('sensors.sensor_id', 'types.sname', 'types.modal', 'types.brand', 'sensors.sensor_type as typename', 'sensors.unit','types.min', 'types.max', 'sensors.sensor_inform', 'sensors.id')
			->get();
			//print_r($items);die();
			return $items;			
		}
		public function headings(): array
		{
			return [
				//'First Name',
				//'Last Name',
				//'Hub Name',
				'Sensor Id',
				'Name',
				'Modal',
				'Brand',
				'Type',
				'Unit',
				/*'Value',*/
				'Min Value',
				'Max Value ',
				'Sensor Information',
				'Store Id',
			];
		}
	}
?>