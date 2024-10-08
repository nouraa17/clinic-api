<?php

namespace App\Http\Controllers;

use App\Filter\ClinicIdFilter;
use App\Filter\EndDateFilter;
use App\Filter\StartDateFilter;
use App\Filter\UserIdFilter;
use App\Http\Requests\FeedbackFormRequest;
use App\Http\Resources\FeedbackResource;
use App\Models\Clinic;
use App\Models\Feedback;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Pipeline\Pipeline;

class FeedbackControllerResource extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth:sanctum', 'check.role:patient,admin'])->except(['index','show']);
        $this->middleware(['auth:sanctum', 'check.role:admin,doctor,patient'])->only(['index','show']);
    }

    public function index(Request $request)
    {
        $data = Feedback::query()->with(['user','clinic']);

        $feedbacks = app(Pipeline::class)
            ->send($data)
            ->through([
                ClinicIdFilter::class,
                UserIdFilter::class,
                StartDateFilter::class,
                EndDateFilter::class,
            ])
            ->thenReturn()
            ->paginate(2);
        $feedbacks=FeedbackResource::collection($feedbacks);

        return view('feedbacks.index', compact('feedbacks'));
    }

    public function create()
    {
        $users = User::all();
        $clinics = Clinic::all();
        return view('feedbacks.create',compact('users','clinics'));
    }

    public function store(FeedbackFormRequest $request)
    {
        $data = $request->validated();
        Feedback::create($data);
        return redirect()->route('feedback.index')->with('success', 'Feedback created successfully!');

    }

    public function show(string $id)
    {
        $feedback = Feedback::with(['user', 'clinic'])->findOrFail($id);
        $feedback = FeedbackResource::make($feedback);
        return view('feedbacks.show', compact('feedback'));
    }

    public function edit(string $id)
    {
        $feedback = Feedback::with(['user', 'clinic'])->findOrFail($id);
        $clinics = Clinic::all();
        $users = User::all();

        return view('feedbacks.edit', compact('feedback', 'clinics', 'users'));
    }

    public function update(FeedbackFormRequest $request, string $id)
    {
        $feedback = Feedback::findOrFail($id);
        $data = $request->validated();
        $feedback->update($data);
        return redirect()->route('feedback.index')->with('success', 'Feedback updated successfully!');

    }

    public function destroy(string $id)
    {
        $feedback = Feedback::findOrFail($id);
        $feedback->delete();
        return redirect()->route('feedback.index')->with('success', 'Feedback deleted successfully!');
    }
}
