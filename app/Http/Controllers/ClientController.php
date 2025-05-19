<?php

namespace App\Http\Controllers;

use App\Models\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ClientController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $clients = Client::all();

        return response()->json($clients);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name'    => 'required|string|max:255',
            'email'   => 'required|email|max:255|unique:clients,email',
            'phone'   => 'required|string|max:15',
            'address' => 'nullable|string|max:255',
        ]);

        if($validator->fails()) 
        {
            return response()->json($validator->errors(), 422);
        }

        $client = Client::create($request->all());
        $data = [
            'message' => 'Client created successfully', 
            'client'  => $client
        ];

        return response()->json($data);
    }

    /**
     * Display the specified resource.
     */
    public function show(Client $client)
    {
        return response()->json($client);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Client $client)
    {
        $validator = Validator::make($request->all(), [
            'name'    => 'required|string|max:255',
            'email'   => 'required|email|max:255|unique:clients,email,' . $client->id,
            'phone'   => 'required|string|max:15',
            'address' => 'nullable|string|max:255',
        ]);

        if($validator->fails()) 
        {
            return response()->json($validator->errors(), 422);
        }

        $client->update($request->all());
        $data = [
            'message' => 'Client updated successfully',
            'client'  => $client
        ];

        return response()->json($data);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Client $client)
    {
        $client->delete();
        $data = [
            'message' => 'Client deleted successfully',
        ];

        return response()->json($data);
    }
}
