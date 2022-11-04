@extends('layouts.admin')
@section('content')
<div class="p-3">
        <div class="row">
            <div class="col-md-12 euz_bar euz_b">
                <a href="{{ url('/agent/gateway') }}"><i class="fas fa-user euz_text_blue"></i> <?php echo $user[0]->fname.' '.$user[0]->lname; ?></a> / <span class="euz_ac_bl">Gateway Group</span>
            </div>
            @if(Session::has('flash_message'))
            <div class="alert alert-success w-100"><button type="button" class="close" data-dismiss="alert">&times;</button>{{ Session::get('flash_message') }}</div>
            @endif
            <div class="col-md-12 euz_border p-3 bg-white">
                <div class="row">
                   <?php foreach($groups as $group) { ?>
                    <div class="col-md-4 mt-2">
                        <div class="card">
                            <div class="card-header">
                                <div class="custom-checkbox">
                                    <label class="euz_check_box euz_b pl-0"><?php echo $group->name; ?></label>
                                </div>
                            </div>
                            <div class="card-body pb-0 euz_b">
                                <p class="mb-0"><label style="width:125px;">Sim card / Ref:Id </label>: <?php echo $group->sim_no; ?></p>
                                <p class="mb-2"><label style="width:125px;">Longitude </label>: <?php echo $group->longitude; ?> <br> <label style="width:125px;">Latitude </label>: <?php echo $group->latitude; ?></p>
                            </div> 
                            <?php $hubcnt = DB::table('sensor_hubs')->where('group_id', $group->id)->where('agent', $group->agent)->get(); ?>
                            <div class="card-footer text-right bg-white euz_card_fo px-0">
                                <span class="ml-2 float-left euz_gren">Sensor Hub : <?php echo count($hubcnt); ?></span>
                                <a href="javascript:void(0)" class="ml-2" data-toggle="tooltip" data-placement="top" title="Group Info" onclick="profileopen(<?php echo $group->id;?>)"><i class="fas fa-eye euz_a_icon"></i></a>
                                <a href="<?php echo url('/agent/sensorhubs/'.$group->agent.'/'.$group->id); ?>" class="ml-2" data-toggle="tooltip" data-placement="top" title="Sensor Hub"><i class="fab fa-hubspot euz_a_icon"></i></a>
								<a href="javascript:void(0)" class="euz_tree_in" data-toggle="tooltip" data-placement="top" title="Visual Hierarchy" onclick="profileopentree(<?php echo $group->id;?>)"><i class="fas fa-sitemap"></i></a>
                            </div>
                        </div>
                    </div>
                    <?php } ?>
                </div>
            </div>			
        </div>
    </div>
	<!---profile---->
    <div id="agentprofile" class="euz_agent_profile" style="overflow-x: auto;"></div>
    <div id="agentprofiletree" class="euz_agent_profile" style="overflow-x: auto;"></div>
    <!---End Profile---->
@endsection
@section('scripts')
<script>
	$(document).ready(function()
	{
		$("#hub").change(function(){
			$.ajax({
				url: "/agent/addview",
				type: "get",
				data: $('#frm').serialize(),
				success: function(data){
					$("#sense_details").html(data);
				}
			});
		});
	});
	function profileopen(groupid) 
	{
		var url = "{{ url('/agent/profileagent') }}";
		var docurl = url + "/" + groupid;
		$.ajax({
			url : docurl,
			method : "GET",
			success:function(response)
			{
				$('#agentprofile').html(response);
			}
		});	
		document.getElementById("agentprofile").style.width = "80%";
	}	
	function profileclose() 
	{
		document.getElementById("agentprofile").style.width = "0";
	}
    function profileopentree(userid) 
    {
        var url = "{{ url('/agent/editGatewaygrouptree') }}";
        var docurl = url + "/" + userid;
        $.ajax({
            url : docurl,
            method : "GET",
            beforeSend: function() {
                $("#loading-image").show();
            },
            success:function(response)
            {
                $('#agentprofiletree').html(response);
                $("#loading-image").hide();
            }
        });	
        document.getElementById("agentprofiletree").style.width = "80%";
    }	
    function profileclosetree() 
    {
        document.getElementById("agentprofiletree").style.width = "0";
    }
</script>
@parent

@endsection









<?php /*?>@extends('layouts.admin')
@section('content')
@can('product_create')
    <div style="margin-bottom: 10px;" class="row">
        <div class="col-lg-12">
            <a class="btn btn-success" href="{{ route("admin.products.create") }}">
                {{ trans('global.add') }} {{ trans('global.product.title_singular') }}
            </a>
        </div>
    </div>
@endcan
<div class="card">
    <div class="card-header">
        {{ trans('global.product.title_singular') }} {{ trans('global.list') }}
    </div>

    <div class="card-body">
        <div class="table-responsive">
            <table class=" table table-bordered table-striped table-hover datatable">
                <thead>
                    <tr>
                        <th width="10">

                        </th>
                        <th>
                            {{ trans('global.product.fields.name') }}
                        </th>
                        <th>
                            {{ trans('global.product.fields.description') }}
                        </th>
                        <th>
                            {{ trans('global.product.fields.price') }}
                        </th>
                        <th>&nbsp;
                            
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($products as $key => $product)
                        <tr data-entry-id="{{ $product->id }}">
                            <td>

                            </td>
                            <td>
                                {{ $product->name ?? '' }}
                            </td>
                            <td>
                                {{ $product->description ?? '' }}
                            </td>
                            <td>
                                {{ $product->price ?? '' }}
                            </td>
                            <td>
                                @can('product_show')
                                    <a class="btn btn-xs btn-primary" href="{{ route('admin.products.show', $product->id) }}">
                                        {{ trans('global.view') }}
                                    </a>
                                @endcan
                                @can('product_edit')
                                    <a class="btn btn-xs btn-info" href="{{ route('admin.products.edit', $product->id) }}">
                                        {{ trans('global.edit') }}
                                    </a>
                                @endcan
                                @can('product_delete')
                                    <form action="{{ route('admin.products.destroy', $product->id) }}" method="POST" onsubmit="return confirm('{{ trans('global.areYouSure') }}');" style="display: inline-block;">
                                        <input type="hidden" name="_method" value="DELETE">
                                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                        <input type="submit" class="btn btn-xs btn-danger" value="{{ trans('global.delete') }}">
                                    </form>
                                @endcan
                            </td>

                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@section('scripts')
@parent
<script>
    $(function () {
  let deleteButtonTrans = '{{ trans('global.datatables.delete') }}'
  let deleteButton = {
    text: deleteButtonTrans,
    url: "{{ route('admin.products.massDestroy') }}",
    className: 'btn-danger',
    action: function (e, dt, node, config) {
      var ids = $.map(dt.rows({ selected: true }).nodes(), function (entry) {
          return $(entry).data('entry-id')
      });

      if (ids.length === 0) {
        alert('{{ trans('global.datatables.zero_selected') }}')

        return
      }

      if (confirm('{{ trans('global.areYouSure') }}')) {
        $.ajax({
          headers: {'x-csrf-token': _token},
          method: 'POST',
          url: config.url,
          data: { ids: ids, _method: 'DELETE' }})
          .done(function () { location.reload() })
      }
    }
  }
  let dtButtons = $.extend(true, [], $.fn.dataTable.defaults.buttons)
@can('product_delete')
  dtButtons.push(deleteButton)
@endcan

  $('.datatable:not(.ajaxTable)').DataTable({ buttons: dtButtons })
})

</script>
@endsection
@endsection<?php */?>