<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\pesanan;
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
        $pesanan = pesanan::get();
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
        $kode = mt_rand(1000,9999);
        $getId = Auth::id();
        $table = pesanan::create([
            "id_user" => $getId,
            "id_kategori" => $request->id_kategori,
            "tanggal_pemesanan" => $request->tanggal_pemesanan,
            "kode" => $kode
        ]);

        return response()->json([
            'success' => 201,
            'message' => 'Data pesanan berhasil di tambahkan',
            'data' => $table
        ],
        201);
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
                'data' => 'Data kategori dengan id ' . $id .' tidak ditemukan'
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
        $pesanan = pesanan::where('id', $id)->first();
        if($pesanan){
            $pesanan->delete();
            return response()->json([
                'status' => 200,
                'message' => 'Data kategori berhasil di hapus',
                'data' => $pesanan
            ], 200);
        } else {
            return response()->json([
                'status' => 404,
                'message' => 'Data dengan id ' . $id . ' tidak ditemukan',
            ], 404);
        }
    }
}
