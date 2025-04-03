<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

// Models
use App\Models\Kurir;

class KurirController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $viewData = [
            "title" => "Data Kurir",
            "datas" => Kurir::paginate(10),
        ];

        return view("admin.kurir.index", $viewData);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $viewData = [
            "title" => "Tambah Kurir",
        ];

        return view('admin.kurir.create', $viewData);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'kode_kurir' => 'required|string|max:255',
            'nama_kurir' => 'required|string|max:255',
            'kode_servis' => 'required|string|max:255',
            'nama_servis' => 'required|string|max:255',
            'rentan_durasi' => 'required|string|max:255',
            'unit_durasi' => 'required|string|max:255',
        ]);

        DB::beginTransaction();

        try {
            Kurir::create($validatedData);
            DB::commit();
            return redirect()->route('admin.kurir.index')->with('success', 'Kurir created successfully');
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->with('error', 'Failed to create kurir: ' . $e->getMessage());
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
            "title" => "Edit Kurir",
            "data" => Kurir::where('id_kurir', $id)->first(),
        ];

        return view('admin.kurir.edit', $viewData);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        $validatedData = $request->validate([
            'id_kurir' => 'required|integer',
            'kode_kurir' => 'required|string|max:255',
            'nama_kurir' => 'required|string|max:255',
            'kode_servis' => 'required|string|max:255',
            'nama_servis' => 'required|string|max:255',
            'rentan_durasi' => 'required|string|max:255',
            'unit_durasi' => 'required|string|max:255',
        ]);

        DB::beginTransaction();

        try {
            $kurir = Kurir::where('id_kurir', $validatedData['id_kurir'])->first();
            $kurir->kode_kurir = $validatedData['kode_kurir'];
            $kurir->nama_kurir = $validatedData['nama_kurir'];
            $kurir->kode_servis = $validatedData['kode_servis'];
            $kurir->nama_servis = $validatedData['nama_servis'];
            $kurir->rentan_durasi = $validatedData['rentan_durasi'];
            $kurir->unit_durasi = $validatedData['unit_durasi'];
            $kurir->save();

            DB::commit();
            return redirect()->route('admin.kurir.index')->with('success', 'Kurir updated successfully');
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->with('error', 'Failed to update kurir: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        DB::beginTransaction();
        try {
            $kurir = Kurir::where('id_kurir', $request->id_kurir)->first();
            $kurir->delete();
            DB::commit();
            return redirect()->route('admin.kurir.index')->with('success', 'Kurir deleted successfully');
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->with('error', 'Failed to delete kurir: ' . $e->getMessage());
        }
    }
}
