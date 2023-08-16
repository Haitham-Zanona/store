@extends('layouts.dashboard')

@section('title', 'Edit Products')

@section('breadcrumb')
    @parent
    <li class="breadcrumb-item active">Products</li>
    <li class="breadcrumb-item active">Edit Products</li>

@endsection

@section('content')

    <!-- Main content -->
    <form action="{{ route('products.update', $product->id) }}" method="post" enctype="multipart/form-data">
        @csrf
        @method('put')

        @include('dashboard.products._form', [
            'button_label' => 'update'
        ])

    </form>

@endsection
