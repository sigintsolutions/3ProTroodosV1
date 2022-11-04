
<!--Sensor unit chart--->
<table class="table table-bordered table-striped">
						<thead class="euz_thead_set">
							<tr>
								<th>Sl.No</th>
								<th>Measuement Unit</th>
								<th>Chart</th>
								<th>Action</th>
							</tr>
						</thead>
						<tbody>
							<?php $j = 1; foreach($units as $unit) { ?>
							<tr>
								<td><?php echo $j; ?></td>
								<td><?php echo $unit->unit; ?></td>
								<td><?php echo $unit->name; ?></td>
								<td>
<a href="#" onclick=loaddtchart("<?php echo $unit->id;?>"); class="text-info euz_td_a"   data-toggle="modal" data-target="#units"><i class="fas fa-user-edit"></i> Edit</a>
									<!--<a onclick="hideimg()" href="javasccript:void()" class="text-info euz_td_a" data-id='{{ $unit->id }}' data-toggle="modal" data-target="#units{{ $unit->id }}"><i class="fas fa-user-edit"></i> Edit</a>-->&nbsp;&nbsp;&nbsp;&nbsp;
									<!-- <a href="{{ url('/admin/deleteunit/'.$unit->id) }}" class="text-danger euz_td_a"><i class="fas fa-user-times"></i> Delete</a> -->
								</td>
							</tr>
							
							<?php $j++; } ?>
						</tbody>
					</table>


<div class="modal fade" id="units">
								<div class="modal-dialog modal-dialog-centered" style="max-width: 80%;">
									<div class="modal-content shadow">
										<div class="modal-header euz_header  rounded-0">
											<p class="text-white euz_b">Edit</p>
											<button type="button" class="close" data-dismiss="modal">
											<span>x</span>
											</button>
										</div>					
										<div class="modal-body row">
											<div class="form-group col-md-12 py-2 mb-0">							<form class="editunit" method="POST" enctype="multipart/form-data">			
												<!--<form action="{{ url('/admin/editunit') }}" method="POST" enctype="multipart/form-data">-->
													{{ csrf_field() }}	
													<input type="hidden" name="eid" value="{{ $unit->id }}" id="eid" class="eidunit" />
													<div class="row">
														<div class="col-md-4 form-group my-2">
															<label for="" class="euz_b">Unit</label>
															<div class="input-group mb-3">
																<select class="form-control eidunitm" name="unit" required>
																	<option value="<?php echo $unit->unit; ?>"><?php echo $unit->unit; ?></option>
																	<?php $i = 1; foreach($measureunits as $item) { ?>
																	<option value="<?php echo $item->unit; ?>"><?php echo $item->unit; ?></option>
																	<?php } ?>
																<select>
															</div>
														</div>
														<div class="col-md-4 form-group my-2">
															<label for="" class="euz_b">Sensor Chart</label>
															<div class="input-group mb-3">
																<select class="form-control euztumb1 eidunitc" name="name" required>
																	<!--<option value="<?php //echo $unit->name; ?>"><?php //echo $unit->name; ?></option>-->
																	<option value="AreaChart" <?php if ($unit->name=="AreaChart"){?> selected <?php } ?> >AreaChart</option>
																	<option value="BarChart" <?php if ($unit->name=="BarChart"){?> selected <?php } ?>>BarChart</option>
																	<option value="PieChart" <?php if ($unit->name=="PieChart"){?> selected <?php } ?>>PieChart</option>
																	<option value="ColumnChart" <?php if ($unit->name=="ColumnChart"){?> selected <?php } ?>>ColumnChart</option>
																	<option value="ComboChart" <?php if ($unit->name=="ComboChart"){?> selected <?php } ?>>ComboChart</option>
																	<option value="ScatterChart" <?php if ($unit->name=="ScatterChart"){?> selected <?php } ?>>ScatterChart</option>
																	<option value="SteppedAreaChart" <?php if ($unit->name=="SteppedAreaChart"){?> selected <?php } ?>>SteppedAreaChart</option>
																	<option value="Histogram" <?php if ($unit->name=="Histogram"){?> selected <?php } ?>>Histogram</option>
																	<option value="LineChart" <?php if ($unit->name=="LineChart"){?> selected <?php } ?>>LineChart</option>
																<select>
															</div>
														</div>
<div class="col-md-2 my-2">

<img src="" class="img-fluid ld" style="width:100px;">
<?php //echo url("image/tumb/area.PNG");?>

															
														</div>


														<div class="col-md-2 my-2">

															<img src="../image/tumb/area.PNG" class="img-fluid euztumbs1 AreaChart" style="width:100px;">
															<img src="../image/tumb/bar.PNG" class="img-fluid euztumbs1 BarChart" style="width:100px;">
															<img src="../image/tumb/pie.PNG" class="img-fluid euztumbs1 PieChart" style="width:100px;">
															<img src="../image/tumb/column.PNG" class="img-fluid euztumbs1 ColumnChart" style="width:100px;">
															<img src="../image/tumb/combo.PNG" class="img-fluid euztumbs1 ComboChart" style="width:100px;">
															<img src="../image/tumb/scatter.PNG" class="img-fluid euztumbs1 ScatterChart" style="width:100px;">
															<img src="../image/tumb/stepped.PNG" class="img-fluid euztumbs1 SteppedAreaChart" style="width:100px;">
															<img src="../image/tumb/histogram.PNG" class="img-fluid euztumbs1 Histogram" style="width:100px;">
															<img src="../image/tumb/line.PNG" class="img-fluid euztumbs1 LineChart" style="width:100px;">
														</div>
													</div>
													
													<div class="input-group-append">
														<button class="btn euz_btn_add" type="submit"><i class="fas fa-plus"></i> Update</button> 
													</div>
												</form>
											</div>
										</div>
									</div>
								</div>
							</div>
					<script>
$(function() {
  $('.euztumb1').change(function(){
    $('.euztumbs1').hide();
    $('.ld').hide();
    $('.' + $(this).val()).show();
  });
});
$(function() {
$('.euztumbs1').hide();
});
function hideimg(){

	//alert("sss");
$('.ld').show();
$('.euztumbs1').hide();
}

function loaddtchart(id){
$('.ld').show();
$('.euztumbs1').hide();
$.ajax({
            type: 'get',
            url:"{{url('admin/getsensoreditdetailschart')}}",
            //data: $('.sengrp1').serialize(),
            async: false,
            dataType:"JSON",
            data:{id:id},
            success: function (data) {
            	//alert(data.id);
            	//alert(data.unit);
$('.eidunitm').empty();
var div_data="<option value="+data.unit+">"+data.unit+"</option>";
                //alert(div_data);
                $(div_data).appendTo('.eidunitm');
//alert("kkk"+data.name);
if (data.name=="AreaChart"){
//alert("area-https://mqtt.eurozapp.eu/argus/image/tumb/area.PNG");
//$(".ld").src="https://mqtt.eurozapp.eu/argus/image/tumb/area.PNG";
$(".ld").attr("src","https://mqtt.eurozapp.eu/argus/image/tumb/area.PNG");
}
if (data.name=="BarChart"){
//alert("area-https://mqtt.eurozapp.eu/argus/image/tumb/area.PNG");
//$(".ld").src="https://mqtt.eurozapp.eu/argus/image/tumb/area.PNG";
$(".ld").attr("src","https://mqtt.eurozapp.eu/argus/image/tumb/bar.PNG");
}
if (data.name=="PieChart"){
//alert("area-https://mqtt.eurozapp.eu/argus/image/tumb/area.PNG");
//$(".ld").src="https://mqtt.eurozapp.eu/argus/image/tumb/area.PNG";
$(".ld").attr("src","https://mqtt.eurozapp.eu/argus/image/tumb/pie.PNG");
}
if (data.name=="ColumnChart"){
//alert("area-https://mqtt.eurozapp.eu/argus/image/tumb/area.PNG");
//$(".ld").src="https://mqtt.eurozapp.eu/argus/image/tumb/area.PNG";
$(".ld").attr("src","https://mqtt.eurozapp.eu/argus/image/tumb/column.PNG");
}
if (data.name=="ComboChart"){
//alert("area-https://mqtt.eurozapp.eu/argus/image/tumb/area.PNG");
//$(".ld").src="https://mqtt.eurozapp.eu/argus/image/tumb/area.PNG";
$(".ld").attr("src","https://mqtt.eurozapp.eu/argus/image/tumb/combo.PNG");
}
if (data.name=="ScatterChart"){
//alert("area-https://mqtt.eurozapp.eu/argus/image/tumb/area.PNG");
//$(".ld").src="https://mqtt.eurozapp.eu/argus/image/tumb/area.PNG";
$(".ld").attr("src","https://mqtt.eurozapp.eu/argus/image/tumb/Scatter.PNG");
}
if (data.name=="SteppedAreaChart"){
//alert("area-https://mqtt.eurozapp.eu/argus/image/tumb/area.PNG");
//$(".ld").src="https://mqtt.eurozapp.eu/argus/image/tumb/area.PNG";
$(".ld").attr("src","https://mqtt.eurozapp.eu/argus/image/tumb/stepped.PNG");
}
if (data.name=="Histogram"){
//alert("area-https://mqtt.eurozapp.eu/argus/image/tumb/area.PNG");
//$(".ld").src="https://mqtt.eurozapp.eu/argus/image/tumb/area.PNG";
$(".ld").attr("src","https://mqtt.eurozapp.eu/argus/image/tumb/histogram.PNG");
}
if (data.name=="LineChart"){
//alert("area-https://mqtt.eurozapp.eu/argus/image/tumb/area.PNG");
//$(".ld").src="https://mqtt.eurozapp.eu/argus/image/tumb/area.PNG";
$(".ld").attr("src","https://mqtt.eurozapp.eu/argus/image/tumb/line.PNG");
}





$(".eidunit").val(data.id);
$(".eidunitc").val(data.name);


}
});





}

$('.editunit').on('submit', function(event){
//$('#updatetype').on('submit', function(event)
    
        event.preventDefault();	
//Edit unit
 $.ajax(
        {
           // url:"{{  url('/editarchive') }}",
           url:"{{url('admin/editunit')}}",
            method:"POST",
            data:new FormData(this),
            contentType: false,
            cache: false,
            processData: false,
            //dataType: 'json',
            success:function(data)
            {    
                      //$("#name").val('');
                $(".tblunit").html(data);
                alert("Updated Successfully");
                //$("#archive").load("#archive");
            }
        });			








    });



					</script>