<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

// Models
use App\Models\Admin;
use App\Models\User;

class AdminController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $viewData = [
            "title" => "Data Admin",
            "datas" => User::where('role', 'admin')->paginate(10),
        ];

        return view("admin.admin.index", $viewData);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $viewData = [
            "title" => "Tambah Admin",
        ];

        return view('admin.admin.create', $viewData);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255',
            'password' => 'required|string|min:8|confirmed',
        ]);

        DB::beginTransaction();

        try {
            User::create([
                'name' => $validatedData['name'],
                'email' => $validatedData['email'],
                'password' => bcrypt($validatedData['password']),
                'role' => 'admin',
            ]);
            DB::commit();
            return redirect()->route('admin.admin.index')->with('success', 'Admin created successfully');
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->with('error', 'Failed to create admin: ' . $e->getMessage());
        }
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
        $viewData = [
            "title" => "Edit Admin",
            "data" => User::where('id', $id)->first(),
        ];

        return view('admin.admin.edit', $viewData);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        $validatedData = $request->validate([
            'id' => 'required',
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255',
            'password' => 'nullable|string|min:8|confirmed',
        ]);

        DB::beginTransaction();

        try {
            $admin = User::where('id', $validatedData['id'])->first();
            $admin->name = $validatedData['name'];
            $admin->email = $validatedData['email'];
            if (!empty($validatedData['password'])) {
                $admin->password = bcrypt($validatedData['password']);
            }
            $admin->save();

            DB::commit();
            return redirect()->route('admin.admin.index')->with('success', 'Admin updated successfully');
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->with('error', 'Failed to update admin: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        DB::beginTransaction();
        try {
            $admin = User::where('id', $request->id)->first();
            $admin->delete();
            DB::commit();
            return redirect()->route('admin.admin.index')->with('success', 'Admin deleted successfully');
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->with('error', 'Failed to delete admin: ' . $e->getMessage());
        }
    }
}
