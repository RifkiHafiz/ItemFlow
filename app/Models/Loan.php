<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Loan extends Model
{
    protected $fillable = [
        'borrower_id',
        'operator_id',
        'purpose',
        'loan_date',
        'planned_return_date',
        'note',
        'status'
    ];

    public function LoanDetail()
    {
        return $this->hasMany(LoanDetail::class);
    }

//    public function item()
//    {
//        return $this->belongsTo(Item::class);
//    }

    public function borrower()
    {
        return $this->belongsTo(User::class, 'borrower_id');
    }
}
