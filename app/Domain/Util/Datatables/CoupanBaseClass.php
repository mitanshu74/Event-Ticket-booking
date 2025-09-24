<?php

namespace App\Domain\Util\Datatables;

use Yajra\Datatables\Html\Builder;

abstract class CoupanBaseClass
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
         $columns = array_merge([
            [
                'data' => 'DT_RowIndex',
                'name' => 'DT_RowIndex',
                'title' =>'SR NO',
                'searchable' => false,
                'orderable' => false,
            ],
        ],
        $this->partialHtml,
        [
            [
                'data' => 'actions',
                'name' => 'actions',
                'title' => 'Action',
                'searchable' => false,
                'orderable' => false,
            ],
        ]);

        /**
         * @var Builder
         */
        $builder = app('datatables.html');

        return $builder->columns($columns)->parameters([
            'lengthMenu'
                    =>
                    [
                        50,100,200
                    ]
                ])
            ->ajax($url ?: request()->fullUrl());
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
