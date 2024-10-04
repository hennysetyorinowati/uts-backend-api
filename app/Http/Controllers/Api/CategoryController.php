<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Categories;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //get all character with relasi on table characters, levels and users
        $categories = Categories::latest()->paginate(5);

        //response
        $response = [
            'message'   => 'List all categories',
            'data'      => $categories,
   ];
        return response()->json($response, 200);

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //validasi data
          $validator = Validator::make($request->all(),[
            'category' => 'required|unique:categories|min:4',

        ]);

        //jika validasi gagal
        if ($validator->fails()) {
            return response()->json([
                'message' => 'Invalid field',
                'errors' => $validator->errors()
            ],422);
        }

        //insert character to database
        $categories = categories::create([
            'category' => $request->category,

        ]);

        //response
        $response = [
            'success'   => 'Add Category success',
            'data'      => $categories,
        ];

        return response()->json($response, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //find Gameplay by ID
        $category = categories::find($id);

        //response
        $response = [
            'success'   => 'Detail Category',
            'data'      => $category,
        ];

        return response()->json($response, 200);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validator = Validator::make($request->all(),[
            'category' => 'required|unique:categories|min:4',

        ]);


        //jika validasi gagal
        if ($validator->fails()) {
            return response()->json([
                'message' => 'Invalid field',
                'errors' => $validator->errors()
            ],422);
        }


        //find character by ID
        $character = Categories::find($id);

            //update post with new image
            $character->update([
                'category' => $request->category,

            ]);


    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //find gameplay by ID
        $categories = Categories::find($id);


        if (isset($categories)) {


            //delete post
            $categories->delete();


            $response = [
                'success'   => 'Delete Category Success',
            ];
            return response()->json($response, 200);


        } else {
            //jika data gameplay tidak ditemukan
            $response = [
                'success'   => 'Data Category Not Found',
            ];


            return response()->json($response, 404);
        }

    }
}
