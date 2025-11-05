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

                            <div class="row mx-2">
                                <div class="col-md-3 mt-3">
                                    <label for="start_time" class="form-label"><b>Start Time</b></label>
                                    <input type="time" class="form-control @error('start_time') is-invalid @enderror"
                                        name="start_time" id="start_time"
                                        value="{{ old('start_time', \Carbon\Carbon::parse($event->start_time)->format('h:i')) }}">
                                    @error('start_time')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-3 mt-3">
                                    <label for="end_time" class="form-label"><b>End Time</b></label>
                                    <input type="time" class="form-control @error('end_time') is-invalid @enderror"
                                        name="end_time" id="end_time"
                                        value="{{ old('end_time', \Carbon\Carbon::parse($event->end_time)->format('h:i')) }}">
                                    @error('end_time')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
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
                                    <label for="EventImages" class="form-label"><b>Choose Images</b></label>
                                    <input type="file" class="form-control @error('EventImages') is-invalid @enderror"
                                        name="EventImages[]" id="EventImages" accept="image/*" multiple>
                                    @error('EventImages')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6 mt-3" id="previewContainer">
                                    @if ($event->image)
                                        @php $images = json_decode($event->image, true); @endphp
                                        @foreach ($images as $img)
                                            <img src="{{ asset('storage/' . $img) }}" class="img-thumbnail m-1"
                                                style="width:100px;height:80px;">
                                        @endforeach
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
    </div>
@endsection
@push('script')
    <script>
        const input = document.getElementById('EventImages');
        const previewContainer = document.getElementById('previewContainer');

        input.addEventListener('change', function() {
            previewContainer.innerHTML = ''; 
            const files = input.files;

            Array.from(files).forEach(file => {
                const reader = new FileReader();
                reader.onload = function(e) {
                    const img = document.createElement('img');
                    img.src = e.target.result;
                    img.classList.add('img-thumbnail', 'm-1');
                    img.style.width = '100px';
                    img.style.height = '80px';
                    previewContainer.appendChild(img);
                }
                reader.readAsDataURL(file);
            });
        });
    </script>
@endpush
