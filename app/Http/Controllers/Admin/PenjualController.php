<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

// Models
use App\Models\User;
use App\Models\Admin;
use App\Models\Penjual;

class PenjualController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $penjual = User::where('role', 'penjual')->paginate(10);
        $viewData = [
            "title" => "Data Penjual",
            "datas" => $penjual,
        ];

        foreach($penjual[3]->products as $item) {
            foreach($item->orders as $order) {
                // Process each order related to the product
                $anjay[] = $order->Transaksi;
            }
        }

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
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255',
            'password' => 'required|string|min:8|confirmed',
            'alamat_penjual' => 'required|string',
            'kode_pos' => 'required|string',
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
            'no_telp' => 'required|string|max:15',
        ]);

        DB::beginTransaction();

        try {
            $user = User::create([
                'name' => $validatedData['name'],
                'email' => $validatedData['email'],
                'password' => bcrypt($validatedData['password']),
                'role' => 'penjual',
            ]);

            $penjual = Penjual::create([
                'id_user' => $user->id,
                'alamat_penjual' => $validatedData['alamat_penjual'],
                'kode_pos' => $validatedData['kode_pos'],
                'latitude' => $validatedData['latitude'],
                'longitude' => $validatedData['longitude'],
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
            "data" => User::where('id', $id)->first(),
        ];

        return view('admin.penjual.edit', $viewData);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        $validatedData = $request->validate([
            'id' => 'required|integer',
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255',
            'password' => 'nullable|string|min:8|confirmed',
            'alamat_penjual' => 'required|string',
            'kode_pos' => 'required|string',
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
            'no_telp' => 'required|string|max:15',
        ]);

        DB::beginTransaction();

        try {
            $user = User::where('id', $validatedData['id'])->first();
            $user->name = $validatedData['name'];
            $user->email = $validatedData['email'];
            if (!empty($validatedData['password'])) {
                $user->password = bcrypt($validatedData['password']);
            }
            $user->save();

            $penjual = Penjual::where('id_user', $validatedData['id'])->first();
            $penjual->alamat_penjual = $validatedData['alamat_penjual'];
            $penjual->no_telp = $validatedData['no_telp'];
            $penjual->kode_pos = $validatedData['kode_pos'];
            $penjual->latitude = $validatedData['latitude'];
            $penjual->longitude = $validatedData['longitude'];
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
            $admin = User::where('id', $request->id)->first();
            $admin->delete();
            DB::commit();
            return redirect()->route('admin.penjual.index')->with('success', 'Penjual deleted successfully');
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->with('error', 'Failed to delete penjual: ' . $e->getMessage());
        }
    }
}
