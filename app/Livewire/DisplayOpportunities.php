<?php

namespace App\Livewire;

use App\Models\Opportunities;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithoutUrlPagination;
use Livewire\WithPagination;

class DisplayOpportunities extends Component
{
    use WithPagination;
    use WithoutUrlPagination;
    public $modalOpened = false;
    public $opts;
    public $actualOpportunityID = '';


    #[On('opportunitySearch')]
    public function search($data) {
        if (!$data) {
            session()->flash('notFound');
            $this->opts = null;
            return;
        }

        $this->opts = $data;
    }


    #[On('closeModal')]
    public function closeModal() {
        $this->modalOpened = false;
    }

    #[On('errorAlreadyApplied')]
    public function errorAlreadyApplied() {
        session()->flash('error', 'You have already applied to this opportunity.');
        $this->closeModal();
    }

    public function deleteOportunitty($opportunityID) {
        $opportunity = Opportunities::find($opportunityID);
        
        if ($opportunity) {
            $opportunity->delete();
            
            session()->flash('status', 'Opportunity deleted successfully.');

            $this->dispatch('updatedOpportunities');
        }
    }

    public function openModal($opportunityID){
        $this->modalOpened = true;
        $this->actualOpportunityID = $opportunityID;
    }

    public function render()
    {

        return view('livewire.display-opportunities', [
            'opportunities' => Opportunities::paginate(10),
        ]);
    }

}
