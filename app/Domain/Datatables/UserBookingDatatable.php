<?php

namespace App\Domain\Datatables;

use App\Domain\Util\Datatables\BaseDatatableScope;
use App\Models\booking;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Auth;

class UserBookingDatatable extends BaseDatatableScope
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
        $userId = Auth::guard('web')->id(); // Get current user ID

        $query = booking::select(
            'bookings.*',
            'users.username as username',
            'events.name as event_name',
            'events.date',
            'events.price',
            'events.location'
        )
            ->join('users', 'users.id', '=', 'bookings.user_id')
            ->join('events', 'events.id', '=', 'bookings.event_id')
            ->where('bookings.user_id', $userId);

        return DataTables::of($query)
            ->addIndexColumn()
            ->addColumn('action', function ($row) {
                if ($row->status === 'confirmed') {
                    $cancelUrl = route('user.booking.cancel', $row->id);
                    return '
            <form action="' . $cancelUrl . '" method="POST" class="cancel-booking-form" style="display:inline;">
                ' . csrf_field() . '
                ' . method_field('DELETE') . '
                <button type="submit" class="btn btn-warning btn-sm">Cancel </button>
            </form>
        ';
                }
                return '';
            })
            ->editColumn('status', function ($row) {
                if ($row->status === 'confirmed') {
                    return '<span class="badge bg-success">Confirmed</span>';
                } elseif ($row->status === 'cancelled') {
                    return '<span class="badge bg-danger">Cancelled</span>';
                } else {
                    return '<span class="badge bg-secondary">Pending</span>';
                }
            })
            ->rawColumns(['status', 'action'])
            ->make(true);
    }
}
