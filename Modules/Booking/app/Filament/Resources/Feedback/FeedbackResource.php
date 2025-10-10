<?php

namespace Modules\Booking\Filament\Resources\Feedback;

use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Modules\Booking\Filament\Resources\Feedback\Pages\CreateFeedback;
use Modules\Booking\Filament\Resources\Feedback\Pages\EditFeedback;
use Modules\Booking\Filament\Resources\Feedback\Pages\ListFeedback;
use Modules\Booking\Filament\Resources\Feedback\Schemas\FeedbackForm;
use Modules\Booking\Filament\Resources\Feedback\Tables\FeedbackTable;
use Modules\Booking\Models\Feedback;

class FeedbackResource extends Resource
{
    protected static ?string $model = Feedback::class;

    public static function getNavigationGroup(): ?string
    {
        return __('Patient Information');
    }

    // ✅ TRANSLATABLE navigation label (sidebar)
    public static function getNavigationLabel(): string
    {
        return __('Feedbacks');
    }

    // ✅ TRANSLATABLE plural label (used in list page titles)
    public static function getPluralLabel(): string
    {
        return __('Feedbacks');
    }

    // ✅ TRANSLATABLE singular label (used in forms)
    public static function getModelLabel(): string
    {
        return __('Feedback');
    }

    // ✅ TRANSLATABLE breadcrumb (top navigation)
    public static function getBreadcrumb(): string
    {
        return __('Feedbacks');
    }

    public static function form(Schema $schema): Schema
    {
        return FeedbackForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return FeedbackTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListFeedback::route('/'),
            'create' => CreateFeedback::route('/create'),
            'edit' => EditFeedback::route('/{record}/edit'),
        ];
    }
}
