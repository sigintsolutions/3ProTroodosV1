<?php
	namespace App\Exports;
	use DB;
	use Maatwebsite\Excel\Concerns\FromCollection;
	use Maatwebsite\Excel\Concerns\WithHeadings;
	use Maatwebsite\Excel\Concerns\FromQuery;
	class TypeExport implements FromCollection, WithHeadings
	{
		private $data;
		public function __construct()
		{
			//$this->data = $data;
		}
		public function collection()
		{
			$items = DB::table('types')->select('sname', 'modal', 'brand', 'min', 'max', 'remark')->get();
			return $items;			
		}
		public function headings(): array
		{
			return [
			    'Sensor Name',
			    'Modal',
			    'Brand',
				//'Type',
				//'Unit',			
				'Min Value',
				'Max Value',
				'Remark'
			];
		}
	}
?>