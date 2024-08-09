@extends('layouts.dashboard')

@section('title', 'Edit Roles')

@section('breadcrumb')
    @parent
    <li class="breadcrumb-item active">Roles</li>
    <li class="breadcrumb-item active">Edit Roles</li>

@endsection

@section('content')

    <!-- Main content -->
    <form action="{{ route('roles.update', $role->id) }}" method="post" enctype="multipart/form-data">
        @csrf
        @method('put')

        @include('dashboard.roles._form', [
            'button_label' => 'update'
        ])

    </form>

@endsection
