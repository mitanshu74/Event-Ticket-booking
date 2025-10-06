<?php

namespace App\Domain\Util\Datatables;

use Yajra\Datatables\Html\Builder;
use Illuminate\Support\Facades\Auth;

abstract class BaseDatatableScope
{
    /**
     * @var
     */
    protected $partialHtml;

    /**
     * @return mixed
     */
    abstract public function query();

    /**
     * @param null $url
     *
     * @return array
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
            $this->partialHtml
        );

        // Check admin role == 2 then not show 
        $admin = Auth::guard('admin')->user();
        if ($admin->role != 2) {
            $columns[] = [
                'data' => 'action',
                'name' => 'action',
                'title' => 'Action',
                'searchable' => false,
                'orderable' => false,
            ];
        }

        $builder = app('datatables.html');
        return $builder->columns($columns)->parameters([
            'order' => [0, 'desc'],
        ])->ajax($url ?: request()->fullUrl());
    }


    /**
     * @param array $html
     *
     * @return $this
     */
    public function setHtml(array $html)
    {
        $this->partialHtml = $html;

        return $this;
    }
}
