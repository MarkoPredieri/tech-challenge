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

    //FUNZIONE PER L'ESTRAZIONE DEL PREZZO UNITARIO DELLA BOLLETTA
    public function getUnitPriceAttribute(): float
    {
        if ($this->consumption == 0) return 0;
        
        return round($this->total_amount / $this->consumption, 6);
    }

    //FUNZIONE PER IL CALCOLO DEL COSTO ANNUALE DELLA BOLLETTA
    public function getAnnualCostAttribute(): float
    {
        if (!$this->period_start || !$this->period_end) return 0;

        $days = $this->period_start->diffInDays($this->period_end);

        if ($days == 0) return 0;

        $dailyCost = $this->total_amount / $days;

        return round($dailyCost * 365, 2);
    }

    //FUNZIONE CHE CONTROLLA SE HO UN RISPARMIO DI OLTRE X€ CON LA QUALE MOSTRERO O MENO UN MESSAGGIO
    public function hasSignificantSaving(): bool
    {
        $service = new \App\Services\OffersComparisonService();
        $offers = $service->getBestOffer($this);

        if (!$offers) return false;

        $threshold = match ($this->supply_type) {
            'electricity' => 50,
            'gas'         => 100,
            default       => 50,
        };

        return $offers[0]['annual_saving'] >= $threshold;
    }
}
