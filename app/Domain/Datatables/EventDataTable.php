<?php

namespace App\Domain\Datatables;

use App\Domain\Util\Datatables\BaseDatatableScope;
use Yajra\DataTables\Facades\DataTables;
use App\Models\Event;

class EventDataTable extends BaseDatatableScope
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
                'data' => 'date',
                'name' => 'date',
                'title' => 'Date',
                'searchable' => true,
                'orderable' => true,
            ],
            [
                'data' => 'location',
                'name' => 'location',
                'title' => 'Location',
                'searchable' => true,
                'orderable' => true,
            ],
            [
                'data' => 'total_tickets',
                'name' => 'total_tickets',
                'title' => 'Total Tickets',
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
        $query = Event::query();

        return DataTables::of($query)
            ->addIndexColumn()
            ->addColumn('action', function ($row) {
                return '<a href="#" class="btn btn-warning btn-sm">Edit</a>';
            })
            ->editColumn('image', function ($event) {
                return $event->image
                    ? '<img src="' . asset('storage/' . $event->image) . '" style="max-width:180px; min-height:60px; object-fit:cover;">'
                    : 'No Image';
            })
            ->rawColumns(['image', 'action'])
            ->make(true);
    }
}
