@extends('backpack::layout')

@section('header')
@endsection

@section('content')  
  <link rel="stylesheet" type="text/css" href="{{ asset('css/onlineclass/class.css') }}">

  <div class="row p-l-20 p-r-20">
    @include('onlineClass/partials/navbar')
  </div>

  <div class="row p-l-20 p-r-20">
    <!-- START RIGHT SIDEBAR -->
    @include('onlineClass/partials/right_sidebar')
    <!-- END RIGHT SIDEBAR -->

    <!-- START OF MAIN FEED -->  
    <div class="col-md-8 col-lg-8 col-one">
      <div class="">
        <div class="info-box add-post shadow">
          <div class="box-body">
            <!-- <div class="row"> -->
              <div class="form-group col-2 col-xs-2 col-sm-2 col-md-1 col-lg-1 p-t-10" style="margin: 0px;">
                <a class="thumbnail form-control" >
                  @if($user->employee->photo)
                    @if(file_exists($user->employee->photo))
                    <img src="{{ asset($user->employee->photo) }}" alt="...">
                    @else
                    <img src="{{ asset('images/headshot-default.png') }}" alt="...">
                    @endif
                  @else
                    <img src="{{ asset('images/headshot-default.png') }}" alt="...">
                  @endif
                </a>
              </div>
              <div class="form-group col-8 col-xs-8 col-sm-8 col-md-10 col-lg-10 p-t-10" style="margin: 0px;">
                  <input style="border: none; margin-top: 5px;" 
                    placeholder="Start a discussion, add an assignment, create a quiz..." 
                    class="form-control" data-toggle="modal" data-target="#formModal">
              </div>
              <div class="form-group col-2 col-xs-2 col-sm-2 col-md-1 col-lg-1 p-t-10" style="margin: 0px; padding: 0px;">
                <button id="btnAddAssignment" type="submit" class="btn btn-primary btn-circle" style="height: 50px; width: 50px; border-radius: 50%; margin-right: 5px;" title="Create Assignment">
                  <i class="fa fa-plus"></i>
                </button>
              </div>
            </div>
          <!-- </div> -->
        </div>
      </div>
      <!-- START SECTION CLASS POSTS -->
      @if(count($assignments)>0)
        @foreach($assignments as $assignment)
          <div class="">
            <div class="box shadow">
              <div class="box-body with-border" style="padding: 20px !important;">
                {{ $assignment->title }}
                {!! $assignment->instructions !!}
                <p class="text-muted"><strong>Due Date: </strong>{{ date('F j, Y', strtotime($assignment->due_date)) }}</p>
                <a class="btn btn-default pull-right" href="{{ url($crud->route . '/' . $assignment->id . '?class_code=' . $class->code) }}">
                  View
                </a>
              </div>
            </div>
          </div>
        @endforeach
        <!-- ALL POST LOADED -->
        <div class="">
          <div class="box" style="border-radius: 5px;">
            <div class="box-body" style="padding: 0px;">
              <div class="text-center">
                <h4> All assignments loaded </h4>
              </div>
            </div>
          </div>
        </div>
      @else
        <div class="p-t-20 p-b-20">
          <img class="img-responsive" src="{{asset('/images/icons/assignment.png')}}" alt="Loading..." style="margin: auto; height: 130px;">
          <h3 class="text-center">No Assignments Yet.</h3>
        </div>
      @endif
      <!-- END SECTION CLASS POSTS -->
    </div>
    <!-- END OF MAIN FEED -->
  </div>

  {{-- START ONLINE CLASS FORM --}}
  @if(backpack_auth()->user()->employee_id == $class->teacher_id || $class->isTeacherSubstitute)
    <form action="{{url('admin/teacher-online-class/video_conference') }}" method="GET" target="_blank" id="form{{ $class->code }}">
      @csrf
      <input type="hidden" name="_method" value="GET">
      <input type="hidden" name="classid" value="{{$class->id}}">
      <input type="hidden" name="class_code" value="{{$class->code}}">
    </form>
  @endif
  <script type="text/javascript">
    document.getElementById("nav-assignments").classList.add("active");
  </script>

@endsection

@push('after_styles')
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.css">
@endpush

@push('after_scripts')
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.js"></script>
  <script>
      $('.startVideoConferencing').click(function () {
        var classCode = $(this).attr('classcode');
        console.log(classCode);
        $('#form' + classCode).submit();
      });

      $('#btnAddAssignment').click(function () {
        window.location.href = "{{ url('admin/online-class/assignment/create?class_code=' . $class->code) }}";
      });
  </script>
@endpush
