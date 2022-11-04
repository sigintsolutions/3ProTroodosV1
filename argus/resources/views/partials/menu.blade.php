<?php 
//error_reporting(0);
if(session()->get('role')==1) { ?>
	<div class="row euz_menu">
	@if(request()->segment(2)!='emails' && request()->segment(2)!='users' && request()->segment(2)!='adduser' && request()->segment(2)!='editUser')
            <div class="col-md-1 text-center euz_left_border px-0 euz_25">
				<a href="{{ url('/admin') }}" class="euz_a" id="dashboards">
					<label class="pt-2 euz_label_menu">
						<i class="fas fa-tachometer-alt"></i><br><small class="euz_b">Dashboard</small>
					</label>					
				</a>
			</div>
			<div class="col-md-1 text-center euz_left_border px-0 euz_25">
				<a href="{{ route('admin.agents.index') }}" class="euz_a" id="agent">
					<label class="pt-2 euz_label_menu">
						<i class="fas fa-user"></i><br><small class="euz_b">Agents</small>
					</label>
				</a>
			</div>
			<div class="col-md-1 text-center euz_left_border px-0 euz_25">
				<a href="{{ url('/admin/weather') }}" class="euz_a" id="wea">
					<label class="pt-2 euz_label_menu">
						<i class="fas fa-cloud-sun"></i><br><small class="euz_b">Weather</small>
					</label>
				</a>
			</div>
			<!--<div class="col-md-1 text-center euz_left_border euz_cus_p euz_25">
				<a href="sensor.html" class="euz_a">
					<i class="far fa-file-alt"></i><br><small class="euz_b">Report</small>
				</a>
			</div>-->
			<div class="col-md-1 text-center euz_left_border px-0 euz_25">
				<a href="{{ url('/admin/userlog') }}" class="euz_a" id="sensor">
					<label class="pt-2 euz_label_menu">
						<i class="fas fa-microchip"></i><br><small class="euz_b">Sensors Report</small>
					<?php
						$countmsgdt=DB::table('userdatamessagesagent')->where('readflag',0)->get();
						$countmsg=count($countmsgdt);
						if ($countmsg==0)
						{
					?>
					<label style="display:none" class='pulse-button adminmsgc'></label>
					<?php } else {?>
					<label style="" class='pulse-button adminmsgc'><?php //echo $countmsg;?> </label>
					<?php } ?>
					</label>
				</a>
			</div>
			<div class="col-md-1 text-center euz_left_border px-0 euz_25">
				<a href="{{ url('/admin/algorithms') }}" class="euz_a" id="algorithm">
					<label class="pt-2 euz_label_menu">
						<i class="fas fa-square-root-alt"></i><br><small class="euz_b">Algorithm Editor</small>
					</label>
				</a>
			</div>
			<div class="col-md-1 text-center euz_left_border px-0 euz_25">
				<a href="{{ route('admin.settings.index') }}" class="euz_a" id="setting">
					<label class="pt-2 euz_label_menu">
						<i class="fas fa-cog"></i><br><small class="euz_b">Settings</small>
					</label>
				</a>
			</div>
			@else
			<div class="col-md-1 text-center euz_left_border px-0 euz_25">
				<a href="{{ url('/admin/emails') }}" class="euz_a" id="emailsetting">
					<label class="pt-2 euz_label_menu">
						<i class="fas fa-envelope"></i><br><small class="euz_b">Email</small>
					</label>
				</a>
			</div>
			<div class="col-md-1 text-center euz_left_border px-0 euz_25">
				<a href="{{ route('admin.users.index') }}" class="euz_a" id="Admin">
					<label class="pt-2 euz_label_menu">
						<i class="fas fa-user-tie"></i><br><small class="euz_b">Admin</small>
					</label>
				</a>
			</div>
			@endif
        </div>
		<?php } ?>
		<?php if(session()->get('role')==2) { ?>
		
		<div class="row euz_menu">
            <div class="col-md-1 text-center euz_left_border px-0 euz_25">
				<a href="{{ url('/agent') }}" class="euz_a" id="dashboards2">
					<label class="pt-2 euz_label_menu">
						<i class="fas fa-tachometer-alt"></i><br><small class="euz_b">Dashboard</small>
					</label>
				</a>
			</div>
			<div class="col-md-1 text-center euz_left_border px-0 euz_25">
				<a href="{{ url('/agent/profile') }}" class="euz_a" id="profile">
					<label class="pt-2 euz_label_menu">
						<i class="fas fa-user-tie"></i><br><small class="euz_b">Profile</small>
					</label>
				</a>
			</div>
			<div class="col-md-1 text-center euz_left_border px-0 euz_25">
				<a href="{{ url('/agent/gateway') }}" class="euz_a" id="gateway">
					<label class="pt-2 euz_label_menu">
						<i class="fas fa-info-circle"></i><br><small class="euz_b">Information</small>
					</label>
				</a>
			</div>
			<div class="col-md-1 text-center euz_left_border px-0 euz_25">
				<a href="{{ url('/agent/userlog') }}" class="euz_a" id="sensor">
					<label class="pt-2 euz_label_menu">
						<i class="fas fa-microchip"></i><br><small class="euz_b">Sensors Report</small>
					<?php
						$agentid=session()->get('userid');
						$countmsgdt=DB::table('userdatamessagesagent')->where('userid',$agentid)->where('readflaguserid',0)->get();
						$countmsgagent=count($countmsgdt);
						if ($countmsgagent==0)
						{
					?>
					<label style="display:none" class='pulse-button agentmsgc'></label>
					<?php } else {?>
					<label style="" class='pulse-button agentmsgc'><?php //echo $countmsg;?> </label>
					<?php } ?>
					</label>
				</a>
			</div>			
			<div class="col-md-1 text-center euz_left_border px-0 euz_25">
				<a href="{{ url('/agent/algorithm') }}" class="euz_a" id="algorithm">
					<label class="pt-2 euz_label_menu">
						<i class="fas fa-user"></i><br><small class="euz_b">Algorithm</small>
					</label>
				</a>
			</div>		
        </div>
		
		<?php } ?>
<script>
$('#setting').click(function(event)
{
	$(".loader").show();
}); 
</script>