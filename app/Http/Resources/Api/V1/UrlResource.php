<?php

namespace App\Http\Resources\Api\V1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UrlResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => (string) $this->id,
            'url' => $this->url,
            'shortCode' => $this->short_code,
            'createdAt' => $this->created_at?->format('Y-m-d\TH:i:s\Z'),
            'updatedAt' => $this->updated_at?->format('Y-m-d\TH:i:s\Z'),
            'accessCount' => $this->whenHas('access_count'),
        ];
    }
}
