@if ($crud->hasAccess('list'))
	@if($entry->active)
		<a href="{{ url($crud->route) . '/deactivate/' . $entry->id}}" class="btn btn-xs btn-danger action-btn" title="Deactivate">
			<i class="fa fa-power-off"></i>
		</a>
	@else
		<a href="{{ url($crud->route) . '/activate/' . $entry->id}}" class="btn btn-xs btn-info action-btn" title="Activate">
			<i class="fa fa-toggle-on" aria-hidden="true"></i>
		</a>
	@endif
@endif