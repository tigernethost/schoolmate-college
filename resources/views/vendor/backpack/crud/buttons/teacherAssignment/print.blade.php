@if ($crud->hasAccess('list'))
	<a  style="margin-bottom: 5px; width: 13%" 
	href="{{ url($crud->route) . '/' . $entry->id . '/print' }}" class="btn btn-xs btn-default" title="print">
		<i class="fa fa-print"></i>
	</a>
@endif