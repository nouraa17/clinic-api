<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\ReservationFormRequest;
use App\Http\Resources\ReservationResource;
use App\Models\Reservation;
use App\Services\Messages;
use Illuminate\Http\Request;

class ReservationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $reservations = Reservation::all();
        return ReservationResource::collection($reservations);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ReservationFormRequest $request)
    {
        $data = $request->validated();
        $reservation = Reservation::query()->create($data);
        return Messages::success(ReservationResource::make($reservation),'Reservation created successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $reservation = Reservation::query()->findOrFail($id);
        return ReservationResource::make($reservation);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ReservationFormRequest $request, string $id)
    {
        $data = $request->validated();
        $reservation = Reservation::query()->findOrFail($id);
        $reservation->update($data);
        return Messages::success(ReservationResource::make($reservation),'Reservation updated successfully');

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $reservation = Reservation::query()->findOrFail($id);
        $reservation->delete();
        return Messages::success(ReservationResource::make($reservation),'Reservation deleted successfully');
    }
}
