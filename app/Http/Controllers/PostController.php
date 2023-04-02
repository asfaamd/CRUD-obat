<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PostController extends Controller
{
    /**
     * index
     *
     * @return void
     */
    public function index()
    {
        //get all posts from Models
        $posts = Post::latest()->get();

        //return view with data
        return view('posts', compact('posts'));
    }

    /**
     * store
     *
     * @param  mixed $request
     * @return void
     */
    public function store(Request $request)
    {
        //define validation rules
        $validator = Validator::make($request->all(), [
            'kode'     => 'required',
            'nama'   => 'required',
            'deskripsi'   => 'required',
            'tipe'   => 'required',
            'jumlah'   => 'required',
            'harga_satuan'   => 'required'
        ]);

        //check if validation fails
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        //create post
        $post = Post::create([
            'kode'     => $request->kode, 
            'nama'   => $request->nama,
            'deskripsi'     => $request->deskripsi,
            'tipe'     => $request->tipe,
            'jumlah'     => $request->jumlah,
            'harga_satuan'     => $request->harga_satuan
        ]);

        //return response
        return response()->json([
            'success' => true,
            'message' => 'Data Berhasil Disimpan!',
            'data'    => $post  
        ]);

    }

    public function show(Post $post)
    {
        //return response
        return response()->json([
            'success' => true,
            'message' => 'Detail Data Post',
            'data'    => $post  
        ]); 
    }

    public function update(Request $request, Post $post)
    {
        //define validation rules
        $validator = Validator::make($request->all(), [
            'kode'     => 'required',
            'nama'   => 'required',
            'deskripsi'   => 'required',
            'tipe'   => 'required',
            'jumlah'   => 'required',
            'harga_satuan'   => 'required'
        ]);

         //check if validation fails
         if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        //create post
        $post->update([
            'kode'     => $request->kode, 
            'nama'   => $request->nama,
            'deskripsi'     => $request->deskripsi,
            'tipe'     => $request->tipe,
            'jumlah'     => $request->jumlah,
            'harga_satuan'     => $request->harga_satuan
        ]);

        //return response
        return response()->json([
            'success' => true,
            'message' => 'Data Berhasil Diupdate!',
            'data'    => $post  
        ]);
    
    }

    public function destroy($id)
    {
        //delete post by ID
        Post::where('id', $id)->delete();

        //return response
        return response()->json([
            'success' => true,
            'message' => 'Data Post Berhasil Dihapus!.',
        ]); 
    }

}