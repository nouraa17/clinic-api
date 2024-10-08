<?php

namespace App\Http\Controllers;

use App\Filter\EndDateFilter;
use App\Filter\LastVisitFilter;
use App\Filter\StartDateFilter;
use App\Filter\UserIdFilter;
use App\Http\Requests\HistoryFormRequest;
use App\Http\Requests\QuestionFormRequest;
use App\Http\Resources\HistoryResource;
use App\Http\Resources\QuestionResource;
use App\Models\History;
use App\Models\Question;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Pipeline\Pipeline;

class HistoryControllerResource extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth:sanctum', 'check.role:admin,doctor'])->except(['show']);
        $this->middleware(['auth:sanctum', 'check.role:admin,doctor,patient'])->only('show');
    }

    public function index(Request $request)
    {
        $data = History::query()->with(['user']);

        $histories = app(Pipeline::class)
            ->send($data)
            ->through([
                UserIdFilter::class,
                LastVisitFilter::class,
                StartDateFilter::class,
                EndDateFilter::class,
            ])
            ->thenReturn()
            ->paginate(2);
        $histories=HistoryResource::collection($histories);
//        $histories = $histories->paginate(10);

        return view('histories.index', compact('histories'));
    }

    public function create()
    {
        $users = User::all();
        return view('histories.create',compact('users'));
    }

    public function store(HistoryFormRequest $request)
    {
        $data = $request->validated();
        $data['last_visit'] = Carbon::createFromFormat('Y-m-d\TH:i', $data['last_visit'])->format('Y-m-d H:i:s');
        History::create($data);
        return redirect()->route('history.index')->with('success', 'History created successfully!');

    }

    public function show(string $id)
    {
        $history = History::with(['user'])->findOrFail($id);
        $history = HistoryResource::make($history);
        return view('histories.show', compact('history'));
    }

    public function edit(string $id)
    {
        $history = History::with(['user'])->findOrFail($id);
        $users = User::all();
        return view('histories.edit', compact('history', 'users'));
    }

    public function update(HistoryFormRequest $request, string $id)
    {
        $history = History::findOrFail($id);
        $data = $request->validated();
        $history->update($data);
        return redirect()->route('history.index')->with('success', 'History updated successfully!');

    }

    public function destroy(string $id)
    {
        $history = History::findOrFail($id);
        $history->delete();
        return redirect()->route('history.index')->with('success', 'History deleted successfully!');
    }
}
