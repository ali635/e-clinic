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

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'Feedback';

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
