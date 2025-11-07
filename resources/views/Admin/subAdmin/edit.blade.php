 @extends('Admin.layout.partials.master')
 @section('title', 'Admin - Add SubAdmin ')
 @section('content')
     <div class="pc-content">
         <div class="row">
             <div class="col-sm-12">
                 <div class="card">
                     <div class="card-header d-flex justify-content-between">
                         <h4>Edit SubAdmin</h4>
                         <a href="{{ route('subadmin.index') }}" class="btn btn-success rounded text-white">Back</a>

                     </div>
                     <div class="card-body">
                         <div class="card-body">
                             <form action="{{ route('subadmin.update', $admin->id) }}" id="editSubadminForm" method="POST">
                                 @csrf
                                 @method('PUT')

                                 @include('admin.subAdmin.form')

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
