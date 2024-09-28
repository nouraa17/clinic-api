<?php

namespace App\Traits;


use App\Http\Requests\ClinicFormRequest;

trait ManageClinics
{
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


}
