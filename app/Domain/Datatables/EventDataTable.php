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
                'data' => 'start_time',
                'name' => 'start_time',
                'title' => 'Time',
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

                $editUrl = route('admin.EditEvent', $row->id);

                $btn .= '<a href="' . $editUrl . '" class="btn btn-warning btn-sm" style="height:31px;position:relative;top:5px">
                        <i class="fa fa-edit" style="font-size:20px;color:white"></i>
                    </a>';

                $deleteUrl = route('admin.DeleteEvent', $row->id);
                $btn .= '<form action="' . $deleteUrl . '" method="POST" style="display:inline;" class="delete-form">
                ' . csrf_field() . '
                        <button type="submit" class="btn btn-danger btn-sm" style="margin:5px;">
                            <i class="fa fa-trash-o" style="font-size:20px;color:white;"></i>
                        </button>
                    </form>';
                $btn .= '</div>';
                return $btn;
            })->editColumn('start_time', function ($event) {
                $start = $event->start_time ? $event->start_time->format('h:i A') : '';
                $end = $event->end_time ? $event->end_time->format('h:i A') : '';
                return $start && $end ? "$start - $end" : "";
            })
            ->editColumn('image', function ($event) {
                if (!$event->image) {
                    return 'No Image';
                }

                $images = json_decode($event->image, true);
                $firstImage = $images[0]; 

                $html = '<a href="' . asset('storage/' . $firstImage) . '" data-lightbox="event-' . $event->id . '" data-title="' . $event->name . '">';
                $html .= '<img src="' . asset('storage/' . $firstImage) . '" style="width:80px;height:80px;object-fit:cover;margin:2px;">';
                $html .= '</a>';

                foreach ($images as $key => $img) {
                    if ($key == 0) continue; 
                    $html .= '<a href="' . asset('storage/' . $img) . '" data-lightbox="event-' . $event->id . '" data-title="' . $event->name . '" style="display:none;"></a>';
                }

                return $html;
            })

            ->editColumn('date', function ($event) {
                return $event->date ? $event->date->format('d-m-Y') : '';
            })
            ->rawColumns(['image', 'action'])
            ->make(true);
    }
}
