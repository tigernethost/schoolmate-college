<!-- text input -->
<div @include('crud::inc.field_wrapper_attributes') >
    <label>{!! $field['label'] !!}</label>
    @include('crud::inc.field_translatable_icon')

    @if(isset($field['prefix']) || isset($field['suffix'])) <div class="input-group"> @endif
        @if(isset($field['prefix'])) <div class="input-group-addon">{!! $field['prefix'] !!}</div> @endif
       {{--  <input
            type="checkbox"
            name="{{ $field['name'] }}"
            value="{{ old(square_brackets_to_dots($field['name'])) ?? $field['value'] ?? $field['default'] ?? '' }}"
            @include('crud::inc.field_attributes')
        > --}}
        <div class="checkbox">
            <label for="teacher">
                <input type="checkbox" name="blast_type[]" id="teacher" value="teacher">
                Teacher&nbsp;&nbsp;
            </label> 
    
            <label for="student">
                <input type="checkbox" name="blast_type[]" id="student" value="student">
                Student&nbsp;&nbsp;
            </label> 

            <label for="employee">
                <input type="checkbox" name="blast_type[]" id="employee" value="employee">
                Employee&nbsp;&nbsp;
            </label> 
        </div>

        @if(isset($field['suffix'])) <div class="input-group-addon">{!! $field['suffix'] !!}</div> @endif
    @if(isset($field['prefix']) || isset($field['suffix'])) </div> @endif

    {{-- HINT --}}
    @if (isset($field['hint']))
        <p class="help-block">{!! $field['hint'] !!}</p>
    @endif
</div>


{{-- FIELD EXTRA CSS  --}}
{{-- push things in the after_styles section --}}

    {{-- @push('crud_fields_styles')
        <!-- no styles -->
    @endpush --}}


{{-- FIELD EXTRA JS --}}
{{-- push things in the after_scripts section --}}

    {{-- @push('crud_fields_scripts')
        <!-- no scripts -->
    @endpush --}}


{{-- Note: you can use @if ($crud->checkIfFieldIsFirstOfItsType($field, $fields)) to only load some CSS/JS once, even though there are multiple instances of it --}}
