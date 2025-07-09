<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

// Models
use App\Models\Produk;
use App\Models\Admin;
use App\Models\Penjual;
use App\Models\User;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $viewData = [
            "title" => "Data Produk",
            "datas" => User::where('role', 'penjual')->paginate(10),
        ];

        return view("admin.produk.index", $viewData);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $penjual = User::where('role', 'penjual')->first();
        $viewData = [
            "title" => "Tambah Produk | " . $penjual->name,
            'id' => request()->query('id'),
            "penjuals" => User::where('role', 'penjual')->get(),
        ];


        return view('admin.produk.create', $viewData);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'id_user' => 'required|integer',
            'nama_produk' => 'required|string|max:255',
            'deskripsi_produk' => 'required|string',
            'harga' => 'required|numeric|min:0',
            'stok' => 'required|integer|min:0',
            'kategori' => 'required|string|max:255',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'berat' => 'required|numeric|min:0',
        ]);

        DB::beginTransaction();

        $penjual = User::where('id', $validatedData['id_user'])->first();

        $validatedData['id_user'] = $penjual->id;


        try {
            if ($request->hasFile('foto')) {
                $timestamp = now()->format('YmdHis');
                $extension = $request->file('foto')->getClientOriginalExtension();
                $filename = $request->id_user . '_' . str_replace(' ', '_', $validatedData['nama_produk']) . '_' . $timestamp . '.' . $extension;
                $fotoPath = $request->file('foto')->storeAs('produk', $filename, 'public');
                $validatedData['foto'] = 'storage/'.$fotoPath;
            }

            Produk::create($validatedData);

            DB::commit();
            return redirect()->route('admin.produk.detail', $validatedData['id_user'])->with('success', 'Produk created successfully');
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->withInput()->with('error', 'Failed to create produk: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $penjual = User::where('id', $id)->first();

        $viewData = [
            "title" => "Data Produk | " . $penjual->name,
            'idPenjual' => $penjual->id,
            "datas" => Produk::where('id_user', $penjual->id)->paginate(10),
        ];

        return view('admin.produk.produk-penjual', $viewData);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $viewData = [
            "title" => "Edit Produk",
            "data" => Produk::where('id', $id)->first(),
            "penjuals" => User::where('role', 'penjual')->get(),
        ];

        return view('admin.produk.edit', $viewData);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        $validatedData = $request->validate([
            'id' => 'required|integer',
            'id_user' => 'required|integer',
            'nama_produk' => 'required|string|max:255',
            'deskripsi_produk' => 'required|string',
            'harga' => 'required|numeric|min:0',
            'stok' => 'required|integer|min:0',
            'kategori' => 'required|string|max:255',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'berat' => 'required|numeric|min:0',
        ]);

        DB::beginTransaction();

        $penjual = User::where('id', $validatedData['id_user'])->first();

        try {
            $produk = Produk::where('id', $validatedData['id'])->first();
            $produk->id_user = $validatedData['id_user'];
            $produk->nama_produk = $validatedData['nama_produk'];
            $produk->deskripsi_produk = $validatedData['deskripsi_produk'];
            $produk->harga = $validatedData['harga'];
            $produk->stok = $validatedData['stok'];
            $produk->kategori = $validatedData['kategori'];
            $produk->berat = $validatedData['berat'];

            if ($request->hasFile('foto')) {
                if ($produk->foto && Storage::disk('public')->exists($produk->foto)) {
                    Storage::disk('public')->delete($produk->foto);
                }
                $timestamp = now()->format('YmdHis');
                $extension = $request->file('foto')->getClientOriginalExtension();
                $filename = $validatedData['id'] . '_' . str_replace(' ', '_', $validatedData['nama_produk']) . '_' . $timestamp . '.' . $extension;
                $fotoPath = $request->file('foto')->storeAs('produk', $filename, 'public');
                $produk->foto = $fotoPath;
            }

            $produk->save();

            DB::commit();
            return redirect()->route('admin.produk.detail', $validatedData['id_user'])->with('success', 'Produk updated successfully');
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->with('error', 'Failed to update produk: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        DB::beginTransaction();
        try {
            $produk = Produk::where('id', $request->id)->first();
            if ($produk->foto && Storage::disk('public')->exists($produk->foto)) {
                Storage::disk('public')->delete($produk->foto);
            }
            $produk->delete();
            DB::commit();
            return back()->with('success', 'Produk deleted successfully');
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->with('error', 'Failed to delete admin: ' . $e->getMessage());
        }
    }
}
