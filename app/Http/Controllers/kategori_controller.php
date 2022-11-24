<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\kategori;

class kategori_controller extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $kategori = kategori::get();
        return $kategori;
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
        $table = kategori::create([
            "id_tiket" => $request->id_tiket,
            "nama_kategori" => $request->nama_kategori,
            "harga" => $request->harga,
            "stok" => $request->stok,
            "deskripsi" => $request->deskripsi
        ]);

        return response()->json([
            'success' => 201,
            'message' => 'Data kategori berhasil di tambahkan',
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
        $kategori = kategori::where('id', $id)->first();
        if ($kategori){
            return response()->json([
                'status' => 200,
                'data' => $kategori
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
        $kategori = kategori::where('id', $id)->first();
        if($kategori){
            $kategori->id_tiket = $request->id_tiket ? $request -> id_tiket : $kategori -> id_tiket;
            $kategori->nama_kategori = $request->nama_kategori ? $request -> nama_kategori : $kategori -> nama_kategori;
            $kategori->harga = $request->harga ? $request -> harga : $kategori -> harga;
            $kategori->stok = $request->stok ? $request -> stok : $kategori -> stok;
            $kategori->deskripsi = $request->deskripsi ? $request -> deskripsi : $kategori -> deskripsi;
            $kategori->save();
            return response()->json([
                'status' => 200,
                'message' => 'Data kategori berhasil diubah',
                'data' => $kategori
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
        $kategori = kategori::where('id', $id)->first();
        if($kategori){
            $kategori->delete();
            return response()->json([
                'status' => 200,
                'message' => 'Data kategori berhasil di hapus',
                'data' => $kategori
            ], 200);
        } else {
            return response()->json([
                'status' => 404,
                'message' => 'Data dengan id ' . $id . ' tidak ditemukan',
            ], 404);
        }
    }
}