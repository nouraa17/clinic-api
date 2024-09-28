<?php

namespace App\Traits;

use App\Http\Requests\ReservationFormRequest;

trait ManageReservations
{
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


}
