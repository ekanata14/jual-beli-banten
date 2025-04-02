<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

// Models
use App\Models\Pelanggan;

class PelangganController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $viewData = [
            "title" => "Data Pelanggan",
            "datas" => Pelanggan::paginate(10),
        ];

        return view("admin.pelanggan.index", $viewData);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $viewData = [
            "title" => "Tambah Pelanggan",
        ];

        return view('admin.pelanggan.create', $viewData);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'nama_pelanggan' => 'required|string|max:255',
            'email' => 'required|string|email|max:255',
            'alamat_pelanggan' => 'required|string',
            'no_telp' => 'required|string|max:15',
            'password' => 'required|string|min:8|confirmed',
        ]);

        DB::beginTransaction();

        try {
            Pelanggan::create([
                'nama_pelanggan' => $validatedData['nama_pelanggan'],
                'email' => $validatedData['email'],
                'password' => bcrypt($validatedData['password']),
                'alamat_pelanggan' => $validatedData['alamat_pelanggan'],
                'no_telp' => $validatedData['no_telp'],
            ]);
            DB::commit();
            return redirect()->route('admin.pelanggan.index')->with('success', 'Pelanggan created successfully');
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->with('error', 'Failed to create pelanggan: ' . $e->getMessage());
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
            "title" => "Edit Pelanggan",
            "data" => Pelanggan::where('id_pelanggan', $id)->first(),
        ];

        return view('admin.pelanggan.edit', $viewData);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        $validatedData = $request->validate([
            'id_pelanggan' => 'required',
            'nama_pelanggan' => 'required|string|max:255',
            'alamat_pelanggan' => 'required|string',
            'email' => 'required|string|email|max:255',
            'password' => 'nullable|string|min:8|confirmed',
        ]);

        DB::beginTransaction();

        try {
            $pelanggan = Pelanggan::where('id_pelanggan', $validatedData['id_pelanggan'])->first();
            $pelanggan->nama_pelanggan = $validatedData['nama_pelanggan'];
            $pelanggan->email = $validatedData['email'];
            $pelanggan->alamat_pelanggan = $validatedData['alamat_pelanggan'];
            if (!empty($validatedData['password'])) {
                $pelanggan->password = bcrypt($validatedData['password']);
            }
            $pelanggan->save();

            DB::commit();
            return redirect()->route('admin.pelanggan.index')->with('success', 'Pelanggan updated successfully');
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
            $pelanggan = Pelanggan::where('id_pelanggan', $request->id_pelanggan)->first();
            $pelanggan->delete();
            DB::commit();
            return redirect()->route('admin.pelanggan.index')->with('success', 'Pelanggan deleted successfully');
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->with('error', 'Failed to delete admin: ' . $e->getMessage());
        }
    }
}
