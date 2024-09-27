<?php

namespace App\Http\Controllers\Api;

use App\Filter\AgeFilter;
use App\Filter\ClinicIdFilter;
use App\Filter\EndDateFilter;
use App\Filter\GenderFilter;
use App\Filter\StartDateFilter;
use App\Filter\UserIdFilter;
use App\Http\Controllers\Controller;
use App\Http\Requests\ReservationFormRequest;
use App\Http\Resources\ReservationResource;
use App\Models\Reservation;
use App\Services\Messages;
use Illuminate\Http\Request;
use Illuminate\Pipeline\Pipeline;

class ReservationController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    public function __construct()
    {
        $this->middleware(['auth:sanctum', 'check.role:admin,doctor'])->except(['show']);
        $this->middleware(['auth:sanctum', 'check.role:admin,doctor,patient'])->only('show');
    }
    public function index()
    {
        $data = Reservation::query()->with(['user','clinic']);
        $reservations = app(Pipeline::class)
            ->send($data)
            ->through([
                ClinicIdFilter::class,
                UserIdFilter::class,
                AgeFilter::class,
                GenderFilter::class,
                StartDateFilter::class,
                EndDateFilter::class,
            ])
            ->thenReturn()
            ->get();
        return ReservationResource::collection($reservations);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ReservationFormRequest $request)
    {
        $data = $request->validated();
        $reservation = Reservation::query()->create($data);
        return Messages::success(ReservationResource::make($reservation), 'Reservation created successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $reservation = Reservation::query()->findOrFail($id)->with(['user','clinic']);;
        if (request()->user()->tokenCan('admin') || request()->user()->tokenCan('doctor')) {
            return ReservationResource::make($reservation);
        }
        if (request()->user()->tokenCan('patient') && $reservation->user_id == request()->user()->id) {
            return ReservationResource::make($reservation);
        }
        return response()->json(['message' => 'Unauthorized to view this reservation'], 403);
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
