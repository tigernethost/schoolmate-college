<?php

namespace App\Http\Controllers\Admin;

use Backpack\CRUD\app\Http\Controllers\CrudController;

// VALIDATION: change the requests to match your own file names if you need form validation
use App\Http\Requests\InventoryDailyReportRequest as StoreRequest;
use App\Http\Requests\InventoryDailyReportRequest as UpdateRequest;
use Backpack\CRUD\CrudPanel;
use Carbon\Carbon;
/**
 * Class InventoryDailyReportCrudController
 * @package App\Http\Controllers\Admin
 * @property-read CrudPanel $crud
 */
class InventoryDailyReportCrudController extends CrudController
{
    public function setup()
    {
        /*
        |--------------------------------------------------------------------------
        | CrudPanel Basic Information
        |--------------------------------------------------------------------------
        */
        $this->crud->setModel('App\Models\InventoryDailyReport');
        $this->crud->setRoute(config('backpack.base.route_prefix') . '/daily-report');
        $this->crud->setEntityNameStrings('inventorydailyreport', 'Daily Reports');

        /*
        |--------------------------------------------------------------------------
        | CrudPanel Configuration
        |--------------------------------------------------------------------------
        */

        // TODO: remove setFromDb() and manually define Fields and Columns
        $this->crud->setFromDb();

        // add asterisk for fields that are required in InventoryDailyReportRequest
        $this->crud->setRequiredFields(StoreRequest::class, 'create');
        $this->crud->setRequiredFields(UpdateRequest::class, 'edit');

        // GET ALL REPORTS TODAY
        $this->data['reports'] = $this->crud->model->whereDate('created_at', Carbon::today())->get();
        // dd($this->data['reports']);

        // SET LIST VIEW
        $this->crud->setListView('itemInventory.daily-report');
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

    public function destroy ($id)
    {
        $model = $this->crud->model::findOrFail($id);
        $model->delete();
    }
}
