<?php

namespace App\DataTables\Masters;

use App\Models\Menu;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class MenuDataTable extends DataTable
{
    protected $type;

    public function __construct($type)
    {
        $this->type = $type;
    }
    /**
     * Build the DataTable class.
     *
     * @param QueryBuilder $query Results from query() method.
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->addIndexColumn()
            ->addColumn('action', function ($menu) {
                $count_parent = Menu::where('parent_id', null)->count();
                $count_child = Menu::where('parent_id', $menu->parent_id)->count();
                return view('components.interface.action', [
                    'name' => 'menu-' . $this->type,
                    'column' => 'name',
                    'update' => [
                        'routeEdit' => route('menus.' . $this->type . '.edit', $menu->id),
                        'routeUpdate' => route('menus.' . $this->type . '.update', $menu->id),
                    ],
                    'delete' => [
                        'routeDelete' => route('menus.' . $this->type . '.destroy', $menu->id),
                        'name' => $menu->name,
                    ],
                    'menu' => [
                        'order' => $menu->order,
                        'routeOrder' => route('menus.' . $this->type . '.order', $menu->id),
                        'is_parent' => $menu->parent_id ? false : true,
                        'count_parent' => $count_parent,
                        'count_child' => $count_child,
                    ]
                ]);
            })
            ->editColumn('icon', function ($menu) {
                return "<i class='$menu->icon'></i>";
            })
            ->editColumn('parent_id', function ($menu) {
                return $menu->parent_id ? $menu->parent->name : '';
            })
            ->rawColumns(['icon'])
            ->setRowId('id');
    }

    /**
     * Get the query source of dataTable.
     */
    public function query(Menu $model): QueryBuilder
    {
        $menus = $model->newQuery()->where('type', $this->type)->orderBy('order')->get();
        if ($menus->isEmpty()) {
            return $model->newQuery()->whereNull('id');
        }
        $structuredMenus = $this->buildMenuHierarchy($menus);
        return $model->newQuery()
            ->whereIn('id', $structuredMenus->pluck('id')->all())
            ->orderByRaw($this->generateOrderByCaseStatement($structuredMenus));
    }

    private function buildMenuHierarchy($menus, $parentId = null)
    {
        $result = collect();
        foreach ($menus as $menu) {
            if ($menu->parent_id == $parentId) {
                $result->push($menu);
                $result = $result->merge($this->buildMenuHierarchy($menus, $menu->id));
            }
        }
        return $result;
    }


    private function generateOrderByCaseStatement($menus)
    {
        $caseStatements = [];
        foreach ($menus as $index => $menu) {
            $caseStatements[] = "WHEN id = {$menu->id} THEN {$index}";
        }
        return 'CASE ' . implode(' ', $caseStatements) . ' END';
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
            ->setTableId('menu-table')
            ->minifiedAjax(script: "
                        data._token = '" . csrf_token() . "';
                        data._p = 'POST';
                    ")
            ->drawCallbackWithLivewire(file_get_contents(public_path('assets/js/helpers/drawCallback.js')))
            ->columns($this->getColumns())
            ->responsive(true)
            ->autoWidth(false)
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
            Column::make('order')
                ->title('Order')
                ->addClass('text-center')
                ->orderable(false)
                ->searchable(false),
            Column::make('title')
                ->title('Title')
                ->orderable(false),
            Column::make('parent_id')
                ->title('Parent')
                ->orderable(false)
                ->searchable(false),
            Column::make('icon')
                ->title('Icon')
                ->addClass('text-center')
                ->orderable(false)
                ->searchable(false),
            Column::make('name')
                ->title('Name')
                ->addClass('w-100'),
        ];
    }

    /**
     * Get the filename for export.
     */
    protected function filename(): string
    {
        return 'Menu_' . date('YmdHis');
    }
}
