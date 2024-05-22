<?php

namespace App\Models;

use App\Models\Invoice;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Item extends Model
{
    use HasFactory;

    
    protected $fillable = [
        'invoice_id', 'description', 'quantity', 'unit_price', 'total_price'
    ];

    public function invoice()
    {
        return $this->belongsTo(Invoice::class);
    }
}
