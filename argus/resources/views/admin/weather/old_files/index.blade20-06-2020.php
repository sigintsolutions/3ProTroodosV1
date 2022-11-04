@extends('layouts.admin')
@section('content')
    <!---- euz_div ----->
	<div class="p-3 add_admin_table">
		<div class="row">
			<div class="col-md-12 euz_bar">
				<i class="fas fa-cloud-sun euz_text_blue"></i> <small class="euz_b euz_text_blue">Weather</small>
				<a href="<?php echo url('/admin/loc'); ?>" class="float-right"><small class="euz_b euz_text_blue">Location</small></a>
			</div>
			@if(Session::has('flash_message'))
            <div class="alert alert-success w-100"><button type="button" class="close" data-dismiss="alert">&times;</button>{{ Session::get('flash_message') }}</div>
            @endif
			<div class="col-md-12 euz_border p-3 bg-white">
				<div class="row">
					<div class="col-md-5 mt-2 wea" id="">
						<a class="weatherwidget-io" href="https://forecast7.com/en/35d1933d38/nicosia/" data-label_1="NICOSIA" data-label_2="WEATHER" data-theme="original" >NICOSIA WEATHER</a>
						<script>
						!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0];if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src='https://weatherwidget.io/js/widget.min.js';fjs.parentNode.insertBefore(js,fjs);}}(document,'script','weatherwidget-io-js');
						</script>
					</div>
					<!--<div class="col-md-5 mt-2 weauser" id=""><?php //echo $user->template; ?></div>-->
					<div class="col-md-7 mt-2">
						<div class="shadow-sm">
							<div class="col-md-12 euz_box_head">
								<p class="text-white euz_b mb-0">Weather Setting</p>
							</div>
							<div class="col-md-12 euz_border">
								<form action="{{ url('/admin/insertwea') }}" method="POST">
									{{ csrf_field() }}
									<div class="row">
										<div class="form-group col-md-6 py-2 mb-0">
											<label for="" class="euz_b">Select Agent</label>
											<select class="form-control" id="" name="userid">
												<option>--select--</option>
												<?php foreach($agents as $agent) { ?>
												<option value="<?php echo $agent->id; ?>"><?php echo $agent->fname.' '.$agent->lname; ?></option>
												<?php } ?>
											</select>	
										</div>
										<div class="form-group col-md-6 py-2 mb-0">
											<label for="" class="euz_b">Select Place</label>
											<select class="form-control place" id="" name="locid">
												<option>--select--</option>
												<?php foreach($value as $val) { ?>
												<option value="<?php echo $val->id; ?>"><?php echo $val->loc; ?></option>
												<?php } ?>
											</select>	
										</div>
									</div>	
									<div class="row bg-light">
										<div class="col-md-12 p-2">
											<button type="submit" class="btn btn-success rounded-0 euz_bt"><i class="fas fa-save"></i> Save</button>
											<!-- &nbsp;&nbsp;
											<a href="#" class="euz_inred"><i class="fas fa-broom"></i> Cancel</a> -->
										</div>
									</div>
								</form>
							</div>
						</div>
					</div>
				</div>
			</div>		
			<div class="col-md-12 mt-3 p-0">
				<div class="shadow-sm">
					<div class="col-md-12 euz_header">
						<p class="text-white euz_b">Agent Weather List</p>
					</div>
					<div class="col-md-12 euz_border bg-white">
						<div class="table-responsive-sm py-3">
							<table class="table table-bordered table-striped">
								<thead class="euz_agent_table">
									<tr>
										<th style="width:50px;" class="euz_agent_222">Sl.No</th>
										<th class="euz_agent_222">Agent</th>
										<th class="euz_agent_222">Weather</th>
										<th style="width:150px;" class="euz_agent_222">Action</th>
									</tr>
								</thead>
								<tbody>
									<?php $i =1; foreach($lists as $list) { ?>
									<tr>
										<td><?php echo $i; ?></td>
										<td><?php echo $list->fname.' '. $list->lname; ?></td>
										<td><?php echo $list->loc; ?></td>
										<td>
											<a href="javascript:void(0)" class="text-info euz_td_a" data-toggle="modal" data-target="#editwea{{ $list->id }}">Edit</a>&nbsp;&nbsp;&nbsp;&nbsp;
											<a href="<?php echo url('/admin/deletewea/'.$list->id); ?>" onclick="return confirm('Are you sure to delete this weather?')" class="text-danger euz_td_a">Delete</a>
										</td>
									</tr>
									<!-- edit weather popup -->
                                    <div class="modal fade" id="editwea{{ $list->id }}">
                                        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable euz_w_90">
                                            <div class="modal-content">
                                                <div class="modal-header euz_carb p-0">
                                                    <h5 class="modal-title p-2 text-white">Edit Weather</h5>
                                                    <button type="button" class="close" data-dismiss="modal">
                                                    <span>×</span>
                                                    </button>
                                                </div>
                                                <form action="{{ url('/admin/editwea') }}" method="POST">
                                                    {{ csrf_field() }}
                                                    <input type="hidden" name="weaid" value="{{ $list->id }}" />
                                                    <div class="modal-body">              
														<div class="row">
															<div class="col-md-12 mt-2 weaedit" id="">
																<?php echo $list->template; ?>
															</div>
															<!--<div class="col-md-12 mt-2 weaeditdis" id=""></div>-->
															<div class="form-group col-md-6 py-2 mb-0">
																<label for="" class="euz_b">Select Agent</label>
																<select class="form-control" id="" name="userid">
																	<option value="<?php echo $list->userid; ?>"><?php echo $list->fname.' '.$list->lname; ?></option>
																	<?php foreach($agents as $agent) { ?>
																	<option value="<?php echo $agent->id; ?>"><?php echo $agent->fname.' '.$agent->lname; ?></option>
																	<?php } ?>
																</select>	
															</div>
															<div class="form-group col-md-6 py-2 mb-0">
																<label for="" class="euz_b">Select Place</label>
																<select class="form-control placeedit" id="" name="locid">
																	<option value="<?php echo $list->locid; ?>"><?php echo $list->loc; ?></option>
																	<?php foreach($value as $val) { ?>
																	<option value="<?php echo $val->id; ?>"><?php echo $val->loc; ?></option>
																	<?php } ?>
																</select>	
															</div>
														</div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="submit" class="btn btn-success rounded-0 euz_bt"><i class="fas fa-save"></i> Save</button>
                                                        <button type="button" class="btn btn-danger rounded-0 euz_bt" data-dismiss="modal"><i class="fas fa-times"></i> Cancel</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- edit weather popup -->	
									<?php $i++; } ?>
								</tbody>
							</table>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>		
    <script>
        $(function()
        {
            $(".euz_a").css({ "color": "#16313c" });
            $("#weather").css({ "color": "#3990b3"});
        });
        $(".add_admin_form").hide();
        $(".add_admin").click(function()
        {
            $(".add_admin_table").hide();
            $(".add_admin_form").show();
        });
        $(".add_admin_back").click(function()
        {
            $(".add_admin_table").show();
            $(".add_admin_form").hide();
        });
// 		$('.place').on('change', function () 
//         {
//             //alert();
//             var selectData = $(this).val();
//             var url = "{{ url('/admin/getwea') }}";
//             var docurl = url + "/" + selectData;
//             $.ajax(
//             {
//                 url : docurl,
//                 method : "GET",
//                 dataType: 'json',
//                 success:function(data)
//                 {
//                     //$('.weauser').hide();
//                     //$('.wea').show();
//                     $(".wea").html(data.template);
//                 }
//             });
//         });
// 		$('.placeedit').on('change', function () 
//         {
//             //alert();
// 			//$(".weaedit").hide();
//             var selectData = $(this).val();
//             var url = "{{ url('/admin/getwea') }}";
//             var docurl = url + "/" + selectData;
//             $.ajax(
//             {
//                 url : docurl,
//                 method : "GET",
//                 dataType: 'json',
//                 success:function(data)
//                 {
//                     //alert(data.template);
//                     $(".weaeditdis").html(data.template);
//                 }
//             });
//         });
    </script>
@parent
@endsection