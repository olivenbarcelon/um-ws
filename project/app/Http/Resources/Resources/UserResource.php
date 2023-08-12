<?php

namespace App\Http\Resources\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource {
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request) {
        return [
            'uuid' => $this->uuid,
            'id_number' => $this->id_number,
            'email' => $this->email,
            'mobile_number' => $this->mobile_number,
            'role' => $this->role,
            'last_name' => $this->last_name,
            'first_name' => $this->first_name,
            'middle_name' => $this->middle_name,
            'created_by' => $this->created_by,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at
        ];
    }
}
