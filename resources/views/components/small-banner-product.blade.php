<!-- Start Small Banner -->
@php
    $products = App\Models\Product::take(1)->get();
@endphp
@foreach ($products as $product)
    <div class="hero-small-banner" style="background-image: url({{ $product->image }});">
        <div class="content">
            <h2>
                <span>New line required</span>
                {{ $product->name }}
            </h2>
            <h3>${{ $product->price }}</h3>
        </div>
    </div>
    <!-- End Small Banner -->
@endforeach
