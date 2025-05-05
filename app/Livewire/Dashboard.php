<?php

namespace App\Livewire;

use App\Models\Item;
use App\Models\Loan;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Spatie\Permission\Models\Role;

class Dashboard extends Component
{
    public $selectedItem;
    public function selectItem($itemId)
    {
        $this->dispatch('itemSelected', itemId: $itemId); // kirim event ke komponen lain
    }

    public $loans; // Tambah property untuk loans

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
                'loan_date' => now() // Jika perlu update tanggal aktual
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
                'actual_return_date' => now() // Jika perlu update tanggal penolakan
            ]);

            session()->flash('success', 'Loan rejected successfully');

        } catch (\Exception $e) {
            session()->flash('error', 'Error rejecting loan: '.$e->getMessage());
        }
    }

    public function mount()
    {
        // Jika user adalah operator, ambil data loans
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
            'loans' => $this->loans ?? collect()
        ]);
    }
}
