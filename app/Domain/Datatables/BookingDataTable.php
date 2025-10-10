<?php

namespace App\Domain\Datatables;

use App\Domain\Util\Datatables\BaseDatatableScope;
use App\Models\booking;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Auth;

class BookingDataTable extends BaseDatatableScope
{
    public function __construct()
    {
        $this->setHtml([
            [
                'data' => 'username',
                'name' => 'users.username',
                'title' => 'User name',
                'searchable' => true,
                'orderable' => true,
            ],
            [
                'data' => 'event_name',
                'name' => 'events.name',
                'title' => 'Event Name',
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
                'title' => 'Tickets Booked',
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
                'data' => 'booking_type',
                'name' => 'bookings.booking_type',
                'title' => 'Booking Type',
                'searchable' => true,
                'orderable' => true,
            ],
            [
                'data' => 'status',
                'name' => 'status',
                'title' => 'Status',
                'searchable' => true,
                'orderable' => true,
            ],
            [
                'data' => 'checkbox',
                'name' => 'checkbox',
                'title' => '<input type="checkbox"  id="select-all">',
                'orderable' => false,
                'searchable' => false,
            ],
        ]);
    }

    public function query()
    {
        $query = booking::select(
            'bookings.*',
            'users.username as username',
            'events.name as event_name',
            'events.date',
            'events.price',
            'events.location'
        )
            ->join('users', 'users.id', '=', 'bookings.user_id')
            ->join('events', 'events.id', '=', 'bookings.event_id');

        return DataTables::of($query)
            ->addIndexColumn()
            ->addColumn('action', function ($row) {
                // Check admin role
                $admin = Auth::guard('admin')->user();
                if ($admin->role == 2) {
                    return ''; // hide buttons for role 2
                }
                $btn = '<div style="display:flex; gap:5px;">';

                // Cancel button (only show on booking is confirmed  delete btn show on Cancelled Pending )
                if ($row->status === 'confirmed') {
                    $cancelUrl = route('admin.booking.cancel', $row->id); // make sure you define this route
                    $btn .= '<form action="' . $cancelUrl . '" method="POST" style="display:inline;" class="cancel-form">
                    ' . csrf_field() . '
                    <button type="submit" class="btn btn-warning btn-sm">Cancel</button>
                </form>';
                } else {
                    $deleteUrl = route('booking.destroy', $row->id);
                    $btn .= '<form action="' . $deleteUrl . '" method="POST" style="display:inline;" class="delete-form">
                        ' . csrf_field() . '
                        ' . method_field('DELETE') . '
                        <button type="submit" class="btn btn-danger btn-sm" style="margin:5px;">
                            <i class="fa fa-trash-o" style="font-size:20px;color:white;"></i>
                        </button>
                    </form>';
                }
                return $btn;
            })->editColumn('status', function ($row) {
                if ($row->status === 'confirmed') {
                    return '<span class="badge bg-success">Confirmed</span>';
                } elseif ($row->status === 'cancelled') {
                    return '<span class="badge bg-danger">Cancelled</span>';
                } else {
                    return '<span class="badge bg-secondary">Pending</span>';
                }
            })->addColumn('checkbox', function ($row) {
                if ($row->status === 'cancelled') {
                    return '<input type="checkbox" class="task-checkbox" value="' . $row->id . '">';
                }
                return '';
            })->rawColumns(['status', 'action', 'checkbox'])
            ->make(true);
    }
}
