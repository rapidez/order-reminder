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
                    <a href="{{ config('app.url').$product->url }}">
                        <img
                            src="{{ config('app.url').'/storage/' . config('rapidez.store') . '/resizes/80x80/magento/catalog/product'.$product->thumbnail.'.webp' }}"
                            alt="{{ $product->name }}"
                        >
                    </a>
                </td>
                <td>
                    <a href="{{ config('app.url').$product->url }}">
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
