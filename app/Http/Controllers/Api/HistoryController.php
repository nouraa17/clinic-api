<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\HistoryFormRequest;
use App\Http\Resources\HistoryResource;
use App\Models\History;
use App\Services\Messages;
use Illuminate\Http\Request;

class HistoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $histories = History::all();
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
        $history = History::query()->findOrFail($id);
        return HistoryResource::make($history);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(HistoryFormRequest $request, string $id)
    {
        $data = $request->validated();
        $history = History::query()->findOrFail($id);
        $history->update($data);
        return Messages::success(HistoryResource::make($history),'History updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $history = History::query()->findOrFail($id);
        $history->delete();
        return Messages::success(HistoryResource::make($history),'History deleted successfully');
    }
}
