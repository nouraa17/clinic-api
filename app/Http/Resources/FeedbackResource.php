<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class FeedbackResource extends JsonResource
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
            'clinic_id' => $this->clinic_id,
            'user_id' => $this->user_id,
            'feedback' => $this->feedback,
            'created_at' => $this->created_at->format('Y-m-d H:i:s'),
            'published_at' => $this->created_at->diffForHumans(),
        ];
    }
}
