<?php

namespace App\Http\Controllers\Api;

use App\Filter\EndDateFilter;
use App\Filter\LastVisitFilter;
use App\Filter\StartDateFilter;
use App\Filter\UserIdFilter;
use App\Http\Controllers\Controller;
use App\Http\Requests\HistoryFormRequest;
use App\Http\Resources\HistoryResource;
use App\Models\History;
use App\Services\Messages;
use Illuminate\Http\Request;
use Illuminate\Pipeline\Pipeline;

class HistoryController extends Controller
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
        $data = History::query()->with('user');
        $histories = app(Pipeline::class)
            ->send($data)
            ->through([
                UserIdFilter::class,
                LastVisitFilter::class,
                StartDateFilter::class,
                EndDateFilter::class,
            ])
            ->thenReturn()
            ->get();
        return HistoryResource::collection($histories);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(HistoryFormRequest $request)
    {
        $data = $request->validated();
        $history = History::query()->create($data);
        return Messages::success(HistoryResource::make($history),'History created successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $history = History::query()->with('user')
            ->where('id',$id)
            ->when(auth()->user()->type == 'patient' , fn ($e) => $e->where('user_id',auth()->id()))
            ->IfNotFound();
        return HistoryResource::make($history);
//        if (request()->user()->tokenCan('admin') || request()->user()->tokenCan('doctor')) {
//            return HistoryResource::make($history);
//        }
//        if (request()->user()->tokenCan('patient') && $history->user_id == request()->user()->id) {
//            return HistoryResource::make($history);
//        }
//        return response()->json(['message' => 'Unauthorized to view this history'], 403);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(HistoryFormRequest $request, string $id)
    {

        $data = $request->validated();
        $history = History::query()->where('id',$id)->IfNotFound();
        $history->update($data);
        return Messages::success(HistoryResource::make($history),'History updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $history = History::query()->where('id',$id)->IfNotFound();
        $history->delete();
        return Messages::success(HistoryResource::make($history),'History deleted successfully');
    }
}
