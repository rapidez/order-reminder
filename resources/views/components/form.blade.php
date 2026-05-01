@props([
    'products',
    'key' => 'sku',
    'edit' => false,
    'noEmail' => false,
    'defaultTimespan' => 1
])
<order-reminder-form
    :product-skus="{{ $products.'.'.$key.' ? ['.$products.'.'.$key.'] : Object.values('.$products.').map(item => item.'.$key.')' }}"
    @if($edit)
        :order-reminder="orderReminder"
    @endif
    :default-timespan="{{ $defaultTimespan }}"
    v-cloak
>
    <div slot-scope="{ toggleForm, show, variables, submitForm, submitDelete }">
        <div v-if="show" class="relative z-slideover">
            <div class="fixed inset-0 z-slideover-overlay pointer-events-auto bg-backdrop transition-opacity"></div>
            <div class="fixed inset-0 flex items-center z-slideover-sidebar mx-4 sm:mx-auto">
                <div class="relative bg-white flex flex-col mx-auto my-8 align-middle shadow-black rounded-6 overflow-hidden" v-on-click-away="toggleForm">
                    <div class="flex w-full sm:w-[500px]">
                        <div class="w-full max-sm:mx-4">
                            <div class="flex items-center justify-between bg-primary pt-7 pb-7 pl-3.5 pr-3 sm:pl-10 sm:pr-9">
                                <h2 class="text-white text-lg font-medium">
                                    @lang('Order reminder')
                                </h2>
                                <div class="text-white" v-on:click="toggleForm">
                                    <x-heroicon-o-x-mark class="w-6" />
                                </div>
                            </div>
                            <div class="mt-7">
                                <form class="flex flex-col flex-1" v-on:submit.prevent="submitForm()">
                                    <div class="px-4 sm:px-10">
                                        @if(!$edit && !$noEmail)
                                            <div class="mb-6">
                                                <label>
                                                    <x-rapidez::label>@lang('Email')</x-rapidez::label>
                                                    <x-rapidez::input v-model="variables.email" name="email" type="email" required />
                                                </label>
                                            </div>
                                        @endif
                                        <label>
                                            <x-rapidez::label>@lang('Timespan')</x-rapidez::label>
                                            <x-rapidez::input.select name="timespan" v-model="variables.timespan" required>
                                                @foreach(config('rapidez-order-reminder.timespans') as $index)
                                                    <option :value="{{ $index }}">
                                                        <span>@lang('Every')</span>
                                                        <span>@choice('week|:count weeks', $index)</span>
                                                    </option>
                                                @endforeach
                                            </x-rapidez::input.select>
                                        </label>
                                        <ul class="max-h-40 overflow-x-auto scrollbar-hide pl-1 pt-1 mt-5 pb-7 space-y-3">
                                            <li v-for="product in ({{ $products }}.{{ $key }} ? [{{ $products }}] : {{ $products }})">
                                                <label>
                                                    <x-rapidez::input.checkbox.base
                                                        v-model="variables.products"
                                                        ::value="product.{{ $key }}"
                                                        ::disabled="{{ $products }}.{{ $key }} || Object.keys({{ $products }}).length == 1"
                                                    />
                                                    @{{ product.name ?? product.product_name }}
                                                </label>
                                            </li>
                                        </ul>
                                    </div>
                                    <div class="flex flex-wrap-reverse items-center gap-y-4 border-t py-7 px-4 justify-end sm:px-10">
                                        @if($edit)
                                            <button
                                                v-on:click="submitDelete"
                                                class="inline-flex items-center justify-center disabled:opacity-50 disabled:cursor-not-allowed py-0.5 text underline transition hover:no-underline"
                                            >
                                                @lang('Delete')
                                            </button>
                                        @endif
                                        <x-rapidez::button.outline v-on:click="toggleForm">
                                            @lang('Close')
                                        </x-rapidez::button.outline>
                                        <x-rapidez::button.conversion
                                            type="submit"
                                            class="group ml-4 md:ml-7"
                                            ::disabled="$root.loading"
                                        >
                                            <span v-if="!$root.loading" class="flex items-center gap-x-2.5">
                                                <x-heroicon-o-bell class="size-3.5 group-hover:animate-wiggle origin-[50%_25%]" />
                                                @lang('Save reminder')
                                            </span>
                                            <span v-else class="flex items-center gap-x-2.5">
                                                <x-heroicon-o-arrow-path class="size-3.5 animate-spin" />
                                                @lang('Saving')...
                                            </span>
                                        </x-rapidez::button.conversion>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div
            class="flex items-center font-medium text-muted cursor-pointer group gap-x-2"
            aria-label="{{ __('Order reminder') }}"
            v-on:click="toggleForm()"
            v-bind:disabled="$root.loading"
        >
            @if($edit)
                <x-heroicon-o-ellipsis-horizontal class="absolute top-6 right-6" />
            @else
                <x-heroicon-o-bell class="size-4 group-hover:animate-wiggle origin-[50%_25%]" />
                <span class="text-sm">@lang('Order reminder')</span>
            @endif
        </div>
    </div>
</order-reminder-form>
