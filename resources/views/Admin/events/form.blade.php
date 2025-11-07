<div class="row mx-2">
    <div class="col-md-6 mt-3">
        <label class="form-label"><b>Name</b></label>
        <input type="text" class="form-control @error('name') is-invalid @enderror" name="name"
            value="{{ isset($event->name) ? $event->name : old('name') }}" placeholder="Enter Event Name">
        @error('name')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
</div>

<div class="row mx-2">
    <div class="col-md-6 mt-3">
        <label class="form-label"><b>Date</b></label>
        <input type="date" class="form-control @error('date') is-invalid @enderror" name="date"
            value="{{ isset($event->date) ? $event->date->format('Y-m-d') : old('date', date('Y-m-d')) }}">
        @error('date')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
</div>

<div class="row mx-2">
    <div class="col-md-3 mt-3">
        <label for="start_time" class="form-label"><b>Start Time</b></label>
        <input type="time" class="form-control @error('start_time') is-invalid @enderror" name="start_time"
            id="start_time"
            value="{{ isset($event->start_time) ? \Carbon\Carbon::parse($event->start_time)->format('H:i') : old('start_time') }}"
            placeholder="Enter Start Time">
        @error('start_time')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-md-3 mt-3 mx-3">
        <label for="end_time" class="form-label"><b>End Time</b></label>
        <input type="time" class="form-control @error('end_time') is-invalid @enderror" name="end_time"
            id="end_time"
            value="{{ isset($event->end_time) ? \Carbon\Carbon::parse($event->end_time)->format('H:i') : old('end_time') }}"
            placeholder="Enter End Time">
        @error('end_time')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
</div>

<div class="row mx-2">
    <div class="col-md-6 mt-3">
        <label class="form-label"><b>Location</b></label>
        <input type="text" class="form-control @error('location') is-invalid @enderror" name="location"
            value="{{ isset($event->location) ? $event->location : old('location') }}"
            placeholder="Enter Event Location">
        @error('location')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
</div>

<div class="row mx-2">
    <div class="col-md-6 mt-3">
        <label class="form-label"><b>Price</b></label>
        <input type="number" class="form-control @error('price') is-invalid @enderror" name="price"
            value="{{ isset($event->price) ? $event->price : old('price') }}" placeholder="Enter Event Price">
        @error('price')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
</div>

<div class="row mx-2 mb-3">
    <div class="col-md-6 mt-3">
        <label class="form-label"><b>Tickets</b></label>
        <input type="number" class="form-control @error('total_tickets') is-invalid @enderror" name="total_tickets"
            value="{{ isset($event->total_tickets) ? $event->total_tickets : old('total_tickets') }}"
            placeholder="Enter Total Tickets">
        @error('total_tickets')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
</div>
<div class="row mx-3 mb-3">
    <label class="form-label"><b>Images</b></label>
    <div class="dropzone border rounded  @error('image') is-invalid @enderror" id="dropzoneArea">
    </div>

    @error('image')
        <div class="invalid-feedback d-block">{{ $message }}</div>
    @enderror
</div>
