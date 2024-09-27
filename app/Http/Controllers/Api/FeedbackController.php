<?php

namespace App\Http\Controllers\Api;

use App\Filter\ClinicIdFilter;
use App\Filter\EndDateFilter;
use App\Filter\StartDateFilter;
use App\Filter\UserIdFilter;
use App\Http\Controllers\Controller;
use App\Http\Requests\FeedbackFormRequest;
use App\Http\Resources\FeedbackResource;
use App\Models\Feedback;
use App\Services\Messages;
use Illuminate\Http\Request;
use Illuminate\Pipeline\Pipeline;

class FeedbackController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function __construct()
    {
        $this->middleware(['auth:sanctum', 'check.role:patient,admin'])->except(['index','show']);
        $this->middleware(['auth:sanctum', 'check.role:admin,doctor,patient'])->only(['index','show']);
    }
    public function index()
    {
        $data = Feedback::query()->with(['clinic', 'user']);
        $feedbacks = app(Pipeline::class)
            ->send($data)
            ->through([
                ClinicIdFilter::class,
                UserIdFilter::class,
                StartDateFilter::class,
                EndDateFilter::class,
            ])
            ->thenReturn()
            ->get();
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
        $feedback = Feedback::query()->findOrFail($id)->with(['user','clinic']);
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
