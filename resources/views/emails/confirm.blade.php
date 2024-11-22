@component('mail::message')
# @lang('Your order reminder!')

@lang('Thank you for creating your order reminder. We have received your request and would like to let you know that we have registered your request. To activate the order reminder, simply click on the button below:')

<x-rapidez::button class="add-to-cart" href="{{ $confirmUrl }}">@lang('Confirm Order Reminder')</x-rapidez::button>

@lang('After confirmation, you will receive a reminder every <strong>:interval</strong> with the following products:', ['interval' => trans_choice('week|:count weeks', $orderReminder->timespan)])

<x-rapidez-order-reminder::email.products :products="$orderReminder->products" />

@lang('You will receive the first email on <strong>:date</strong>.', ['date' => $orderReminder->reminder_date->isoFormat('dddd D MMMM YYYY')])
@endcomponent
