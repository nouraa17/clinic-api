<?php

namespace App\Traits;


use App\Http\Requests\HistoryFormRequest;
use App\Models\History;

trait ManageHistories
{

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
