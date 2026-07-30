<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CalculatorScenario extends Model
{
    protected $fillable = ['customer_id', 'name', 'platform', 'fee_percent', 'flat_fee', 'products'];

    protected $casts = [
        'products'    => 'array',
        'fee_percent' => 'float',
        'flat_fee'    => 'float',
    ];

    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class);
    }
}
