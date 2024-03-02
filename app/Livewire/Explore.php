<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Opportunities;
use Livewire\Attributes\On;
use Livewire\WithoutUrlPagination;


class Explore extends Component
{ 
    use WithPagination;
    use WithoutUrlPagination;

    public $isOptSearch = false;
    public $opts;

    #[On('opportunitySearch')]
    public function search($data) {
        $this->isOptSearch = true;  
        $this->opts = $data;
    }


    public function render()
    {
        return view('explore')->with([
            'opportunities' => $this->opts,
        ]);
    }
}
