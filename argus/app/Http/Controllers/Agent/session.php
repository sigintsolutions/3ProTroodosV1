
<?php
	//$data = mysqli_query($conn, "UPDATE hubdata SET hub = '".$sval."' WHERE id = '1'");
?>
<form id="logoutform" action="{{ route('logout') }}" method="POST" style="display: none;">
    {{ csrf_field() }}
</form>
<?php 
	$conn=mysqli_connect("localhost", "payloader", "wY#UcYxpo659$6jzsHg","mqttdata") or die(mysqli_error()); 
	date_default_timezone_set('Asia/Kolkata');
	$data = mysqli_query($conn, "SELECT logintoken FROM users");
	$row = mysqli_fetch_assoc($data); 
	while($row = mysqli_fetch_assoc($data)) 
	{
		foreach($row as $key=>$value)
		{
			//$s[] = $value;
			print_r($value).'<br />';
			//$data = mysqli_query($conn, "UPDATE users SET hub = '".$sval."' WHERE id = '1'");
		}		
	}
	
	// $date = $up->logintoken; 	
	// $firstdate = date('Y-m-d H:i:s', time());
	// echo $minutes = round(abs(strtotime($date) - strtotime($firstdate)) / 60);	
	// if($minutes > 3)
	// {
	// 	$up=DB::table('users')
	// 	->where('id', session()->get('userid'))
	// 	->update(['log_status'=>'0']);
	// 	if($up)
	// 	{
?>
	<?php /* <script type="text/javascript">
		document.getElementById('logoutform').submit();
	</script>
<?php } } ?> * /?>