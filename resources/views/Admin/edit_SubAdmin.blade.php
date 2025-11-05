 @extends('Admin.layout.partials.master')
 @section('title', 'Admin - Add SubAdmin ')
 @section('content')
     <div class="pc-content">
         <div class="row">
             <div class="col-sm-12">
                 <div class="card">
                     <div class="card-header d-flex justify-content-between">
                         <h4>Add SubAdmin</h4>
                         <a href="{{ route('admin.manageSubAdmin') }}" class="btn btn-success rounded text-white">Back</a>

                     </div>
                     <div class="card-body">
                         <div class="card-body">
                             <form action="{{ route('admin.UpdateSubAdmin', $admin->id) }}" id="editSubadminForm"
                                 method="POST">
                                 @csrf
                                 @method('PUT')

                                 <div class="col-md-6 mt-3">
                                     <label for="Name" class="form-label">Name</label>
                                     <input type="text" class="form-control @error('name') is-invalid @enderror"
                                         name="name" id="Name" placeholder="Enter SubAdmin Name"
                                         value="{{ old('name', $admin->name) }}">
                                     @error('name')
                                         <div class="invalid-feedback">
                                             {{ $message }}
                                         </div>
                                     @enderror
                                 </div>

                                 <div class="col-md-6 mt-3">
                                     <label for="email" class="form-label">Email</label>
                                     <input type="email" class="form-control @error('email') is-invalid @enderror"
                                         name="email" id="email" placeholder="Enter SubAdmin Email"
                                         value="{{ old('email', $admin->email) }}">
                                     @error('email')
                                         <div class="invalid-feedback">
                                             {{ $message }}
                                         </div>
                                     @enderror
                                 </div>

                                 <div class="col-12 mt-3">
                                     <button class="btn btn-success" type="submit">Update</button>
                                 </div>
                             </form>
                             <div id="loading-overlay">
                                 <div class="spinner"></div>
                             </div>
                         </div>

                     </div>
                 </div>
             </div>
         </div>
     </div>
 @endsection
 @push('script')
     <script>
         const form = document.getElementById('editSubadminForm');
         const overlay = document.getElementById('loading-overlay');

         form.addEventListener('submit', function() {
             overlay.style.display = 'flex';
         });
     </script>
 @endpush
