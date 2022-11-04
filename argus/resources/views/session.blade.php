<form id="logoutform" action="{{ route('logout') }}" method="POST" style="display: none;">
    {{ csrf_field() }}
</form>
<?php 
	date_default_timezone_set('Asia/Kolkata');
	$up=DB::table('users')
	->where('id', session()->get('userid'))
	->first();
	$date = $up->logintoken; 	
	$firstdate = date('Y-m-d H:i:s', time());
	echo $minutes = round(abs(strtotime($date) - strtotime($firstdate)) / 60);	
	if($minutes > 3)
	{
		$up=DB::table('users')
		->where('id', session()->get('userid'))
		->update(['log_status'=>'0']);
		if($up)
		{
?>
	<script type="text/javascript">
		document.getElementById('logoutform').submit();
	</script>
<?php } } ?>