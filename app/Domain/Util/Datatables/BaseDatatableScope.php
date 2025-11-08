<?php

namespace App\Domain\Util\Datatables;

use Yajra\Datatables\Html\Builder;
use Illuminate\Support\Facades\Auth;

abstract class BaseDatatableScope
{
    /**
     * @var array
     */
    protected $partialHtml;

    /**
     * Each Datatable must define its own query
     */
    abstract public function query();

    /**
     * Build datatable columns
     *
     * @param string|null $url
     * @return \Yajra\DataTables\Html\Builder
     */
    public function html($url = null)
    {
        $columns = array_merge(
            [
                [
                    'data' => 'DT_RowIndex',
                    'name' => 'DT_RowIndex',
                    'title' => 'No',
                    'orderable' => false,
                    'searchable' => false,
                ],
            ],
            $this->partialHtml ?? []
        );

        $admin = Auth::guard('admin')->user();

        if ($admin->role == 1) {
           
            $columns[] = [
                'data' => 'action',
                'name' => 'action',
                'title' => 'Action',
                'searchable' => false,
                'orderable' => false,
            ];
           
        }

        /** @var Builder $builder */
        $builder = app('datatables.html');

        return $builder->columns($columns)->parameters([
            'order' => [0, 'desc'],
        ])->ajax($url ?: request()->fullUrl());
    }

    /**
     * Set partial HTML columns
     *
     * @param array $html
     * @return $this
     */
    public function setHtml(array $html)
    {
        $this->partialHtml = $html;
        return $this;
    }
}
