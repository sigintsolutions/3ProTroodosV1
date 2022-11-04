@extends('layouts.admin')
@section('content')

<div class="p-3 add_Algorithm_form">
			<div class="row">
				<div class="col-md-12 euz_bar">
					<i class="fas fa-square-root-alt euz_text_blue"></i> <small class="euz_b euz_text_blue">Algorithm Editor</small>
				</div>
				
				<div class="col-md-12 euz_border p-3 bg-white">
					<div class="row">
						<div class="col-md-12">
							<a class="btn euz_btn_add float-right euz_pointer add_Algorithm_back" href="{{ url('/admin/algorithms') }}"><i class="far fa-arrow-alt-circle-left"></i> Back</a>
						</div>
						<div class="col-md-12 mt-2">
							<div class="shadow-sm">
								<div class="col-md-12 euz_box_head">
									<p class="text-white euz_b mb-0">New Algorithm</p>
								</div>
								<div class="col-md-12 euz_border" id="parent"><form method="post" action="insertalgorithm" name="frmlog" id="frmlog">
								{{ csrf_field() }}
									<div class="row">
										<div class="form-group col-md-4 py-2 mb-0">
											<label for="" class="euz_b">Agent</label>
											<select class="form-control agent" name="agent" required id="agent">
												<option value="">-Select-</option>
												@foreach($agents as $item)
												<option value="{{ $item->id }}">{{ $item->fname }} {{ $item->lname }}</option>
												@endforeach
											</select>
										</div>
										<div class="form-group col-md-4 py-2 mb-0">
											<label for="" class="euz_b">Algorithm Name</label>
											<input class="form-control" name="name" required>
										</div>
										<div class="items col-md-12 py-2 mb-0" id="items0">
										<div class="col-md-12 p-0">
											<div class="card bg-light">
												<div class="card-body row py-0">
													<div class="form-group col-md-4 py-2 mb-0">
														<label for="" class="euz_b">Group Name</label>
														<select class="form-control group" name="group[]" onchange="gethub(this.value,$(this).closest('.items').attr('id'))">
															<option value="">-Select-</option>
														</select>
													</div>
													<div class="form-group col-md-4 py-2 mb-0">
														<label for="" class="euz_b">Hub Name</label>
														<select class="form-control hub" name="hub[]" onchange="getsensor(this.value,$(this).closest('.items').attr('id'))">
														<option value="">-Select-</option>
														</select>
													</div>
													<div class="form-group col-md-4 py-2 mb-0">
														<label for="" class="euz_b">Sensor ID</label>
														<select class="form-control sensor" name="sensor[]">
															<option value="">-Select-</option>
														</select>
													</div>
												</div>
												<div class="card-footer bg-white py-0">
													<div class="row">
														<div class="form-group col-md-2 py-2 mb-0">
															<br>
															<div class="custom-control custom-radio custom-control-inline float-right">
																<label for="" class="euz_b mr-5">Choose</label>
																<input type="radio" value="0" class="custom-control-input choose" name="choose0" id="it0" checked="checked" required onclick="swap(this.value,$(this).closest('.items').attr('id'))">
																<label class="custom-control-label euz_b choose_label" for="it0"></label>
															</div>
														</div>
														<div class="form-group col-md-3 py-2 mb-0">
															<label for="" class="euz_b">Condition</label>
															<select class="form-control condition1" name="condition1[]">
																<option value="">-Select Condition-</option>
																<option value="less than"> < (less than) </option>
																<option value="greater than"> > (greater than) </option>
																<option value="less than equals"> <= (less than equals) </option>
																<option value="greater than equals"> >= (greater than equals) </option>
																<option value="equal to"> = (equal to) </option>
															</select>
														</div>
														<div class="form-group col-md-3 py-2 mb-0">
															<label for="" class="euz_b">Value</label>
															<input type="text" class="form-control value" name="value[]">
														</div>
														<div class="form-group col-md-4 py-2 mb-0">
															<label for="" class="euz_b text-white">Choose</label><br>
															<div class="custom-control custom-radio custom-control-inline">
																<input type="radio" class="custom-control-input con1" value="None" id="none0" name="condition20">
																<label class="custom-control-label euz_b label_con1" for="none0">None</label>
															</div>
															<div class="custom-control custom-radio custom-control-inline">
																<input type="radio" class="custom-control-input con2" value="Or" id="or0" name="condition20">
																<label class="custom-control-label euz_b label_con2" for="or0">OR</label>
															</div>
															<div class="custom-control custom-radio custom-control-inline">
																<input type="radio" class="custom-control-input con3" value="And" id="and0" name="condition20">
																<label class="custom-control-label euz_b label_con3" for="and0">AND</label>
															</div>
														</div>
														
														<div class="form-group col-md-2 py-2 mb-0">
															<br>
															<div class="custom-control custom-radio custom-control-inline float-right">
																<input type="radio" class="custom-control-input choose2" value="1" id="its0" name="choose0" required onclick="swap(this.value,$(this).closest('.items').attr('id'))">
																<label class="custom-control-label euz_b choose_label2" for="its0"></label>
															</div>
														</div>
														<div class="form-group col-md-3 py-2 mb-0">
															<label for="" class="euz_b">Min Value</label>
															<input type="text" class="form-control minvalue" name="min[]" readonly="readonly">
														</div>
														<div class="form-group col-md-3 py-2 mb-0">
															<label for="" class="euz_b">Max Value</label>
															<input type="text" class="form-control maxvalue" name="max[]" readonly="readonly">
														</div>
														
													</div>
												</div>
											</div>
											<div class="col-md-12 addmoreadd">
											<a class="btn euz_btn_add float-right euz_pointer mb-3 sh_onemore_btn add_details"><i class="fas fa-plus"></i> More Condition</a>
										</div>
										</div>
										
										</div>
										<?php /*?><div class="items2" style="display:none" id="1">
										<div class="col-md-12 items3" >
											<div class="card bg-light">
												<div class="card-body row py-0">
													<div class="form-group col-md-4 py-2 mb-0">
														<label for="" class="euz_b">Group Name</label>
														<select class="form-control group" name="group[]">
															<option value="">-Select-</option>
														</select>
													</div>
													<div class="form-group col-md-4 py-2 mb-0">
														<label for="" class="euz_b">Hub Name</label>
														<select class="form-control hub" name="hub[]">
														<option value="">-Select-</option>
														</select>
													</div>
													<div class="form-group col-md-4 py-2 mb-0">
														<label for="" class="euz_b">Sensor ID</label>
														<select class="form-control sensor" name="sensor[]">
															<option value="">-Select-</option>
														</select>
													</div>
												</div>
												<div class="card-footer bg-white py-0">
													<div class="row">
														<div class="form-group col-md-2 py-2 mb-0">
															<br>
															<div class="custom-control custom-radio custom-control-inline float-right">
																<label for="" class="euz_b mr-5">Choose</label>
																<input type="radio" value="0" class="custom-control-input" name="choose[]" required>
																<label class="custom-control-label euz_b" for="no"></label>
															</div>
														</div>
														<div class="form-group col-md-3 py-2 mb-0">
															<label for="" class="euz_b">Condition</label>
															<select class="form-control" name="condition1[]">
																<option value="">-Select Condition-</option>
																<option value="less than"> < (less than) </option>
																<option value="greater than"> > (greater than) </option>
																<option value="less than equals"> <= (less than equals) </option>
																<option value="greater than equals"> >= (greater than equals) </option>
																<option value="equal to"> = (equal to) </option>
															</select>
														</div>
														<div class="form-group col-md-3 py-2 mb-0">
															<label for="" class="euz_b">Value</label>
															<input type="text" class="form-control" name="value[]">
														</div>
														<div class="form-group col-md-4 py-2 mb-0">
															<label for="" class="euz_b text-white">Choose</label><br>
															<div class="custom-control custom-radio custom-control-inline">
																<input type="radio" class="custom-control-input" value="None" name="condition2[]">
																<label class="custom-control-label euz_b" for="algo">None</label>
															</div>
															<div class="custom-control custom-radio custom-control-inline">
																<input type="radio" class="custom-control-input" value="Or" name="condition2[]">
																<label class="custom-control-label euz_b" for="OR">OR</label>
															</div>
															<div class="custom-control custom-radio custom-control-inline">
																<input type="radio" class="custom-control-input" value="And" name="condition2[]">
																<label class="custom-control-label euz_b" for="AND">AND</label>
															</div>
														</div>
														
														<div class="form-group col-md-2 py-2 mb-0">
															<br>
															<div class="custom-control custom-radio custom-control-inline float-right">
																<input type="radio" class="custom-control-input" value="1" name="choose[]" required>
																<label class="custom-control-label euz_b" for="v"></label>
															</div>
														</div>
														<div class="form-group col-md-3 py-2 mb-0">
															<label for="" class="euz_b">Min Value</label>
															<input type="text" class="form-control" name="min[]">
														</div>
														<div class="form-group col-md-3 py-2 mb-0">
															<label for="" class="euz_b">Max Value</label>
															<input type="text" class="form-control" name="max[]">
														</div>
														
													</div>
												</div>
											</div>
											<a class="btn euz_btn_remove float-right euz_pointer mb-3 sh_onemore sh_one remove-btn"><i class="fas fa-plus"></i> Remove</a>
                                            <div class="col-md-12">
											<a class="btn euz_btn_add float-right euz_pointer mb-3 sh_onemore_btn add_details"><i class="fas fa-plus"></i> More Condition</a>
										
										</div>
										</div>
										
										</div><?php */?>
										
										<div class="form-group col-md-12 py-2 mb-0">
											<label for="" class="euz_b">Push Notification</label>
											<textarea class="form-control" id="push" name="push"></textarea>
										</div>
										
									</div>	
									
									<div class="row bg-light">
										<div class="col-md-12 p-2">
											<button type="submit" class="euz_btn_add euz_pointer text-white bg-success border-0"><i class="fas fa-save"></i> Save</button>
											&nbsp;&nbsp;
											<a href="{{ url('/admin/algorithms') }}" class="euz_btn_add euz_pointer text-white bg-danger border-0"><i class="fas fa-times"></i> Cancel</a>
										</div>
									</div>
								
								</form></div>
							</div>
						</div>
					</div>
				</div>
			</div>
			
        </div>


@endsection
@section('scripts')
<script>
var rowNum = 0;

$("body").on("click", ".add_details", function() {
      rowNum++;
      var $address = $(this).parents('.items');
      var nextHtml = $address.clone();
      nextHtml.attr('id', 'items' + rowNum);
	  nextHtml.find('.choose').attr('id', 'it' + rowNum);
	  nextHtml.find('.choose').attr('name', 'choose' + rowNum);
	  nextHtml.find('.choose2').attr('id', 'its' + rowNum);
	  nextHtml.find('.choose2').attr('name', 'choose' + rowNum);
	  nextHtml.find('.choose_label').attr('for', 'it' + rowNum);
	  nextHtml.find('.choose_label2').attr('for', 'its' + rowNum);
	  
	  nextHtml.find('.con1').attr('id', 'none' + rowNum);
	  nextHtml.find('.con2').attr('id', 'or' + rowNum);
	  nextHtml.find('.con3').attr('id', 'and' + rowNum);
	  
	  nextHtml.find('.con1').attr('name', 'condition2' + rowNum);
	  nextHtml.find('.con2').attr('name', 'condition2' + rowNum);
	  nextHtml.find('.con3').attr('name', 'condition2' + rowNum);
	  
	  nextHtml.find('.label_con1').attr('for', 'none' + rowNum);
	  nextHtml.find('.label_con2').attr('for', 'or' + rowNum);
	  nextHtml.find('.label_con3').attr('for', 'and' + rowNum);
	  
      var hasRmBtn = $('.remove-btn', nextHtml).length > 0;
    if (!hasRmBtn) {
      var rm = "<a class='btn euz_btn_remove float-right euz_pointer mb-3 sh_onemore sh_one remove-btn'><i class='fas fa-plus'></i> Remove</a>"
      $('.addmoreadd', nextHtml).append(rm);
    }
      //$address.after(nextHtml); 
	  $( ".items" ).last().after(nextHtml); 
 });
	$("body").on("click",".remove-btn",function(e){
	rowNum--;
		$(this).parents('.items').remove();
	});
	$(".agent").change(function(){
		$.ajax(
		{
			url: "{{ url('/admin/getgroup') }}",
			type: "post",
			data: $('#frmlog').serialize(),
			success: function(data)
			{
				//alert(data);
				$(".group").html(data);
			}
		});
	});
	function gethub(id,vid)
	{
    	$.ajax(
		{
			url: "{{ url('/admin/gethub') }}",
			type: "post",
			data: { agent : $('.agent').val(),group : id,_token : $( "input[name='_token']" ).val() },
			success: function(data)
			{
				$("#"+vid+" .hub").html(data);
			}
		});
	}
	function getsensor(id,vid)
	{
		$.ajax(
		{
			url: "{{ url('/admin/getsensor') }}",
			type: "post",
			data: { hub : id,_token : $( "input[name='_token']" ).val() },
			success: function(data)
			{
				$("#"+vid+" .sensor").html(data);
			}
		});
	}
function swap(value,vid)
{
//alert(vid);
if(value==0)
{
$("#"+vid+" .minvalue").attr('readonly','readonly');
$("#"+vid+" .maxvalue").attr('readonly','readonly');

$("#"+vid+" .condition1").css({"pointer-events": "auto", "cursor": "default"});
$("#"+vid+" .value").removeAttr('readonly');
$("#"+vid+" .label_con1").css({"pointer-events": "auto", "cursor": "default"});
$("#"+vid+" .label_con2").css({"pointer-events": "auto", "cursor": "default"});
$("#"+vid+" .label_con3").css({"pointer-events": "auto", "cursor": "default"});

}
else
{
$("#"+vid+" .minvalue").removeAttr('readonly');
$("#"+vid+" .maxvalue").removeAttr('readonly');

$("#"+vid+" .condition1").css({"pointer-events": "none", "cursor": "default"});
$("#"+vid+" .value").attr('readonly','readonly');
$("#"+vid+" .label_con1").css({"pointer-events": "none"});
$("#"+vid+" .label_con2").css({"pointer-events": "none"});
$("#"+vid+" .label_con3").css({"pointer-events": "none"});
}
}

</script>
@parent

@endsection