<?php

namespace App\Http\Controllers\dashboard;

use App\Models\Category;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;

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
        $category = new Category();

        return view('Dashboard.categories.create', compact('category','parents'));
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


        $data = $request->except('image');
        if ($request->hasFile('image')) {
            $file = $request->file('image'); // UploadedFile Object
            $path = $file->store('uploads', [
                'disk' => 'public'
            ]);
            $data['image'] = $path;

        }



        // Mass assignment
        $category = Category::create($data);

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
        try {
            $category = Category::findOrFail($id);
        } catch (Exception $e) {
            //abort(404);
            return Redirect::route("categories.index")
                ->with('info', 'Record not found!');
        }


        // Using findOrFail instead of if statement
        /* if (!$category) {
            abort(404);
        } */

        /**
        * Select * FROM categories WHERE id <> $id
        * AND (parent_id IS NULL OR parent_id <> $id)
        */
        $parents = Category::where('id', '<>', $id)
            ->where(function($query) use ($id) {
                $query->whereNull('parent_id')
                      ->orWhere('parent_id', '<>', $id);
            })->get();
        return view('Dashboard.categories.edit', compact('category', 'parents'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $category = Category::findOrFail($id);

        $old_image = $category->image;

        $data = $request->except('image');

        if ($request->hasFile('image')) {
            $file = $request->file('image'); // UploadedFile Object
            $path = $file->store('uploads', [
                'disk' => 'public'
            ]);
            $data['image'] = $path;

        }

        // Manuel requests

        // $category->name = $request->name;
        // $category->parent_id = $request->parent_id;
        // .
        // .
        // .
        // $category->save();

        $category->update($data);
        // $category->fill($request->all())->save();

        if ($old_image && isset($data['image'])) {
            Storage::disk('public')->delete($old_image);
        }

        return Redirect::route("categories.index")
                ->with('success', 'Category Updated!');

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $category = Category::findOrFail($id);
        $category->delete();

        if ($category->image) {
            Storage::disk('public')->delete($category->image);
        }

        // Category::where('id', '=', $id)->delete(); //Nest method is a shortcut of this method
        // Category::destroy($id);

        return Redirect::route("categories.index")
                ->with('success', 'Category Deleted!');
    }
}
