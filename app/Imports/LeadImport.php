<?php

namespace App\Imports;

use App\Models\Lead;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class LeadImport implements ToModel, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new Lead([
            "fullname" => $row['fullname'],
            "phone" => $row['phone'],
            "secondary_phone" => $row['secondary_phone'],
            "email" => $row['email'],
            "whatsapp" => $row['whatsapp'],
            "campaign_name" => $row['campaign_name'],
            "city" => $row['city'],
            "country" => $row['country'],
            "budget" => $row['budget'],
            "contact_time" => $row['contact_time'],
            "purpose" => $row['purpose'],
            "inquiry" => $row['inquiry'],
            "bedroom" => $row['bedroom'],
            "property_type" => $row['property_type'],
            "source" => $row['source'],
            "developer" => $row['developer'],
            "created_by" => Auth::user()->id,
        ]);
    }
}
