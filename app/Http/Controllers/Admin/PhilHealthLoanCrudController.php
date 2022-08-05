<?php

namespace App\Http\Controllers\Admin;

use Backpack\CRUD\app\Http\Controllers\CrudController;

// VALIDATION: change the requests to match your own file names if you need form validation
use App\Http\Requests\PhilHealthLoanRequest as StoreRequest;
use App\Http\Requests\PhilHealthLoanRequest as UpdateRequest;
use Backpack\CRUD\CrudPanel;

/**
 * Class PhilHealthLoanCrudController
 * @package App\Http\Controllers\Admin
 * @property-read CrudPanel $crud
 */
class PhilHealthLoanCrudController extends CrudController
{
    public function setup()
    {
        /*
        |--------------------------------------------------------------------------
        | CrudPanel Basic Information
        |--------------------------------------------------------------------------
        */
        $this->crud->setModel('App\Models\PhilHealthLoan');
        $this->crud->setRoute(config('backpack.base.route_prefix') . '/philhealth-loan');
        $this->crud->setEntityNameStrings('PhilHealth Loan', 'PhilHealth Loans');

        /*
        |--------------------------------------------------------------------------
        | CrudPanel Configuration
        |--------------------------------------------------------------------------
        */

        // TODO: remove setFromDb() and manually define Fields and Columns
        $this->crud->setFromDb();

        // add asterisk for fields that are required in PhilHealthLoanRequest
        $this->crud->setRequiredFields(StoreRequest::class, 'create');
        $this->crud->setRequiredFields(UpdateRequest::class, 'edit');


        $this->crud->addColumn([
            'label' => 'Employee',
            'type'  => 'select',
            'name'  => 'employee_id',
            'entity' => 'employee',
            'attribute' => 'full_name',
            'model' => 'App\Models\Employee'
        ]);

        // FIELDS
        $this->crud->addField([
            'label'         => 'Student Number',
            'name'          => 'employee_id',
            'type'          => 'hidden',
            'attributes'    => [ 'id' => 'studentNumber' ]
        ]);

        $this->crud->addField([
            'name' => 'searchEmployee',
            'type' => 'searchEmployee',
            'label' => '',
            'attributes' => [
                'id' => 'searchInput',
                'placeholder' => 'Search For Name or ID Number (ex. 1100224)',
            ],
        ])->beforeField('employee_id');

        $this->crud->addField([
            'label' => 'Amount',
            'type'  => 'text',
            'name'  => 'amount',
            'wrapperAttributes' => [
                'class' => 'form-group col-md-12'
            ]
        ]);

        $this->crud->addField([
            'label' => 'Start Date',
            'type'  => 'date',
            'name'  => 'start_date',
            'wrapperAttributes' => [
                'class' => 'form-group col-md-6'
            ]
        ]);

        $this->crud->addField([
            'label' => 'Expiry Date',
            'type'  => 'date',
            'name'  => 'expiry_date',
            'wrapperAttributes' => [
                'class' => 'form-group col-md-6'
            ]
        ]);

        $this->crud->addField([
            'label' => 'Description',
            'type'  => 'textarea',
            'name'  => 'description',
            'wrapperAttributes' => [
                'class' => 'form-group col-md-6'
            ]
        ]);
    }

    public function store(StoreRequest $request)
    {
        // your additional operations before save here
        $redirect_location = parent::storeCrud($request);
        // your additional operations after save here
        // use $this->data['entry'] or $this->crud->entry
        return $redirect_location;
    }

    public function update(UpdateRequest $request)
    {
        // your additional operations before save here
        $redirect_location = parent::updateCrud($request);
        // your additional operations after save here
        // use $this->data['entry'] or $this->crud->entry
        return $redirect_location;
    }
}