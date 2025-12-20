<?php

namespace Modules\Booking\Filament\Resources\Visits\Pages;

use Filament\Actions\Action;
use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;
use Modules\Booking\Filament\Resources\Visits\VisitResource;
use Modules\Room\Filament\Pages\RoomView;

class EditVisit extends EditRecord
{
    protected static string $resource = VisitResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make(),
            Action::make('goToRoom')
                ->label(__('Go to Room'))
                ->icon('heroicon-o-building-office-2')
                ->color('info')
                ->url(
                    fn() => $this->record->room_id
                    ? RoomView::getUrl(['roomId' => $this->record->room_id])
                    : null
                )
                ->visible(fn() => $this->record->room_id !== null),
            DeleteAction::make(),
        ];
    }
}
