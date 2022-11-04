<div id="agentprofile" class="euz_agent_profile">
		<div class="row">
			<div class="col-md-12">
				<div class="card euz_carb rounded-0 text-white">
					<div class="card-body">
						<h4 class="card-title m-0"><i class="fas fa-square-root-alt text-info"></i> Algorithm name <a href="javascript:void(0)" class="closebtn float-right" onclick="profileclose()">×</a></h4>
					</div>
				</div>
                <div class="p-3 add_Algorithm_form">
        			<div class="row">
        				<div class="col-md-12 euz_bar">
        					<i class="fas fa-square-root-alt euz_text_blue"></i> <small class="euz_b euz_text_blue">Algorithm Editor</small>
        				</div>
        				@if(Session::has('flash_message'))
        				<div class="alert alert-success w-100"><button type="button" class="close" data-dismiss="alert">&times;</button>{{ Session::get('flash_message') }}</div>
        				@endif
        				<div class="col-md-12 euz_border p-3 bg-white">
        					<div class="row">
        						<?php /*?><div class="col-md-12">
        							<a href="/admin/algorithms" class="btn euz_btn_add float-right euz_pointer add_Algorithm_back"><i class="far fa-arrow-alt-circle-left"></i> Back</a>
        						</div><?php */?>
        						<div class="col-md-12 mt-2">
        							<div class="shadow-sm">
        								<form method="post" action="{{ url('agent/updatealgorithm') }}" name="frmlog" id="frmlog">
                                        <input type="hidden" name="eid" value="{{ $alg[0]->id }}" id="eid" />
        								{{ csrf_field() }}
        								<div class="col-md-12 euz_border" id="parent">
        									<div class="row">
        										<input type="text" name="agent" value="<?php echo session()->get('userid'); ?>" />
        										<div class="form-group col-md-4 py-2 mb-0">
        											<label for="" class="euz_b">Algorithm Name</label>
        											<input class="form-control" name="name" value="{{ $alg[0]->name }}" required>
        										</div>
                                                @foreach($details as $i=>$sensor)
        										<div class="items" id="items{{ $i }}">
        										<div class="col-md-12 ">
        											<div class="card bg-light">
        												<div class="card-body row py-0">
        													<div class="form-group col-md-4 py-2 mb-0">
        														<label for="" class="euz_b">Group Name</label>
        														<select class="form-control group" name="group[]" onchange="gethub(this.value,$(this).closest('.items').attr('id'))">
        															<option value="">-Select-</option>
                                                                    @foreach($groups as $group)
                                                                    @if($group->groupid==$sensor->groupid)
                                                         			<option value="{{ $group->groupid }}" selected="selected">{{ $group->name }}</option>
                                                                    @else
                                                                    <option value="{{ $group->groupid }}">{{ $group->name }}</option>
                                                                    @endif
                                                                    @endforeach
        														</select>
        													</div>
        													<div class="form-group col-md-4 py-2 mb-0">
        														<label for="" class="euz_b">Hub Name</label>
        														<select class="form-control hub" name="hub[]" onchange="getsensor(this.value,$(this).closest('.items').attr('id'))">
        														<option value="">-Select-</option>
                                                                    @foreach($hubs[$i] as $hub)
                                                                    @if($hub->id==$sensor->hub)
                                                         			<option value="{{ $hub->id }}" selected="selected">{{ $hub->name }}</option>
                                                                    @else
                                                                    <option value="{{ $hub->id }}">{{ $hub->name }}</option>
                                                                    @endif
                                                                    @endforeach
        														</select>
        													</div>
        													<div class="form-group col-md-4 py-2 mb-0">
        														<label for="" class="euz_b">Sensor ID</label>
        														<select class="form-control sensor" name="sensor[]">
        															<option value="">-Select-</option>
                                                                    @foreach($sensors[$i] as $item)
                                                                    @if($item->id==$sensor->sensor)
                                                         			<option value="{{ $item->id }}" selected="selected">{{ $item->sensor_id }}</option>
                                                                    @else
                                                                    <option value="{{ $item->id }}">{{ $item->sensor_id }}</option>
                                                                    @endif
                                                                    @endforeach
        														</select>
        													</div>
        												</div>
        												<!--<div class="card-footer bg-white py-0">-->
        												<!--	<div class="row">-->
        												<!--		<div class="form-group col-md-2 py-2 mb-0">-->
        												<!--			<br>-->
        												<!--			<div class="custom-control custom-radio custom-control-inline float-right">-->
        												<!--				<label for="" class="euz_b mr-5">Choose</label>-->
        												<!--				<input type="radio" value="0" class="custom-control-input choose" onclick="swap(this.value,$(this).closest('.items').attr('id'))" name="choose{{ $i }}" {{ ($sensor->choose==0)?"checked":"" }} id="it{{ $i }}" required>-->
        												<!--				<label class="custom-control-label euz_b choose_label" for="it{{ $i }}"></label>-->
        												<!--			</div>-->
        												<!--		</div>-->
        												<!--		<div class="form-group col-md-3 py-2 mb-0">-->
        												<!--			<label for="" class="euz_b">Condition</label>-->
        												<!--			<select class="form-control condition1" name="condition1[]">-->
        												<!--				<option value="">-Select Condition-</option>-->
        												<!--				<option value="less than" {{ ($sensor->condition1=='less than')?'selected':'' }}> < (less than) </option>-->
        												<!--				<option value="greater than" {{ ($sensor->condition1=='greater than')?'selected':'' }}> > (greater than) </option>-->
        												<!--				<option value="less than equals" {{ ($sensor->condition1=='less than equals')?'selected':'' }}> <= (less than equals) </option>-->
        												<!--				<option value="greater than equals" {{ ($sensor->condition1=='greater than equals')?'selected':'' }}> >= (greater than equals) </option>-->
        												<!--				<option value="equal to" {{ ($sensor->condition1=='equal to')?'selected':'' }}> = (equal to) </option>-->
        												<!--			</select>-->
        												<!--		</div>-->
        												<!--		<div class="form-group col-md-3 py-2 mb-0">-->
        												<!--			<label for="" class="euz_b">Value</label>-->
        												<!--			<input type="text" class="form-control value" name="value[]" value="{{ $sensor->value }}">-->
        												<!--		</div>-->
        												<!--		<div class="form-group col-md-4 py-2 mb-0">-->
        												<!--			<label for="" class="euz_b text-white">Choose</label><br>-->
        												<!--			<div class="custom-control custom-radio custom-control-inline">-->
        												<!--				<input type="radio" class="custom-control-input con1" value="None" id="none{{ $i }}" {{ ($sensor->condition2=='None')?"checked":"" }} name="condition2{{ $i }}">-->
        												<!--				<label class="custom-control-label euz_b label_con1" for="none{{ $i }}">None</label>-->
        												<!--			</div>-->
        												<!--			<div class="custom-control custom-radio custom-control-inline">-->
        												<!--				<input type="radio" class="custom-control-input con2" value="Or" id="or{{ $i }}" {{ ($sensor->condition2=='Or')?"checked":"" }} name="condition2{{ $i }}">-->
        												<!--				<label class="custom-control-label euz_b label_con2" for="or{{ $i }}">OR</label>-->
        												<!--			</div>-->
        												<!--			<div class="custom-control custom-radio custom-control-inline">-->
        												<!--				<input type="radio" class="custom-control-input con3" value="And" id="and{{ $i }}" {{ ($sensor->condition2=='And')?"checked":"" }} name="condition2{{ $i }}">-->
        												<!--				<label class="custom-control-label euz_b label_con3" for="and{{ $i }}">AND</label>-->
        												<!--			</div>-->
        												<!--		</div>-->
        														
        												<!--		<div class="form-group col-md-2 py-2 mb-0">-->
        												<!--			<br>-->
        												<!--			<div class="custom-control custom-radio custom-control-inline float-right">-->
        												<!--				<input type="radio" class="custom-control-input choose2" onclick="swap(this.value,$(this).closest('.items').attr('id'))" value="1" id="its{{ $i }}" {{ ($sensor->choose==1)?"checked":"" }} name="choose{{ $i }}" required>-->
        												<!--				<label class="custom-control-label euz_b choose_label2" for="its{{ $i }}"></label>-->
        												<!--			</div>-->
        												<!--		</div>-->
        												<!--		<div class="form-group col-md-3 py-2 mb-0">-->
        												<!--			<label for="" class="euz_b">Min Value</label>-->
        												<!--			<input type="text" class="form-control minvalue" name="min[]" value="{{ $sensor->min_value }}">-->
        												<!--		</div>-->
        												<!--		<div class="form-group col-md-3 py-2 mb-0">-->
        												<!--			<label for="" class="euz_b">Max Value</label>-->
        												<!--			<input type="text" class="form-control minvalue" name="max[]" value="{{ $sensor->max_value }}">-->
        												<!--		</div>-->
        														
        												<!--	</div>-->
        												<!--</div>-->
        											</div>
        											<div class="col-md-12 addmoreadd">
        											<a class="btn euz_btn_add float-right euz_pointer mb-3 sh_onemore_btn add_details"><i class="fas fa-plus"></i> More Condition</a>
        										@if($i!=0)
                                                <a class='btn euz_btn_remove float-right euz_pointer mb-3 sh_onemore sh_one remove-btn'><i class='fas fa-plus'></i> Remove</a>
                                   				@endif
                                                <script>
        										$(window).ready(function () {
        										swap(<?php echo $sensor->choose ?>,'items'+<?php echo $i ?>);
        										});
        										</script>
        										</div>
        										</div>
        										</div>
        										@endforeach
        										<div class="form-group col-md-12 py-2 mb-0">
        											<label for="" class="euz_b">Push Notification</label>
        											<textarea class="form-control" id="push" name="push">{{ $alg[0]->push_message }}</textarea>
        										</div>
        									</div>	
        									<div class="row bg-light">
        										<div class="col-md-12 p-2">
        											<button type="submit" class="euz_ingreen"><i class="fas fa-save"></i> Save</button>
        											&nbsp;&nbsp;
        											<?php /*?><a href="/admin/algorithms" class="euz_inred"><i class="fas fa-broom"></i> Cancel</a><?php */?>
        										</div>
        									</div>
        								</div>
        								</form>
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
<script>
var rowNum = {{ $i }};

$("#agentprofile").on("click", ".add_details", function() {
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
      $( ".items" ).last().after(nextHtml); 
 });
    $("#agentprofile").on("click",".remove-btn",function(e){
    rowNum--;
        $(this).parents('.items').remove();
    });
    $(".agent").change(function(){
        $.ajax({
            url: "/admin/getgroup",
            type: "post",
            data: $('#frmlog').serialize(),
            success: function(data){
                $(".group").html(data);
            }
        });
    });
    function gethub(id,vid)
    {
        $.ajax({
            url: "/admin/gethub",
            type: "post",
            //data: $('#frmlog').serialize(),
    		data: { agent : $('.agent').val(),group : id,_token : $( "input[name='_token']" ).val(), },
            success: function(data){
                //$(".hub").html(data);
    			$("#"+vid+" .hub").html(data);
            }
        });
	}
    function getsensor(id,vid)
    {
        $.ajax({
            url: "/admin/getsensor",
            type: "post",
            //data: $('#frmlog').serialize(),
    		data: { hub : id,_token : $( "input[name='_token']" ).val() },
            success: function(data){
                //$(".sensor").html(data);
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
