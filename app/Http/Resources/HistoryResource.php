<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class HistoryResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'user_id' => $this->user_id,
            'chronic_diseases' => $this->chronic_diseases,
            'prescriptions' => $this->prescriptions,
            'last_visit' => $this->last_visit,
            'created_at' => $this->created_at->format('Y-m-d H:i:s'),
            'published_at' => $this->created_at->diffForHumans(),
        ];
    }
}
