<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class RequestUserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'open' => $this->open,
            'pending' => $this->pending,
            'closed' => $this->closed,
            'name' => $this->user->name,
            'id' => $this->user->id
        ];
    }
}
