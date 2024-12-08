@php
    $stores = $products = App\Models\Store::all();
@endphp
@foreach ($stores as $store)
    <div class="brand-logo">
        <img src="{{ $store->logo_image }}" alt="#">
    </div>
@endforeach
