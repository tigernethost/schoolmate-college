@extends('backpack::layout')

@section('header')
	{{-- <section class="content-header">
	  <h1>
        <span class="text-capitalize">
        	{{ $teacher->full_name }}
        </span>
        <small>{!! $crud->getSubheading() ?? trans('backpack::crud.edit').' '.$crud->entity_name !!}.</small>
	  </h1>
	  <ol class="breadcrumb">
	    <li><a href="{{ url(config('backpack.base.route_prefix'),'dashboard') }}">{{ trans('backpack::crud.admin') }}</a></li>
	    <li><a href="{{ url($crud->route) }}" class="text-capitalize">{{ $crud->entity_name_plural }}</a></li>
	    <li class="active">{{ trans('backpack::crud.edit') }}</li>
	  </ol>
	</section> --}}
@endsection

@section('content')
	<!-- HEADER -->
    <div class="row" style="padding: 15px;">
      <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 smo-search-group"> 
        <section class="content-header">
          <ol class="breadcrumb">
            <li><a href="{{ url(config('backpack.base.route_prefix'), 'dashboard') }}">{{ trans('backpack::crud.admin') }}</a></li>
		    <li><a href="{{ url($crud->route) }}" class="text-capitalize">{{ $crud->entity_name_plural }}</a></li>
		    <li class="active">{{ trans('backpack::crud.edit') }}</li>
          </ol>
        </section>
        <h1 class="smo-content-title">
          	{{ $teacher->full_name ?? '-' }}
	        <small>{!! $crud->getSubheading() ?? trans('backpack::crud.edit').' '.$crud->entity_name !!}.</small>
        </h1>
      </div>
    </div>
  	<!-- END OF HEADER -->

	@if ($crud->hasAccess('list'))
		<a href="{{ url($crud->route) }}?teacher_id={{ request()->teacher_id }}" class="hidden-print"><i class="fa fa-angle-double-left"></i> {{ trans('backpack::crud.back_to_all') }} <span>{{ $crud->entity_name_plural }}</span></a>
	@endif

	<div class="row m-t-20">
		<div class="{{ $crud->getEditContentClass() }}">
			<!-- Default box -->

			@include('crud::inc.grouped_errors')

			  <form method="post"
			  		action="{{ url($crud->route.'/'.$entry->getKey()) }}?teacher_id={{ request()->teacher_id }}"
					@if ($crud->hasUploadFields('update', $entry->getKey()))
					enctype="multipart/form-data"
					@endif
			  		>
			  {!! csrf_field() !!}
			  {!! method_field('PUT') !!}
			  <div class="col-md-12">
			  	@if ($crud->model->translationEnabled())
			    <div class="row m-b-10">
			    	<!-- Single button -->
					<div class="btn-group pull-right">
					  <button type="button" class="btn btn-sm btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
					    {{trans('backpack::crud.language')}}: {{ $crud->model->getAvailableLocales()[$crud->request->input('locale')?$crud->request->input('locale'):App::getLocale()] }} &nbsp; <span class="caret"></span>
					  </button>
					  <ul class="dropdown-menu">
					  	@foreach ($crud->model->getAvailableLocales() as $key => $locale)
						  	<li><a href="{{ url($crud->route.'/'.$entry->getKey().'/edit') }}?locale={{ $key }}">{{ $locale }}</a></li>
					  	@endforeach
					  </ul>
					</div>
			    </div>
			    @endif
			    <div class="row display-flex-wrap">
			      <!-- load the view from the application if it exists, otherwise load the one in the package -->
			      @if(view()->exists('vendor.backpack.crud.form_content'))
			      	@include('vendor.backpack.crud.form_content', ['fields' => $fields, 'action' => 'edit'])
			      @else
			      	@include('crud::form_content', ['fields' => $fields, 'action' => 'edit'])
			      @endif
			    </div><!-- /.box-body -->

	            <div class="">

	                {{-- @include('crud::inc.form_save_buttons') --}}
	                <div id="saveActions" class="form-group">

					    <input type="hidden" name="save_action" value="{{ $saveAction['active']['value'] }}">

					    <div class="btn-group">

					        <button type="submit" class="btn btn-success">
					            <span class="fa fa-save" role="presentation" aria-hidden="true"></span> &nbsp;
					            <span data-value="{{ $saveAction['active']['value'] }}">{{ $saveAction['active']['label'] }}</span>
					        </button>

					        <button type="button" class="btn btn-success dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aira-expanded="false">
					            <span class="caret"></span>
					            <span class="sr-only">&#x25BC;</span>
					        </button>

					        <ul class="dropdown-menu">
					            @foreach( $saveAction['options'] as $value => $label)
					            <li><a href="javascript:void(0);" data-value="{{ $value }}">{{ $label }}</a></li>
					            @endforeach
					        </ul>

					    </div>

					    <a href="{{ $crud->hasAccess('list') ? url($crud->route) : url()->previous() }}?teacher_id={{ request()->teacher_id }}" class="btn btn-default"><span class="fa fa-ban"></span> &nbsp;{{ trans('backpack::crud.cancel') }}</a>
					</div>

			    </div><!-- /.box-footer-->
			  </div><!-- /.box -->
			  </form>
		</div>
	</div>
@endsection
