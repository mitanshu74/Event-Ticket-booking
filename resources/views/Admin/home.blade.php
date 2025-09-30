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
                                     <i class="ti ti-users f-24"></i>
                                 </div>
                             </div>
                             <div class="flex-grow-1 ms-3">
                                 <p class="mb-1">Total Seller</p>
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
                                     <i class="ti ti-notebook f-24"></i>
                                 </div>
                             </div>
                             <div class="flex-grow-1 ms-3">
                                 <p class="mb-1">Total Product</p>
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
                                     <i class="ti ti-credit-card f-24"></i>
                                 </div>
                             </div>
                             <div class="flex-grow-1 ms-3">
                                 <p class="mb-1">Total Order</p>
                                 <div class="d-flex align-items-center justify-content-between">
                                     <h6 class="mb-0">0</h6>
                                     <a href="" class="text-danger fw-medium">View All</a>
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
             </div>
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
                             <tr>
                                 <th>ID</th>
                                 <th>Name</th>
                                 <th>Email</th>
                                 <th>Mobile Number</th>
                                 <th>City</th>
                                 <th>Action</th>
                             </tr>
                         </thead>
                         <tbody>

                             <tr>
                                 <td></td>
                                 <td>
                                     <div class="user_details d-flex align-items-center">
                                         <div class="user_profile_photo">
                                             <img src="" alt="Profile Photo" class="profile-photo" />
                                         </div>
                                         <div>
                                             <p class="mb-0"></p>
                                             <small></small>
                                         </div>
                                     </div>
                                 </td>
                                 <td></td>
                                 <td></td>
                                 <td></td>
                                 <td>
                                     <a href="" class="btn btn-success rounded-pill text-white">Approve</a>
                                     <a href="" class="btn btn-danger rounded-pill text-white">Deny</a>
                                 </td>
                             </tr>
                         </tbody>
                     </table>
                 </div>
             </div>

         </div>
     </div>

 @endsection
