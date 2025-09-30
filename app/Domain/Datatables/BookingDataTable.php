<?php

namespace App\Domain\Datatables;

use App\Domain\Util\Datatables\BaseDatatableScope;
use App\Models\booking;
use App\Models\User;
use App\Models\Event;
use Yajra\DataTables\Facades\DataTables;

class BookingDataTable extends BaseDatatableScope
{
    public function __construct()
    {
        $this->setHtml([
            [
                'data' => 'username',
                'name' => 'username',
                'title' => 'User name',
                'searchable' => true,
                'orderable' => true,
            ],
            [
                'data' => 'event_name',
                'name' => 'eventname',
                'title' => 'Event Name',
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
                'data' => 'tickets_booked',
                'name' => 'tickets_booked',
                'title' => 'Tickets Booked',
                'searchable' => true,
                'orderable' => true,
            ],
            [
                'data' => 'total_price',
                'name' => 'total_price',
                'title' => 'Total Price',
                'searchable' => true,
                'orderable' => true,
            ],
            [
                'data' => 'booking_type',
                'name' => 'booking_type',
                'title' => 'Booking Type',
                'searchable' => true,
                'orderable' => true,
            ],
            [
                'data' => 'status',
                'name' => 'status',
                'title' => 'Status',
                'searchable' => false,
                'orderable' => false,
            ],
        ]);
    }

    public function query()
    {
        $query = booking::select(
            'booking.*',
            'users.username as username',
            'event.name as event_name',
            'event.date',
            'event.price',
            'event.location'
        )
            ->join('users', 'users.id', '=', 'booking.user_id')
            ->join('event', 'event.id', '=', 'booking.event_id');

        return DataTables::of($query)
            ->addIndexColumn()
            ->addColumn('action', function ($row) {
                $btn = '<div style="display:flex; gap:5px;">';

                // Edit button (adjust routes if needed)
                $editUrl = route('admin.EditEvent', $row->id);
                $btn .= '<a href="' . $editUrl . '" class="btn btn-warning btn-sm" style="height:31px;position:relative;top:5px">
                        <i class="fa fa-edit" style="font-size:20px;color:white"></i>
                    </a>';

                $deleteUrl = route('booking.destroy', $row->id);
                $btn .= '<form action="' . $deleteUrl . '" method="POST" style="display:inline;" class="delete-form">
            ' . csrf_field() . '
            ' . method_field('DELETE') . '
            <button type="submit" class="btn btn-danger btn-sm" style="margin:5px;">
                <i class="fa fa-trash-o" style="font-size:20px;color:white;"></i>
            </button>
        </form>';
                $btn .= '</div>';


                return $btn;
            })
            ->make(true);
    }
}
