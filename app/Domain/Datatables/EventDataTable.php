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
            ->addColumn('action', function ($model) {
                return view('admin.shared.dtcontrols-without-ajax')
                    ->with('id', $model->getKey())
                    ->with('model', $model)
                    ->with('editUrl', route('event.edit', $model->getKey()))
                    ->with('deleteUrl', route('event.destroy', $model->getKey()))
                    ->render();
            })->editColumn('start_time', function ($model) {
                $start = $model->start_time ? $model->start_time->format('h:i A') : '';
                $end = $model->end_time ? $model->end_time->format('h:i A') : '';
                return $start && $end ? "$start - $end" : "";
            })
            ->editColumn('image', function ($model) {
                if (!$model->image) {
                    return 'No Image';
                }

                $images = json_decode($model->image, true);
                $firstImage = $images[0];

                $html = '<a href="' . asset('storage/' . $firstImage) . '" data-lightbox="event-' . $model->id . '" data-title="' . $model->name . '">';
                $html .= '<img src="' . asset('storage/' . $firstImage) . '" style="width:80px;height:80px;object-fit:cover;margin:2px;">';
                $html .= '</a>';

                foreach ($images as $key => $img) {
                    if ($key == 0) continue;
                    $html .= '<a href="' . asset('storage/' . $img) . '" data-lightbox="event-' . $model->id . '" data-title="' . $model->name . '" style="display:none;"></a>';
                }

                return $html;
            })

            ->editColumn('date', function ($model) {
                return $model->date ? $model->date->format('d-m-Y') : '';
            })
            ->rawColumns(['image', 'action'])
            ->make(true);
    }
}
