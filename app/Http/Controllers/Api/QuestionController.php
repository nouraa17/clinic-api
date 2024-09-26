<?php

namespace App\Http\Controllers\Api;

use App\Filter\EndDateFilter;
use App\Filter\StartDateFilter;
use App\Filter\UserIdFilter;
use App\Http\Controllers\Controller;
use App\Http\Requests\QuestionFormRequest;
use App\Http\Resources\QuestionResource;
use App\Models\Question;
use App\Services\Messages;
use Illuminate\Http\Request;
use Illuminate\Pipeline\Pipeline;

class QuestionController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    public function __construct()
    {
        $this->middleware(['auth:sanctum', 'check.role:patient,doctor'])->except(['index','show']);
        $this->middleware(['auth:sanctum', 'check.role:admin,doctor,patient'])->only(['index','show']);
    }
    public function index()
    {
        $data = Question::query();
        $questions = app(Pipeline::class)
            ->send($data)
            ->through([
                UserIdFilter::class,
                StartDateFilter::class,
                EndDateFilter::class,
            ])
            ->thenReturn()
            ->get();
        return QuestionResource::collection($questions);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(QuestionFormRequest $request)
    {
        $data = $request->validated();
        $question = Question::query()->create($data);
        return Messages::success(QuestionResource::make($question),'Question created successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $question = Question::query()->findOrFail($id);
        return QuestionResource::make($question);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(QuestionFormRequest $request, string $id)
    {
        $data = $request->validated();
        $question = Question::query()->findOrFail($id);
        $question->update($data);
        return Messages::success(QuestionResource::make($question),'Question updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $question = Question::query()->findOrFail($id);
        $question->delete();
        return Messages::success(QuestionResource::make($question),'Question deleted successfully');
    }
}
