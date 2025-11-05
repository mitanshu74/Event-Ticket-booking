@extends('User.layout.partials.master')

@section('title', 'Eventify - Home')

@section('content')
    <section class="hero-section text-white" style="padding-top:70px;">
        @include('User.slider')
    </section>

    @include('User.about')

    @include('User.events')
@endsection

