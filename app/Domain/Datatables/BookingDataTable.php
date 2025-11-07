<?php

namespace App\Domain\Datatables;

use App\Domain\Util\Datatables\BaseDatatableScope;
use App\Models\booking;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

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
                'name' => 'event_name',
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
                'data' => 'checkbox',
                'name' => 'checkbox',
                'title' => '<input type="checkbox"  id="select-all">',
                'orderable' => false,
                'searchable' => false,
            ],
            [
                'data' => 'status',
                'name' => 'status',
                'title' => 'Status',
                'searchable' => true,
                'orderable' => true,
            ],
        ]);
    }

    public function query()
    {

        $bookings = Booking::with(['user', 'event'])
            ->select([
                'id',
                'user_id',
                'event_id',
                'tickets_booked',
                'total_price',
                'booking_type',
                'status'
            ])->get();

        // dd($bookings);
        return DataTables::of($bookings)
            ->addIndexColumn()
            ->addColumn('username', function ($row) {

                return $row->user ? $row->user->username : 'N/A';
            })

            ->addColumn('event_name', function ($row) {
                return $row->event ? $row->event->name : 'N/A';
            })
            ->addColumn('location', function ($row) {
                return $row->event ? $row->event->location : 'N/A';
            })
            ->addColumn('price', function ($row) {
                return $row->event ? $row->event->price : 'N/A';
            })
            ->addColumn('date', function ($row) {
                return $row->event ? $row->event->date->format('d-m-Y') : 'N/A';
            })

            ->addColumn('action', function ($row) {
                $btn = '<div style="display:flex; gap:5px;">';

                if ($row->status === 'confirmed') {
                    $cancelUrl = route('admin.booking.cancel', $row->id);
                    $btn .= '<form action="' . $cancelUrl . '" method="POST" class="cancel-form" style="display:inline;">
                        ' . csrf_field() . '
                        <button type="submit" class="btn btn-warning btn-sm">Cancel</button>
                    </form>';
                } else {
                    $deleteUrl = route('booking.destroy', $row->id);
                    $btn .= '<form action="' . $deleteUrl . '" method="POST" class="delete-form" style="display:inline;">
                        ' . csrf_field() . method_field('DELETE') . '
                        <button type="submit" class="btn btn-danger btn-sm" style="margin:5px;">
                            <i class="fa fa-trash-o" style="font-size:20px;color:white;"></i>
                        </button>
                    </form>';
                }

                $btn .= '</div>';
                return $btn;
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

            ->addColumn('checkbox', function ($row) {
                $admin = Auth::guard('admin')->user();
                if ($admin && $admin->role == 1) {
                    if ($row->status === 'cancelled') {
                        return '<input type="checkbox" class="task-checkbox" value="' . $row->id . '">';
                    }
                }
                return '';
            })
            ->rawColumns(['status', 'action', 'checkbox'])
            ->make(true);
    }
}
