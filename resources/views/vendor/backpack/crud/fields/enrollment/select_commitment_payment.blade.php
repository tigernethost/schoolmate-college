<!-- select -->
@php
	$current_value = old(square_brackets_to_dots($field['name'])) ?? $field['value'] ?? $field['default'] ?? '';
    $entity_model = $crud->getRelationModel($field['entity'],  - 1);

    if (!isset($field['options'])) {
        $options = $field['model']::all();
    } else {
        $options = call_user_func($field['options'], $field['model']::query());
    }
@endphp
<style>
    #disabled {
        cursor: not-allowed;
        opacity: 0.65; 
    }
</style>
<div @include('crud::inc.field_wrapper_attributes') >

    <label>{!! $field['label'] !!}</label>
    @include('crud::inc.field_translatable_icon')
 

    <select
        name="{{ $field['name'] }}"
        @include('crud::inc.field_attributes')
        @if($crud->getActionMethod() === "edit")
            {{ $current_value !== '' ? 'disabled' : '' }}
        @endif
        >

        @if ($entity_model::isColumnNullable($field['name']))
            <option value="">-</option>
        @endif
        
        @if (count($options))
            @foreach ($options as $connected_entity_entry)
                @if($current_value == $connected_entity_entry->getKey())
                    <option value="{{ $connected_entity_entry->getKey() }}" selected>{{ $connected_entity_entry->{$field['attribute']} }}</option>
                @else
                    <option value="{{ $connected_entity_entry->getKey() }}">{{ $connected_entity_entry->{$field['attribute']} }}</option>
                @endif
            @endforeach
        @endif
    </select>

    @if($current_value !== '')
        <input type="hidden" name="{{ $field['name'] }}" value="{{ $current_value }}">
    @else
        
    @endif

    {{-- HINT --}}
    @if (isset($field['hint']))
        <p class="help-block">{!! $field['hint'] !!}</p>
    @endif

</div>