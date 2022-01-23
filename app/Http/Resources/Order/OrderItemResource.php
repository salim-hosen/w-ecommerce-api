<?php

namespace App\Http\Resources\Order;

use Illuminate\Http\Resources\Json\JsonResource;

class OrderItemResource extends JsonResource
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
            "id" => $this->id,
            "order_id" => $this->order_id,
            "name" => $this->name,
            "price" => $this->price,
            "qty" => $this->qty,
            "total" => $this->total,
            "image" => asset("images/product/$this->image")
        ];
    }
}
