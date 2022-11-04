    <?php
    namespace App\Exports;
	use DB;
    use Maatwebsite\Excel\Concerns\FromQuery;
	use Maatwebsite\Excel\Concerns\Exportable;
    class PostExport implements FromQuery
    {
	use Exportable;
      public function collection()
      {
        $agent = $request->input('agent');
		$group = $request->input('group');
		$hub = $request->input('hub');
		$sensor = $request->input('sensor');
		
		$items = DB::table('sensors')
			->leftjoin('sensor_hubs', 'sensors.hub_id', '=', 'sensor_hubs.id')
			->leftjoin('sensor_groups', 'sensor_hubs.sensor_group_id', '=', 'sensor_groups.id')
			->leftjoin('hubs', 'sensor_hubs.hub_id', '=', 'hubs.id')
			->leftjoin('users', 'sensor_hubs.agent', '=', 'users.id')
			->where('users.id', $agent)
			->where('sensor_groups.id', $group)
			->where('hubs.id', $hub)
			->where('sensors.id', $sensor)
			->get();
			
		return $items;

      }
    }