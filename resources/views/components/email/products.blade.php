@props(['products'])
<table>
    <thead>
        <tr>
            <th></th>
            <th>@lang('Product')</th>
            <th>@lang('Price')</th>
        </tr>
    </thead>
    <tbody>
        @foreach($products as $product)
            <tr>
                <td>
                    <a href="{{ url($product->url) }}">
                        <img
                            src="{{ route('resized-image'. [
                                'store' => config('rapidez.store'),
                                'size' => '80',
                                'placeholder' => 'magento',
                                'file' => 'catalog/product'.$product->thumbnail
                            ]) }}"
                            alt="{{ $product->name }}"
                        >
                    </a>
                </td>
                <td>
                    <a href="{{ url($product->url) }}">
                        {{ $product->name }}
                    </a>
                </td>
                <td>
                    <p>{{ price($product->special_price ?? $product->price) }}</p>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
