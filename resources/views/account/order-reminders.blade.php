@extends('rapidez::account.partials.layout')

@section('title', __('My orders reminders'))

@section('robots', 'NOINDEX,NOFOLLOW')

@section('account-content')
    <div class="container">
        <div class="w-full relative mb-6 mt-12 sm:mt-4">
            <h1 class="ml-9 sm:ml-0">@lang('Order reminders')</h1>
        </div>
        <x-rapidez-order-reminder::list />
        <x-rapidez-order-reminder::description />
    </div>
@endsection
