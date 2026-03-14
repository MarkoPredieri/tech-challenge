<?php
namespace App\Services;

use App\Models\Bill;
use App\Models\Offer;

class OffersComparisonService
{
    public function getBestOffer(Bill $bill): ?array
    {
        //ESTRAGGO LE 4 OFFERTE MIGLIORI CHE HANNO UN PREZZO UNITARIO < DI QUELLO DELLA BOLLETTA
        $offers = Offer::where('supply_type', $bill->supply_type)
            ->where('is_active', true)
            ->where('unit_price', '<', $bill->unit_price)
            ->orderBy('unit_price', 'asc')
            ->limit(4)
            ->get();

        if ($offers->isEmpty()) return null;

        //ESTRATTE LE OFFERTE, LE CICLO CON UN FOREACH PER IL CALCOLO DEI PREZZI
        $results = [];
        foreach ($offers as $offer) {
            $offer_estimated_cost = round($offer->unit_price * $bill->consumption, 2);

            // COSTO ANNUALE STIMATO DELL'OFFERTA
            $days = $bill->period_start->diffInDays($bill->period_end);
            $daily_cost_offer = $offer_estimated_cost / $days;
            $annual_cost_offer = round($daily_cost_offer * 365, 2);

            // COSTO ANNUALE ATTUALE DELLA BILL
            $annual_cost_bill = $bill->annual_cost;

            $results[] = [
                'offer' => $offer,
                'estimated_cost' => $offer_estimated_cost,
                'saving' => round($bill->total_amount - $offer_estimated_cost, 2),
                'annual_saving' => round($annual_cost_bill - $annual_cost_offer, 2),
            ];
        }

        //RITORNO I RISULTATI
        return $results;
    }
}