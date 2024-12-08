@php
    $products = App\Models\Product::paginate(2);
@endphp
@foreach ($products as $product)
    <div class="col-lg-6 col-md-6 col-12">
        <div class="single-banner" style="background-image:url({{ $product->image }})">
            <div class="content">
                <h2>{{ $product->name }}</h2>
                <p>{{ $product->description }} with <br>{{ $product->store->name }} </p>
                <div class="button">
                    <a href="{{ route('product.show', $product->slug) }}" class="btn">View Details</a>
                </div>
            </div>
        </div>
    </div>
@endforeach
