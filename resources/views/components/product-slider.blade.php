@php
    $products = App\Models\Product::take(4)->get();
@endphp


@foreach ($products as $product)
    <div class="single-slider" style="background-image: url({{ $product->image }});">
        <div class="content">
            @if ($product->sale_percent)
                {{-- <span class="sale-tag">-{{ $product->sale_percent }}</span> --}}

                <h2><span>No restocking fee (${{ $product->sale_percent }} savings)</span>
                    {{ $product->name }}
                </h2>
                {{-- <h2><span>Big Sale Offer</span>
                    Get the Best Deal on CCTV Camera
                </h2> --}}
            @endif
            <p>{{ $product->description }}</p>
            <h3><span>Now Only:</span> ${{ $product->price }}</h3>
            <div class="button">
                <a href="{{ route('product.show', $product->slug) }}" class="btn">Shop Now</a>
            </div>
        </div>
    </div>
@endforeach
