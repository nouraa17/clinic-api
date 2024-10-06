<?php

namespace App\Http\Controllers;

use App\Filter\AgeFilter;
use App\Filter\ClinicIdFilter;
use App\Filter\EndDateFilter;
use App\Filter\GenderFilter;
use App\Filter\LocationFilter;
use App\Filter\NameFilter;
use App\Filter\StartDateFilter;
use App\Filter\UserIdFilter;
use App\Http\Requests\ClinicFormRequest;
use App\Http\Requests\ReservationFormRequest;
use App\Http\Resources\ReservationResource;
use App\Models\Clinic;
use App\Models\Reservation;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Pipeline\Pipeline;

class ReservationControllerResource extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'check.role:admin'])->except(['index', 'show']);
    }

    public function index(Request $request)
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
            ->paginate(1);
        $reservations=ReservationResource::collection($reservations);
//        $reservations = $reservations->paginate(10);

        return view('reservations.index', compact('reservations'));
    }

    public function create()
    {
        $users = User::all();
        $clinics = Clinic::all();
        return view('reservations.create',compact('users','clinics'));
    }

    public function store(ReservationFormRequest $request)
    {
        $data = $request->validated();
        $data['time'] = Carbon::createFromFormat('Y-m-d\TH:i', $data['time'])->format('Y-m-d H:i:s');
        Reservation::create($data);
        return redirect()->route('reservation.index')->with('success', 'Reservation created successfully!');

    }

    public function show(string $id)
    {
        $reservation = Reservation::with(['user', 'clinic'])->findOrFail($id);
        $reservation = ReservationResource::make($reservation);
        return view('reservations.show', compact('reservation'));
    }

    public function edit(string $id)
    {
        $reservation = Reservation::with(['user', 'clinic'])->findOrFail($id);
        $clinics = Clinic::all();
        $users = User::all();

        return view('reservations.edit', compact('reservation', 'clinics', 'users'));
    }

    public function update(ReservationFormRequest $request, string $id)
    {
        $reservation = Reservation::findOrFail($id);
        $data = $request->validated();
        $reservation->update($data);
        return redirect()->route('reservation.index')->with('success', 'Reservation updated successfully!');

    }

    public function destroy(string $id)
    {
        $reservation = Reservation::findOrFail($id);
        $reservation->delete();
        return redirect()->route('reservation.index')->with('success', 'Reservation deleted successfully!');
    }
}
