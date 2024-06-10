<?php

namespace App\Http\Resources\V1\Customer;

use App\Http\Resources\V1\Invoice\InvoiceResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CustomerResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'fullname' => $this->fullname,
            'email' => $this->email,
            'address' => $this->address,
            'birthday' => $this->birthday,
            'starPoints' => $this->star_points,
            'type' => $this->type,
            'createdAt' => $this->created_at,
            'updatedAt' => $this->updated_at,
            'invoices' => InvoiceResource::collection($this->whenLoaded('invoices')),
        ];
    }
}
