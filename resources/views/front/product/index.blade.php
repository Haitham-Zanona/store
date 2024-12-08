<x-front-layout :title="__('Products')">

    <x-slot:breadcrumb>
        <div class="breadcrumbs">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-lg-6 col-md-6 col-12">
                        <div class="breadcrumbs-content">
                            <h1 class="page-title">{{ __('Products') }}</h1>
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-6 col-12">
                        <ul class="breadcrumb-nav">
                            <li><a href="{{ route('home') }}"><i class="lni lni-home"></i> Home</a></li>
                            <li><a href="{{ route('products.index') }}">Shop</a></li>
                            <li>{{ __('Products') }}</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </x-slot:breadcrumb>

    <form action="{{ URL::current() }}" method="get" class="mb-4 d-flex jusify-content-between">

        <x-form.input name="name" placeholder="Name" class="mx-2" :value="request('name')" />
        <select name="status" class="mx-2 form-control">
            <option value="">All</option>
            <option value="active" @selected(request('status') == 'active')>Active</option>
            <option value="archived" @selected(request('status') == 'archived')>Archived</option>
        </select>
        <button class="mx-2 btn btn-dark">Filter</button>

    </form>
    <!-- Start product show -->
    <div class="product-header">
        <div class="tags">
            <button class="tag" data-category="all">All</button>
            @foreach ($categories as $category)
                <button class="tag" data-category="{{ $category->name }}">{{ $category->name }}</button>
            @endforeach
            {{-- <button class="tag" data-category="fashion">Fashion</button> --}}
            {{-- <button class="tag" data-category="home-appliances">Home Appliances</button> --}}
        </div>
    </div>
    <div class="product-grid" id="product-grid">
        <!-- Products will be dynamically loaded here -->


        <div class="row">
            @foreach ($products as $product)
                <div class="col-lg-3 col-md-6 col-12 product-grid" id="product-grid">
                    <!-- Start Single Product -->
                    <x-product-card :product="$product" />
                    <!-- End Single Product -->
                </div>
            @endforeach
        </div>
    </div>
    <!-- end product show -->
    <div class="my-3 d-flex justify-content-center">
        {{ $products->withQueryString()->appends(['search' => 1])->links() }}
    </div>

    <script>
        const tags = document.querySelectorAll(".tag");

        tags.forEach((tag) => {
            tag.addEventListener("click", () => {
                const category = tag.getAttribute("data-category");

                fetch(`/get-products?category=${category}`, {
                        method: "GET",
                        headers: {
                            "X-Requested-With": "XMLHttpRequest",
                        },
                    })
                    .then((response) => response.json())
                    .then((data) => {
                        const productGrid = document.getElementById("product-grid");
                        productGrid.innerHTML = ""; // Clear existing products

                        data.products.forEach((product) => {
                            productGrid.innerHTML += `
                        <div class="product">
                            <h3>${product.name}</h3>
                        </div>
                    `;
                        });

                        // Highlight the active tag
                        tags.forEach((tag) => tag.classList.remove("active"));
                        tag.classList.add("active");
                    })
                    .catch((error) => console.error("Error fetching products:", error));
            });
        });
    </script>
</x-front-layout>
