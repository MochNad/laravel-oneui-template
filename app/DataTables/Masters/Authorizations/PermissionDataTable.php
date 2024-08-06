<?php

namespace App\DataTables\Masters\Authorizations;

use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Spatie\Permission\Models\Permission;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class PermissionDataTable extends DataTable
{
    /**
     * Build the DataTable class.
     *
     * @param QueryBuilder $query Results from query() method.
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->addIndexColumn()
            ->addColumn('action', function ($permission) {
                return view('components.interface.action', [
                    'name' => 'permission',
                    'column' => 'name',
                    'update' => [
                        'routeEdit' => route('authorizations.permission.edit', $permission->id),
                        'routeUpdate' => route('authorizations.permission.update', $permission->id),
                    ],
                    'delete' => [
                        'routeDelete' => route('authorizations.permission.destroy', $permission->id),
                        'name' => $permission->name,
                    ]
                ]);
            })
            ->editColumn('create', function ($permission) {
                return getIconTrueFalse(Permission::where('name', $permission->name . '-create')->exists());
            })
            ->editColumn('read', function ($permission) {
                return getIconTrueFalse(Permission::where('name', $permission->name . '-read')->exists());
            })
            ->editColumn('update', function ($permission) {
                return getIconTrueFalse(Permission::where('name', $permission->name . '-update')->exists());
            })
            ->editColumn('delete', function ($permission) {
                return getIconTrueFalse(Permission::where('name', $permission->name . '-delete')->exists());
            })
            ->rawColumns(['action', 'create', 'read', 'update', 'delete'])
            ->setRowId('id');
    }

    /**
     * Get the query source of dataTable.
     */
    public function query(Permission $model): QueryBuilder
    {
        return $model->newQuery()
            ->select('id', 'name', 'guard_name')
            ->where(function ($query) {
                $query->where('name', 'not like', '%-create')
                    ->where('name', 'not like', '%-read')
                    ->where('name', 'not like', '%-update')
                    ->where('name', 'not like', '%-delete');
            });
    }


    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
            ->setTableId('permission-table')
            ->minifiedAjax(script: "
                        data._token = '" . csrf_token() . "';
                        data._p = 'POST';
                    ")
            ->drawCallbackWithLivewire(file_get_contents(public_path('assets/js/helpers/drawCallback.js')))
            ->columns($this->getColumns())
            ->responsive(true)
            ->autoWidth(false)
            ->orderBy(2, 'asc')
            ->buttons([]);
    }

    /**
     * Get the dataTable columns definition.
     */
    public function getColumns(): array
    {
        return [
            Column::computed('DT_RowIndex')
                ->title('No')
                ->addClass('text-center')
                ->orderable(false)
                ->searchable(false),
            Column::computed('action')
                ->title('Action')
                ->addClass('text-center')
                ->orderable(false)
                ->searchable(false),
            Column::make('name')
                ->title('Name')
                ->addClass('w-100'),
            Column::make('create')
                ->title('Create')
                ->addClass('text-center')
                ->orderable(false)
                ->searchable(false),
            Column::make('read')
                ->title('Read')
                ->addClass('text-center')
                ->orderable(false)
                ->searchable(false),
            Column::make('update')
                ->title('Update')
                ->addClass('text-center')
                ->orderable(false)
                ->searchable(false),
            Column::make('delete')
                ->title('Delete')
                ->addClass('text-center')
                ->orderable(false)
                ->searchable(false),
            Column::make('guard_name')
                ->title('Guard Name'),
        ];
    }

    /**
     * Get the filename for export.
     */
    protected function filename(): string
    {
        return 'Permission_' . date('YmdHis');
    }
}
