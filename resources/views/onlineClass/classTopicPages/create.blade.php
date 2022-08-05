@extends('backpack::layout')

@section('header')
	<section class="content-header">
	  <h1>
        <span class="text-capitalize">Topic: {{$selected_topic->title ?? 'Unknown'}}</span>
        <!-- <small>{{ trans('backpack::crud.add').' '.$crud->entity_name }}.</small> -->
	  </h1>
	  <ol class="breadcrumb">
	    <li><a href="{{ url(config('backpack.base.route_prefix'), 'dashboard') }}">{{ trans('backpack::crud.admin') }}</a></li>
	    <li><a href="{{ url($crud->route) }}?course_code={{$course->code}}&module_id={{$module->id}}" class="text-capitalize">{{ $crud->entity_name_plural }}</a></li>
	    <li class="active">{{ trans('backpack::crud.add') }}</li>
	  </ol>
	</section>
@endsection

@section('content')
<div class="row">
	<div class="col-md-12">
		<!-- Default box -->
		@if ($crud->hasAccess('list'))
			<a href="{{ url('admin/online-class-topic?course_code=' . $course->code . '&module_id=' . $module->id . '&topic_id=' . $selected_topic->id) }}"><i class="fa fa-angle-double-left"></i> {{ trans('backpack::crud.back_to_all') }} <span>{{ $crud->entity_name_plural }}</span></a><br><br>
		@endif

		@include('crud::inc.grouped_errors')

		  <form method="post"
		  		action="{{ url('admin/online-class-topic-page?course_code=' . $course->code . '&module_id=' . $module->id . '&topic_id=' . $selected_topic->id . '&page_type=' . request()->page_type) }}"
				@if ($crud->hasUploadFields('create'))
				enctype="multipart/form-data"
				@endif
		  		>
		  {!! csrf_field() !!}
		  <div class="box">

		    <div class="box-header with-border">
		      <h3 class="box-title">{{ trans('backpack::crud.add_a_new') }} Topic {{request()->page_type}} </h3>
		    </div>
		    {{-- <div class="box-body row display-flex-wrap" style="display: flex; flex-wrap: wrap;"> --}}
		      <!-- load the view from the application if it exists, otherwise load the one in the package -->
		      @if(view()->exists('vendor.backpack.crud.form_content'))
		      	@include('vendor.backpack.crud.form_content', [ 'fields' => $crud->getFields('create'), 'action' => 'create' ])
		      @else
		      	@include('crud::form_content', [ 'fields' => $crud->getFields('create'), 'action' => 'create' ])
		      @endif
		    {{-- </div> --}}
		    <!-- /.box-body -->
		    <div class="box-footer" style="margin-left: 10px;">
                <button id="btnPost" style="margin-right: 10px;" type="submit" class="btn btn-success" >
                	<span class="fa fa-save" role="presentation" aria-hidden="true"></span> Create
              	</button>
              	<a href="{{ url('admin/online-class-topic?course_code='.request()->course_code.'&module_id='.request()->module_id.'&topic_id='.request()->topic_id) }}" style="margin-right: 10px;" type="button" class="btn btn-secondary" data-dismiss="modal">
                	<span class="fa fa-ban"></span> Cancel
              	</a>
		    </div><!-- /.box-footer-->

		  </div><!-- /.box -->
		  </form>
	</div>
</div>

@endsection
