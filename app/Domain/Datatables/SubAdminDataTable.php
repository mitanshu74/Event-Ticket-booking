<?php

namespace App\Domain\Datatables;

use App\Domain\Util\Datatables\BaseDatatableScope;
use Yajra\DataTables\Facades\DataTables;
use App\Models\Admin;

class SubAdminDataTable extends BaseDatatableScope
{
    public function __construct()
    {
        $this->setHtml([
            [
                'data' => 'name',
                'name' => 'name',
                'title' => 'Name',
                'searchable' => true,
                'orderable' => true,
            ],
            [
                'data' => 'email',
                'name' => 'email',
                'title' => 'Email',
                'searchable' => true,
                'orderable' => true,
            ],

        ]);
    }

    public function query()
    {
        $query = Admin::where('role', 2);

        return DataTables::of($query)
            ->addIndexColumn()
            ->addColumn('action', function ($model) {
                return view('admin.shared.dtcontrols-without-ajax')
                    ->with('id', $model->getKey())
                    ->with('model', $model)
                    ->with('editUrl', route('subadmin.edit', $model->getKey()))
                    ->with('deleteUrl', route('subadmin.destroy', $model->getKey()))
                    ->render();
            })
            ->rawColumns(['action'])
            ->make(true);
    }
}
