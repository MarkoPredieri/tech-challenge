@if(count($offers) > 0)
    <x-filament::section class="mt-6">
        {{-- TITOLO SEZIONE OFFERTE --}}
        <x-slot name="heading">Offerte consigliate</x-slot>
        <x-slot name="description">
            Offerte più convenienti rispetto alla tua bolletta attuale (Prezzo unitario attuale: €{{ number_format($bill->unit_price, 6) }}/{{ $bill->consumption_unit }})
        </x-slot>

        <div class="flex flex-col gap-4 md:grid-cols-2">
            @if($hasSignificantSaving)
                <div class="w-[80%] bg-red-200 py-2 px-4 rounded-md flex flex-row mb-4 m-auto items-center gap-3">
                    <i class="fas fa-triangle-exclamation text-3xl text-red-900"></i>
                    <div class="flex flex-col">
                        <span class="text-red-950 font-bold">Attenzione! Potresti risparmiare molto...</span>
                        <span class="text-red-900">Abbiamo rilevato offerte che ti propongono un sostanzioso risparmio, ti consigliamo di dare un'occhiata alle seguenti proposte per la tua fornitura di <b>{{ $bill->supply_type === 'electricity' ? 'luce' : 'gas' }}</b>.</span>
                    </div>
                </div>
            @endif
            @foreach($offers as $index => $result)
                <div class="offer-card @if($index == 0) best @endif relative" >
                    @if($index == 0) 
                        <div class="absolute top-[-18px] left-0 right-0 w-fit m-auto py-1 px-2 rounded-xl font-bold text-white" style="background:linear-gradient(156deg,rgba(63, 94, 251, 1) 0%, rgba(252, 70, 107, 1) 100%);">
                            OFFERTA MIGLIORE
                        </div>
                    @endif
                    <div class="space-y-3 relative">
                        {{-- HEADER CARD OFFERTA --}}
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-base font-semibold text-gray-900 dark:text-white">
                                    {{ $result['offer']->provider_name }}
                                </p>
                                <p class="text-sm text-gray-500 dark:text-gray-400">
                                    {{ $result['offer']->offer_name }}
                                </p>
                            </div>
                            <div class="text-2xl flex flex-col items-end w-fit py-2 px-4 text-black">
                                <span class="font-bold"> - {{ number_format($result['annual_saving'], 2) }} €</span>
                                <span class="text-xs text-gray-700">Risparmio annuo previsto</span>
                            </div>
                        </div>

                         {{-- SEZIONE DI DETTAGLIO --}}
                        <details class="w-[60%] min-w-[540px] m-auto border-2 border-amber-100 rounded-2xl overflow-hidden">
                            <summary class="py-2 px-4 cursor-pointer bg-amber-100 font-medium text-center list-none text-sm text-amber-900">
                                Scopri i dettagli
                                <i class="fas fa-chevron-down transition-transform duration-300"></i>
                            </summary>
                            
                            
                            <div class="p-4 pt-2 space-y-3">
                                {{-- DATI OFFERTA --}}
                                <div class="space-y-1 text-sm">
                                    <div class="flex justify-between">
                                        <span class="text-gray-800">Prezzo unitario offerta</span>
                                        <span class="font-medium">{{ number_format($result['offer']->unit_price, 6) }} €/{{ $result['offer']->price_unit }}</span>
                                    </div>
                                </div>

                                {{-- COSTI STIMATI --}}
                                <div class="space-y-1 text-sm mt-2">
                                    <div class="flex justify-between">
                                        <div class="flex flex-col">
                                            <span class="text-gray-800">Costo attuale bolletta</span>
                                            <span class="text-xs text-gray-500">({{ $bill->period_start->format('d/m/Y') }} - {{ $bill->period_end->format('d/m/Y') }})</span>
                                        </div>
                                        <span class="font-medium">{{ number_format($bill->total_amount, 2) }} €</span>
                                    </div>
                                    <div class="flex justify-between">
                                        <div class="flex flex-col">
                                            <span class="text-gray-800">Costo stimato offerta</span>
                                            <span class="text-xs text-gray-500">({{ $bill->period_start->format('d/m/Y') }} - {{ $bill->period_end->format('d/m/Y') }})</span>
                                        </div>
                                        <span class="font-medium">{{ number_format($result['estimated_cost'], 2) }} €</span>
                                    </div>
                                    
                                    <hr class="border-gray-200 py-2"/>
                                    <div class="flex justify-between font-semibold text-green-800">
                                        <div class="flex flex-col">
                                            <span>Risparmio potenziale</span>
                                            <span class="text-xs text-gray-500 font-normal">({{ $bill->period_start->format('d/m/Y') }} - {{ $bill->period_end->format('d/m/Y') }})</span>
                                        </div>
                                        <span>- {{ number_format($result['saving'], 2) }} €</span>
                                    </div>
                                    <div class="flex justify-between font-semibold text-green-800 text-base">
                                        <span>Risparmio annuale stimato</span>
                                        <span class="text-xl">- {{ number_format($result['annual_saving'], 2) }} €</span>
                                    </div>
                                </div>
                            </div>
                        </details>

                    </div>
                </div>
            @endforeach
        </div>

    </x-filament::section>
@else
    {{-- MESSAGGIO IN CASO NESSUN OFFERTA MIGLIORE TROVATA --}}
    <x-filament::section class="mt-6">
        <x-slot name="heading">Offerte consigliate</x-slot>
        <p class="text-sm text-gray-500 dark:text-gray-400">
            Nessuna offerta più conveniente trovata per questa bolletta.
        </p>
    </x-filament::section>
@endif