<label class="cursor-pointer font-sans rounded-md relative flex items-center justify-center border py-2 has-[:checked]:bg-primary/10 has-[:checked]:border-primary md:py-4">
    <x-rapidez::input.radio.base name="reminder" id="{{ $index }}" value="{{ $index }}" v-model="variables.timespan" class="peer absolute top-1/2 left-1/2 opacity-0"/>
    <span class="opacity-0 peer-checked:opacity-100 flex items-center justify-center absolute -right-2 -top-2 size-6 bg-primary rounded-full">
        <x-heroicon-s-check class="size-4 text-white" stroke-width="2"/>
    </span>
    <span class="flex flex-col items-center justify-center">
        <span class="text-sm text-muted">@lang('Every')</span>
        <span class="text-sm text font-medium -mt-0.5">@choice('week|:count weeks', $index)</span>
    </span>
</label>
