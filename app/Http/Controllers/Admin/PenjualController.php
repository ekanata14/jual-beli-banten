<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

// Models
use App\Models\Admin;
use App\Models\Penjual;

class PenjualController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $viewData = [
            "title" => "Data Penjual",
            "datas" => Admin::where('role', 'penjual')->paginate(10),
        ];

        return view("admin.penjual.index", $viewData);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $viewData = [
            "title" => "Tambah Penjual",
        ];

        return view('admin.penjual.create', $viewData);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'nama' => 'required|string|max:255',
            'email' => 'required|string|email|max:255',
            'password' => 'required|string|min:8|confirmed',
            'alamat_penjual' => 'required|string',
            'no_telp' => 'required|string|max:15',
        ]);

        DB::beginTransaction();

        try {
            $admin = Admin::create([
                'nama' => $validatedData['nama'],
                'email' => $validatedData['email'],
                'password' => bcrypt($validatedData['password']),
                'role' => 'penjual',
            ]);

            $penjual = Penjual::create([
                'id_admin' => $admin->id_admin,
                'nama_penjual' => $validatedData['nama'],
                'alamat_penjual' => $validatedData['alamat_penjual'],
                'no_telp' => $validatedData['no_telp'],
            ]);

            DB::commit();
            return redirect()->route('admin.penjual.index')->with('success', 'Penjual created successfully');
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->with('error', 'Failed to create penjual: ' . $e->getMessage());
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
            "title" => "Edit Penjual",
            "data" => Admin::where('id_admin', $id)->first(),
        ];

        return view('admin.penjual.edit', $viewData);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        $validatedData = $request->validate([
            'id_admin' => 'required',
            'nama' => 'required|string|max:255',
            'email' => 'required|string|email|max:255',
            'password' => 'nullable|string|min:8|confirmed',
            'alamat_penjual' => 'required|string',
            'no_telp' => 'required|string|max:15',
        ]);

        DB::beginTransaction();

        try {
            $admin = Admin::where('id_admin', $validatedData['id_admin'])->first();
            $admin->nama = $validatedData['nama'];
            $admin->email = $validatedData['email'];
            if (!empty($validatedData['password'])) {
                $admin->password = bcrypt($validatedData['password']);
            }
            $admin->save();

            $penjual = Penjual::where('id_admin', $validatedData['id_admin'])->first();
            $penjual->nama_penjual = $validatedData['nama'];
            $penjual->alamat_penjual = $validatedData['alamat_penjual'];
            $penjual->no_telp = $validatedData['no_telp'];
            $penjual->save();

            DB::commit();
            return redirect()->route('admin.penjual.index')->with('success', 'Penjual updated successfully');
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->with('error', 'Failed to update penjual: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        DB::beginTransaction();
        try {
            $admin = Admin::where('id_admin', $request->id_admin)->first();
            $admin->delete();
            DB::commit();
            return redirect()->route('admin.penjual.index')->with('success', 'Penjual deleted successfully');
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->with('error', 'Failed to delete penjual: ' . $e->getMessage());
        }
    }
}
