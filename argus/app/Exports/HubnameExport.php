<?php
	namespace App\Exports;
	use DB;
	use Maatwebsite\Excel\Concerns\FromCollection;
	use Maatwebsite\Excel\Concerns\WithHeadings;
	use Maatwebsite\Excel\Concerns\FromQuery;
	class HubnameExport implements FromCollection, WithHeadings
	{
		private $data;
		public function __construct()
		{
			//$this->data = $data;
		}
		public function collection()
		{
			$items = DB::table('hubs')->select('name')->get();
			return $items;			
		}
		public function headings(): array
		{
			return [
				'Name'
			];
		}
	}
?>