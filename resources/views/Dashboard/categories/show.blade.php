@extends('layouts.dashboard')

@section('title', $category->name)

@section('breadcrumb')
    @parent
    <li class="breadcrumb-item active">Categories</li>
    <li class="breadcrumb-item active">{{ $category->name }}</li>

@endsection

@section('content')

    <!-- Main content -->
    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th scope="col">Image</th>
                <th scope="col">Name</th>
                <th scope="col">Store</th>
                <th scope="col">Status</th>
                <th scope="col">Created At</th>
            </tr>
        </thead>
        <tbody>
            @php
                $products = $category->products()->with('store')->latest()->paginate(1);
            @endphp
            @forelse ($products as $product) <!-- products without () that return collection of products but with () it return the relationship itself to apply conditions -->
                <tr>
                    <td><img src="{{ asset('storage/' . $product->image) }}" alt="" height="50"></td>
                    <td>{{ $product->name }}</td>
                    <td>{{ $product->store->name }}</td>
                    <td>{{ $product->status }}</td>
                    <td>{{ $product->created_at }}</td>

                </tr>
            @empty
                <tr>
                    <td colspan="5" class="text-center">No Products found!</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    {{ $products->links() }}
@endsection
