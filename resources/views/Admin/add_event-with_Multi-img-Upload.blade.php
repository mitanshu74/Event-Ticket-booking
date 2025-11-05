
@extends('Admin.layout.partials.master')
@section('title', 'Admin - Add event')
@section('content')
    <div class="pc-content">
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between">
                        <h4>Add Event</h4>
                        <a href="{{ route('admin.manageEvent') }}" class="btn btn-success rounded text-white">Back</a>
                    </div>
                    <div class="card-body">
                        <form class="g-3 needs-validation" method="POST" action="{{ route('admin.storeEvent') }}"
                            enctype="multipart/form-data" novalidate>
                            @csrf

                            <div class="row mx-2">
                                <div class="col-md-6 mt-3">
                                    <label for="Name" class="form-label"><b>Name</b></label>
                                    <input type="text" class="form-control @error('name') is-invalid @enderror"
                                        name="name" id="Name" placeholder="Enter Event Name"
                                        value="{{ old('name') }}">
                                    @error('name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mx-2">
                                <div class="col-md-6 mt-3">
                                    <label for="Date" class="form-label"><b>Date</b></label>
                                    <input type="date" class="form-control @error('date') is-invalid @enderror"
                                        name="date" id="Date" value="{{ old('date') }}">
                                    @error('date')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mx-2">
                                <div class="col-md-3 mt-3">
                                    <label for="start_time" class="form-label"><b>Start Time</b></label>
                                    <input type="time" class="form-control @error('start_time') is-invalid @enderror"
                                        name="start_time" id="start_time" value="{{ old('start_time') }}">
                                    @error('start_time')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-3 mt-3">
                                    <label for="end_time" class="form-label"><b>End Time</b></label>
                                    <input type="time" class="form-control @error('end_time') is-invalid @enderror"
                                        name="end_time" id="end_time" value="{{ old('end_time') }}">
                                    @error('end_time')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mx-2">
                                <div class="col-md-6 mt-3">
                                    <label for="Location" class="form-label"><b>Location</b></label>
                                    <input type="text" class="form-control @error('location') is-invalid @enderror"
                                        name="location" id="Location" placeholder="Enter Event Location"
                                        value="{{ old('location') }}">
                                    @error('location')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mx-2">
                                <div class="col-md-6 mt-3">
                                    <label for="Price" class="form-label"><b>Price</b></label>
                                    <input type="number" class="form-control @error('price') is-invalid @enderror"
                                        name="price" id="Price" placeholder="Enter Event Price"
                                        value="{{ old('price') }}">
                                    @error('price')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mx-2">
                                <div class="col-md-6 mt-3">
                                    <label for="total_tickets" class="form-label"><b>Tickets</b></label>
                                    <input type="number" class="form-control @error('total_tickets') is-invalid @enderror"
                                        name="total_tickets" id="total_tickets" placeholder="Enter Event Tickets"
                                        value="{{ old('total_tickets') }}">
                                    @error('total_tickets')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="row mx-2">
                                <div class="col-md-6 mt-3">
                                    <label for="EventImages" class="form-label"><b>Choose Images</b></label>
                                    <input type="file" class="form-control" name="EventImages[]" id="EventImages"
                                        accept="image/*" multiple required>

                                    @if ($errors->has('EventImages'))
                                        <div class="invalid-feedback d-block">{{ $errors->first('EventImages') }}</div>
                                    @elseif ($errors->first('EventImages.*'))
                                        <div class="invalid-feedback d-block">{{ $errors->first('EventImages.*') }}</div>
                                    @endif
                                </div>

                                <div class="col-md-6 mt-3" id="previewContainer"></div>
                            </div>

                            <div class="row">
                                <div class="col-12 m-3">
                                    <button class="btn btn-primary" type="submit" name="submit">Submit</button>
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
