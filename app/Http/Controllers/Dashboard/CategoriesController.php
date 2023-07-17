<?php

namespace App\Http\Controllers\dashboard;

use App\Models\Category;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Redirect;

class CategoriesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories = Category::all();  // Return collection object

        return view('Dashboard.categories.index', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $parents = Category::all();

        return view('Dashboard.categories.create', compact('parents'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // $request->input('name');
        // $request->post('name');
        // $request->query('name');
        // $request->get('name');
        // $request->name;
        // $request['name'];

        // $request->all(); // Return array of all input data
        // $request->only(['name', 'parent_id']);
        // $request->except(['image', 'status']);

        // Request merge
        $request->merge([
            "slug" => Str::slug($request->post('name'))
        ]);

        // Mass assignment
        $category = Category::create($request->all());

        // PRG
        return Redirect::route("categories.index")
                ->with('success', 'Category Created!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
