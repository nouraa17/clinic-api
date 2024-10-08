<?php

namespace App\Http\Controllers;

use App\Filter\EndDateFilter;
use App\Filter\LocationFilter;
use App\Filter\NameFilter;
use App\Filter\StartDateFilter;
use App\Http\Requests\ClinicFormRequest;
use App\Http\Resources\ClinicResource;
use App\Models\Clinic;
use Illuminate\Http\Request;
use Illuminate\Pipeline\Pipeline;

class ClinicControllerResource extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'check.role:admin'])->except(['index', 'show']);
    }

    public function index(Request $request)
    {
//        dd(request()->all());
        $data = Clinic::query();

        $clinics = app(Pipeline::class)
            ->send($data)
            ->through([
                NameFilter::class,
                LocationFilter::class,
                StartDateFilter::class,
                EndDateFilter::class,
            ])
            ->thenReturn()
            ->paginate(2);

//        $clinics = $clinics->paginate(10);
        $clinics=ClinicResource::collection($clinics);
        return view('clinics.index', compact('clinics'));
    }

    public function create()
    {
        return view('clinics.create');
    }

    public function store(ClinicFormRequest $request)
    {
        $data = $request->validated();
        Clinic::create($data);
        return redirect()->route('clinic.index')->with('success', 'Clinic created successfully!');

    }

    public function show(string $id)
    {
        $clinic = Clinic::findOrFail($id);
        $clinic=ClinicResource::make($clinic);
        return view('clinics.show', compact('clinic'));
    }

    public function edit(string $id)
    {
        $clinic = Clinic::findOrFail($id);
        return view('clinics.edit', compact('clinic'));
    }

    public function update(ClinicFormRequest $request, string $id)
    {
        $clinic = Clinic::findOrFail($id);
        $data = $request->validated();
        $clinic->update($data);
        return redirect()->route('clinic.index')->with('success', 'Clinic updated successfully!');

    }

    public function destroy(string $id)
    {
        $clinic = Clinic::findOrFail($id);
        $clinic->delete();
        return redirect()->route('clinic.index')->with('success', 'Clinic deleted successfully!');
    }
}
