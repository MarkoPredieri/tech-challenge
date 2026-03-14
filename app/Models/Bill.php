<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bill extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'supply_type',
        'consumption',
        'consumption_unit',
        'total_amount',
        'period_start',
        'period_end',
        'provider_name',
        'invoice_number',
        'due_date',
        'notes',
    ];

    protected function casts(): array
    {
        return [
            'period_start' => 'date',
            'period_end' => 'date',
            'due_date' => 'date',
            'consumption' => 'decimal:6',
            'total_amount' => 'decimal:2',
        ];
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function getUnitPriceAttribute(): float
    {
        if ($this->consumption == 0) return 0;
        
        return round($this->total_amount / $this->consumption, 6);
    }
}
