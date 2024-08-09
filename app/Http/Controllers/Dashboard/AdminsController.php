<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\Role;
use Illuminate\Http\Request;

class AdminsController extends Controller
{

    public function __construct() {
        $this->authorizeResource(Admin::class, 'admin');
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $admin = Admin::paginate();
        return view('admins.index', compact('admins'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admins.create', [
            'roles'=> Role::all(),
            'admin' => new Admin(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name'=> 'required|string|max:255',
            'roles' => 'required|array',
        ]);

        $admin = Admin::create($request->all());
        $admin->roles()->attach($request->roles);

        return redirect()
            ->route('admins.index')
            ->with('success','Admin Created Successfully');
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
    public function edit(Admin $admin)
    {
        $roles = Role::all();
        $admin_roles = $admin->roles()->pluck('id')->toArray();

        return view('admins.edit', compact('admin', 'roles', 'admin_roles'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Admin $admin)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'roles' => 'required|array',
        ]);

        $admin->update($request->all());
        $admin->roles()->sync($request->roles);

        return redirect()
            ->route('admins.index')
            ->with('success','Admin updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        Admin::destroy($id);
        return redirect()
            ->route('admins.index')
            ->with('success','');
    }
}
