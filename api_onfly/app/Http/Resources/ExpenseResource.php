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
            'descricao' => $this->description,
            'data'      => \Carbon\Carbon::createFromDate($this->date)->format('d/m/Y'),
            'valor'     => 'R$ ' . number_format($this->cost, 2, ',', '.'),
        ];
    }
}
