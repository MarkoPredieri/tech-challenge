<?php
namespace App\Services;

use App\Models\Bill;
use App\Models\Offer;

class OffersComparisonService
{
    public function getBestOffer(Bill $bill): ?array
    {
        //CONTROLLO DI ESTRARRE SOLO LE OFFERTE DELLO STESSO TIPO DELLA BOLLETTA
        $offers = Offer::where('supply_type', $bill->supply_type)
            ->where('is_active', true)
            ->get();

        if ($offers->isEmpty()) return null;

        //ESTRATTE LE OFFERTE DI TIPO COMPATIBILE, LE CICLO CON UN FOREACH
        $results = [];
        foreach ($offers as $offer) {
            //SE IL PREZZO UNITARIO DELLA BILL > DI QUELLO DELL'OFFERTA, AGGIUNGO QUEST'ULTIMA ALLE OFFERTE PAPABILI DA PROPORRE AL CLIENTE, IN CASO NEGATIVO SALTO E CONTINUO IL CICLO
            if($bill->unit_price > $offer->unit_price){
                $offer_estimated_cost = round($offer->unit_price * $bill->consumption, 2);

                $results[] = [
                    'offer' => $offer,
                    'estimated_cost' => $offer_estimated_cost,
                    'saving' => round($bill->total_amount - $offer_estimated_cost, 2),
                ];
            }
        }

        //RIORDINO LE OFFERTE ESTRATTE DALLA MIGLIORE ALLA PEGGIORE
        usort($results, fn($a, $b) => $a['estimated_cost'] <=> $b['estimated_cost']);

        //PRENDO SOLO LE PRIME QUATTRO OFFERTE
        return array_slice($results, 0, 4);
    }
}