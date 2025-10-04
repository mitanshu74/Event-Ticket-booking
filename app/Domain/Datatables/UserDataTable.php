<?php

namespace App\Domain\Datatables;

use App\Domain\Util\Datatables\BaseDatatableScope;
use Yajra\DataTables\Facades\DataTables;

use App\Models\User;

class UserDataTable extends BaseDatatableScope
{
    public function __construct()
    {
        $this->setHtml([
            [
                'data' => 'username',
                'name' => 'username',
                'title' => 'Username',
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
            [
                'data' => 'number',
                'name' => 'number',
                'title' => 'Number',
                'searchable' => true,
                'orderable' => true,
            ],
            [
                'data' => 'address',
                'name' => 'address',
                'title' => 'Address',
                'searchable' => true,
                'orderable' => true,
            ],
            [
                'data' => 'gender',
                'name' => 'gender',
                'title' => 'Gender',
                'searchable' => true,
                'orderable' => true,
            ],
            [
                'data' => 'image',
                'name' => 'image',
                'title' => 'Image',
                'searchable' => false,
                'orderable' => false,
            ],

        ]);
    }

    public function query()
    {
        $query = User::query();
        return DataTables::of($query)
            ->addIndexColumn()
            ->addColumn('action', function ($row) {
                $btn = '<div style="display:flex; gap:5px;">';

                $deleteUrl = route('admin.DeleteUser', $row->id);
                $btn .= '<form action="' . $deleteUrl . '" method="POST" style="display:inline;" class="delete-form">
                ' . csrf_field() . method_field('DELETE') . '
                <button type="submit" class="btn btn-danger btn-sm" style="margin:5px;">
                    <i class="fa fa-trash-o" style="font-size:20px;color:white;"></i>
                </button>
            </form>';

                return $btn;
            })
            ->editColumn('image', function ($users) {
                return $users->image
                    ? '<img src="' . asset('storage/' . $users->image) . '" style="width:80px; height:80px; object-fit:cover;">'
                    : 'No Image';
            })

            ->rawColumns(['image', 'action'])
            ->make(true);
    }
}
