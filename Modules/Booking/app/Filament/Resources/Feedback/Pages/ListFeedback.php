<?php

namespace Modules\Booking\Filament\Resources\Feedback\Pages;

use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;
use Modules\Booking\Filament\Resources\Feedback\FeedbackResource;

class ListFeedback extends ListRecords
{
    protected static string $resource = FeedbackResource::class;

    protected function getHeaderActions(): array
    {
        return [
            // CreateAction::make(),
        ];
    }
}
