<?php

namespace App\Livewire;

use App\Models\Opportunities;
use Livewire\Component;

class SearchOpportunities extends Component
{

    public $opts;
    public $query = ''; 

    public function searchOpportunities() {
        $this->opts = Opportunities::where('title', 'like', '%' . $this->query . '%')
            ->orWhere('requirements', 'like', '%' . $this->query . '%')
            ->orWhere('description', 'like', '%' . $this->query . '%')
            ->get();


        $this->dispatch('opportunitySearch', $this->opts);
    }

    public function render()
    {
        return view('livewire.search-opportunities');
    }
}
