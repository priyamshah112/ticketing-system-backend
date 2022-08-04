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
        $images = !empty($this->whenLoaded('customerDetails')->image_name) ? url('storage/image/' . $this->whenLoaded('customerDetails')->image_name) : null;
        return [
            'id' => $this->id,
            'first_name' => $this->whenLoaded('customerDetails')->firstName,
            'middle_name' => $this->whenLoaded('customerDetails')->middleName,
            'last_name' => $this->whenLoaded('customerDetails')->lastName,
            'email' => $this->email,
            'phone' => $this->whenLoaded('customerDetails')->cellPhone,
            'location' => $this->whenLoaded('customerDetails')->clientLocation,
            'role' => $this->userType,
            'image_name' => $images,
        ];
    }
}
