<?php

namespace Rapidez\OrderReminder\Http\ViewComposers;

use Illuminate\Support\Facades\Config;
use Illuminate\View\View;

class ConfigComposer
{
    public function compose(View $view)
    {
        Config::set('frontend.order_reminder.translations', __('rapidez-order-reminder::frontend.order_reminder'));
    }
}
