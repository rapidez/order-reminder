@props(['productSku', 'defaultTimespan' => 1])

<order-reminder-form :product-skus="['{{ $productSku }}']" :default-timespan="{{ $defaultTimespan }}" v-cloak>
    <div id="order-reminder" slot-scope="{ variables, submitForm }">
        <div class="text text-base font-medium mb-4">
            @lang('Set your order reminder:')
            <template v-if="variables.timespan > 1">
                <span class="text-muted font-normal">(@{{ variables.timespan }} @lang('weeks'))</span>
            </template>
            <template v-else>
                <span class="text-muted font-normal">(@lang('Every week'))</span>
            </template>
        </div>
        <form class="flex flex-col gap-4" v-on:submit.prevent="submitForm">
            <div class="grid grid-cols-2 sm:grid-cols-3 gap-4">
                @foreach(config('rapidez-order-reminder.timespans') as $index)
                    <x-rapidez-order-reminder::input.radio-tile :index="$index" />
                @endforeach
            </div>
            <div class="w-full relative">
                <x-rapidez::input
                    v-model="variables.email"
                    id="email"
                    name="email"
                    type="text"
                    :placeholder="__('Enter your email address here')"
                />
                <x-heroicon-o-bell class="absolute mt-0.5 right-6 top-1/2 -translate-y-1/2 size-5" />
            </div>
            <x-rapidez::button.conversion class="col-span-2 sm:col-span-3 mt-1">@lang('Set order reminder')</x-rapidez::button.conversion>
        </form>
    </div>
</order-reminder-form>
