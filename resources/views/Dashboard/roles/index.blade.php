@extends('layouts.dashboard')

@section('title', 'Roles')

@section('breadcrumb')
    @parent
    <li class="breadcrumb-item active">Roles</li>

@endsection

@section('content')

<div class="mb-5">
    {{-- @if (Auth::user()->can('Roles.create') --}}
    @can('create', 'App\\Models\Role')
    <a href="{{ route('roles.create') }}" class="btn btn-sm btn-outline-primary mr-2">Create</a>
@endcan
    {{-- @endif --}}
    {{-- <a href="{{ route('roles.trash') }}" class="btn btn-sm btn-outline-dark">Trash</a> --}}
</div>

<x-alert type="success" />
<x-alert type="info" />


    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th scope="col">ID</th>
                <th scope="col">Name</th>
                <th scope="col">Created At</th>
                <th colspan="2"></th>
            </tr>
        </thead>
        <tbody>
                @forelse ($roles as $role)
                    <tr>
                        <td>{{ $role->id }}</td>
                        <td><a href="{{ route('roles.show', $role->id) }}">{{ $role->name }}</a></td>
                        <td>{{ $role->created_at }}</td>
                        <td>
                            <!-- Button edit -->
                            @can('update', $role)
                            <a href="{{ route('roles.edit', $role->id) }}" class="btn btn-sm btn-outline-success">Edit</a>
                            @endcan
                            </td>
                        <td>
                            <!-- Form delete role-->
                            @can('delete', $role)
                            <form action="{{ route('roles.destroy', $role->id) }}" method="post">
                                @csrf
                                {{-- Form Method Spoofing --}}
                                <input type="hidden" name="_method" value="delete">
                                @method('delete')
                                <button type="submit" class="btn btn-sm btn-outline-danger">Delete</button>
                            </form>
                            @endcan
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="text-center">No Roles found!</td>
                    </tr>
                @endforelse
        </tbody>
    </table>

    {{ $roles->withQueryString()->links() }}

@endsection
