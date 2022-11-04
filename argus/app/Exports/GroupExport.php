<?php
	namespace App\Exports;
	use DB;
	use Maatwebsite\Excel\Concerns\FromCollection;
	use Maatwebsite\Excel\Concerns\WithHeadings;
	use Maatwebsite\Excel\Concerns\FromQuery;
	class GroupExport implements FromCollection, WithHeadings
	{
		private $data;
		public function __construct($data)
		{
			$this->data = $data;
		}
		public function collection()
		{
			$lists = explode(',', $this->data['group']);
			$items = DB::table('gateway_groups')
			->join('users', 'users.id', '=', 'gateway_groups.agent')
			->join('sensor_groups', 'sensor_groups.id', '=', 'gateway_groups.sensor_group_id')
			->whereIn('gateway_groups.id', $lists)
			->select('sensor_groups.name', 'gateway_groups.sim_no', 'gateway_groups.router_sensor_no', 'gateway_groups.latitude', 'gateway_groups.longitude', 'gateway_groups.sensor_information', 'gateway_groups.group_id')
			->get();
			return $items;			
		}
		public function headings(): array
		{
			return [
				'Gateway Group Name',
				'Sim card / Ref:Id',
				'Router Sensor Number',
				'Latitude',
				'Longitude',
				'Gateway Group Information',
				'Group Id'
			];
		}
	}
?>