<form id="logoutform" action="{{ route('logout') }}" method="POST" style="display: none;">
	{{ csrf_field() }}
</form>
<?php  
	date_default_timezone_set('Asia/Kolkata');
	$curtimesession = date("Y-m-d H:i:s", time());
	$uptoken = DB::table('users')
	->where('id', session()->get('userid'))
	->first();
	if($uptoken->log_status == '0')
	{
?>
	<script type="text/javascript">
		document.getElementById('logoutform').submit();
	</script>
<?php } else { ?>
<?php
	$up=DB::table('users')
	->where('id', session()->get('userid'))
	->update(['logintoken'=> $curtimesession]);
?>
<?php } ?>
<?php /*?>{{dd(Session::all()) }}<?php */?>
<?php $username = session()->get('name'); ?>
<div class="row euz_header euz_height">
    <div class="col-md-6 col">
		<h6 class="euz_b m-0 text-white pt-1 euz_mob">ARGUS Panoptes - Administration</h6>
	</div>
	<div class="col-md-6 col euz_text_right euz_p6">

				<small class="text-white"><?php echo $username; ?></small>

				<a href="#"><i class="fas fa-user-tie euz_admin text-white"></i></a>
<?php if(session()->get('role')==1) { ?>
				<label class="euz_v_line"></label>

				<a href="{{ url('/admin') }}" data-toggle="tooltip" title="Back to Dashboard"><i class="fas fa-home euz_admin text-white"></i></a>

				<label class="euz_v_line"></label>

				<a href="{{ url('/admin/emails') }}" data-toggle="tooltip" title="System Setting"><i class="fas fa-cog euz_admin text-white"></i></a>

				<label class="euz_v_line"></label>
<?php } ?>
				<a href="#" onclick="event.preventDefault(); document.getElementById('logoutform').submit();"><i class="fas fa-power-off euz_logout text-white"></i></a>

			</div>
	<?php /*?><div class="col-md-6 col euz_text_right euz_p6">
		<small class="text-white"><?php echo $username; ?></small>
		<a href="#"><i class="fas fa-user-tie euz_admin text-white"></i></a>
		<label class="euz_v_line"></label>
		<a href="#" onclick="event.preventDefault(); document.getElementById('logoutform').submit();"><i class="fas fa-power-off euz_logout text-white"></i></a>
	</div><?php */?>
</div>
<?php //}
?>