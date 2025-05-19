<?php

namespace App\Http\Controllers;

use App\Models\Service;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ServiceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): JsonResponse
    {
        $services = Service::with('clients')->get();

        return response()->json($services);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'name'        => 'required|string|max:255',
            'price'       => 'required|numeric|min:0',
        ]);

        if($validator->fails()) 
        {
            return response()->json($validator->errors(), 422);
        }

        $service = Service::create($request->all());
        $data = [
            'message' => 'Service created successfully',
            'service' => $service,
            'clients' => $service->clients,
        ];

        return response()->json($data);
    }

    /**
     * Display the specified resource.
     */
    public function show(int $id): JsonResponse
    {
        $service = Service::find($id);

        if(!$service)
        {
            return response()->json(['message' => 'Service not found'], 404);
        }

        $data = [
            'message' => 'Service displayed successfully',
            'service' => $service,
            'clients' => $service->clients,
        ];

        return response()->json($data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, int $id): JsonResponse
    {
        $service = Service::find($id);

        if(!$service)
        {
            return response()->json(['message' => 'Service not found'], 404);
        }

        $validator = Validator::make($request->all(), [
            'name'        => 'required|string|max:255',
            'price'       => 'required|numeric|min:0',
        ]);

        if($validator->fails()) 
        {
            return response()->json($validator->errors(), 422);
        }

        $service->update($request->all());
        $data = [
            'message' => 'Service updated successfully',
            'service' => $service,
            'clients' => $service->clients,
        ];

        return response()->json($data);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $id): JsonResponse
    {
        $service = Service::find($id);

        if(!$service)
        {
            return response()->json(['message' => 'Service not found'], 404);
        }
        
        $service->delete();
        $data = [
            'message' => 'Service deleted successfully',
            'service'  => $service,
        ];

        return response()->json($data);
    }

    public function clients($id): JsonResponse
    {
        $service = Service::where('id', $id)->with('clients')->get();

        if($service->count() == 0)
        {
            return response()->json(['message' => 'Service not found'], 404);
        }

        $data = [
            'message' => 'Service displayed with its clients successfully',
            'service'  => $service,
        ];

        return response()->json($data);
    }
}
