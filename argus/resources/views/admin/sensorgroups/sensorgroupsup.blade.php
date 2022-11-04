<table class="table table-bordered table-striped">
						<thead class="euz_thead_set">
							<tr>
								<!--<th>Sl.No</th>-->
								<th>Sensor Group Name</th>
								<th>Action</th>
							</tr>
						</thead>
						<tbody>
							<?php $i = 1; 

                            foreach($groups as $group) { ?>
							<tr id="gr<?php echo $group->id;?>">
								<!--<td><?php //echo $i; ?></td>-->
								<td><?php echo $group->name; ?></td>
								<td>

<a href="#" onclick=loaddt("<?php echo $group->id;?>"); data-toggle="modal" data-target="#sensorgroup" class="text-info euz_td_a"><i class="fas fa-user-edit"></i> Edit</a>
									<!--<a href="" class="text-info euz_td_a" data-id='{{ $group->id }}' data-name='{{ $group->name }}' data-toggle="modal" data-target="#sensorgroup"><i class="fas fa-user-edit"></i> Edit</a>-->&nbsp;&nbsp;&nbsp;&nbsp;

<a href="#" onclick=delitem("<?php echo $group->id;?>");  class="text-danger euz_td_a"><i class="fas fa-user-times"></i> Delete</a>


									<!--<a href="<?php //echo url('/admin/deleteGroup/'.$group->id); ?>" onclick="return confirm('Are you sure to delete this item?')"  class="text-danger euz_td_a"><i class="fas fa-user-times"></i> Delete</a>-->
								</td>
							</tr>

							<?php $i++; } ?>
						</tbody>
					</table>



<div class="modal fade" id="sensorgroup">
								<div class="modal-dialog modal-dialog-centered">
									<div class="modal-content shadow">
									<div class="modal-header euz_header  rounded-0">
										<p class="text-white euz_b">Edit Sensor Group Name</p>
										<button type="button" class="close" data-dismiss="modal">
										<span>x</span>
										</button>
									</div>									
									<div class="modal-body row">
										<div class="form-group col-md-12 py-2 mb-0">
<form id="sengrp" name="settleUp" class="sengrp1" method="POST" enctype="multipart/form-data">


											<label for="" class="euz_b">Sensor Group Name</label>
											<!--<form onsubmit="goto();" action="{{ url('/admin/updategroup') }}" method="POST" enctype="multipart/form-data">-->




											<div class="input-group mb-3">
											{{ csrf_field() }}
												<input type="hidden" name="eid" value="" id="eid" class="eid" />
												<input type="text" class="name form-control" required id="name" value="" name="name" />
												<div class="input-group-append">
													<button class="btn btnup1 euz_btn_add" type="submit"><i class="fas fa-plus"></i> Update</button>

													 
												</div>
											</div>
											</form>
										</div>
									</div>		
									<div class="modal-footer bg-light py-0 rounded-0">
										<button type="button" class="btcheck btn euz_inred" data-dismiss="modal"><i class="fas fa-times"></i> Close</button>
									</div>
									</div>
								</div>
							</div>
					<script type="text/javascript">
						


$('body, html').one('submit','.sengrp1', function(e) {
 
e.stopImmediatePropagation();
//alert("hai1");
 $.ajax(
        {
           //Update group
           url:"{{url('/admin/updategroup')}}",
            method:"POST",
            data:new FormData(this),
            contentType: false,
            cache: false,
            processData: false,
           async: false,
            success:function(data)
            {    
                      
                $(".tblsen").html(data);
                alert("Updated Successfully");
                
            }
        });			




});

			
       

function loaddt(id){
	//Sensor edit
$.ajax({
            type: 'get',
            url:"{{url('/admin/getsensoreditdetails')}}",
            //data: $('.sengrp1').serialize(),
            async: false,
            dataType:"JSON",
            data:{id:id},
            success: function (data) {
            	//alert(data.id);
$(".eid").val(data.id);
$(".name").val(data.name);
//$("#eid").val('');

}
});
}
						
					</script>

<style>
		.modal-backdrop.show 
		{
			z-index:999999!important;
display: none;
		}
	</style>
