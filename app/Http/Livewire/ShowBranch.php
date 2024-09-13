<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Modules\Org\Entities\OrgBranch;

class ShowBranch extends Component
{
    protected $branch, $branchCode;
    public $codes = [];

    protected $listeners = ['checkOrgChart'];

    public function render()
    {
        $branches = OrgBranch::orderBy('order', 'asc')->get();

        return view('livewire.show-branch', [
            'branches' => $branches
        ]);
    }


    public function branchFilter($branchCode)
    {
        $this->emit('addBranchFilter', $branchCode);
    }

    public function checkOrgChart($codes)
    {
        $this->codes = $codes;
    }
}
