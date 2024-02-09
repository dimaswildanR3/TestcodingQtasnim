<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Barang;
use App\Models\Transaksi;

class BarangController extends Controller
{
   
    public function index()
    {
        $barangs = Barang::all();
    
        if ($barangs->isEmpty()) {
            return response()->json(['message' => 'Data kosong.'], 404);
        } else {
            return response()->json($barangs);
        }
    }
    
    
    public function show($id)
    {
        $barang = Barang::find($id);
    
        if ($barang) {
            return response()->json($barang);
        } else {
            return response()->json(['message' => 'Data tidak ditemukan.'], 404);
        }
    }

    public function search(Request $request)
{
    $query = Barang::query();

    if ($request->has('search')) {
        $query->where('nama_barang', 'like', '%' . $request->input('search') . '%');
    }

    $sortField = $request->input('sortField', 'id');
    $sortOrder = $request->input('sortOrder', 'asc');
    $query->orderBy($sortField, $sortOrder);

    $barangs = $query->get();

    if ($barangs->isEmpty()) {
        return response()->json(['message' => 'Data tidak ditemukan.'], 404);
    } else {
        return response()->json($barangs);
    }
}

public function store(Request $request)
{

    $barang = Barang::create([
        'nama_barang' => $request->input('nama_barang'),
        'stok' => $request->input('stok'),
        'jenis_barang' => $request->input('jenis_barang'),
    ]);

    return response()->json(['message' => 'Data berhasil ditambahkan.', 'data' => $barang], 201);
}


public function update(Request $request, $id)
{
    $barang = Barang::find($id);

    if ($barang) {
        $barang->update($request->all());
        Transaksi::where('barang_id', $barang->id)->update(['jenis_barang' => $request->jenis_barang]);

        return response()->json(['message' => 'Data berhasil diperbarui.', 'data' => $barang], 200);
    } else {
        return response()->json(['message' => 'Data tidak ditemukan.'], 404);
    }
}

    
    public function destroy($id)
    {
        $barang = Barang::find($id);

        if (!$barang) {
            return response()->json(['message' => 'Data barang tidak ditemukan.'], 404);
        }
    
        $barang->delete();
    
        return response()->json(['message' => 'Data barang berhasil dihapus.'], 200);
    }

  

}
