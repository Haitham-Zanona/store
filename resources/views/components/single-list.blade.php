<div class="single-list">
    <div class="list-image">
        <a href="{{ route('product.show', $product->id) }}"><img src="{{ $product->image }}" alt="#"></a>
    </div>
    <div class="list-info">
        <h3>
            <a href="{{ route('product.show', $product->id) }}">{{ $product->name }}</a>
        </h3>
        <span>${{ $product->price }}</span>
    </div>
</div>
