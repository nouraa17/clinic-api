<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\FeedbackFormRequest;
use App\Http\Resources\FeedbackResource;
use App\Models\Feedback;
use App\Services\Messages;
use Illuminate\Http\Request;

class FeedbackController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $feedbacks = Feedback::all();
        return FeedbackResource::collection($feedbacks);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(FeedbackFormRequest $request)
    {
        $data = $request->validated();
        $feedback = Feedback::query()->create($data);
        return Messages::success(FeedbackResource::make($feedback),'Feedback created successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $feedback = Feedback::query()->findOrFail($id);
        return FeedbackResource::make($feedback);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(FeedbackFormRequest $request, string $id)
    {
        $data = $request->validated();
        $feedback = Feedback::query()->findOrFail($id);
        $feedback->update($data);
        return Messages::success(FeedbackResource::make($feedback),'Feedback updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $feedback = Feedback::query()->findOrFail($id);
        $feedback->delete();
        return Messages::success(FeedbackResource::make($feedback),'Feedback deleted successfully');
    }
}
