<div class="col-md-6 mt-3">
    <label for="Name" class="form-label">Name</label>
    <input type="text" class="form-control @error('name') is-invalid @enderror" name="name" id="Name"
        placeholder="Enter SubAdmin Name" value="{{ isset($admin->name) ? $admin->name : old('name') }}">
    @error('name')
        <div class="invalid-feedback">
            {{ $message }}
        </div>
    @enderror
</div>
<div class="col-md-6 mt-3">
    <label for="email" class="form-label">Email</label>
    <input type="email" class="form-control @error('email') is-invalid @enderror" name="email" id="email"
        placeholder="Enter SubAdmin Email" value="{{ isset($admin->email) ? $admin->email : old('email') }}">
    @error('email')
        <div class="invalid-feedback">
            {{ $message }}
        </div>
    @enderror
</div>
