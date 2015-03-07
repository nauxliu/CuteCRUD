<?php namespace App\Http\Controllers;

use App\Http\FormComponents\Manager;
use App\Models\Table;
use App\Models\TableRow;
use \Input;
use \Session;
use \Schema;

class SettingsController extends Controller
{
    /**
     * Show Setting Page
     *
     * @Get("table/{table_name}/settings", as="setting.show")
     */
    public function settings($table)
    {
        if (!Schema::hasTable($table)) {
            Session::flash('error_msg', 'Specified table not found');
            return view('tables.settings');
        }

        $columns_count = count(Schema::getColumnListing($table));

        if ( $columns_count != TableRow::where('table_name', $table)->count()) {
            Table::where('table_name', $table)->first()->initialRows();
        }

        $columns = TableRow::where('table_name', $table)->get();

        foreach ($columns as $column) {
            switch($column->type){
                case 'radio':
                    $column->radios = $column->pairs()->get();
                    break;
                case 'checkbox':
                    $column->checkboxes = $column->pairs()->get();
                    break;
                case 'range':
                    $range = $column->pairs()->get();
                    $column->range_from = $range->key;
                    $column->range_to = $range->value;
                    break;
                case 'select':
                    $column->selects = $column->pairs()->get();
                    break;
            }
        }

        return view('tables.settings', compact('columns', 'table'));
    }

    /**
     * Update Settings
     *
     * @Post("table/{table_name}/settings", as="setting.update")
     */
    public function postSettings($table)
    {
        $columns = Input::get('columns');

        foreach ($columns as $column) {
            $row = TableRow::where('column_name', $column)->where('table_name', $table)->first();

            $row_data = Input::get($column);
            $row->updateRow($row_data);
        }

        Session::flash('success_msg', 'Table metadata has been updated');

        return redirect()->route('table.show',$table);
    }

}
