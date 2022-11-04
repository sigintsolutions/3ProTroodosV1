<?php
	namespace App\Exports;
	use DB;
	use Maatwebsite\Excel\Concerns\FromCollection;
	use Maatwebsite\Excel\Concerns\WithHeadings;
	use Maatwebsite\Excel\Concerns\FromQuery;
	class UnitExport implements FromCollection, WithHeadings
	{
		private $data;
		public function __construct()
		{
			//$this->data = $data;
		}
		public function collection()
		{
			$items = DB::table('measurement_units')->select('minimum', 'maximum', 'unit')->get();
			return $items;			
		}
		public function headings(): array
		{
			return [
				'Minimum',
				'Maximum',
				'Unit',
			];
		}
	}
?>