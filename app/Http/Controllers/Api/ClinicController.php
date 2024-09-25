<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\ClinicFormRequest;
use App\Http\Resources\ClinicResource;
use App\Http\Resources\UserResource;
use App\Models\Clinic;
use App\Services\Messages;
use Illuminate\Http\Request;

class ClinicController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $clinics = Clinic::all();
        return ClinicResource::collection($clinics);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ClinicFormRequest $request)
    {
        $data = $request->validated();
//        dd($data);
        $clinic = Clinic::query()->create($data);
        return Messages::success(ClinicResource::make($clinic),'Clinic created successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $clinic = Clinic::query()->findOrFail($id);
        return ClinicResource::make($clinic);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ClinicFormRequest $request, string $id)
    {
        $data = $request->validated();
        $clinic = Clinic::query()->findOrFail($id);
        $clinic->update($data);
        return Messages::success(ClinicResource::make($clinic),'Clinic updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $clinic = Clinic::query()->findOrFail($id);
        $clinic->delete();
        return Messages::success(ClinicResource::make($clinic),'Clinic deleted successfully');
    }
}
