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

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $viewData = [
            "title" => "Data Produk",
            "datas" => Admin::where('role', 'penjual')->paginate(10),
        ];

        return view("admin.produk.index", $viewData);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $viewData = [
            "title" => "Tambah Produk",
            "penjuals" => Admin::where('role', 'penjual')->get(),
            'idPenjual' => request()->query('id'),
        ];


        return view('admin.produk.create', $viewData);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'id_admin' => 'required|integer',
            'nama_produk' => 'required|string|max:255',
            'deskripsi_produk' => 'required|string',
            'harga' => 'required|numeric|min:0',
            'stok' => 'required|integer|min:0',
            'kategori' => 'required|string|max:255',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'berat' => 'required|numeric|min:0',
        ]);

        DB::beginTransaction();

        $penjual = Penjual::where('id_admin', $request->id_admin)->first();

        $validatedData['id_penjual'] = $penjual->id_penjual;


        try {
            if ($request->hasFile('foto')) {
                $validatedData['foto'] = $request->file('foto')->store('produk', 'public');
            }

            Produk::create($validatedData);

            DB::commit();
            return redirect()->route('admin.produk.detail', $validatedData['id_admin'])->with('success', 'Produk created successfully');
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
        $penjual = Penjual::where('id_admin', $id)->first();

        $viewData = [
            "title" => "Data Produk " . $penjual->nama_penjual,
            "datas" => Produk::where('id_penjual', $penjual->id_penjual)->paginate(10),
            'idPenjual' => $id,
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
            "data" => Produk::where('id_produk', $id)->first(),
            "penjuals" => Admin::where('role', 'penjual')->get(),
        ];

        return view('admin.produk.edit', $viewData);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        $validatedData = $request->validate([
            'id_produk' => 'required|integer',
            'id_admin' => 'required|integer',
            'nama_produk' => 'required|string|max:255',
            'deskripsi_produk' => 'required|string',
            'harga' => 'required|numeric|min:0',
            'stok' => 'required|integer|min:0',
            'kategori' => 'required|string|max:255',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'berat' => 'required|numeric|min:0',
        ]);

        DB::beginTransaction();

        $penjual = Penjual::where('id_admin', $validatedData['id_admin'])->first();

        $validatedData['id_penjual'] = $penjual->id_penjual;

        try {
            $produk = Produk::where('id_produk', $validatedData['id_produk'])->first();
            $produk->id_penjual = $validatedData['id_penjual'];
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
                $fotoPath = $request->file('foto')->store('produk', 'public');
                $produk->foto = $fotoPath;
            }

            $produk->save();

            DB::commit();
            return redirect()->route('admin.produk.detail', $validatedData['id_admin'])->with('success', 'Produk updated successfully');
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
            $produk = Produk::where('id_produk', $request->id_produk)->first();
            $produk->delete();
            DB::commit();
            return back()->with('success', 'Produk deleted successfully');
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->with('error', 'Failed to delete admin: ' . $e->getMessage());
        }
    }
}
