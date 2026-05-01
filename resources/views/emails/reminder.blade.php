@component('mail::message')
# @lang('Your order reminder!')

@lang('We would like to remind you of the products you have previously shown interest in. Below is a list of these products.')

<x-rapidez-order-reminder::email.products :products="$orderReminder->products" />

@lang('Click the button below to quickly and easily order these products.')

<x-rapidez::button.conversion class="add-to-cart" href="{{ route('cart', ['skus' => $orderReminder->products->pluck('sku')]) }} }}">@lang('Add to cart')</x-rapidez::button.conversion>
<x-rapidez::button.outline class="unsubscribe" href="{{ $unsubscribeUrl }}">@lang('Unsubscribe from order reminders')</x-rapidez::button.outline>
@endcomponent
