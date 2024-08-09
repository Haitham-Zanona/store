@extends('layouts.dashboard')

@section('title', 'Import Products')

@section('breadcrumb')
    @parent
    <li class="breadcrumb-item active">Import Products</li>

@endsection

@section('content')

    <!-- Main content -->
    <form action="{{ route('products.import') }}" method="post" enctype="multipart/form-data">
        @csrf

        <div class="form-group">
            <x-form.input label="Product Count" class="form-control-lg" name="count" />
        </div>

        <button type="submit" class="btn btn-primary">Start Import...</button>

        {{-- @include('Dashboard.products._form') --}}
    </form>

@endsection
