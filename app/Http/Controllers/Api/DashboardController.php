<?php

namespace App\Http\Controllers\Api;

use App\Filter\EndDateFilter;
use App\Filter\NameFilter;
use App\Filter\StartDateFilter;
use App\Filter\TypeFilter;
use App\Filter\UserIdFilter;
use App\Http\Controllers\Controller;
use App\Http\Requests\ClinicFormRequest;
use App\Http\Requests\FeedbackFormRequest;
use App\Http\Requests\HistoryFormRequest;
use App\Http\Requests\QuestionFormRequest;
use App\Http\Requests\ReservationFormRequest;
use App\Http\Requests\UserFormRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use App\Repositories\Auth\RegisterRepository;
use App\Services\Messages;
use Illuminate\Pipeline\Pipeline;

class DashboardController extends Controller
{
    private $repo;

    public function __construct(RegisterRepository $repo)
    {
        $this->middleware(['auth:sanctum', 'check.role:admin']);
        $this->repo = $repo;
        $this->clinicController = new ClinicController();
        $this->reservationController = new ReservationController();
        $this->questionController = new QuestionController();
        $this->feedbackController = new FeedbackController();
        $this->historyController = new HistoryController();

    }

    // users management
    public function usersIndex()
    {
        $data = User::query();
        $users = app(Pipeline::class)
            ->send($data)
            ->through([
                NameFilter::class,
                UserIdFilter::class,
                TypeFilter::class,
                StartDateFilter::class,
                EndDateFilter::class,
            ])
            ->thenReturn()
            ->get();
        return UserResource::collection($users);
    }
    public function storeUser(UserFormRequest $request)
    {
        return $this->repo->create_user($request->validated());

    }
    public function showUser(string $id)
    {
        $user = User::query()->findOrFail($id);
        return UserResource::make($user);

    }
    public function updateUser(UserFormRequest $request, string $id)
    {
        $data = $request->validated();
        $user = User::query()->findOrFail($id);
        $user->update($data);
        return Messages::success(UserResource::make($user),'User updated successfully');

    }
    public function deleteUser(string $id)
    {
        $user = User::query()->findOrFail($id);
        $user->delete();
        return Messages::success(UserResource::make($user),'User deleted successfully');
    }

    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////

    // clinics management
    public function clinicsIndex()
    {
        return $this->clinicController->index();
    }
    public function storeClinic(ClinicFormRequest $request)
    {
        return $this->clinicController->store($request);

    }
    public function showClinic(string $id)
    {
        return $this->clinicController->show($id);

    }
    public function updateClinic(ClinicFormRequest $request, string $id)
    {
//        dd($request->all());
        return $this->clinicController->update($request, $id);
    }
    public function deleteClinic(string $id)
    {
        return $this->clinicController->destroy($id);
    }

    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////

    // reservations management
    public function reservationsIndex()
    {
        return $this->reservationController->index();
    }
    public function storeReservation(ReservationFormRequest $request)
    {
        return $this->reservationController->store($request);
    }
    public function showReservation(string $id)
    {
        return $this->reservationController->show($id);
    }
    public function updateReservation(ReservationFormRequest $request, string $id)
    {
        return $this->reservationController->update($request, $id);
    }
    public function deleteReservation(string $id)
    {
        return $this->reservationController->destroy($id);
    }

    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////

    // questions management
    public function questionsIndex()
    {
        return $this->questionController->index();
    }
    public function storeQuestion(QuestionFormRequest $request)
    {
        return $this->questionController->store($request);
    }
    public function showQuestion(string $id)
    {
        return $this->questionController->show($id);
    }
    public function updateQuestion(QuestionFormRequest $request, string $id)
    {
        return $this->questionController->update($request, $id);
    }
    public function deleteQuestion(string $id)
    {
        return $this->questionController->destroy($id);
    }

    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////

    // feedbacks management
    public function feedbacksIndex()
    {
        return $this->feedbackController->index();
    }
    public function storeFeedback(FeedbackFormRequest $request)
    {
        return $this->feedbackController->store($request);
    }
    public function showFeedback(string $id)
    {
        return $this->feedbackController->show($id);
    }
    public function updateFeedback(FeedbackFormRequest $request, string $id)
    {
        return $this->feedbackController->update($request, $id);
    }
    public function deleteFeedback(string $id)
    {
        return $this->feedbackController->destroy($id);
    }

    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////

    // histories management
    public function historiesIndex()
    {
        return $this->historyController->index();
    }
    public function storeHistory(HistoryFormRequest $request)
    {
        return $this->historyController->store($request);
    }
    public function showHistory(string $id)
    {
        return $this->historyController->show($id);
    }
    public function updateHistory(HistoryFormRequest $request, string $id)
    {
        return $this->historyController->update($request, $id);
    }
    public function deleteHistory(string $id)
    {
        return $this->historyController->destroy($id);
    }
}
