<?php

namespace App\Filament\Resources\Bills\Pages;

use App\Filament\Resources\Bills\BillResource;
use Filament\Actions\DeleteAction;
use App\Services\OffersComparisonService;
use Filament\Resources\Pages\EditRecord;

class EditBill extends EditRecord
{
    protected static string $resource = BillResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }

    public function getFooter(): ?\Illuminate\Contracts\View\View
    {
        $offers = (new OffersComparisonService())->getBestOffer($this->record) ?? [];

        return view('filament.bills.offers-section', [
            'offers' => $offers,
            'bill'   => $this->record,
            'hasSignificantSaving' => $this->record->hasSignificantSaving(),
        ]);
    }
}
