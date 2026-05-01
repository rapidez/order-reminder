<?php

namespace Rapidez\OrderReminder\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\URL;
use Rapidez\Core\Models\Customer;
use Rapidez\OrderReminder\Http\Requests\OrderReminderRequest;
use Rapidez\OrderReminder\Mail\ConfirmMailable;
use Rapidez\OrderReminder\Models\OrderReminder;


class OrderReminderController
{
    public function index(Request $request): array
    {
        $customer = auth()->user();

        $orderReminders = OrderReminder::where('email', $customer->email)
            ->where('is_confirmed', true)
            ->with(['products' => function ($query) {
                $query->select(
                    'entity_id',
                    'name',
                    'sku',
                    'url_key',
                    'thumbnail',
                    'price',
                    'special_price'
                );
            }])
            ->orderBy(DB::raw('DATE_ADD(renewal_date, INTERVAL timespan WEEK)'))
            ->limit($request->query('limit', null))
            ->get();

        return compact('orderReminders');
    }

    public function store(OrderReminderRequest $request): array
    {
        $orderData = $request->safe(['email', 'timespan']);
        $orderData['locale'] = App::getLocale();
        $orderReminder = OrderReminder::create($orderData);
        $orderReminder->products()->sync($request->products);

        $orderReminder->load(['products' => fn ($query) => $query->select(
            'entity_id',
            'name',
            'sku',
            'url_key',
            'thumbnail',
            'price',
            'special_price'
        )]);

        Mail::to($request->email)->send(new ConfirmMailable($orderReminder, URL::signedRoute(
            'rapidez-order-reminder.confirm',
            compact('orderReminder')
        )));

        return compact('orderReminder');
    }

    public function update(OrderReminderRequest $request, OrderReminder $orderReminder): array
    {
        $orderReminder->update($request->safe(['timespan']));
        $orderReminder->products()->sync($request->products);

        return compact('orderReminder');
    }

    public function confirm(OrderReminder $orderReminder)
    {
        $orderReminder->update([
            'is_confirmed' => true
        ]);

        $notification = [
            'message' => __(
                'Your order reminder has been confirmed! You will receive a reminder with the selected products every :weeks. You will receive the first email on :reminder_date in your inbox.', [
                    'weeks' => trans_choice('week|:count weeks', $orderReminder->timespan),
                    'reminder_date' => Carbon::createFromDate($orderReminder->reminder_date)->locale(app()->getLocale())->isoFormat('dddd D MMMM YYYY')
                ]
            ),
            'type' => 'success',
            'show' => true
        ];

        $notifications = session()->get('notifications', []);
        $notifications[] = $notification;

        return redirect('/')->with(['notifications' => $notifications]);
    }

    public function destroy(OrderReminder $orderReminder)
    {
        $orderReminder->delete();
    }

    public function unsubscribe(OrderReminder $orderReminder)
    {
        $orderReminder->delete();

        $notification = [
            'message' => __('Your order reminder has been deleted. You will no longer receive reminders for this.'),
            'type' => 'success',
            'show' => true
        ];

        $notifications = session()->get('notifications', []);
        $notifications[] = $notification;

        return redirect('/')->with(['notifications' => $notifications]);
    }
}
