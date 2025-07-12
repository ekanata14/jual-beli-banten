<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

// Models
use App\Models\Pelanggan;
use App\Models\User;
use App\Models\Transaksi;

class PelangganController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $viewData = [
            "title" => "Data Pelanggan",
            "datas" => User::where('role', 'pelanggan')->paginate(10),
        ];

        return view("admin.pelanggan.index", $viewData);
    }

    public function transaksiPelanggan(string $id)
    {
        $user = User::where('id', $id)->first();
        $viewData = [
            "title" => "Transaksi | " . $user->name,
            "datas" => Transaksi::where('id_user', $id)->latest()->paginate(10),
        ];

        return view("admin.transaksi.index", $viewData);
    }

    public function transaksiPelangganDetail(string $id)
    {
        $transaksi = Transaksi::with(['orders', 'user'])->findOrFail($id);

        $viewData = [
            'title' => 'Detail Transaksi',
            'data' => $transaksi,
            'orders' => $transaksi->orders,
            'user' => $transaksi->user,
        ];

        return view('admin.transaksi.detail', $viewData);
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
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255',
            'alamat_pelanggan' => 'required|string',
            'kode_pos' => 'required|string',
            'no_telp' => 'required|string|max:15',
            'password' => 'required|string|min:8|confirmed',
        ]);

        DB::beginTransaction();

        try {
            $user = User::create([
                'name' => $validatedData['name'],
                'email' => $validatedData['email'],
                'password' => bcrypt($validatedData['password']),
                'role' => 'pelanggan', // Assuming role is required
            ]);

            Pelanggan::create([
                'id_user' => $user->id, // Assuming id_user is not required for Pelanggan
                'password' => bcrypt($validatedData['password']),
                'alamat_pelanggan' => $validatedData['alamat_pelanggan'],
                'kode_pos' => $validatedData['kode_pos'],
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
            "data" => User::where('id', $id)->first(),
        ];

        return view('admin.pelanggan.edit', $viewData);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        $validatedData = $request->validate([
            'id' => 'required|integer|exists:users,id',
            'name' => 'required|string|max:255',
            'alamat_pelanggan' => 'required|string',
            'email' => 'required|string|email|max:255',
            'password' => 'nullable|string|min:8|confirmed',
            'kode_pos' => 'required|string',
            'no_telp' => 'required|string|max:15',
        ]);

        DB::beginTransaction();

        try {
            $user = User::where('id', $validatedData['id'])->first();
            if (!$user) {
                return redirect()->back()->with('error', 'User not found');
            }
            $user->name = $validatedData['name'];
            $user->email = $validatedData['email'];
            if (!empty($validatedData['password'])) {
                $user->password = bcrypt($validatedData['password']);
            }
            $user->save();

            // Update Pelanggan details
            $pelanggan = Pelanggan::where('id_user', $validatedData['id'])->first();
            $pelanggan->alamat_pelanggan = $validatedData['alamat_pelanggan'];
            $pelanggan->no_telp = $validatedData['no_telp'];
            if (!empty($validatedData['password'])) {
                $pelanggan->password = bcrypt($validatedData['password']);
            }
            $pelanggan->kode_pos = $validatedData['kode_pos'];
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
