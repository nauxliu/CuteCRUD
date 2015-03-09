<?php namespace App\Http\Controllers;

use App\Http\FormComponents\ValidationFailException;
use App\Models\Table;
use App\Models\TableRow;
use App\Utils;
use Laracasts\Flash\Flash;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Schema;

class SettingsController extends Controller
{
    /**
     * Show Setting Page
     *
     * @Get("table/{table_name}/settings", as="setting.show")
     */
    public function settings($table)
    {
        $type_options = [
            'text'      =>  'Text',
            'password'  =>  'Password',
            'number'    =>  'Number',
            'radio'     =>  'Radio',
            'checkbox'  =>  'Checkbox',
            'select'    =>  'Select',
            'range'     =>  'Range',
            'content_editor'  =>  'Content Editor',
            'belongs_to'=>  'Belongs To',
        ];

        if (!Schema::hasTable($table)) {
            Flash::error('Specified table not found.');
            return view('tables.settings');
        }

        $columns_count = count(Schema::getColumnListing($table));

        if ( $columns_count != TableRow::where('table_name', $table)->count()) {
            Table::where('table_name', $table)->first()->initialRows();
        }

        $columns = TableRow::where('table_name', $table)->get();

        return view('tables.settings', compact('columns', 'table', 'type_options'));
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
            try{
                $row->updateRow($row_data);
            }catch (ValidationFailException $e){
                Flash::error(Utils::buildMessages($e->getValidator()->errors()->all()));
                return redirect()->back();
            }
        }

        Flash::success('Table metadata has been updated.');

        return redirect()->route('setting.show', $table);
    }

}
