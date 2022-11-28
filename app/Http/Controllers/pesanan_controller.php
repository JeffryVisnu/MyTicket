<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\pesanan;
use App\Models\User;
use App\Models\Kategori;
use Auth;

class pesanan_controller extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $pesanan = pesanan::with('user','kategori')->get();
        return $pesanan;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $kategori = kategori::where('id', $request->id_kategori)->first();
        if($kategori){
            $kategori = kategori::where('id', $request->id_kategori)->first();
            if($kategori->stok == 0){
                return response()->json([
                    'success' => 401,
                    'message' => 'Stock tiket habis, silahkan pilih tiket/kategori lain',
                ], 401);
            }
        $total_harga = (($kategori->harga) * ($request->stok));
        $getId = Auth::id();
        $date = date('Y-m-d');
        $table = pesanan::create([
            'id_user' => $getId,
            'id_kategori' => $request->id_kategori,
            'tanggal_pemesanan' => $date,
            'stok' => $request->stok,
            'total_harga' => $total_harga,
            'status' => 0
        ]);
        $kategori = kategori::where('id', $request->id_kategori)->first();
        if($kategori){
            $kategori->stok = (($kategori->stok) - ($request->stok));
            $kategori->save();
        }


        return response()->json([
            'success' => 201,
            'message' => 'Berhasil menambahkan pesanan',
            'data' => $table
        ], 201);
    } else {
        return response()->json([
            'success' => 401,
            'message' => 'Gagal menemukan kategori',
        ], 401);
        }
    } 
    


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $pesanan = pesanan::where('id', $id)->first();
        if ($pesanan){
            return response()->json([
                'status' => 200,
                'data' => $pesanan
            ], 200);
        } else {
            return response()->json([
                'status' => 404,
                'data' => 'Data pesanan dengan id ' . $id .' tidak ditemukan'
            ], 404);
        }
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $pesanan = pesanan::where('id', $id)->first();
        if($pesanan){
            $pesanan->id_kategori = $request->id_kategori ? $request -> id_kategori : $pesanan -> id_kategori;
            $pesanan->tanggal_pemesanan = $request->tanggal_pemesanan ? $request -> tanggal_pemesanan : $pesanan -> tanggal_pemesanan;
            $pesanan->save();
            return response()->json([
                'status' => 200,
                'message' => 'Data kategori berhasil diubah',
                'data' => $pesanan
            ], 200);
        } else {
            return response()->json([
                'status' => 404,
                'message' => 'Data dengan id ' . $id . ' tidak ditemukan'
            ], 404);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function destroy($id)
    {
        $pemesanan = pesanan::where('id', $id)->first();
        $id_kategori = $pemesanan->id_kategori;
        $kategori = kategori::where('id', $id_kategori)->first();
        if($pemesanan){
            $kategori->stok = (($kategori->stok) + ($pemesanan->stok));
            $kategori->save();
            $pemesanan->delete();
            return response()->json([
                'status' => 200,
                'message' => 'Data pesanan berhasil di hapus',
            ], 200);
        } else {
            return response()->json([
                'status' => 404,
                'message' => 'Gagal menemukan data pemesanan',
            ], 401);
        }
    }

    public function getStatusSudahBayar(){
        $pesanan = pesanan::where('status', 1)->get();
        if($pesanan){
            return response()->json([
                'status' => 201,
                'data' => $pesanan
            ], 201);
        } else{
            return response()->json([
                'status' => 401,
                'message' => 'Data pesanan tidak di temukan'
            ], 401);
        }
    }
}