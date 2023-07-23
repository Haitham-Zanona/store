@extends('layouts.dashboard')

@section('title', 'Categories')

@section('breadcrumb')
    @parent
    <li class="breadcrumb-item active">Categories</li>

@endsection

@section('content')

<div class="mb-3">
    <a href="{{ route('categories.create') }}" class="btn btn-sm btn-outline-primary">Create</a>
</div>

@if (session()->has('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif
@if (session()->has('info'))
    <div class="alert alert-info">
        {{ session('info') }}
    </div>
@endif

    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th scope="col">Image</th>
                <th scope="col">ID</th>
                <th scope="col">Name</th>
                <th scope="col">Parent</th>
                <th scope="col">Created At</th>
                <th colspan="2" scope="col">Actions</th>
            </tr>
        </thead>
        <tbody>
                @forelse ($categories as $category)
                    <tr>
                        <td><img src="{{ asset('storage/' . $category->image) }}" alt="" height="50"></td>
                        <td>{{ $category->id }}</td>
                        <td>{{ $category->name }}</td>
                        <td>{{ $category->parent_id }}</td>
                        <td>{{ $category->created_at }}</td>
                        <td>
                            <!-- Button edit -->
                            <a href="{{ route('categories.edit', $category->id) }}" class="btn btn-sm btn-outline-success">Edit</a>
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
                        <td colspan="7" class="text-center">No categories found!</td>
                    </tr>
                @endforelse
        </tbody>
    </table>

@endsection
