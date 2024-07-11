<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\Category;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\CategoryRequest;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;

class CategoriesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        if (!Gate::allows('categories.view')) {
            abort(403);
        }

        /* Filter code */
        $request = request();

        // SELECT a.*, b.name FROM categories as a
        // LEFT JOIN categories as b ON b.id = a.parent_id

        $categories = Category::with('parent')
            /* leftJoin('categories as parents', 'parents.id', '=', 'categories.parent_id')
            ->select([
                'categories.*',
                'parents.name as parent_name'
            ]) */
            //->select('categories.*')
            //->selectRaw('(SELECT COUNT(*) FROM products WHERE AND status = 'active' AND category_id = categories.id) as products_count')
            //->addSelect(DB::raw('(SELECT COUNT(*) FROM products WHERE category_id = categories.id) as products_count'))
            //->withCount('products')
            //->withCount('products as products_number')    When you have different column name of products_count
            ->withCount([
                'products'=>function ($query){
                    $query->where('status','=', 'active');}
            ])
            ->filter($request->query())
            ->orderBy('categories.name')
            ->withTrashed()
            ->paginate(10);

        // $categories = Category::all();  // Return collection object

        // $categories = $query->paginate(2); //Maximum 15 records return and you can put any number under 15 between () to control the number

        // $categories = Category::simplePaginate(2); //using previous and next not number of record's pages

        // $categories = Category::active()->paginate();
        // $categories = Category::status('active')->paginate();

        return view('Dashboard.categories.index', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        if (Gate::denies('categories.create')) {
            abort(403);
        }
        $parents = Category::all();
        $category = new Category();

        return view('Dashboard.categories.create', compact('category', 'parents'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        /* if (Gate::denies('categories.create')) {
            abort(403);
        } */

        Gate::authorize('categories.create');

        // $request->input('name');
        // $request->post('name');
        // $request->query('name');
        // $request->get('name');
        // $request->name;
        // $request['name'];

        // $request->all(); // Return array of all input data
        // $request->only(['name', 'parent_id']);
        // $request->except(['image', 'status']);


        $clean_data = $request->validate(Category::rules(), [
            'required' => 'This field (:attribute) is required',
            'unique' => 'This name is already exists!', // you can use it for a specific field so write field name before unique like (name.unique)
        ]);

        // Request merge
        $request->merge([
            "slug" => Str::slug($request->post('name'))
        ]);


        $data = $request->except('image');

        $data['image'] = $this->uploadImage($request);





        // Mass assignment
        $category = Category::create($data);

        // PRG
        return Redirect::route("categories.index")
            ->with('success', 'Category Created!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Category $category)
    {
        if (Gate::denies('categories.view')) {
            abort(403);
        }
        return view('dashboard.categories.show', [
            'category' => $category,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        Gate::authorize('categories.update');

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
            ->where(function ($query) use ($id) {
                $query->whereNull('parent_id')
                    ->orWhere('parent_id', '<>', $id);
            })->get();
        return view('Dashboard.categories.edit', compact('category', 'parents'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CategoryRequest $request, $id)
    {

        // $request->validate(Category::rules($id));

        $category = Category::findOrFail($id);

        $old_image = $category->image;

        $data = $request->except('image');
        $new_image = $this->uploadImage($request);
        if ($new_image) {
            $data['image'] = $new_image;
        }

        $category->update($data);
        // $category->fill($request->all())->save();

        if ($old_image && $new_image) {
            Storage::disk('public')->delete($old_image);
        }

        return Redirect::route("categories.index")
            ->with('success', 'Category Updated!');


        /* $file->getClientOriginalName();
            $file->getSize();
            $file->getMimeType();
            $file->getClientOriginalExtension(); */ // Use for validation




        // Manuel requests

        // $category->name = $request->name;
        // $category->parent_id = $request->parent_id;
        // .
        // .
        // .
        // $category->save();


    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        Gate::authorize('categories.delete');

        $category = Category::findOrFail($id);
        $category->delete();

        /* if ($category->image) {
            Storage::disk('public')->delete($category->image);
        } */

        // Category::where('id', '=', $id)->delete(); //Nest method is a shortcut of this method
        // Category::destroy($id);

        return Redirect::route("categories.index")
            ->with('success', 'Category Deleted!');
    }

    protected function uploadImage(Request $request)
    {
        if (!$request->hasFile('image')) {
            return;
        }
        $file = request()->file('image');
        $path = $file->store('uploads', [
            'disk' => 'public'
        ]);
        return $path;
    }

    public function trash()
    {
        $categories = Category::onlyTrashed()->paginate();
        return view('dashboard.categories.trash', compact('categories'));
    }
    public function restore(Request $request, $id)
    {
        $category = Category::onlyTrashed()->findOrFail($id);
        $category->restore();

        return redirect()->route('categories.trash')
            ->with('success', 'Category restored!');
    }
    public function forceDelete($id)
    {
        $category = Category::onlyTrashed()->findOrFail($id);
        $category->forceDelete();

        if ($category->image) {
            Storage::disk('public')->delete($category->image);
        }

        return redirect()->route('categories.trash')
            ->with('success', 'Category delete forever!');
    }
}
