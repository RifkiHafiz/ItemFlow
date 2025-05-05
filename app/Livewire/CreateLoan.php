<?php

namespace App\Livewire;

use App\Models\Loan;
use App\Models\loanDetail;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\Validate;
use Livewire\Component;

class CreateLoan extends Component
{
    #[Validate('required')]
    public $purpose;

    #[Validate('required')]
    public $loan_date;

    #[Validate('required')]
    public $planned_return_date;

    #[Validate('required')]
    public $note;

    public $item_id;
    public $quantity_borrowed;
    public $loanDetails = [];

    protected $listeners = ['itemSelected' => 'setItem'];

    public function setItem($itemId)
    {
        $this->item_id = $itemId;
    }

    public function add()
    {
        $this->validate();

        DB::beginTransaction();

        try {
            $loan = Loan::create([
                'borrower_id' => Auth::id(),
                'operator_id' => Auth::id(),
                'purpose' => $this->purpose,
                'loan_date' => $this->loan_date,
                'planned_return_date' => $this->planned_return_date,
                'note' => $this->note,
                'status' => 'pending'
            ]);

            LoanDetail::create([
                'loan_id' => $loan->id,
                'item_id' => $this->item_id,
                'quantity_borrowed' => $this->quantity_borrowed,
                'status' => 'borrowed',
            ]);

            DB::commit();
            return redirect()->route('dashboard');
        } catch (\Exception $e) {
            DB::rollBack();
            session()->flash('error', 'Error: ' . $e->getMessage());
        }
    }


    public function render()
    {
        return view('livewire.create-loan');
    }
}
