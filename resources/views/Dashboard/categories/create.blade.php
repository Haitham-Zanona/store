@extends('layouts.dashboard')

@section('title', 'Categories')

@section('breadcrumb')
    @parent
    <li class="breadcrumb-item active">Categories</li>

@endsection

@section('content')

    <!-- Main content -->
    <form action="{{ route('categories.store') }}" method="post" enctype="multipart/form-data">
        @csrf

        @include('Dashboard.categories._form')
    </form>

@endsection
