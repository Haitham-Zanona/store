@php
    $categories = App\Models\Category::take(6)->get();
    $products = App\Models\Product::with('category')->active()->paginate(4);
@endphp

@foreach ($categories as $category)
    <div class="col-lg-4 col-md-6 col-12 featured-categories" style="background-image: url({{ $category->image }});">
        <!-- Start Single Category -->
        <div class="single-category">
            <h3 class="heading">{{ $category->name }}</h3>
            <ul>
                @foreach ($products as $product)
                    <li><a href="{{ route('product.show', $product->slug) }}">{{ $product->name }}</a></li>
                @endforeach
                {{-- <li><a href="product-grids.html">QLED TV</a></li>
                <li><a href="product-grids.html">Audios</a></li>
                <li><a href="product-grids.html">Headphones</a></li> --}}
                <li><a href="product-grids.html">View All</a></li>
            </ul>
            {{-- <div class="images">
                <img src="{{ $category->image }}" alt="#">
            </div> --}}
        </div>
        <!-- End Single Category -->
    </div>
@endforeach
