@extends('User.layout.partials.master')

@section('title', 'Eventify - Home')

@section('content')
    <section class="hero-section text-white" style="padding-top:70px;">
        @include('User.home.slider')
    </section>

    @include('User.about.index')

    @include('User.event.index')
@endsection
