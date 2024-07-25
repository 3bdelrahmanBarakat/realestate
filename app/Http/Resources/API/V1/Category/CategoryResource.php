<?php

namespace App\Http\Resources\API\V1\Category;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CategoryResource extends JsonResource
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
            'name' => $this->name,
            'image' => $this->image ? url("/storage/uploads/categories/{$this->image}") : null,
            'created_at' => Carbon::parse($this->created_at)->format("d M Y H:i:s")
        ];
    }
}
