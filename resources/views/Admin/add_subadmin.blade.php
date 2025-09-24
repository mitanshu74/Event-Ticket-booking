 @extends('Admin.layout.partials.master')
 @section('title', 'Admin - Add SubAdmin ')
 @section('content')
     <div class="pc-content">
         <!-- [ Main Content ] start -->
         <div class="row">
             <!-- [ Form Validation ] start -->
             <div class="col-sm-12">
                 <div class="card">
                     <div class="card-header">
                         <h4>Add SubAdmin</h4>
                         <a href="{{ route('admin.manageSubAdmin') }}" class="btn btn-success rounded text-white">Back</a>

                     </div>
                     <div class="card-body">
                         <form class=" g-3 needs-validation" method="POST" enctype="multipart/form-data" novalidate>
                             <!-- Product Image and Name -->

                             <div class="col-md-6 mt-3">
                                 <label for="EventName" class="form-label">Name</label>
                                 <input type="text" class="form-control" name="Name" id="Name"
                                     placeholder="Enter SubAdmin Name">
                             </div>
                             <div class="col-md-6 mt-3">
                                 <label for="EventDate" class="form-label">Event Date</label>
                                 <input type="date" class="form-control" name="EventDate" id="EventDate">
                             </div>
                             <div class="col-md-6 mt-3">
                                 <label for="EventLocation" class="form-label">Event Location</label>
                                 <input type="text" class="form-control" name="EventLocation" id="EventLocation"
                                     placeholder="Enter Event Location">
                             </div>
                             <div class="col-md-6 mt-3">
                                 <label for="total_tickets" class="form-label">Event Tickets</label>
                                 <input type="number" class="form-control" name="total_tickets" id="total_tickets"
                                     placeholder="Enter Event Tickets">
                             </div>

                             <div class="row mt-3">
                                 <div class="col-md-6 py-0">
                                     <label for="EventImage" class="form-label">Choose Event image</label>
                                     <input type="file" class="form-control" name="EventImage" id="EventImage"
                                         accept="image/*" required>
                                 </div>
                                 <div class="col-md-6 p-0">
                                     <img id="EventImagePreview" src="#" alt="Selected Image"
                                         class="img-thumbnail d-none" style="width: 160px; height: 120px;">
                                 </div>
                             </div>
                             <!-- Submit Button -->
                             <div class="col-12 mt-3">
                                 <button class="btn btn-primary" type="submit" name="submit">Submit</button>
                             </div>

                         </form>
                     </div>
                 </div>
             </div>
             <!-- [ Form Validation ] end -->
         </div>
         <!-- [ Main Content ] end -->
     </div>
 @endsection
