<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ProfileResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $images = url('image/' . $this->whenLoaded('customerDetails')->image_name ?? "");
        return [
            'id' => $this->id,
            'image_name' => $images,
        ];
    }
}
