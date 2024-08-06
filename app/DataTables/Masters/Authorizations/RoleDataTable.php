<?php

namespace App\DataTables\Masters\Authorizations;

use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Spatie\Permission\Models\Role;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class RoleDataTable extends DataTable
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
            ->addColumn('action', function ($role) {
                return view('components.interface.action', [
                    'name' => 'role',
                    'column' => 'name',
                    'update' => [
                        'routeEdit' => route('authorizations.role.edit', $role->id),
                        'routeUpdate' => route('authorizations.role.update', $role->id),
                    ],
                    'delete' => [
                        'routeDelete' => route('authorizations.role.destroy', $role->id),
                        'name' => $role->name,
                    ],
                    'role' => [
                        'routeEdit' => route('authorizations.role.edit-permission', $role->id),
                        'routeUpdate' => route('authorizations.role.update-permission', $role->id),
                        'name' => $role->name,
                    ],
                ]);
            })
            ->setRowId('id');
    }

    /**
     * Get the query source of dataTable.
     */
    public function query(Role $model): QueryBuilder
    {
        return $model->newQuery();
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
            ->setTableId('role-table')
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
                ->addClass('w-100'),
            Column::make('guard_name')
                ->title('Guard Name'),
        ];
    }

    /**
     * Get the filename for export.
     */
    protected function filename(): string
    {
        return 'Role_' . date('YmdHis');
    }
}
