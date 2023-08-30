<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class LeadResource extends JsonResource
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
            'id' => $this->id,
            'fullname' => $this->fullname,
            'phone' => $this->phone,
            'email' => $this->email,
            'secondaryPhone' => $this->secondary_phone,
            'whatsapp' => $this->whatsapp,
            'city' => $this->city,
            'country' => $this->country,
            'budget' => $this->budget,
            'contactTime' => $this->contact_time,
            'purpose' => $this->purpose,
            'inquiry' => $this->inquiry,
            'propertyType' => $this->property_type,
            'bedroom' => $this->bedroom,
            'source' => $this->source,
            'status' => $this->status,
            'priority' => $this->priority,
            'type' => $this->type,
            'isMigrateLead' => $this->is_migrate_lead,
            'assignTo' => $this->assign_to,
            'createdBy' => $this->created_by,
            'assignTime' => $this->assign_time,
            'createdAt' => $this->created_at,
            'updatedAt' => $this->updated_at,
        ];
    }
}
