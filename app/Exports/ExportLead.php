<?php

namespace App\Exports;

use App\Models\Lead;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Carbon\Carbon;

class ExportLead implements FromCollection, WithHeadings
{
    public function __construct(public $filterUserId, public $leadType, public $filterStatusID, public $filterCampaignName, public $startDate, public $endDate){}

    public function collection()
    {
        if(Auth::user()->user_type == config('custom.USER_SUPERADMIN')){

            $leads = [];

        } elseif(Auth::user()->user_type == config('custom.USER_ADMIN')){

            $leads = DB::table('leads')
                        ->join('lead_statuses', 'leads.status', '=', 'lead_statuses.id')
                        ->join('users', 'leads.assign_to', '=', 'users.id')
                        ->select('leads.fullname','leads.phone','leads.secondary_phone', 'leads.email', 'leads.whatsapp', 'leads.city','leads.country', 'leads.budget', 'leads.contact_time', 'leads.purpose', 'leads.inquiry','leads.campaign_name', 'leads.property_type', 'leads.bedroom','lead_statuses.name as lead_status', 'users.name as assign_user')
                        ->where('leads.created_by', Auth::user()->id)
                        ->where('leads.is_migrate_lead', 0)
                        ->when($this->filterUserId, function ($query, $filterUserId) {
                            $query->where('assign_to', $filterUserId);
                        })->when($this->leadType, function ($query, $leadType) {
                            if($leadType == 'fresh'){
                                $query->whereIn('type', [config('custom.LEAD_TYPE_FRESH'), config('custom.LEAD_TYPE_HOT')]);
                            } else {
                                $query->where('type', config('custom.LEAD_TYPE_COLD'));
                            }                            
                        })->when($this->filterStatusID, function ($query, $filterStatusID) {
                            $query->where('status', $filterStatusID);
                        })->when($this->filterCampaignName, function ($query, $filterCampaignName) {
                            $query->where('campaign_name', $filterCampaignName);
                        })->when($this->startDate, function ($query, $startDate) {
                            $startdt = new Carbon($startDate);
                            $enddt = new Carbon($this->endDate);
                            $query->whereBetween('leads.created_at', [$startdt->startOfDay(), $enddt->endOfDay()]);
                        }) 
                        ->orderByDesc('leads.created_at')                     
                        ->get();

        } else{

            $leads = DB::table('leads')
                        ->join('lead_statuses', 'leads.status', '=', 'lead_statuses.id')
                        ->join('users', 'leads.assign_to', '=', 'users.id')
                        ->select('leads.fullname','leads.phone','leads.secondary_phone', 'leads.email', 'leads.whatsapp', 'leads.city','leads.country', 'leads.budget', 'leads.contact_time', 'leads.purpose', 'leads.inquiry','leads.campaign_name', 'leads.property_type', 'leads.bedroom','lead_statuses.name as lead_status')
                        ->where('leads.type', '!=', config('custom.LEAD_TYPE_COLD'))
                        ->where('leads.is_migrate_lead', 0)
                        ->where(function($query) {
                            $query->where('leads.assign_to', Auth::user()->id)
                                ->orWhere('leads.created_by', Auth::user()->id);
                        })->when($this->filterUserId, function ($query, $filterUserId) {
                            $query->where('assign_to', $filterUserId);
                        })->when($this->leadType, function ($query, $leadType) {
                            if($leadType == 'fresh'){
                                $query->whereIn('type', [config('custom.LEAD_TYPE_FRESH'), config('custom.LEAD_TYPE_HOT')]);
                            } else {
                                $query->where('type', config('custom.LEAD_TYPE_COLD'));
                            }                            
                        })->when($this->filterStatusID, function ($query, $filterStatusID) {
                            $query->where('status', $filterStatusID);
                        })->when($this->filterCampaignName, function ($query, $filterCampaignName) {
                            $query->where('campaign_name', $filterCampaignName);
                        })->when($this->startDate, function ($query, $startDate) {
                            $startdt = new Carbon($startDate);
                            $enddt = new Carbon($this->endDate);
                            $query->whereBetween('leads.created_at', [$startdt->startOfDay(), $enddt->endOfDay()]);
                        })
                        ->orderByDesc('leads.created_at')
                        ->get();
                        
        }

        return $leads;
    }

    public function headings(): array
    {
        if(Auth::user()->user_type == config('custom.USER_SUPERADMIN')){

            return [
                'fullname',
                'phone',
                'secondary_phone',
                'email',
                'whatsapp',
                'city',
                'country',
                'budget',
                'contact_time',
                'purpose',
                'inquiry',
                'campaign_name',
                'property_type',
                'bedroom',
                'lead_status',               
                'assign_agent',
            ];

        } elseif(Auth::user()->user_type == config('custom.USER_ADMIN')){

            return [
                'fullname',
                'phone',
                'secondary_phone',
                'email',
                'whatsapp',
                'city',
                'country',
                'budget',
                'contact_time',
                'purpose',
                'inquiry',
                'campaign_name',
                'property_type',
                'bedroom',
                'lead_status',               
                'assign_agent',
            ];

        } else{

            return [
                'fullname',
                'phone',
                'secondary_phone',
                'email',
                'whatsapp',
                'city',
                'country',
                'budget',
                'contact_time',
                'purpose',
                'inquiry',
                'campaign_name',
                'property_type',
                'bedroom',
                'lead_status'
            ];
                        
        }
        
    }
}
