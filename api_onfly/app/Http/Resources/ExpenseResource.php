<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ExpenseResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request) {
        return [
            'id'          => $this->id,
            'description' => $this->description,
            'date'        => $this->date,
            'cost'        => $this->cost,
            'user_id'     => $this->user_id,
        ];
    }
}
