@extends('layouts.dashboard')

@section('title', 'create Role')

@section('breadcrumb')
    @parent
    <li class="breadcrumb-item active">Roles</li>

@endsection

@section('content')

    <!-- Main content -->
    <form action="{{ route('roles.store') }}" method="post" enctype="multipart/form-data">
        @csrf

        @include('Dashboard.roles._form')
    </form>

@endsection
