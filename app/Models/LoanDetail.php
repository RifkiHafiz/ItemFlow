<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class loanDetail extends Model
{
    protected $fillable = [
        'loan_id',
        'item_id',
        'quantity_borrowed',
        'status'
    ];

    public function Loan()
    {
        return $this->hasMany(Loan::class);
    }

    public function item()
    {
        return $this->belongsTo(Item::class);
    }
}
