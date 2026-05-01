<?php

namespace Rapidez\OrderReminder\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Rapidez\Core\Models\Customer;
use Rapidez\Core\Models\Product;
use Rapidez\Core\Models\Scopes\Product\WithProductStockScope;

class OrderReminder extends Model
{
    protected $guarded = [];

    protected $appends = ['reminder_date'];

    protected $casts = [
        'renewal_date' => 'datetime',
        'timespan' => 'integer',
    ];

    protected static function booted(): void
    {
        static::saving(function (OrderReminder $orderReminder) {
            $orderReminder->renewal_date = now()->is(config('rapidez-order-reminder.cron_day')) ? now() : now()->next(config('rapidez-order-reminder.cron_day'));
        });
    }

    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class);
    }

    public function products(): BelongsToMany
    {
        return $this->belongsToMany(Product::class, 'order_reminder_product', 'order_reminder_id', 'product_sku', 'id', 'sku')
            ->withoutGlobalScopes()
            ->withGlobalScope(WithProductStockScope::class, new WithProductStockScope);
    }

    public function reminderDate(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->renewal_date?->addWeeks($this->timespan)
        );
    }
}
