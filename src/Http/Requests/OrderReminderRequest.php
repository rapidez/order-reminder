<?php

namespace Rapidez\OrderReminder\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

/**
 * NOTE: Authorization for order reminders is handled by OrderReminderAuthMiddleware.
 * Any route using this request should include the 'order-reminder-auth' middleware.
 */
class OrderReminderRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'email' => 'required|email',
            'timespan' => [
                'required',
                'integer',
                Rule::in(config('rapidez-order-reminder.timespans'))
            ],
            'products' => 'required|array|min:1',
            'products.*' => 'required|exists:catalog_product_entity,sku'
        ];
    }
}
