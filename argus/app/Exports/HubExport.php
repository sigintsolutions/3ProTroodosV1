<?php
	namespace App\Exports;
	use DB;
	use Maatwebsite\Excel\Concerns\FromCollection;
	use Maatwebsite\Excel\Concerns\WithHeadings;
	use Maatwebsite\Excel\Concerns\FromQuery;
	class HubExport implements FromCollection, WithHeadings
	{
		private $data;
		public function __construct($data)
		{
			$this->data = $data;
		}
		public function collection()
		{
			$lists = explode(',', $this->data['hub']);
			$items = DB::table('sensor_hubs')
			->join('users', 'users.id', '=', 'sensor_hubs.agent')
			//->join('sensor_groups', 'sensor_groups.id', '=', 'sensor_hubs.sensor_group_id')
			//->join('hubs', 'hubs.id', '=', 'sensor_hubs.hub_id')
			->whereIn('sensor_hubs.id', $lists)
			->select('sensor_hubs.hub_id', 'sensor_hubs.mac_id', 'sensor_hubs.hub_inform', 'sensor_hubs.sensor_hub_id')
			->get();
			return $items;			
		}
		public function headings(): array
		{
			return [
				'Hub Name',
				'Mac Id',
				'Hub Information',
				'Sensor Hub id',
			];
		}
	}
?>