<?php

namespace App\Http\Livewire\Pages;

use App\Models\Lead;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithPagination;


class Campaigns extends Component
{

    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    public function render()
    {
        return view('livewire.pages.campaigns', [
            'campaigns' => Lead::select('campaign_name', DB::raw('count(*) as lead_count'), 'created_at')
                            ->where('is_migrate_lead', 0)
                            ->groupBy('campaign_name')
                            ->orderByDesc('created_at')
                            ->paginate(5),
        ])->layout('layouts.app',  [
            'title' => 'campaigns'
        ]);
    }
}
