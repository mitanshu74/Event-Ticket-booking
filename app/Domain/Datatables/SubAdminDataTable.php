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
            ->addColumn('action', function ($row) {
                $btn = '<div style="display:flex; gap:5px;">';

                $editUrl = route('subadmin.edit', $row->id);

                $btn .= '<a href="' . $editUrl . '" class="btn btn-warning btn-sm" style="height:31px;position:relative;top:5px">
                        <i class="fa fa-edit" style="font-size:20px;color:white;height:30px;"></i>
                    </a>';

                $deleteUrl = route('subadmin.destroy', $row->id);
                $btn .= '<form action="' . $deleteUrl . '" method="POST" style="display:inline;" class="delete-form">
            ' . csrf_field() . '
            <button type="submit" class="btn btn-danger btn-sm" style="margin:5px;">
                <i class="fa fa-trash-o" style="font-size:20px;color:white;"></i>
            </button>
        </form>';
                $btn .= '</div>';

                return $btn;
            })
            ->rawColumns(['action'])
            ->make(true);
    }
}
