<?php

namespace App\Http\Controllers;

use Validator;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        $validator = Validator::make( $request->all(),[
            'photo_profile' => ['nullable', 'file', 'max:2048', 'image'],
        ]);

        if($validator->fails()){
            return response()->json([
                "code" => "400",
                "status" => "BAD_REQUEST",
                "errors" => $validator->errors()
            ],400);
        }

        $user = $request->user();

        $date = [];

        if($request->hasFile('photo_profile')){
            $data['photo_profile'] = $request->file('photo_profile')->store('photos_profile', 'public');
        }

        $user->update($data);

        return response()->json([
            'code' => '200',
            'status' => 'success',
            'message' => 'Update successfully.'
        ], 200);

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        //
    }
}
