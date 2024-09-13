<?php

namespace Rapidez\OrderReminder\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Illuminate\Validation\Rule;
use Illuminate\Validation\UnauthorizedException;
use Rapidez\Core\Models\Customer;

class OrderReminderRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        if (!Customer::firstWhere('email', $this->email)) {
            return true;
        }

        abort_if(auth('magento-customer')->user()?->email !== $this->email, 403);

        return true;
    }

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
