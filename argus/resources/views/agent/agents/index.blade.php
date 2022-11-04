@extends('layouts.admin')
@section('content')
<?php //print_r($age);exit; ?>

<!--Agent Personal Inf-->
<div class="p-3">
			<div class="row">
				<div class="col-md-4">
					<div class="row p-2">
						<div class="col-md-12 euz_bar_agent">
							<p class="euz_b euz_text_blue m-0 pt-1">Personal Information</p>
						</div>
						<div class="col-md-12 euz_border_agent euz_fix_box">
							<div class="row">						
								<table style="width:100%;">
                                    <colgroup>
                                        <col width="40%">
                                        <col width="60%">
                                    </colgroup>
                                    <tbody>
                                        <tr>
                                            <td class="euz_left_td euz_b">
                                                First Name
                                            </td>
                                            <td class="euz_right_td">{{ $age[0]->fname}}</td>
                                        </tr>
                                        <tr>
                                            <td class="euz_left_td euz_b">
                                                Last Name
                                            </td>
                                            <td class="euz_right_td">{{ $age[0]->lname}}</td>
                                        </tr>
                                        <tr>
                                            <td class="euz_left_td euz_b">
                                                Organization
                                            </td>
                                            <td class="euz_right_td">{{ $age[0]->corporate_name}}</td>
                                        </tr>
										<tr>
                                            <td class="euz_left_td_empty euz_b">
                                                
                                            </td>
                                            <td class="euz_right_td_empty text-white">.</td>
                                        </tr>
										<tr>
                                            <td class="euz_left_td_empty euz_b">
                                                
                                            </td>
                                            <td class="euz_right_td_empty text-white">.</td>
                                        </tr>
                                    </tbody>
                                </table>
							</div>
						</div>
					</div>
				</div>
				
				<div class="col-md-4">
					<div class="row p-2">
						<div class="col-md-12 euz_bar_agent">
							<p class="euz_b euz_text_blue m-0 pt-1">Location</p>
						</div>
						<div class="col-md-12 euz_border_agent euz_fix_box">
							<div class="row">						
								<table style="width:100%;">
                                    <colgroup>
                                        <col width="40%">
                                        <col width="60%">
                                    </colgroup>
                                    <tbody>
                                        <tr>
                                            <td class="euz_left_td euz_b">
                                                Street
                                            </td>
                                            <td class="euz_right_td">{{ $age[0]->street}}</td>
                                        </tr>
                                        <tr>
                                            <td class="euz_left_td euz_b">
                                                City
                                            </td>
                                            <td class="euz_right_td">{{ $age[0]->city}}</td>
                                        </tr>
                                        <tr>
                                            <td class="euz_left_td euz_b">
                                                state
                                            </td>
                                            <td class="euz_right_td">{{ $age[0]->state}}</td>
                                        </tr>
										<tr>
                                            <td class="euz_left_td euz_b">
                                                Post Code
                                            </td>
                                            <td class="euz_right_td">{{ $age[0]->post_code}}</td>
                                        </tr>
										<tr>
                                            <td class="euz_left_td euz_b">
                                                Country
                                            </td>
                                            <td class="euz_right_td">{{ $age[0]->country}}</td>
                                        </tr>
                                    </tbody>
                                </table>
							</div>
						</div>
					</div>
				</div>
				
				<div class="col-md-4">
					<div class="row p-2">
						<div class="col-md-12 euz_bar_agent">
							<p class="euz_b euz_text_blue m-0 pt-1">Log Details</p>
						</div>
						<div class="col-md-12 euz_border_agent euz_fix_box">
							<div class="row">						
								<table style="width:100%;">
                                    <colgroup>
                                        <col width="40%">
                                        <col width="60%">
                                    </colgroup>
                                    <tbody>
                                        <tr>
                                            <td class="euz_left_td euz_b" style="width: 60%;">
                                                Login Email
                                            </td>
                                            <td class="euz_right_td">{{ $age[0]->email}}</td>
                                        </tr>
                                        <tr>
                                            <td class="euz_left_td euz_b">
                                                Password
                                            </td>
                                            <td class="euz_right_td">**************</td>
                                        </tr>
                                        <tr>
                                            <td class="euz_left_td euz_b">
                                                Active
                                            </td>
                                            <td class="euz_right_td">@if($age[0]->status==1)
											Yes <i class='fas fa-smile-beam euz_ingreen'></i>
											@else
											No <i class='fas fa-frown text-danger'></i>
											@endif
                                        </tr>
                                        <tr>
                                            <td class="euz_left_td euz_b">
                                                Subscription Start Date
                                            </td>
                                            <td class="euz_right_td">{{ $age[0]->service_start}}</td>
                                        </tr>
										<tr>
                                            <td class="euz_left_td euz_b">
                                                Subscription End & Renew Date
                                            </td>
                                            <td class="euz_right_td">{{ $age[0]->service_expiry}}</td>
                                        </tr>
										<tr>
                                            <td class="euz_left_td_empty euz_b">
                                                
                                            </td>
                                            <td class="euz_right_td_empty text-white">.</td>
                                        </tr>
                                    </tbody>
                                </table>
							</div>
						</div>
					</div>
				</div>
				
				<div class="col-md-12">
					<div class="row p-2">
						<div class="col-md-12 euz_bar_agent">
							<p class="euz_b euz_text_blue m-0 pt-1">Remark</p>
						</div>
						<div class="col-md-12 euz_border_agent">
							<p class="text-justify">
								{{ $age[0]->remark}}
							</p>
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