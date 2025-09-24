@extends('User.layout.partials.master')

@section('title', 'Eventify - Home')

@section('content')
<section class="hero-section text-white" style="padding-top:70px;">
    @include('User.slider')
</section>

<!-- About Section -->
@include('User.about')

<!-- Events Section -->
@include('User.events')
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const el = document.getElementById('heroCarousel');
        if (el && typeof bootstrap !== 'undefined') {
            new bootstrap.Carousel(el, {
                interval: 4500,
                pause: 'hover',
                wrap: true
            });
        }
    });
</script>
@endpush