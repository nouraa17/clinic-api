<?php

namespace App\Traits;


use App\Http\Requests\FeedbackFormRequest;

trait ManageFeedbacks
{
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


}
