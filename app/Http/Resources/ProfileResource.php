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
        $images = !empty($this->whenLoaded('userDetails')->image_name) ? url('storage/image/' . $this->whenLoaded('userDetails')->image_name) : null;
        return [
            'id' => $this->id,
            'first_name' => $this->whenLoaded('userDetails')->firstName,
            'middle_name' => $this->whenLoaded('userDetails')->middleName,
            'last_name' => $this->whenLoaded('userDetails')->lastName,
            'email' => $this->email,
            'phone' => $this->whenLoaded('userDetails')->cellPhone,
            'location' => $this->whenLoaded('userDetails')->clientLocation,
            'role' => $this->userType,
            'image_name' => $images,
        ];
    }
}
