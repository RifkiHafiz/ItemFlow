<?php

namespace App\Livewire;

use App\Models\Item;
use App\Models\Loan;
use App\Models\loanDetail;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Spatie\Permission\Models\Role;

class Dashboard extends Component
{
    public $loans;

    public $selectedItem;
    public function selectItem($itemId)
    {
        $this->dispatch('itemSelected', itemId: $itemId);
    }

    public function approveLoan($loanId)
    {
        try {
            $loan = Loan::findOrFail($loanId);

            // Validasi status dan role
            if($loan->status !== 'pending') {
                session()->flash('error', 'Loan request already processed');
                return;
            }

            $loan->update([
                'status' => 'approved',
                'operator_id' => Auth::id(),
                'loan_date' => now()
            ]);

            session()->flash('success', 'Loan approved successfully');

        } catch (\Exception $e) {
            session()->flash('error', 'Error approving loan: '.$e->getMessage());
        }
    }

    public function rejectLoan($loanId)
    {
        try {
            $loan = Loan::findOrFail($loanId);

            if($loan->status !== 'pending') {
                session()->flash('error', 'Loan request already processed');
                return;
            }

            $loan->update([
                'status' => 'rejected',
                'operator_id' => Auth::id(),
                'actual_return_date' => now()
            ]);

            session()->flash('success', 'Loan rejected successfully');

        } catch (\Exception $e) {
            session()->flash('error', 'Error rejecting loan: '.$e->getMessage());
        }
    }

    public function mount()
    {
        if(auth()->user()->hasRole('operator')) {
            $this->loans = Loan::with('borrower')
                ->orderBy('created_at', 'desc')
                ->get();
        }
    }

    public function logout()
    {
        Auth::logout();
        session()->invalidate();
        session()->regenerateToken();

        return redirect()->route('login');
    }

    public function render()
    {
        return view('livewire.dashboard', [
            'user' => Auth::user(),
            'items' => Item::all(),
            'details' => LoanDetail::all(),
            'loans' => $this->loans ?? collect()
        ]);
    }
}
