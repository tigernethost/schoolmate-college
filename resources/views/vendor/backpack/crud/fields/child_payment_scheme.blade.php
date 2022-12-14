<!-- array input -->
<?php
    $max = isset($field['max']) && (int) $field['max'] > 0 ? $field['max'] : -1;
    $min = isset($field['min']) && (int) $field['min'] > 0 ? $field['min'] : -1;
    $item_name = strtolower(isset($field['entity_singular']) && !empty($field['entity_singular']) ? $field['entity_singular'] : $field['label']);

    $items = old($field['name']) ? (old($field['name'])) : (isset($field['value']) ? ($field['value']) : (isset($field['default']) ? ($field['default']) : '' ));

    if($crud->getActionMethod() === 'edit') {
        foreach ($items as $key => $value) {
            if(isset($value->scheme_date)) {
                $items[$key]->scheme_date = Carbon\Carbon::parse($value->scheme_date)->toDateString();
            }
        }

    }

    // make sure not matter the attribute casting
    // the $items variable contains a properly defined JSON
    if (is_array($items)) {
        if (count($items)) {
            $items = json_encode($items);
        } else {
            $items = '[]';
        }
    } elseif (is_string($items) && !is_array(json_decode($items))) {
        $items = '[]';
    }

?>
<div 
    ng-app="backPackTableApp" 
    ng-controller="PaymentSchemeController" 
    @include('crud::inc.field_wrapper_attributes') 
    >

    <label style="display: block;">{!! $field['label'] !!}</label>
    @include('crud::inc.field_translatable_icon')

    <input class="array-json" type="hidden" id="{{ $field['name'] }}" name="{{ $field['name'] }}">

    <div class="array-container form-group">

        <table 
            class="table table-bordered table-striped m-b-0" 
            ng-init="field = '#{{ $field['name'] }}'; items = {{ $items }}; max = {{$max}}; min = {{$min}}; maxErrorTitle = '{{trans('backpack::crud.table_cant_add', ['entity' => $item_name])}}'; maxErrorMessage = '{{trans('backpack::crud.table_max_reached', ['max' => $max])}}'"
            >

            <thead>
                <tr>
                    @foreach( $field['columns'] as $column )
                    <th style="font-weight: 600!important;">
                        {{ $column['label'] }}
                    </th>
                    @endforeach
                    <th class="text-center" ng-if="max == -1 || max > 1"> {{-- <i class="fa fa-sort"></i> --}} </th>
                    <th class="text-center" ng-if="max == -1 || max > 1"> {{-- <i class="fa fa-trash"></i> --}} </th>
                </tr>
            </thead>

            <tbody ui-sortable="sortableOptions" ng-model="items" class="table-striped">

                <tr post-render ng-repeat="item in items" class="array-row" id="tr-render" >
                    
                    @foreach ($field['columns'] as $column)
                        <td 
                             class="
                                @if(isset($column['size']))  
                                    col-md-{{ $column['size'] }}
                                @endif
                                "
                            >
                        <!-- load the view from the application if it exists, otherwise load the one in the package -->
                        @if(view()->exists('vendor.backpack.crud.fields.'.$column['type']))
                            @include('vendor.backpack.crud.fields.'.$column['type'], array('field' => $column))
                        @else
                            @include('crud::fields.'.$column['type'], array('field' => $column))
                        @endif
                        </td>
                    @endforeach

                    <td ng-if="max == -1 || max > 1">
                        <span class="btn btn-sm btn-default sort-handle"><span class="sr-only">sort item</span><i class="fa fa-sort" role="presentation" aria-hidden="true"></i></span>
                    </td>
                    <td ng-if="max == -1 || max > 1">
                        <button ng-hide="min > -1 && $index < min" class="btn btn-sm btn-default" type="button" ng-click="removeItem(item);"><span class="sr-only">delete item</span><i class="fa fa-trash" role="presentation" aria-hidden="true"></i></button>
                    </td>
                </tr>

                <tr>
                    <td></td>
                    @foreach (App\Models\CommitmentPayment::active()->get() as $cPayment)
                        <td>
                            <div class="form-group col-xs-12" style="margin-bottom: 0;">
                                <h4><b><% total_{{ $cPayment->snake }} | number %></b></h4>
                            </div>
                        </td>
                    @endforeach
                    <td colspan="2"></td>
                </tr>

            </tbody>

        </table>

        <div class="array-controls btn-group m-t-10">
            <button ng-if="max == -1 || items.length < max" class="btn btn-sm btn-default" type="button" ng-click="addItem()"><i class="fa fa-plus"></i> Add {{ $item_name }}</button>
        </div>

    </div>

    {{-- HINT --}}
    @if (isset($field['hint']))
        <p class="help-block">{!! $field['hint'] !!}</p>
    @endif
</div>

{{-- ########################################## --}}
{{-- Extra CSS and JS for this particular field --}}
{{-- If a field type is shown multiple times on a form, the CSS and JS will only be loaded once --}}
@if ($crud->checkIfFieldIsFirstOfItsType($field, $fields))

    {{-- FIELD CSS - will be loaded in the after_styles section --}}
    @push('crud_fields_styles')
    {{-- @push('crud_fields_styles')
        {{- YOUR CSS HERE --}}
        <link href="{{ asset('vendor/backpack/select2/select2.css') }}" rel="stylesheet" type="text/css" />
        <link href="{{ asset('vendor/backpack/select2/select2-bootstrap-dick.css') }}" rel="stylesheet" type="text/css" />
    @endpush

    {{-- FIELD JS - will be loaded in the after_scripts section --}}
    @push('crud_fields_scripts')
        {{-- YOUR JS HERE --}}
        <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/angular.js/1.5.8/angular.min.js"></script>
        <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
        <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/angular-ui-sortable/0.14.3/sortable.min.js"></script>

        <script>

            window.angularApp = window.angularApp || angular.module('backPackTableApp', ['ui.sortable'], function($interpolateProvider){
                $interpolateProvider.startSymbol('<%');
                $interpolateProvider.endSymbol('%>');
            });


            window.angularApp.controller('PaymentSchemeController', function($scope){

                $scope.sortableOptions = {
                    handle: '.sort-handle'
                };

                @php
                    $cPayments = App\Models\CommitmentPayment::active()->get();
                @endphp

                var cPayments = {!! $cPayments !!}

                $scope.addItem = function() {
                    if( $scope.max > -1 ) {
                        if( $scope.items.length < $scope.max ) {
                            var item = {
                                "scheme_date":"",
                                "monthly_amount":0,
                                "semi_amount":0,
                                "quarterly_amount":0
                            };
                            $scope.items.push(item);
                        } else {
                            new PNotify({
                                title: $scope.maxErrorTitle,
                                text: $scope.maxErrorMessage,
                                type: 'error'
                            });
                        }
                    }
                    else {
                        var item = {
                            "scheme_date":"",
                            "monthly_amount":0,
                            "semi_amount":0,
                            "quarterly_amount":0
                        };
                        $scope.items.push(item);
                    }   

                    @if($crud->getActionMethod() == 'edit')
                        setTimeout(function () {
                            $('input[ng-model="item.scheme_date"]').attr('type', 'date');
                        }, 100);
                    @endif

                }

                $scope.removeItem = function(item){
                    var index = $scope.items.indexOf(item);
                    $scope.items.splice(index, 1);

                    if($scope.items.length == 0)
                    {
                        $scope.items = [];
                        $('input[name="{{ $field['name'] }}"]').val('[]');
                    }
                }
                var breakLoop    = false; 
                $scope.$watch('items', function(a, b) {
                    // CHECK IF CREATE ACTION METHOD. IF IT IS. THEN, GENERATE MONTHS ACCORDING TO THE YEAR LEVEL OF START DATE  AND END DATE
                    var actionMethod = "{{ $crud->getActionMethod() }}";
                    
                    if(!breakLoop && actionMethod == "create") {
                        var initial_months = {!! json_encode($initial_months) !!};
                        var items = [];
                        for(var i = 0; i < initial_months.length; i++)
                        {
                            var obj = {};
                            // obj.scheme_date = initial_months[i];
                            $.each(cPayments, function (key, val) {
                                obj[val.snake + '_amount'] = 0;
                            });
                            items.push(obj);
                        }
                        $scope.items = items;
                        breakLoop = true;
                    }

                    if( $scope.min > -1 ){
                        while($scope.items.length < $scope.min){
                            $scope.addItem();
                        }
                    }

                    if( typeof $scope.items != 'undefined' && $scope.items.length ) {

                        $.each(cPayments, function (key, val) {
                            $scope['total_' + val.snake] = 0;
                        });

                        $scope.grand_total_payment  = 0;

                        angular.forEach($scope.items, function (val, key) {
                            $.each(cPayments, function (cKey, cVal) {
                                if(val[ cVal.snake + '_amount'] === undefined) { $scope.items[key][cVal.snake + '_amount'] = 0; }
                                $scope['total_' + cVal.snake] += parseFloat(val[ cVal.snake + '_amount']);
                            });

                        });

                        $.each(cPayments, function (cKey, cVal) {
                            $scope['total_' + cVal.snake] = $scope['total_' + cVal.snake].toFixed(2);
                        });

                        if( typeof $scope.field != 'undefined'){
                            if( typeof $scope.field == 'string' ){
                                $scope.field = $($scope.field);
                            }
                            $scope.field.val( angular.toJson($scope.items) );
                        }
                    }
                    
                }, true);

                if( $scope.min > -1 ){
                    for(var i = 0; i < $scope.min; i++){
                        $scope.addItem();
                    }
                }
            });
            window.angularApp.directive('postRender', function($timeout) {
                return {
                   link: function(scope, element, attr) {
                      $timeout(function() {
                         $('.select2').each(function (i, obj) {
                                if (!$(obj).data("select2"))
                                {
                                    $(obj).select2();
                                }
                            });
                      });
                   }
                }
            });
        
            angular.element(document).ready(function(){
                angular.forEach(angular.element('[ng-app]'), function(ctrl){
                    var ctrlDom = angular.element(ctrl);
                    if( !ctrlDom.hasClass('ng-scope') ){
                        angular.bootstrap(ctrl, [ctrlDom.attr('ng-app')]);
                    }
                });
            });

        </script>

    @endpush
@endif
{{-- End of Extra CSS and JS --}}
{{-- ########################################## --}}