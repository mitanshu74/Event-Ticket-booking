  <div class="mb-3">
      <label for="user_id" class="form-label">User</label>
      <select name="user_id" id="user_id" class="form-select @error('user_id') is-invalid @enderror" required>
          <option value="">Select User</option>
          @foreach ($users as $user)
              <option value="{{ $user->id }}" data-email="{{ $user->email }}"
                  {{ old('user_id') == $user->id ? 'selected' : '' }}>
                  {{ $user->username }}
              </option>
          @endforeach
      </select>
      @error('user_id')
          <div class="invalid-feedback">{{ $message }}</div>
      @enderror
  </div>

  <div class="mb-3">
      <label for="email" class="form-label">Email</label>
      <input type="email" name="email" id="email" class="form-control @error('email') is-invalid @enderror"
          value="{{ old('email') }}" readonly placeholder="Email">
      @error('email')
          <div class="invalid-feedback">{{ $message }}</div>
      @enderror
  </div>

  <div class="mb-3">
      <label for="event_id" class="form-label">Event</label>
      <select name="event_id" id="event_id" class="form-select @error('event_id') is-invalid @enderror" required>
          <option value="">Select Event</option>
          @foreach ($events as $event)
              <option value="{{ $event->id }}" data-date="{{ $event->date->format('Y-m-d') }}"
                  data-price="{{ $event->price }}" {{ old('event_id') == $event->id ? 'selected' : '' }}>
                  {{ $event->name }}
              </option>
          @endforeach
      </select>
      @error('event_id')
          <div class="invalid-feedback">{{ $message }}</div>
      @enderror
  </div>

  <div class="mb-3">
      <label for="date" class="form-label">Date</label>
      <input type="date" name="date" id="date" class="form-control @error('date') is-invalid @enderror"
          value="{{ old('date') }}" readonly required>
      @error('date')
          <div class="invalid-feedback">{{ $message }}</div>
      @enderror
  </div>

  <div class="mb-3">
      <label for="price" class="form-label">Price</label>
      <input type="number" name="price" id="price" class="form-control @error('price') is-invalid @enderror"
          value="{{ old('price') }}" readonly placeholder="Price">
      @error('price')
          <div class="invalid-feedback">{{ $message }}</div>
      @enderror
  </div>

  <div class="mb-3">
      <label for="tickets_booked" class="form-label">Tickets Booked</label>
      <input type="number" name="tickets_booked" id="tickets_booked"
          class="form-control @error('tickets_booked') is-invalid @enderror" value="{{ old('tickets_booked') }}"
          min="1" required placeholder="Tickets">
      @error('tickets_booked')
          <div class="invalid-feedback">{{ $message }}</div>
      @enderror
  </div>

  <div class="mb-3">
      <label for="total_price" class="form-label">Total Price</label>
      <input type="number" name="total_price" id="total_price"
          class="form-control @error('total_price') is-invalid @enderror" value="{{ old('total_price', 0) }}" readonly
          placeholder="Total Ticket Price">
      @error('total_price')
          <div class="invalid-feedback">{{ $message }}</div>
      @enderror
  </div>

  <div class="mb-3">
      <label class="form-label d-block">Booking Type</label>
      <div class="form-check form-check-inline">
          <input class="form-check-input @error('booking_type') is-invalid @enderror" type="radio" name="booking_type"
              value="offline" {{ old('booking_type', 'offline') == 'offline' ? 'checked' : '' }}>
          <label class="form-check-label">Offline</label>
      </div>
  </div>
