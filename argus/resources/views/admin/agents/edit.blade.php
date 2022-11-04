<!--Edit Agent-->
<div class="row">
	<div class="col-md-12">
		<div class="card euz_carb rounded-0 text-white">
			<div class="card-body">
				<h4 class="card-title m-0"><i class="fas fa-portrait text-info"></i> <?php echo $user[0]->fname.' '.$user[0]->lname; ?><a href="javascript:void(0)" class="closebtn float-right" onclick="profileclose()">×</a></h4>
			</div>
		</div>
		<ul class="nav nav-tabs nav-justified">
			<li class="nav-item">
				<a class="nav-link active" data-toggle="tab" href="#agprofile">Agent Profile</a>
			</li>
		</ul>
		<div class="tab-content">
			<div class="tab-pane active p-3" id="agprofile">
				<form action="{{ url('admin/updateagent') }}" method="POST" enctype="multipart/form-data">
					{{ csrf_field() }}
					<input type="hidden" name="eid" value="{{ $user[0]->id }}" id="eid" />
					<div class="row">
						<div class="form-group col-md-4">
							<label class="euz_b" for="">Customer ID</label>
							<input type="text" class="form-control" id="" value="<?php echo $user[0]->customer_id; ?>" readonly ="readonly" name="customer_id" />
						</div>
						<div class="form-group col-md-4">
							<label class="euz_b" for="">First Name</label>
							<input type="text" class="form-control disname" id="" value="<?php echo $user[0]->fname; ?>" disabled="disabled" name="fname" />
						</div>
						<div class="form-group col-md-4">
							<label class="euz_b" for="">Last Name</label>
							<input type="text" class="form-control disname" id="" value="<?php echo $user[0]->lname; ?>" disabled="disabled" name="lname" />
						</div>
						
						<div class="form-group col-md-4">
							<label class="euz_b" for="">Organization</label>
							<input type="text" class="form-control disname" id="" value="<?php echo $user[0]->corporate_name; ?>" disabled="disabled" name="corporate_name" />
						</div>
						<div class="form-group col-md-4">
							<label class="euz_b" for="">Street</label>
							<input type="text" class="form-control disname" id="" value="<?php echo $user[0]->street; ?>" disabled="disabled" name="street" />
						</div>
						<div class="form-group col-md-4">
							<label class="euz_b" for="">City</label>
							<input type="text" class="form-control disname" id="" value="<?php echo $user[0]->city; ?>" disabled="disabled" name="city" />
						</div>
						
						<div class="form-group col-md-4">
							<label class="euz_b" for="">State</label>
							<input type="text" class="form-control disname" id="" value="<?php echo $user[0]->state; ?>" disabled="disabled" name="state" />
						</div>
						<div class="form-group col-md-4">
							<label class="euz_b" for="">Post Code</label>
							<input type="text" class="form-control disname" id="" value="<?php echo $user[0]->post_code; ?>" disabled="disabled" name="post_code" />
						</div>
						<div class="form-group col-md-4">
							<label class="euz_b" for="">Country</label>
							<input type="text" class="form-control disname" id="" value="<?php echo $user[0]->country; ?>" disabled="disabled" name="country" />
						</div>
						<div class="form-group col-md-4">
							<label class="euz_b" for="">Subscription Start Date</label>
							<input type="date" class="form-control disname" id="" value="<?php echo date('Y-m-d', strtotime($user[0]->service_start)); ?>" disabled="disabled" name="service_start" />
						</div>
						<div class="form-group col-md-4">
							<label class="euz_b" for="">Subscription End & Renew Date</label>
							<input type="date" class="form-control disname" id="" value="<?php echo date('Y-m-d', strtotime($user[0]->service_expiry)); ?>" disabled="disabled" name="service_expiry" />
						</div>
						<div class="form-group col-md-4">
							<label class="euz_b" for="">Login Email</label>
							<input type="email" class="form-control disname" id="" value="<?php echo $user[0]->email; ?>" disabled="disabled" name="email" />
						</div>
						<div class="form-group col-md-4">
							<label class="euz_b" for="">Password</label>
							<input type="password" class="form-control disname" id="" value="<?php echo $user[0]->original; ?>" disabled="disabled" name="password" />
						</div>
						
						<div class="form-group col-md-8">
							<label class="euz_b" for="">Remark</label>
							<input type="text" class="form-control disname" id="" value="<?php echo $user[0]->remark; ?>" disabled="disabled" name="remark" />
						</div>
						<div class="form-group col-md-4 py-2 mb-0">
							<label for="" class="euz_b">Active</label><br>
							<div class="custom-control custom-radio custom-control-inline">
								<input type="radio" value="1" class="custom-control-input disname" id="yes" <?php if($user[0]->status == '1') { ?> checked="checked" <?php } ?> name="status" disabled="disabled" >
								<label class="custom-control-label euz_b" for="yes">Yes</label>
							</div>
							<div class="custom-control custom-radio custom-control-inline">
								<input type="radio" value="0" class="custom-control-input disname" id="no" <?php if($user[0]->status == '0') { ?> checked="checked" <?php } ?> name="status" disabled="disabled" >
								<label class="custom-control-label euz_b" for="no">No</label>
							</div>
						</div>
						
						<div class="form-group col-md-8 py-2 mb-0">
							<label for="" class="euz_b">Send Mail</label>
							<input type="checkbox" name="sendmail" value="Y" id="addsend" disabled="disabled" class="disname addsend" />
							<span> (System will send profile modification message to the corresponding login email id)</span>
						</div>
						<div class="form-group col-md-12 addsendmailshow" id="addsendmailshow">
							<textarea type="text" class="form-control disname" rows="10" disabled="disabled" name="template">
								<?php 
									if(!empty($user[0]->email_template)) 
									{ 
										echo $user[0]->email_template; 
									} 
									else 
									{ 
										echo $settings[0]->agent_email; 
									} 
								?> 
							</textarea>
						</div>						
						<div class="col-md-12">
							<a class="btn btn-danger float-right euz_all_edc ml-2" href="javascript:void(0)" onclick="profileclose()"><i class="fas fa-times"></i> Cancel</a>
							<button type="submit" class="btn btn-success float-right euz_all_edc ml-2 btnupdate" name="update"><i class="far fa-save"></i> Update</button>
							<a class="btn btn-primary float-right euz_all_edc ml-2 btnenable" href="#"><i class="far fa-edit"></i> Edit</a>
						</div>				
					</div>
				</form>
			</div>
		</div>
	</div>
</div>
<script>
	$(".btnupdate").hide();	
	$(".btnenable").click(function() {
		//$(".disname").attr('enabled', !$(".disname").attr('enabled'));
		$(".disname").removeAttr("disabled");
		$(".btnupdate").show(); 
		$(".btnenable").hide();
	});
</script>
<style>
	.modal-backdrop.show 
	{
		z-index: 0 !important;
	}
</style>
