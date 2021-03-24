<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class YourDayResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'answer' => $this->answer,
            'question' => $this->question,
        ];
    }
}
