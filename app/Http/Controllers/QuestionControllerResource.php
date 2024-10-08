<?php

namespace App\Http\Controllers;

use App\Filter\EndDateFilter;
use App\Filter\StartDateFilter;
use App\Filter\UserIdFilter;
use App\Http\Requests\QuestionFormRequest;
use App\Http\Resources\QuestionResource;
use App\Models\Question;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Pipeline\Pipeline;

class QuestionControllerResource extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth:sanctum', 'check.role:patient,doctor'])->except(['index','show']);
        $this->middleware(['auth:sanctum', 'check.role:admin,doctor,patient'])->only(['index','show']);
    }

    public function index(Request $request)
    {
        $data = Question::query()->with(['user']);

        $questions = app(Pipeline::class)
            ->send($data)
            ->through([
                UserIdFilter::class,
                StartDateFilter::class,
                EndDateFilter::class,
            ])
            ->thenReturn()
            ->paginate(2);
        $questions=QuestionResource::collection($questions);
//        $questions = $questions->paginate(10);

        return view('questions.index', compact('questions'));
    }

    public function create()
    {
        $users = User::all();
        return view('questions.create',compact('users'));
    }

    public function store(QuestionFormRequest $request)
    {
        $data = $request->validated();
        Question::create($data);
        return redirect()->route('question.index')->with('success', 'Question created successfully!');

    }

    public function show(string $id)
    {
        $question = Question::with(['user'])->findOrFail($id);
        $question = QuestionResource::make($question);
        return view('questions.show', compact('question'));
    }

    public function edit(string $id)
    {
        $question = Question::with(['user'])->findOrFail($id);
        $users = User::all();
        return view('questions.edit', compact('question', 'users'));
    }

    public function update(QuestionFormRequest $request, string $id)
    {
        $question = Question::findOrFail($id);
        $data = $request->validated();
        $question->update($data);
        return redirect()->route('question.index')->with('success', 'Question updated successfully!');

    }

    public function destroy(string $id)
    {
        $question = Question::findOrFail($id);
        $question->delete();
        return redirect()->route('question.index')->with('success', 'Question deleted successfully!');
    }
}
