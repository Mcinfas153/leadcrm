<?php

namespace App\Classes\Automation;

use App\Http\Traits\OrganizationTrait;
use App\Http\Traits\LeadTrait;

class LeadReshuffle{

    use OrganizationTrait;

    public function __invoke()
    {
        //get auto reshuffle enabled companies
        // get their leads through loop
        // check lead 1 by 1 is it updated
        // if it's updated do nothing
        // if isn't chnage user
        LeadTrait::getEligibleReshuffleLeads();
        
    }

}