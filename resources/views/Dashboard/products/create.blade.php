@extends('layouts.dashboard')

@section('title', 'Products')

@section('breadcrumb')
    @parent
    <li class="breadcrumb-item active">Products</li>

@endsection

@section('content')

    <!-- Main content -->
    <form action="{{ route('products.store') }}" method="post" enctype="multipart/form-data">
        @csrf

        @include('Dashboard.products._form')
    </form>

@endsection
