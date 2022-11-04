<table class="table table-bordered table-striped">
					<thead class="euz_thead_set">
						<tr>
							<th>Sl.No</th>
							<th>Sensor Name</th>
							<th>Brand</th>
							<th>Modal</th>
							<th>Action</th>
						</tr>
					</thead>
					<tbody>
						<?php $i = 1; foreach($types as $item) { ?>
						<tr id="grty<?php echo $item->id;?>">
							<td><?php echo $i; ?></td>
							<td>{{ $item->sname }}</td>
							<td>{{ $item->brand }}</td>
							<td>{{ $item->modal }}</td>
							<td>
<a href="#" onclick=loaddtsentype("<?php echo $item->id;?>"); class="text-info euz_td_a"   data-toggle="modal" data-target="#types"><i class="fas fa-user-edit"></i> Edit</a>


								<!--<a href="" class="text-info euz_td_a" data-id='{{ $item->id }}' data-name='{{ $item->name }}' data-toggle="modal" data-target="#types{{ $item->id }}"><i class="fas fa-user-edit"></i> Edit</a>-->&nbsp;&nbsp;&nbsp;&nbsp;
								<!--<a href="<?php //echo url('/admin/deleteType/'.$item->id); ?>" onclick="return confirm('Are you sure to delete this item?')"  class="text-danger euz_td_a"><i class="fas fa-user-times"></i> Delete</a>-->
								<a href="#" onclick=delsensortype("<?php echo $item->id;?>");  class="text-danger euz_td_a"><i class="fas fa-user-times"></i> Delete</a>



							</td>
						</tr>
						
						<?php $i++; } ?>
					</tbody>
				</table>

<div class="modal fade" id="types">
							<div class="modal-dialog modal-dialog-centered" style="max-width: 80%;">
								<div class="modal-content shadow">
								<div class="modal-header euz_header  rounded-0">
									<p class="text-white euz_b">Edit</p>
									<button type="button" class="close" data-dismiss="modal">
									<span>x</span>
									</button>
								</div>					
								<div class="modal-body row">
									<div class="form-group col-md-12 py-2 mb-0">				<form class="updatetype" id="updatetype" method="POST" enctype="multipart/form-data">						
										<!--<form action="updatetype" method="POST" enctype="multipart/form-data">-->
											{{ csrf_field() }}	
											<input type="hidden" name="eid" value="{{ $item->id }}" class="eid1" id="eid" />
											<div class="row">
												<div class="form-group col-md-4">
													<label for="" class="euz_b">Sensor Name</label>
													<div class="input-group mb-3">								
														<input type="text" class="form-control sname1" required  id="sname" value="{{ $item->sname }}" name="sname" />
													</div>
												</div>
												<div class="form-group col-md-4">
													<label for="" class="euz_b">Modal</label>
													<div class="input-group mb-3">								
														<input type="text" class="form-control modal1" required  id="modal" value="{{ $item->modal }}" name="modal" />
													</div>
												</div>
												<!-- <div class="form-group col-md-4">
													<label for="" class="euz_b">Type Name</label>
													<div class="input-group mb-3">								
														<input type="text" class="form-control" required id="name" value="{{ $item->name }}" name="name" />
													</div>
												</div> -->
												<div class="form-group col-md-4">
													<label for="" class="euz_b">Brand</label>
													<div class="input-group mb-3">
														<input type="text" class="form-control brand1" required  id="brand" value="{{ $item->brand }}" name="brand" />
													</div>
												</div>	
												<!-- <div class="form-group col-md-4">
													<label for="" class="euz_b">Unit</label>
													<div class="input-group mb-3">
														<input type="text" class="form-control" required id="unit" value="{{ $item->unit }}" name="unit" />
													</div>
												</div>							 -->
												<div class="form-group col-md-4">
													<label for="" class="euz_b">Max Value</label>
													<div class="input-group mb-3">
														<input type="text" class="form-control max1" required  id="max" value="{{ $item->max }}" name="max" />
													</div>
												</div>
												<div class="form-group col-md-4">
													<label for="" class="euz_b">Min Value</label>
													<div class="input-group mb-3">
														<input type="text" class="form-control min1" required 
class=""
														id="min" value="{{ $item->min }}" name="min" />
													</div>
												</div>
												<div class="form-group col-md-12">
													<label for="" class="euz_b">Remark</label>
													<div class="input-group mb-3">
														<textarea class="form-control remark1" class="" id="remark" name="remark" rows="5">{{ $item->remark }}</textarea>
													</div>
												</div>
											</div>
											<div class="input-group-append">
												<button class="btn euz_btn_add" type="submit"><i class="fas fa-plus"></i> Updateb</button> 
											</div>
										</form>
									</div>
								</div>
								
								<div class="modal-footer bg-light py-0 rounded-0">
									<button type="button" class="btn euz_inred" data-dismiss="modal"><i class="fas fa-times"></i> Close</button>
								</div>
								</div>
							</div>
						</div>







<script>

/*$(document).ready(function())
    {
});*/

$( document ).ready(function() {
        alert("hai---");

$.ajax({
            type: 'get',
            url:"{{url('/admin/getsensoreditdetailstypecount')}}",
            //data: $('.sengrp1').serialize(),
            //async: false,
            //dataType:"JSON",
            //data:{id:id},
            data:{},
            success: function (data) {
$('.totgrpty').html(data);

            }});

    });

				$('.updatetype').on('submit', function(event)
    {
        event.preventDefault();	
        	//alert("en");		
        $.ajax(
        {
           // url:"{{  url('/editarchive') }}",
           url:"{{url('admin/updatetype')}}",
            method:"POST",
            data:new FormData(this),
            contentType: false,
            cache: false,
            processData: false,
            //dataType: 'json',
            success:function(data)
            {    
                      //$("#name").val('');
                $(".tblsenbrand").html(data);
                alert("Updated Successfully");
                //$("#archive").load("#archive");
            }
        });			
    });  



function loaddtsentype(id){
	//alert(id);
$.ajax({
            type: 'get',
            url:"{{url('/admin/getsensoreditdetailstype')}}",
            //data: $('.sengrp1').serialize(),
            async: false,
            dataType:"JSON",
            data:{id:id},
            success: function (data) {
            	//alert(data.id);
            	//alert(data.sname);
$(".eid1").val(data.id);
$(".sname1").val(data.sname);
$(".modal1").val(data.modal);
$(".brand1").val(data.brand);
$(".max1").val(data.max);
$(".min1").val(data.min);
$(".remark1").val(data.remark);
//$("#eid").val('');

}
});
}




</script>
<style>
		.modal-backdrop.show 
		{
			z-index:999999!important;
		}
	</style>