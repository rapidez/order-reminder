@extends('rapidez::account.partials.layout')

@section('title', __('My orders reminders'))

@section('robots', 'NOINDEX,NOFOLLOW')

@section('account-content')
    <x-rapidez-order-reminder::list />
    <x-rapidez-order-reminder::description />
@endsection
