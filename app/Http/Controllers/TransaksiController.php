<?php

namespace App\Http\Controllers;

use App\Models\Transaksi;
use App\Models\Barang;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class TransaksiController extends Controller
{
    public function index()
    {
        $transaksis = Transaksi::all();
    
        if ($transaksis->isEmpty()) {
            return response()->json(['message' => 'Data transaksi tidak tersedia.'], 404);
        } else {
            return response()->json($transaksis);
        }
    }
    

    public function show($id)
    {
        $transaksi = Transaksi::find($id);

        if ($transaksi) {
            return response()->json($transaksi);
        } else {
            return response()->json(['message' => 'Data transaksi tidak ditemukan.'], 404);
        }
    }

    public function store(Request $request)
    {     
        $barang = Barang::find($request->barang_id);
    
      
        if (!$barang) {
            return response()->json(['message' => 'Barang tidak ditemukan.'], 404);
        }
            
        $transaksi = Transaksi::create([
            'barang_id' => $request->barang_id,
            'jumlah_terjual' => $request->jumlah_terjual,
            'tanggal_transaksi' => $request->tanggal_transaksi,
            'jenis_barang' => $barang->jenis_barang,
        ]);
    
        return response()->json(['message' => 'Data transaksi berhasil ditambahkan.', 'data' => $transaksi], 201);
    }
    

    public function update(Request $request, $id)
    {
        $transaksi = Transaksi::find($id);
    
        if (!$transaksi) {
            return response()->json(['message' => 'Data transaksi tidak ditemukan.'], 404);
        }
           
        $barang = Barang::find($request->barang_id);
    
        
        if (!$barang) {
            return response()->json(['message' => 'Barang tidak ditemukan.'], 404);
        }
    
        
        $transaksi->update([
            'barang_id' => $request->barang_id,
            'jumlah_terjual' => $request->jumlah_terjual,
            'tanggal_transaksi' => $request->tanggal_transaksi,
            'jenis_barang' => $barang->jenis_barang, 
        ]);
    
        return response()->json(['message' => 'Data transaksi berhasil diperbarui.', 'data' => $transaksi], 200);
    }
    

    public function destroy($id)
    {
        $transaksi = Transaksi::find($id);

        if ($transaksi) {
            $transaksi->delete();
            return response()->json(['message' => 'Data transaksi berhasil dihapus.'], 200);
        } else {
            return response()->json(['message' => 'Data transaksi tidak ditemukan.'], 404);
        }
    }
    
    public function search(Request $request)
    {
        $order = $request->input('order');
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');
    
        $query = Transaksi::query();
           
        if ($startDate && $endDate) {
            $query->whereBetween('tanggal_transaksi', [$startDate, $endDate]);
        }
        
        if ($order == 'asc') {
            $query->orderBy('jumlah_terjual', 'asc');
        } elseif ($order == 'desc') {
            $query->orderBy('jumlah_terjual', 'desc');
        }
            
        $salesData = $query->get();
    
        return response()->json([
            'data' => $salesData,
        ]);
    }

   
    
}
