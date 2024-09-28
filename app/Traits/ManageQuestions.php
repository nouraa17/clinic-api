<?php

namespace App\Traits;

use App\Http\Requests\QuestionFormRequest;

trait ManageQuestions
{
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


}
