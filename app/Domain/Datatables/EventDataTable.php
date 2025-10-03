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
                'data' => 'price',
                'name' => 'price',
                'title' => 'Price',
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
                $btn = '<div style="display:flex; gap:5px;">';

                // Edit button
                $editUrl = route('admin.EditEvent', $row->id);

                $btn .= '<a href="' . $editUrl . '" class="btn btn-warning btn-sm" style="height:31px;position:relative;top:5px">
                        <i class="fa fa-edit" style="font-size:20px;color:white"></i>
                    </a>';

                // Delete button
                $deleteUrl = route('admin.DeleteEvent', $row->id);
                $btn .= '<form action="' . $deleteUrl . '" method="POST" style="display:inline;" class="delete-form">
                ' . csrf_field() . '
                        <button type="submit" class="btn btn-danger btn-sm" style="margin:5px;">
                            <i class="fa fa-trash-o" style="font-size:20px;color:white;"></i>
                        </button>
                    </form>';
                $btn .= '</div>';

                return $btn;
            })
            ->editColumn('image', function ($event) {
                return $event->image
                    ? '<img src="' . asset('storage/' . $event->image) . '" style="max-width:180px; min-height:60px; object-fit:cover;">'
                    : 'No Image';
            })
            ->editColumn('date', function ($event) {
                return $event->date ? $event->date->format('d-m-Y') : '';
            })
            ->rawColumns(['image', 'action'])
            ->make(true);
    }
}
