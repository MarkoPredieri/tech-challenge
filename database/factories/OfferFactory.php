<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class OfferFactory extends Factory
{
    public function definition(): array
    {
        $supplyType = $this->faker->randomElement(['electricity', 'gas']);

        $providers = [
            'Enel Energia',
            'ENI gas e luce',
            'A2A Energia',
            'Illumia',
            'Plenitude',
            'Hera Comm',
            'Edison Energia',
            'Alperia',
            'Acea Energia',
            'Axpo',
        ];

        $electricityOffers = ['Luce Flex', 'Luce Smart', 'Web Easy Luce', 'Luce Sempre', 'Energia Verde'];
        $gasOffers         = ['Gas Sicuro', 'Gas Casa', 'Web Easy Gas', 'Gas Relax', 'Gas Convenienza'];

        $providerName = $this->faker->randomElement($providers);
        $offerName    = $supplyType === 'electricity'
            ? $this->faker->randomElement($electricityOffers)
            : $this->faker->randomElement($gasOffers);

        return [
            'provider_name'            => $providerName,
            'offer_name'               => $offerName,
            'supply_type'              => $supplyType,
            'unit_price'               => $supplyType === 'electricity'
                ? $this->faker->randomFloat(6, 0.18, 0.35)  // range realistico €/kWh
                : $this->faker->randomFloat(6, 0.70, 1.20), // range realistico €/Smc
            'price_unit'               => $supplyType === 'electricity' ? 'kWh' : 'Smc',
            'is_active'                => $this->faker->boolean(80), // 80% attive
        ];
    }
}