@extends('layouts.admin')
@section('content')
<?php //dd($users) ?>
<div class="p-3 add_Algorithm_table">

			<div class="row">

				<div class="col-md-12 euz_bar">

					<i class="fas fa-envelope euz_text_blue"></i> <small class="euz_b euz_text_blue">Email Templates</small>

				</div>

				<div id="table_data2" style="display:none;" class="w-100">
				<div class="alert alert-success w-100"><button type="button" class="close" data-dismiss="alert">&times;</button>Record inserted successfully</div>.<br/>
				</div>
				
				<div id="table_data3" style="display:none;" class="w-100">
				<div class="alert alert-success w-100"><button type="button" class="close" data-dismiss="alert">&times;</button>Record updated successfully</div>.<br/>
				</div>
				
				<div id="table_data4" style="display:none;" class="w-100">
				<div class="alert alert-success w-100"><button type="button" class="close" data-dismiss="alert">&times;</button>Record inserted successfully</div>.<br/>
				</div>
				
				<div id="table_data5" style="display:none;" class="w-100">
				<div class="alert alert-success w-100"><button type="button" class="close" data-dismiss="alert">&times;</button>Record updated successfully</div>.<br/>
				</div>


				<div class="col-md-12 euz_border p-3 bg-white">

					<div class="row">

						<div class="col-md-12 mt-2">

							<ul class="nav nav-tabs euz_tab" role="tablist">

								<li class="nav-item">

									<a class="nav-link euz_tabtex active" data-toggle="tab" href="#loghistoryqq"><i class="fas fa-user-tie"></i> Admin</a>

								</li>

								<li class="nav-item">

									<a class="nav-link euz_tabtex" data-toggle="tab" href="#senrepor"><i class="fas fa-user"></i> Agent</a>

								</li>

							</ul>

			

								<!-- Tab panes -->

							<div class="tab-content px-3">

								<div id="loghistoryqq" class="tab-pane active">

									<div class="row py-3">

										<div class="col-lg-7 col-md-12 mt-2 mb-3">

											<div class="shadow-sm">

												<div class="col-md-12 euz_box_head">

													<p class="text-white euz_b mb-0">Email template ( New/Edit Admin User )</p>

												</div>
<form method="post" name="frm" id="frm">
{{ csrf_field() }}
								<input type="hidden" name="eid" class="eid" value="{{ @$users[0]->id }}" id="eid" />
												<div class="col-md-12 euz_border pt-3">

													<textarea type="text" class="form-control" required rows="10" id="email" name="email" placeholder="Dear << firstname >>, .....">{{ (@$users[0]->admin_email)?@$users[0]->admin_email:"" }}</textarea>

													<div class="row bg-light mt-3">

														<div class="col-md-12 p-2">

															<button type="submit" name="butEmail" id="butEmail" class="btn btn-success rounded-0 euz_bt"><i class="fas fa-save"></i> Save</button>

															&nbsp;&nbsp;

															<button type="reset" class="btn btn-info rounded-0 euz_bt"><i class="fas fa-undo"></i> Reset</button>

														</div>

													</div>

												</div>

											</div>
</form>
										</div>

										

										<div class="col-lg-5 col-md-12 mt-2 mb-3">

											<div class="shadow-sm">

												<div class="col-md-12 euz_box_head">

													<p class="text-white euz_b mb-0">Email Tagline</p>

												</div>

												<div class="col-md-12 euz_border">

													

													<div class="alert alert-info mt-3">

														<b>Note:  Copy/Type the tagline to attach the tag. ( Sample: Dear << firstname >> << lastname >>, )</b>

													</div>

												

													<ul class="euz_emai">

														<li><label><b>First Name </label><label class="euz_dot">:</label></b> << firstname >> </li>

														<li><label><b>Last Name </label><label class="euz_dot">:</label></b> << lastname >> </li>

														<li><label><b>Email </label><label class="euz_dot">:</label></b> << email >> </li>

														<li><label><b>Mobile Number </label><label class="euz_dot">:</label></b> << mobile >> </li>

														<li><label><b>User Name </label><label class="euz_dot">:</label></b> << username >> </li>

														<li><label><b>Password </label><label class="euz_dot">:</label></b> << password >> </li>

													</ul>

												</div>

											</div>

										</div>

									</div>

								</div>

								<div id="senrepor" class="tab-pane fade">

									<div class="row py-3">

										<div class="col-lg-7 col-md-12 mt-2 mb-3">

											<div class="shadow-sm">

												<div class="col-md-12 euz_box_head">

													<p class="text-white euz_b mb-0">Email template ( New/Edit Agent User )</p>

												</div>
<form method="post" name="frm2" id="frm2">
{{ csrf_field() }}
								<input type="hidden" name="eid" class="eid" value="{{ @$users[0]->id }}" id="eid2" />

												<div class="col-md-12 euz_border pt-3">

													<textarea type="text" class="form-control" id="email2" name="email2" required rows="10" placeholder="Dear << firstname >>, .....">{{ (@$users[0]->agent_email)?@$users[0]->agent_email:"" }}</textarea>

													<div class="row bg-light mt-3">

														<div class="col-md-12 p-2">

															<button type="submit" name="butEmail2" id="butEmail2" class="btn btn-success rounded-0 euz_bt"><i class="fas fa-save"></i> Save</button>

															&nbsp;&nbsp;

															<button type="reset" class="btn btn-info rounded-0 euz_bt"><i class="fas fa-undo"></i> Reset</button>

														</div>

													</div>

												</div>

											</div>

										</div>

										

										<div class="col-lg-5 col-md-12 mt-2 mb-3">

											<div class="shadow-sm">

												<div class="col-md-12 euz_box_head">

													<p class="text-white euz_b mb-0">Email Tagline</p>

												</div>

												<div class="col-md-12 euz_border">

													

													<div class="alert alert-info mt-3">

														<b>Note:  Copy/Type the tagline to attach the tag. ( Sample: Dear << firstname >> << lastname >>, )</b>

													</div>

												

													<ul class="euz_emai">

														<li><label><b>First Name </label><label class="euz_dot">:</label></b> << firstname >> </li>

														<li><label><b>Last Name </label><label class="euz_dot">:</label></b> << lastname >> </li>

														<li><label><b>Email </label><label class="euz_dot">:</label></b> << email >> </li>

														<li><label><b>Mobile Number </label><label class="euz_dot">:</label></b> << mobile >> </li>

														<li><label><b>User Name </label><label class="euz_dot">:</label></b> << username >> </li>

														<li><label><b>Password </label><label class="euz_dot">:</label></b> << password >> </li>

													</ul>

												</div>

											</div>

										</div>

										

									</div>

								</div>

								

							</div>

						</div>

					</div>

				</div>

				

			</div>

        </div>
		
		



<?php /*?><div class="p-3 add_admin_table">
			<div class="row">
				<div class="col-md-12 euz_bar">
					<i class="fas fa-user-tie euz_text_blue"></i> <small class="euz_b euz_text_blue">Admin</small>
				</div>
				@if(Session::has('flash_message'))
				<div class="alert alert-success w-100"><button type="button" class="close" data-dismiss="alert">&times;</button>{{ Session::get('flash_message') }}</div>
				@endif
				<div class="col-md-12 euz_border p-3 bg-white">
					<div class="row">
						<div class="col-md-12">
							<a class="btn euz_btn_add float-right euz_pointer add_admin" href="/admin/adduser"><i class="fas fa-user-plus"></i> Add new Admin</a>
						</div>
						<div class="col-md-12 mt-2">
							<div class="table-responsive-sm">
								<table class="table table-bordered table-striped">
									<thead class="euz_thead">
										<tr>
											<th>Sl.No</th>
											<th>First Name</th>
											<th>Last Name</th>
											<th>Admin User Name</th>
											<th>Action</th>
										</tr>
									</thead>
									<tbody>
									@foreach($users as $index =>$item)
										<tr>
											<td>{{ $index + @$users->firstItem() }}</td>
											<td>{{ $item->fname }}</td>
											<td>{{ $item->lname }}</td>
											<td>{{ $item->email }}</td>
											<td><a href="editUser/{{ $item->id }}" class="euz_inblue"><i class="fas fa-user-edit"></i> Edit</a>&nbsp;&nbsp;&nbsp;&nbsp;<a href="deleteUser/{{ $item->id }}" class="euz_inred" onclick="return confirm('Are you sure to delete this item?')"><i class="fas fa-user-times"></i> Delete</a></td>
										</tr>
									@endforeach
									</tbody>
								</table>
							</div>
							{{ $users->links() }}
						</div>
						
					</div>
				</div>
				
			</div>
        </div><?php */?>

@endsection
@section('scripts')
		<script>
$(document).ready(function(){
$("#butEmail").click(function(e){
e.preventDefault();
if($("#eid").val()=="")
{
    $.ajax({
        url: "{{ url('/admin/insertemail') }}",
        type: "post",
        data: $('#frm').serialize(),
        success: function(data){
            $("#table_data2").show();
			$("#eid").val(data);
        }
    });
	}
	else
	{
	    $.ajax({
        url: "{{ url('/admin/updateemail') }}",
        type: "post",
        data: $('#frm').serialize(),
        success: function(data){
			$("#table_data2").hide();
			$("#table_data4").hide();
			$("#table_data5").hide();
            $("#table_data3").show();
        }
    });

	}
});

});

</script>

<script>
$(document).ready(function(){
$("#butEmail2").click(function(e){
e.preventDefault();
if($("#eid2").val()=="")
{
    $.ajax({
        url: "{{ url('/admin/insertemail2') }}",
        type: "post",
        data: $('#frm2').serialize(),
        success: function(data){
            $("#table_data4").show();
			$(".eid").val(data);
        }
    });
	}
	else
	{
	    $.ajax({
        url: "{{ url('/admin/updateemail2') }}",
        type: "post",
        data: $('#frm2').serialize(),
        success: function(data){
			$("#table_data2").hide();
			$("#table_data3").hide();
			$("#table_data4").hide();
			//$("#table_data5").hide();
            $("#table_data5").show();
        }
    });

	}
});

});

</script>

@parent

@endsection

