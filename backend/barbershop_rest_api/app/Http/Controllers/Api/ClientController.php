<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Client;
use Illuminate\Support\Facades\Validator;

class ClientController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $clients = Client::all();
        

        if($clients->count() > 0){
            return response()->Json([
                    'status' => 200,
                    'clients' => $clients

            ], 200);
        } else {
            
                return response()->Json([
                    'status' => 404,
                    'message' => 'No Records Found'

                 ], 404);

        }
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
        $validator = Validator::make($request->all(),[
            'name' => 'required'
        ]);

        if($validator->fails()){
            return response()->json([
                'status' => 422,
                'errors'=> $validator->messages()
            ], 422);
        }else {
            $client = Client::create([
                'name' => $request->name,
                'email' => $request->email,
                'cell_phone' => $request->cell_phone,
                'address' => $request->address,
                'state' => $request->state
            ]);

            if($client){
                return response()->json([
                    'status' => 200,
                    'message' => 'Client Create Successfully'
                ],200);
            }else{

                return response()->json([
                    'status' => 500,
                    'message' => 'Something Went Wrong!'
                ],500);

            }
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $client = Client::find($id);
        if($client){
            return response()->json([
                'status' => 200,
                'client' => $client
            ],200);

        }else{
            return response()->json([
                'status' => 404,
                'message' => 'No such Client Found!'
            ],404);

        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $client = Client::find($id);
        if($client){
            return response()->json([
                'status' => 200,
                'client' => $client
            ],200);

        }else{
            return response()->json([
                'status' => 404,
                'message' => 'No such Client Found!'
            ],404);

        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validator = Validator::make($request->all(),[
            'name' => 'required',
        ]);

        if($validator->fails()){
            return response()->json([
                'status' => 422,
                'errors'=> $validator->messages()
            ], 422);
        }else {
            $client = Client::find($id);
           
            if($client){

                $client->update([
                    'name' => $request->name,
                    'email' => $request->email,
                    'cell_phone' => $request->cell_phone,
                    'address' => $request->address,
                    'state' => $request->state
                ]);

                return response()->json([
                    'status' => 200,
                    'message' => 'Client Updated Successfully'
                ],200);
            }else{

                return response()->json([
                    'status' => 404,
                    'message' => 'No Such Client Found!'
                ],404);

            }
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $client = Client::find($id);
        if($client){
            $client->delete();
            return response()->json([
                'status' => 200,
                'message' => 'Client Deleted Sucessfully!'
            ],200);

        }else {

            return response()->json([
                'status' => 404,
                'message' => 'No Such Client Found!'
            ],404);

        }
    }
}
