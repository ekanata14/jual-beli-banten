<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

// Models
use App\Models\MetodePembayaran;

class MetodePembayaranController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $viewData = [
            "title" => "Metode Pembayaran",
            "datas" => MetodePembayaran::paginate(10),
        ];

        return view("admin.metode-pembayaran.index", $viewData);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $viewData = [
            "title" => "Tambah Metode Pembayaran",
        ];

        return view('admin.metode-pembayaran.create', $viewData);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'nama_metode' => 'required|string|max:255',
            'tipe' => 'required|string|max:255',
            'kode' => 'required|string|max:255',
            'logo' => 'required|mimes:jpeg,png,jpg|max:2048',
        ]);

        DB::beginTransaction();

        try {
            // Store the logo in the 'metode_pembayaran_logo' folder
            $logoPath = $request->file('logo')->store('metode_pembayaran_logo', 'public');
            $validatedData['logo'] = $logoPath;

            MetodePembayaran::create($validatedData);
            DB::commit();
            return redirect()->route('admin.metode-pembayaran.index')->with('success', 'Metode Pembayaran created successfully');
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->with('error', 'Failed to create metode-pembayaran: ' . $e->getMessage());
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
            "title" => "Edit Metode Pembayaran",
            "data" => MetodePembayaran::where('id_metode', $id)->first(),
        ];

        return view('admin.metode-pembayaran.edit', $viewData);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        $validatedData = $request->validate([
            'nama_metode' => 'required|string|max:255',
            'tipe' => 'required|string|max:255',
            'kode' => 'required|string|max:255',
            'logo' => 'nullable|mimes:jpeg,png,jpg|max:2048',
        ]);

        DB::beginTransaction();

        try {
            $metodePembayaran = MetodePembayaran::where('id_metode', $request->id_metode)->first();

            // Update fields
            $metodePembayaran->nama_metode = $validatedData['nama_metode'];
            $metodePembayaran->tipe = $validatedData['tipe'];
            $metodePembayaran->kode = $validatedData['kode'];

            // Handle logo update
            if ($request->hasFile('logo')) {
                // Delete the old logo
                if ($metodePembayaran->logo && Storage::disk('public')->exists($metodePembayaran->logo)) {
                    Storage::disk('public')->delete($metodePembayaran->logo);
                }

                // Store the new logo
                $logoPath = $request->file('logo')->store('metode_pembayaran_logo', 'public');
                $metodePembayaran->logo = $logoPath;
            }

            $metodePembayaran->save();

            DB::commit();
            return redirect()->route('admin.metode-pembayaran.index')->with('success', 'Metode Pembayaran updated successfully');
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->with('error', 'Failed to update metode pembayaran: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        DB::beginTransaction();
        try {
            $metodePembayaran = MetodePembayaran::where('id_metode', $request->id_metode)->first();
            $metodePembayaran->delete();
            DB::commit();
            return redirect()->route('admin.metode-pembayaran.index')->with('success', 'Metode Pembayaran deleted successfully');
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->with('error', 'Failed to delete metode pembayaran: ' . $e->getMessage());
        }
    }
}
