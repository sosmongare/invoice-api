<?php

namespace App\Models;

use App\Models\Item;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Invoice extends Model
{
    use HasFactory;

    
    protected $fillable = [
        'invoice_number', 'invoice_date', 'due_date', 'customer_name', 
        'customer_address', 'customer_email', 'customer_phone', 
        'subtotal', 'tax', 'total', 'payment_terms', 'notes',
        'from_name',
        'from_address',
        'from_pin',
        'from_email',
        'from_phone',
        'payment_bank',
        'payment_branch',
        'payment_name',
        'payment_account',
        'payment_pin',
        'payment_method',
        'payment_phone',

    ];

    public function items()
    {
        return $this->hasMany(Item::class);
    }
}
