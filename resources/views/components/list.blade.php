@props(['limit' => null])
<order-reminder-list @if ($limit) v-bind:limit="{{ $limit }}" @endif>
    <div slot-scope="{ orderReminders }">
        <div v-if="orderReminders.length">
            <div v-for="orderReminder in orderReminders" class="overflow-hidden rounded-xl relative border shadow-gray mb-5 pt-5 pb-6 pl-8 pr-6 md:pr-16 not:first-child:mt-5">
                <div class="absolute bg-primary w-1 h-full top-0 left-0"></div>
                <div class="flex max-sm:flex-col">
                    <div class="w-full sm:w-52 text-muted font-medium text-base">
                        @{{ orderReminder.products.length > 1 ? window.config.translations.order_reminder.products : window.config.translations.order_reminder.product }}:
                    </div>
                    <div class="flex flex-col md:flex-1">
                        <a class="text-primary font-medium text-base" v-for="product in orderReminder.products" :href="product.url">
                            @{{ product.name }}
                        </a>
                    </div>
                </div>
                <div class="flex max-sm:flex-col mt-2.5">
                    <div class="w-full sm:w-52 text-muted font-medium text-base">@lang('Next reminder'):</div>
                    <div class="md:flex-1 text font-medium text-base first-letter:uppercase">
                        @{{ new Date(orderReminder.reminder_date).toLocaleDateString(window?.config?.locale?.replace?.('_', '-'), { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' }) }}
                    </div>
                </div>
                <div class="flex max-sm:flex-col mt-2.5">
                    <div class="w-full sm:w-52 text-muted font-medium text-base">@lang('Reminder every'):</div>
                    <div class="md:flex-1 text font-medium text-base">
                        @{{ orderReminder.timespan }} @{{ orderReminder.timespan > 1 ? window.config.translations.order_reminder.weeks : window.config.translations.order_reminder.week }}
                    </div>
                </div>
                <x-rapidez-order-reminder::form products="orderReminder.products" edit />
            </div>
        </div>
    </div>
</order-reminder-list>
