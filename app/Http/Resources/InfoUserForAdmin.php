<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class InfoUserForAdmin extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->user_id,
            'name' => $this->user->name,
            'email' => $this->user->email,
            'address' => $this->address->address ?? "",
            'city' => $this->address->city ?? "",
            'country' => $this->address->country ?? "",
        ];
    }
}
