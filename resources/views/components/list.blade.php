@props(['limit' => null])
<order-reminder-list @if ($limit) v-bind:limit="{{ $limit }}" @endif>
    <div slot-scope="{ orderReminders }">
        <div v-if="orderReminders.length">
            <div v-for="orderReminder in orderReminders" class="overflow-hidden rounded-xl relative border shadow-gray mb-5 pt-5 pb-6 pl-8 pr-6 md:pr-16 not:first-child:mt-5">
                <div class="absolute bg-primary w-1 h-full top-0 left-0"></div>
                <div class="flex flex-col sm:flex-row">
                    <div class="w-full sm:w-[202px] text-inactive font-medium text-16">
                        @{{ window.config.translations.order_reminder.product[+(orderReminder.products.length !== 1)] }}:
                    </div>
                    <div class="flex flex-col md:flex-1">
                        <a class="text-primary font-medium text-16" v-for="product in orderReminder.products" :href="product.url">
                            @{{ product.name }}
                        </a>
                    </div>
                </div>
                <div class="flex flex-col sm:flex-row mt-2.5">
                    <div class="w-full sm:w-[202px] text-inactive font-medium text-16">@lang('Next reminder'):</div>
                    <div class="md:flex-1 text-neutral font-medium text-16 first-letter:uppercase">
                        @{{ new Date(orderReminder.reminder_date).toLocaleDateString('nl-NL', { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' }) }}
                    </div>
                </div>
                <div class="flex flex-col sm:flex-row mt-2.5">
                    <div class="w-full sm:w-[202px] text-inactive font-medium text-16">@lang('Reminder every'):</div>
                    <div class="md:flex-1 text-neutral font-medium text-16">
                        @{{ orderReminder.timespan }} @{{ window.config.translations.order_reminder.week[+(orderReminder.timespan !== 1)] }}
                    </div>
                </div>
                <x-rapidez-order-reminder::form products="orderReminder.products" edit />
            </div>
        </div>
    </div>
</order-reminder-list>
