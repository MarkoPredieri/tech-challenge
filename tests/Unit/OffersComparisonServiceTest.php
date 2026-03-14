<?php

namespace Tests\Unit;

use App\Models\Bill;
use App\Services\OffersComparisonService;
use Tests\TestCase;

class OffersComparisonServiceTest extends TestCase
{
    public function test_returns_best_offer_for_existing_bill(): void
    {
        $bill = Bill::find(1);

        $this->assertNotNull($bill, 'Bill con id impostato non trovata');

        $service = new OffersComparisonService();
        $results = $service->getBestOffer($bill);

        dump($results);

        $this->assertNotEmpty($results);
        $this->assertArrayHasKey('offer', $results[0]);
        $this->assertArrayHasKey('estimated_cost', $results[0]);
        $this->assertArrayHasKey('saving', $results[0]);
        $this->assertGreaterThan(0, $results[0]['saving']);
    }
}