@extends('Admin.layout.partials.master')
@section('title', 'Admin - Edit Event')

@section('content')
    <div class="pc-content">
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between">
                        <h4>Edit Event</h4>
                        <a href="{{ route('admin.manageEvent') }}" class="btn btn-success rounded text-white">Back</a>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="{{ route('admin.UpdateEvent', $event->id) }}"
                            enctype="multipart/form-data">
                            @csrf
                            @method('POST')

                            <div class="col-md-6 mt-3">
                                <label for="Name" class="form-label"><b>Name</b></label>
                                <input type="text" class="form-control @error('name') is-invalid @enderror"
                                    name="name" id="Name" placeholder="Enter Event Name"
                                    value="{{ old('name', $event->name) }}">
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mt-3">
                                <label for="Date" class="form-label"><b>Date</b></label>
                                <input type="date" class="form-control @error('date') is-invalid @enderror"
                                    name="date" id="Date" value="{{ old('date', $event->date->format('Y-m-d')) }}">
                                @error('date')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mt-3">
                                <label for="Location" class="form-label"><b>Location</b></label>
                                <input type="text" class="form-control @error('location') is-invalid @enderror"
                                    name="location" id="Location" placeholder="Enter Event Location"
                                    value="{{ old('location', $event->location) }}">
                                @error('location')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mt-3">
                                <label for="total_tickets" class="form-label"><b>Tickets</b></label>
                                <input type="number" class="form-control @error('total_tickets') is-invalid @enderror"
                                    name="total_tickets" id="total_tickets" placeholder="Enter Event Tickets"
                                    value="{{ old('total_tickets', $event->total_tickets) }}">
                                @error('total_tickets')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6 mt-3">
                                <label for="price" class="form-label"><b>Price</b></label>
                                <input type="number" class="form-control @error('price') is-invalid @enderror"
                                    name="price" id="price" placeholder="Enter Event Price"
                                    value="{{ old('price', $event->price) }}">
                                @error('price')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="row">
                                <div class="col-md-6 mt-3">
                                    <label for="EventImage" class="form-label"><b>Choose image</b></label>
                                    <input type="file" class="form-control @error('EventImage') is-invalid @enderror"
                                        name="EventImage" id="EventImage" accept="image/*">

                                    @error('EventImage')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-6 mt-3">

                                    @if ($event->image)
                                        <img id="EventImagePreview" src="{{ asset('storage/' . $event->image) }}"
                                            alt="Selected Image" class="img-thumbnail mt-2"
                                            style="width:160px; height:120px;">
                                    @else
                                        <img id="EventImagePreview" src="#" alt="Selected Image"
                                            class="img-thumbnail mt-2 d-none" style="width:160px; height:120px;">
                                    @endif

                                </div>
                            </div>
                            <div class="row mt-3">
                                <div class="col-12">
                                    <button class="btn btn-success" type="submit">Update</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <script>
            // Preview image on change
            document.getElementById('EventImage').addEventListener('change', function(event) {
                const preview = document.getElementById('EventImagePreview');
                const file = event.target.files[0];

                if (file) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        preview.src = e.target.result;
                        preview.classList.remove('d-none');
                    }
                    reader.readAsDataURL(file);
                } else {
                    preview.src = '#';
                    preview.classList.add('d-none');
                }
            });
        </script>
    </div>
@endsection
