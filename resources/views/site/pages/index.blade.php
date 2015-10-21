@extends('site.layouts.default')

{{-- Content --}}
@section('content')
<div class="page-header">
	<h3>
		<!-- {{{ $title }}} -->
		site.pages.index

		<div class="pull-right">
			<a href="{{{ URL::to('admin/blogs/create') }}}" class="btn btn-small btn-info iframe"><span class="glyphicon glyphicon-plus-sign"></span> Create</a>
		</div>
	</h3>
</div>

<table id="tickets" class="table table-striped table-hover cell-border">
	<thead>
		<tr>
			<th class="col-md-1">{{{ Lang::get('admin/issues/table.status') }}}</th>
			@if($user->hasRole("admin"))
			<th class="col-md-1">{{{ Lang::get('admin/issues/table.user') }}}</th>
			@endif
			<th class="col-md-1">{{{ Lang::get('admin/issues/table.topic') }}}</th>
			<th class="col-md-1">{{{ Lang::get('admin/issues/table.comments') }}}</th>
			<th class="col-md-1">{{{ Lang::get('admin/issues/table.created_at') }}}</th>
			<th class="col-md-1">{{{ Lang::get('table.actions') }}}</th>
		</tr>
	</thead>
	<tbody>
	</tbody>
</table>
@stop

{{-- Scripts --}}
@section('scripts')

@if($user->hasRole("admin"))

<script type="text/javascript">
	var oTable;
	$(document).ready(function() {
		oTable = $('#tickets').dataTable( {
			"sDom": "<'row'<'col-md-6'l><'col-md-6'f>r>t<'row'<'col-md-6'i><'col-md-6'p>>",
			"sPaginationType": "bootstrap",
			"oLanguage": {
				"sLengthMenu": "_MENU_ records per page"
			},
			"bProcessing": true,
			"bServerSide": true,
			"sAjaxSource": "{{ URL::to('issues/data/admin') }}",
			"fnDrawCallback": function ( oSettings ) {
				$(".iframe").colorbox({iframe:true, width:"80%", height:"80%"});
			}
		});
	});
</script>

@endif

@if($user->hasRole("comment"))

<script type="text/javascript">
	var oTable;
	$(document).ready(function() {
		oTable = $('#tickets').dataTable( {
			"sDom": "<'row'<'col-md-6'l><'col-md-6'f>r>t<'row'<'col-md-6'i><'col-md-6'p>>",
			"sPaginationType": "bootstrap",
			"oLanguage": {
				"sLengthMenu": "_MENU_ records per page"
			},
			"bProcessing": true,
			"bServerSide": true,
			"sAjaxSource": "{{ URL::to('issues/data/user') }}",
			"fnDrawCallback": function ( oSettings ) {
				$(".iframe").colorbox({iframe:true, width:"80%", height:"80%"});
			}
		});
	});
</script>

@endif

@stop
