@extends('layouts.app')

@section('title', 'Aderose Glowing Salon')
@section('meta_description', 'Aderose Glowing Salon menghadirkan hair spa, facial, nail art, make up, body spa, dan
perawatan premium dengan beautician profesional.')

@section('content')
@include('partials.hero')
@include('partials.about')
@include('partials.services')
@include('partials.gallery')
@include('partials.pricing')
@include('partials.testimonials')
@include('partials.team')
@include('partials.booking')
@include('partials.faq')
@include('partials.contact')
@include('partials.checkout-modal')
@endsection