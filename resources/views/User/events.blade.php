<section id="events" class="py-5">
    <div class="container">
        <h2 class="fw-bold text-center mb-5">🔥 Upcoming Events</h2>
        <div class="row g-4">
            @forelse($events as $event)
                @php
                    $images = json_decode($event->image, true) ?? []; // decode JSON array
                    $firstImage = $images[0];
                @endphp
                <div class="col-md-4">
                    <div class="event-card shadow-sm">
                        <a href="{{ asset('storage/' . $firstImage) }}" data-lightbox="event-{{ $event->id }}">
                            <img src="{{ asset('storage/' . $firstImage) }}" class="w-100" alt="{{ $event->title }}"
                                style="height:280px; object-fit:cover;">
                        </a>

                        {{-- Add hidden images for lightbox --}}
                        @if (count($images) > 1)
                            @foreach (array_slice($images, 1) as $img)
                                <a href="{{ asset('storage/' . $img) }}" data-lightbox="event-{{ $event->id }}"
                                    class="d-none"></a>
                            @endforeach
                        @endif

                        <div class="event-body p-3">
                            <h5 class="d-flex justify-content-between">
                                {{ $event->name }}
                                @if ($event->total_tickets > 0)
                                    <span class="badge bg-success">Available</span>
                                @else
                                    <span class="badge bg-danger">Sold Out</span>
                                @endif
                            </h5>

                            <p>📅 {{ \Carbon\Carbon::parse($event->date)->format('jS M Y') }} <br>
                                📍{{ $event->location }}</p>
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
