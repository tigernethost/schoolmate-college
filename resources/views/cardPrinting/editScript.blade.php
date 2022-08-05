<input type="hidden" name="http_referrer" value={{ old('http_referrer') ?? \URL::previous() ?? url($crud->route) }}>

@if ($crud->model->translationEnabled())
<input type="hidden" name="locale" value={{ $crud->request->input('locale')?$crud->request->input('locale'):App::getLocale() }}>
@endif

{{-- See if we're using tabs --}}
@if ($crud->tabsEnabled() && count($crud->getTabs()))
    @include('crud::inc.show_tabbed_fields')
    <input type="hidden" name="current_tab" value="{{ str_slug($crud->getTabs()[0], "") }}" />
@else
   {{--  <div class="box col-md-12 padding-10 p-t-20">
    @include('crud::inc.show_fields', ['fields' => $fields])
    </div> --}}
@endif

{{-- Define blade stacks so css and js can be pushed from the fields to these sections. --}}

@section('after_styles')
    <link rel="stylesheet" href="{{ asset('vendor/backpack/crud/css/crud.css') }}">
    <link rel="stylesheet" href="{{ asset('vendor/backpack/crud/css/form.css') }}">
    <link rel="stylesheet" href="{{ asset('vendor/backpack/crud/css/'.$action.'.css') }}">

    <!-- CRUD FORM CONTENT - crud_fields_styles stack -->
    @stack('crud_fields_styles')
@endsection

@section('after_scripts')
    <script src="{{ asset('vendor/backpack/crud/js/crud.js') }}"></script>
    <script src="{{ asset('vendor/backpack/crud/js/form.js') }}"></script>
    <script src="{{ asset('vendor/backpack/crud/js/'.$action.'.js') }}"></script>

    <!-- CRUD FORM CONTENT - crud_fields_scripts stack -->
    @stack('crud_fields_scripts')

    

<script src="{{ asset('/js/fabric.js') }}"></script>

  {{-- // SCRIPT FOR FRONT --}}
  <script src="{{ asset("/js/smartcard/front_card.js") }}"></script>
  <script src="{{ asset("/js/smartcard/back_card.js") }}"></script>

  <script>
    $(document).ready(function () {

      // $('#formEditor').submit(function () {
      //  var front =  canvas_front.toJSON(['id']);
      //  var back  =  canvas_back.toJSON(['id']);
        
      //    console.log('test')
      //  setTimeout(function () {
      //  var form = $('#formEditor');
      //  form.append('<input type="text" name="template_name" value="' + $('#name').val() + '"/>');
      //  form.append('<textarea name="front_card">' + JSON.stringify(front) + '</textarea>');
      //  form.append('<textarea name="rear_card">' + JSON.stringify(back) + ' </textarea>');
      //  }, 1000);

      //  // form.appendTo('body').submit();
      // });
    })
  </script>

  <script>
    {{-- LOAD FRONT AND BACK --}}
    canvas_front.loadFromJSON('{!! $template->front_card !!}', function() {
       canvas_front.renderAll(); 
    },function(o,object){
       console.log(o,object)
    })

    canvas_back.loadFromJSON('{!! $template->rear_card !!}', function() {
       canvas_front.renderAll(); 
    },function(o,object){
       console.log(o,object)
    })
  </script>
  




    <script>
    jQuery('document').ready(function($){

      // Save button has multiple actions: save and exit, save and edit, save and new
      var saveActions = $('#saveActions'),
      crudForm        = saveActions.parents('form'),
      saveActionField = $('[name="save_action"]');

      saveActions.on('click', '.dropdown-menu a', function(e){
          var saveAction = $(this).data('value');
          var front =  canvas_front.toJSON(['id']);
          var back  =  canvas_back.toJSON(['id']);
          
          saveActionField.val( saveAction );
          
          console.log('test')

          crudForm.append('<input type="hidden" name="template_name" value="' + $('#name').val() + '"/>');
          crudForm.append('<textarea name="front_card">' + JSON.stringify(front) + '</textarea>');
          crudForm.append('<textarea name="rear_card">' + JSON.stringify(back) + ' </textarea>');
          crudForm.submit();
      });

      // Ctrl+S and Cmd+S trigger Save button click
      $(document).keydown(function(e) {
          if ((e.which == '115' || e.which == '83' ) && (e.ctrlKey || e.metaKey))
          {
              e.preventDefault();
              // alert("Ctrl-s pressed");
              $("button[type=submit]").trigger('click');
              return false;
          }
          return true;
      });

      // prevent duplicate entries on double-clicking the submit form
      crudForm.submit(function (event) {
        $("button[type=submit]").prop('disabled', true);

          var front =  canvas_front.toJSON(['id']);
          var back  =  canvas_back.toJSON(['id']);
          
          console.log('test')

          crudForm.append('<input type="hidden" name="template_name" value="' + $('#name').val() + '"/>');
          crudForm.append('<textarea name="front_card">' + JSON.stringify(front) + '</textarea>');
          crudForm.append('<textarea name="rear_card">' + JSON.stringify(back) + ' </textarea>');

      });

    

      });
    </script>

@endsection
