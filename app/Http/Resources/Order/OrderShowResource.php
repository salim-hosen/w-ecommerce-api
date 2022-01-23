<?php

namespace App\Http\Resources\Order;

use Illuminate\Http\Resources\Json\JsonResource;

class OrderShowResource extends JsonResource
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
            "order_uid" => $this->order_uid,
            "buyer_id" => $this->buyer_id,
            "buyer" => $this->buyer->name,
            "total" => $this->total,
            "items" => OrderItemResource::collection($this->items)
        ];
    }
}
