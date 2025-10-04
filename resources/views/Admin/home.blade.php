 @extends('Admin.layout.partials.master')

 @section('title', 'Admin - Home')
 @section('content')

     <div class="pc-content">
         <div class="row">
             <div class="col-lg-3 col-md-6">
                 <div class="card">
                     <div class="card-body">
                         <div class="d-flex align-items-center">
                             <div class="flex-shrink-0">
                                 <div class="avtar bg-light-primary">
                                     <i class="ti ti-users f-24"></i>
                                 </div>
                             </div>
                             <div class="flex-grow-1 ms-3">
                                 <p class="mb-1">Total User</p>
                                 <div class="d-flex align-items-center justify-content-between">
                                     <h6 class="mb-0">{{ $totalUser }}</h6>
                                     <a href="" class="text-success fw-medium">View All</a>
                                 </div>
                             </div>
                         </div>
                     </div>
                 </div>
             </div>
             <div class="col-lg-3 col-md-6">
                 <div class="card">
                     <div class="card-body">
                         <div class="d-flex align-items-center">
                             <div class="flex-shrink-0">
                                 <div class="avtar bg-light-primary">
                                     <i class="ti ti-users f-24"></i>
                                 </div>
                             </div>
                             <div class="flex-grow-1 ms-3">
                                 <p class="mb-1">Total SubAdmin</p>
                                 <div class="d-flex align-items-center justify-content-between">
                                     <h6 class="mb-0">{{ $totalSubAdmin }}</h6>
                                     <a href="{{ route('admin.manageSubAdmin') }}" class="text-success fw-medium">View
                                         All</a>
                                 </div>
                             </div>
                         </div>
                     </div>
                 </div>
             </div>
             <div class="col-lg-3 col-md-6">
                 <div class="card">
                     <div class="card-body">
                         <div class="d-flex align-items-center">
                             <div class="flex-shrink-0">
                                 <div class="avtar bg-light-primary">
                                     <i class="ti ti-credit-card f-24"></i>
                                 </div>
                             </div>
                             <div class="flex-grow-1 ms-3">
                                 <p class="mb-1">Total Event</p>
                                 <div class="d-flex align-items-center justify-content-between">
                                     <h6 class="mb-0">{{ $totalevent }}</h6>
                                     <a href="{{ route('admin.manageEvent') }}" class="text-success fw-medium">View All</a>
                                 </div>
                             </div>
                         </div>
                     </div>
                 </div>
             </div>
             <div class="col-lg-3 col-md-6">
                 <div class="card">
                     <div class="card-body">
                         <div class="d-flex align-items-center">
                             <div class="flex-shrink-0">
                                 <div class="avtar bg-light-primary">
                                     <i class="ti ti-notebook f-24"></i>
                                 </div>
                             </div>
                             <div class="flex-grow-1 ms-3">
                                 <p class="mb-1">Total Booking</p>
                                 <div class="d-flex align-items-center justify-content-between">
                                     <h6 class="mb-0">{{ $totalbooking }}</h6>
                                     <a href="{{ route('booking.index') }}" class="text-success fw-medium">View
                                         All</a>
                                 </div>
                             </div>
                         </div>
                     </div>
                 </div>
             </div>

             {{--  <div class="col-lg-3 col-md-6">
                 <div class="card">
                     <div class="card-body">
                         <div class="d-flex align-items-center">
                             <div class="flex-shrink-0">
                                 <div class="avtar bg-light-primary">
                                     <svg class="pc-icon">
                                         <use xlink:href="#custom-shopping-bag"></use>
                                     </svg>
                                 </div>
                             </div>
                             <div class="flex-grow-1 ms-3">
                                 <p class="mb-1">Total Category</p>
                                 <div class="d-flex align-items-center justify-content-between">
                                     <h6 class="mb-0">0</h6>
                                     <a href="" class="text-success fw-medium">View All</a>
                                 </div>
                             </div>
                         </div>
                     </div>
                 </div>
             </div>
             <div class="col-lg-3 col-md-6">
                 <div class="card">
                     <div class="card-body">
                         <div class="d-flex align-items-center">
                             <div class="flex-shrink-0">
                                 <div class="avtar bg-light-warning">
                                     <svg class="pc-icon">
                                         <use xlink:href="#custom-layer"></use>
                                     </svg>
                                 </div>
                             </div>
                             <div class="flex-grow-1 ms-3">
                                 <p class="mb-1">Total Slider</p>
                                 <div class="d-flex align-items-center justify-content-between">
                                     <h6 class="mb-0">0</h6>
                                     <a href="" class="text-warning fw-medium">View All</a>
                                 </div>
                             </div>
                         </div>
                     </div>
                 </div>
             </div>
             <div class="col-lg-3 col-md-6">
                 <div class="card">
                     <div class="card-body">
                         <div class="d-flex align-items-center">
                             <div class="flex-shrink-0">
                                 <div class="avtar bg-light-success">
                                     <svg class="pc-icon">
                                         <use xlink:href="#custom-story"></use>
                                     </svg>
                                 </div>
                             </div>
                             <div class="flex-grow-1 ms-3">
                                 <p class="mb-1">Total Revenue</p>
                                 <div class="d-flex align-items-center justify-content-between">
                                     <h6 class="mb-0">0</h6>
                                     <a href="" class="text-success fw-medium">View All</a>
                                 </div>
                             </div>
                         </div>
                     </div>
                 </div>
             </div>
             <div class="col-lg-3 col-md-6">
                 <div class="card">
                     <div class="card-body">
                         <div class="d-flex align-items-center">
                             <div class="flex-shrink-0">
                                 <div class="avtar bg-light-danger">
                                     <svg class="pc-icon">
                                         <use xlink:href="#custom-user-square"></use>
                                     </svg>
                                 </div>
                             </div>
                             <div class="flex-grow-1 ms-3">
                                 <p class="mb-1">Total Contact</p>
                                 <div class="d-flex align-items-center justify-content-between">
                                     <h6 class="mb-0">0</h6>
                                     <a href="" class="text-danger fw-medium">View All</a>
                                 </div>
                             </div>
                         </div>
                     </div>
                 </div>
             </div> --}}
         </div>
         <!-- new user authentication data table-->
         <div class="cards_design p-3 mb-4 bg-white border">
             <!-- <div class="card-header"> -->
             <h5 class="mb-0 p-2 border rounded text-dark bg-light-secondary">All User</h5>

             <!-- </div> -->

             <div class="card-body">
                 <div class="table-responsive pt-3 rounded-1">
                     <table class="table table-bordered data-table">
                         <thead>
                             {!! $html->table(['class' => 'table table-striped table-bordered', 'id' => 'User-table']) !!}

                         </thead>
                         <tbody>

                             {!! $html->scripts() !!}

                         </tbody>
                     </table>
                 </div>
             </div>
             <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
             <script>
                 document.addEventListener("DOMContentLoaded", function() {
                     $(document).on('submit', '.delete-form', function(e) {
                         e.preventDefault();
                         let form = this;

                         Swal.fire({
                             title: "Are you sure?",
                             text: "This action will permanently delete the user!",
                             icon: "warning",
                             showCancelButton: true,
                             confirmButtonColor: "#d33",
                             cancelButtonColor: "#3085d6",
                             confirmButtonText: "Yes, delete it!",
                             cancelButtonText: "Cancel"
                         }).then((result) => {
                             if (result.isConfirmed) {
                                 $.ajax({
                                     url: form.action,
                                     type: 'POST',
                                     data: $(form).serialize(),
                                     success: function(response) {
                                         Swal.fire(
                                             "Deleted!",
                                             response.success,
                                             "success"
                                         );
                                         $('#User-table').DataTable().ajax
                                             .reload(); // reload datatable
                                     },
                                 });
                             }
                         });
                     });
                 });
             </script>

         </div>
     </div>

 @endsection
