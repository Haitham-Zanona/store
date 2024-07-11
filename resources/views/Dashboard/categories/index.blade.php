@extends('layouts.dashboard')

@section('title', 'Categories')

@section('breadcrumb')
    @parent
    <li class="breadcrumb-item active">Categories</li>

@endsection

@section('content')

<div class="mb-5">
    {{-- @if (Auth::user()->can('categories.create') --}}
    @can('categories.create')

    <a href="{{ route('categories.create') }}" class="btn btn-sm btn-outline-primary mr-2">Create</a>
@endcan
    {{-- @endif --}}
    <a href="{{ route('categories.trash') }}" class="btn btn-sm btn-outline-dark">Trash</a>
</div>

<x-alert type="success" />
<x-alert type="info" />

<form action="{{ URL::current() }}" method="get" class="d-flex jusify-content-between mb-4">

    <x-form.input name="name" placeholder="Name" class="mx-2" :value="request('name')" />
    <select name="status" class="form-control mx-2">
        <option value="">All</option>
        <option value="active" @selected(request('status') == 'active')>Active</option>
        <option value="archived" @selected(request('status') == 'archived')>Archived</option>
    </select>
    <button class="btn btn-dark mx-2">Filter</button>

</form>

    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th scope="col">Image</th>
                <th scope="col">ID</th>
                <th scope="col">Name</th>
                <th scope="col">Parent</th>
                <th scope="col">Products #</th>
                <th scope="col">Status</th>
                <th scope="col">Created At</th>
                <th colspan="2" scope="col">Actions</th>
            </tr>
        </thead>
        <tbody>
                @forelse ($categories as $category)
                    <tr>
                        <td><img src="{{ asset('storage/' . $category->image) }}" alt="" height="50"></td>
                        <td>{{ $category->id }}</td>
                        <td><a href="{{ route('categories.show', $category->id) }}">{{ $category->name }}</a></td>
                        <td>{{ $category->parent->name}}</td>
                        <td>{{ $category->products_count }}</td>
                        <td>{{ $category->status }}</td>
                        <td>{{ $category->created_at }}</td>
                        <td>
                            <!-- Button edit -->
                            @can('categories.update')
                            <a href="{{ route('categories.edit', $category->id) }}" class="btn btn-sm btn-outline-success">Edit</a>
                            @endcan
                            </td>
                        <td>
                            <!-- Form delete category-->
                            <form action="{{ route('categories.destroy', $category->id) }}" method="post">
                                @csrf
                                {{-- Form Method Spoofing --}}
                                {{-- <input type="hidden" name="_method" value="delete"> --}}
                                @method('delete')
                                <button type="submit" class="btn btn-sm btn-outline-danger">Delete</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="9" class="text-center">No categories found!</td>
                    </tr>
                @endforelse
        </tbody>
    </table>

    {{ $categories->withQueryString()->appends(['search'=> 1])->links() }}

@endsection
