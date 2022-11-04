<?php
	namespace App\Exports;
	use DB;
	use Maatwebsite\Excel\Concerns\FromCollection;
	use Maatwebsite\Excel\Concerns\WithHeadings;
	use Maatwebsite\Excel\Concerns\FromQuery;
	class AgentExport implements FromCollection, WithHeadings
	{
		private $data;
		public function __construct($data)
		{
			$this->data = $data;
		}
		public function collection()
		{
		    $this->data['agent'];
			$lists = explode(',', $this->data['agent']);
			$items = DB::table('users')
			->whereIn('id', $lists)
			//->DATE_FORMAT( `service_start`.`service_expiry`, '%m/%d/%Y' )
			->select('fname', 'lname', 'corporate_name', 'street', 'city', 'state', 'post_code', 'country', 'service_start', 'service_expiry', 'email', 'original', 'remark', 'customer_id')
			->get();
			// foreach($items as $item) {
			// 	//return \Carbon\Carbon::parse($item->service_start)->format('d/m/y');
			// 	Carbon::parse($item->service_start)->format('d/m/y');
			// };
			return $items;			
		}
		public function headings(): array
		{
			return [
				'First Name',
				'Last Name',
				'Organization',
				'Street',
				'City',
				'State',
				'Postal Code',
				'Country',
				'Subscription Start Date (dd-mm-yyyy)',
				'Subscription End & Renew Date (dd-mm-yyyy)',
				'Login Email',	
				'Password',
				'Remark',
				'Customer Id'
			];
		}
	}
?>