@extends('layouts.admin')
@section('content')
<div class="p-3 add_admin_table">
			<div class="row">
				<div class="col-md-12 euz_bar">
					<i class="fas fa-user-tie euz_text_blue"></i> <small class="euz_b euz_text_blue">Agents</small>
				</div>
				@if(Session::has('flash_message'))
				<div class="alert alert-success w-100"><button type="button" class="close" data-dismiss="alert">&times;</button>{{ Session::get('flash_message') }}</div>
				@endif
				<div class="col-md-12 euz_border p-3 bg-white">
					<div class="row">
						<div class="col-md-12 mt-2">
							<ul class="nav nav-tabs euz_tab" role="tablist">
								<li class="nav-item">
									<a class="nav-link euz_tabtex " href="/admin/agents"><i class="fas fa-user-plus"></i> Add Agent</a>
								</li>
								<li class="nav-item">
									<a class="nav-link euz_tabtex active" href="/admin/gatewaygroups"><i class="fas fa-users"></i> Add Gateway Group</a>
								</li>
								<li class="nav-item">
									<a class="nav-link euz_tabtex" href="/admin/sensorhubs"><i class="fas fa-microchip"></i> Add Sensor Hub</a>
								</li>
							</ul>
							<div class="tab-content px-3">
							
							<div id="gateway" class="tab-pane active"><br>
								
									<a class="btn euz_btn_add float-right euz_pointer mb-3 euz_newgateway_list_q euz_newgateway_btn_q" href="/admin/addgatewaygroup"><i class="fas fa-plus"></i> Add Gateway Group</a>
									
									<div class="euz_newgateway_list_q table-responsive-sm">	
								<table class="table table-bordered table-striped">
									<thead class="euz_thead">
										<tr>
											<th>Group ID</th>
												<th>Agent Name</th>
												<th>Sensor Group Name</th>
												<th>SIM Card Number</th>
												<th>Action</th>
										</tr>
									</thead>
									<tbody>
									@foreach($groups as $index =>$item)
										<tr>
											<td>{{ $item->group_id }}</td>
											<td>{{ $item->fname }}</td>
											<td>{{ $item->name }}</td>
											<td>{{ $item->sim_no }}</td>
											
											<td><a href="editGatewaygroup/{{ $item->id }}" class="euz_inblue"><i class="fas fa-user-edit"></i> Edit</a>&nbsp;&nbsp;&nbsp;&nbsp;<a href="deleteGatewaygroup/{{ $item->id }}" class="euz_inred" onclick="return confirm('Are you sure to delete this item?')"><i class="fas fa-user-times"></i> Delete</a></td>
										</tr>
									@endforeach
									</tbody>
								</table>
							</div>
							{{ $groups->links() }}
						</div>
						</div>
							
						</div>
						
					</div>
				</div>
				
			</div>
        </div>

@endsection
@section('scripts')
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