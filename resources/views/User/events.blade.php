<section id="events" class="py-5">
    <div class="container">
        <h2 class="fw-bold text-center mb-5">🔥 Upcoming Events</h2>
        <div class="row g-4">
            @forelse($events as $event)
                <div class="col-md-4">
                    <div class="event-card shadow-sm">
                        <img src="{{ $event->image ? asset('storage/' . $event->image) : 'https://via.placeholder.com/400x250' }}"
                            class="w-100" alt="{{ $event->title }}">
                        <div class="event-body p-3">
                            <h5>{{ $event->name }}</h5>
                            <p>📅 {{ \Carbon\Carbon::parse($event->date)->format('jS M Y') }} <br> 📍
                                {{ $event->location }}</p>
                            <a href="{{ route('user.event.details', $event->id) }}" class="btn btn-gradient w-100">View
                                Details</a>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12 text-center">
                    <p>No upcoming events.</p>
                </div>
            @endforelse
        </div>
    </div>
</section>
