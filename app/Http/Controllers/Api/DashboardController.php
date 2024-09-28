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
use App\Traits\ManageClinics;
use App\Traits\ManageFeedbacks;
use App\Traits\ManageHistories;
use App\Traits\ManageQuestions;
use App\Traits\ManageReservations;
use App\Traits\ManageUsers;
use Illuminate\Pipeline\Pipeline;
use App\Models\History;


class DashboardController extends Controller
{
    use ManageUsers, ManageClinics, ManageReservations, ManageQuestions, ManageFeedbacks, ManageHistories;

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
}
