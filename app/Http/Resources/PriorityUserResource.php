<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class PriorityUserResource extends JsonResource
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
            'ticket' => $this->subject,
            'assign' => $this->whenLoaded('support')->name ?? "-",
            'created' => Carbon::parse($this->created_at)->format('d/m/Y'),
        ];
    }
}
