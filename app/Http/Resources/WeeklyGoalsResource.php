<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class WeeklyGoalsResource extends JsonResource
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
            'id'=> $this->id,
            'day'=> $this->day,
            'goal'=> $this->goal,
            'status'=> $this->status == 1 ? "Accomplished" : "Not Accomplished",
        ];
    }
}
