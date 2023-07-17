@extends('layouts.dashboard')

@section('title', 'Categories')

@section('breadcrumb')
    @parent
    <li class="breadcrumb-item active">Categories</li>

@endsection

@section('content')

    <!-- Main content -->
    <form action="{{ route('categories.store') }}" method="post">
        @csrf
        <div class="form-group">
            <label for="">Category Name</label>
            <input type="text" name="name" class="form-control form-select">
        </div>
        <div class="form-group">
            <label for="">Category Parent</label>
            <select name="parent_id" class="form-control">
                <option value="">Primary Category</option>
                @foreach ($parents as $parent)
                    <option value="{{ $parent->id }}">{{ $parent->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="form-group">
            <label for="">Description</label>
            <textarea name="description" class="form-control form-select"></textarea>
        </div>
        <div class="form-group">
            <label for="">Image</label>
            <input type="file" name="image" class="form-control form-select">
        </div>
        <div class="form-group">
            <label for="">Status</label>
            <div>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="status" value="active" checked>
                    <label class="form-check-label" for="flexRadioDefault1">
                        Active
                    </label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="status" value="archived">
                    <label class="form-check-label">
                        Archived
                    </label>
                </div>
            </div>
        </div>
        <div class="form-group">
            <button type="submit" class="btn btn-primary mt-2 mb-3">Save</button>
        </div>
    </form>

@endsection
