<?php

namespace App\DataTables\Managements;

use App\Models\User;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class UserDataTable extends DataTable
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
            ->addColumn('action', function ($user) {
                return view('components.interface.action', [
                    'name' => 'user',
                    'column' => 'name',
                    'update' => [
                        'routeEdit' => route('user.edit', $user->id),
                        'routeUpdate' => route('user.update', $user->id),
                    ],
                    'delete' => [
                        'routeDelete' => route('user.destroy', $user->id),
                        'name' => $user->name,
                    ],
                    'user' =>[
                        'routeReset' => route('user.reset', $user->id),
                        'routeImpersonate' => route('user.impersonate', $user->id),
                    ]
                ]);
            })
            ->editColumn('role', function ($user) {
                return $user->getRoleNames()->first();
            })
            ->setRowId('id');
    }

    /**
     * Get the query source of dataTable.
     */
    public function query(User $model): QueryBuilder
    {
        return $model->newQuery();
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
            ->setTableId('user-table')
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
                ->addClass('w-50'),
            Column::make('email')
                ->title('Email')
                ->addClass('w-50')
                ->orderable(false)
                ->searchable(false),
            Column::make('role')
                ->title('Role')
                ->orderable(false)
                ->searchable(false),
        ];
    }

    /**
     * Get the filename for export.
     */
    protected function filename(): string
    {
        return 'User_' . date('YmdHis');
    }
}
