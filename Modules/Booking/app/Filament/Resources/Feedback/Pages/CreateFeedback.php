<?php

namespace Modules\Booking\Filament\Resources\Feedback\Pages;

use Filament\Resources\Pages\CreateRecord;
use Modules\Booking\Filament\Resources\Feedback\FeedbackResource;

class CreateFeedback extends CreateRecord
{
    protected static string $resource = FeedbackResource::class;
}
