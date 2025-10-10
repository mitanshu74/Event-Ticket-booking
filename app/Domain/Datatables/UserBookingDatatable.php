<?php

namespace App\Domain\Datatables;

use App\Domain\Util\Datatables\BaseDatatableScope;
use App\Models\booking;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class UserBookingDatatable extends BaseDatatableScope
{
    public function __construct()
    {
        $this->setHtml([
            [
                'data' => 'username',
                'name' => 'users.username',
                'title' => 'Name',
                'searchable' => true,
                'orderable' => true,
            ],
            [
                'data' => 'event_name',
                'name' => 'events.name',
                'title' => 'EventName',
                'searchable' => true,
                'orderable' => true,
            ],
            [
                'data' => 'start_time',
                'name' => '',
                'title' => 'Time',
                'searchable' => true,
                'orderable' => true,
            ],
            [
                'data' => 'date',
                'name' => 'events.date',
                'title' => 'Date',
                'searchable' => true,
                'orderable' => true,
            ],
            [
                'data' => 'location',
                'name' => 'events.location',
                'title' => 'Location',
                'searchable' => true,
                'orderable' => true,
            ],
            [
                'data' => 'price',
                'name' => 'events.price',
                'title' => 'Price',
                'searchable' => true,
                'orderable' => true,
            ],
            [
                'data' => 'tickets_booked',
                'name' => 'bookings.tickets_booked',
                'title' => 'Tickets',
                'searchable' => true,
                'orderable' => true,
            ],
            [
                'data' => 'total_price',
                'name' => 'bookings.total_price',
                'title' => 'Total Price',
                'searchable' => true,
                'orderable' => true,
            ],
            [
                'data' => 'status',
                'name' => 'bookings.status',
                'title' => 'Status',
                'searchable' => false,
                'orderable' => false,
            ],
        ]);
    }

    public function query()
    {
        $userId = Auth::guard('web')->id();
        $query = booking::select(
            'bookings.*',
            'users.username as username',
            'events.name as event_name',
            'events.date',
            'events.start_time',
            'events.end_time',
            'events.price',
            'events.location'
        )
            ->join('users', 'users.id', '=', 'bookings.user_id')
            ->join('events', 'events.id', '=', 'bookings.event_id')
            ->where('bookings.user_id', $userId);

        return DataTables::of($query)
            ->addIndexColumn()
            ->editColumn('start_time', function ($row) {
                $start = $row->start_time ? Carbon::parse($row->start_time)->format('h:i A') : '';
                $end = $row->end_time ? Carbon::parse($row->end_time)->format('h:i A') : '';
                return $start && $end ? "$start - $end" : $start;
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
            ->addColumn('action', function ($row) {
                if ($row->status === 'confirmed') {
                    $cancelUrl = route('user.booking.cancel', $row->id);
                    return '
                    <form action="' . $cancelUrl . '" method="POST" class="cancel-booking-form" style="display:inline;">
                        ' . csrf_field() . '
                        ' . method_field('DELETE') . '
                        <button type="submit" class="btn btn-warning btn-sm">Cancel</button>
                    </form>
                ';
                } elseif ($row->status === 'pending') {
                    $payUrl = route('razorpay.payment.redirect', ['bookingId' => $row->id, 'from' => 'ticket_booked']);
                    return '<a href="' . $payUrl . '" class="btn btn-primary btn-sm pay-booking-btn">Pay</a>';
                }
                return '';
            })
            ->rawColumns(['status', 'action'])
            ->make(true);
    }
}
