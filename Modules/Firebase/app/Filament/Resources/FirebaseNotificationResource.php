<?php

namespace Modules\Firebase\Filament\Resources;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Infolists\Components\ImageEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Modules\Firebase\Filament\Resources\FirebaseNotificationResource\Pages;
use Modules\Firebase\Filament\Resources\FirebaseNotificationResource\RelationManagers;
use Modules\Firebase\Models\FirebaseNotification;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Filament\Support\Enums\FontWeight;
use Filament\Infolists\Infolist;
use Filament\Infolists\Components;
use BackedEnum;
use Filament\Forms\Get;

class FirebaseNotificationResource extends Resource
{
    protected static ?string $model = FirebaseNotification::class;

    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-bell-alert';

    public static function getNavigationGroup(): ?string
    {
        return __('Firebase');
    }

    public static function getNavigationLabel(): string
    {
        return __('Firebase Notifications');
    }



    protected static ?int $navigationSort = 1;

    public static function form(Schema $form): Schema
    {
        return $form->schema([
            Section::make('Notification Details')
                ->schema([
                    TextInput::make('title')
                        ->required()
                        ->maxLength(255)
                        ->columnSpanFull()
                        ->placeholder('Enter notification title'),

                    Textarea::make('message')
                        ->required()
                        ->rows(4)
                        ->columnSpanFull()
                        ->placeholder('Enter notification message'),

                    FileUpload::make('image')
                        ->image()
                        ->directory('firebase_notifications')
                        ->disk('public')
                        ->imagePreviewHeight('250')
                        ->imageEditor()
                        ->imageEditorAspectRatios([
                            '16:9',
                            '4:3',
                            '1:1',
                        ])
                        ->helperText('Optional: Upload an image to display in the notification')
                        ->columnSpanFull(),

                    Select::make('screen_event')
                        ->options([
                            'home' => 'Home',
                            'services' => 'Services',
                            'visits' => 'Visits',
                            'feeds' => 'Feeds',
                            'profile' => 'Profile',
                            'visit_details' => 'Visit Details',
                            'feed_details' => 'Feed Details',
                            'service_details' => 'Service Details',
                        ])
                        ->placeholder('Select screen or event')
                        ->live()
                        ->helperText('Specify the screen to open when notification is tapped')
                        ->columnSpan(1),

                    Select::make('data.visit_id')
                        ->label('Select Visit')
                        ->options(fn() => \Modules\Booking\Models\Visit::latest()->take(50)->pluck('id', 'id')->map(fn($id) => "Visit #$id"))
                        ->searchable()
                        ->getSearchResultsUsing(fn(string $search) => \Modules\Booking\Models\Visit::where('id', 'like', "%{$search}%")->limit(50)->pluck('id', 'id')->map(fn($id) => "Visit #$id"))
                        ->visible(fn($get) => $get('screen_event') === 'visit_details')
                        ->required(fn($get) => $get('screen_event') === 'visit_details')
                        ->columnSpan(1),

                    Select::make('data.post_id')
                        ->label('Select Post')
                        ->options(fn() => \Modules\Blog\Models\Post::latest()->take(50)->pluck('name', 'id')) // Assuming 'name' is translatable, might need handling
                        ->searchable()
                        ->getSearchResultsUsing(fn(string $search) => \Modules\Blog\Models\Post::where('name', 'like', "%{$search}%")->limit(50)->pluck('name', 'id'))
                        ->visible(fn($get) => $get('screen_event') === 'feed_details')
                        ->required(fn($get) => $get('screen_event') === 'feed_details')
                        ->columnSpan(1),

                    Select::make('data.service_id')
                        ->label('Select Service')
                        ->options(fn() => \Modules\Service\Models\Service::latest()->take(50)->pluck('name', 'id'))
                        ->searchable()
                        ->getSearchResultsUsing(fn(string $search) => \Modules\Service\Models\Service::where('name', 'like', "%{$search}%")->limit(50)->pluck('name', 'id'))
                        ->visible(fn($get) => $get('screen_event') === 'service_details')
                        ->required(fn($get) => $get('screen_event') === 'service_details')
                        ->columnSpan(1),

                    DateTimePicker::make('send_date')
                        ->native(false)
                        ->seconds(false)
                        ->helperText('Optional: Schedule this notification for a future date/time. Leave empty to send immediately.')
                        ->columnSpan(1),
                ])
                ->columns(2),

            Section::make('Target Audience')
                ->schema([
                    Select::make('patients')
                        ->relationship('patients', 'name')
                        ->multiple()
                        ->searchable()
                        ->preload()
                        ->helperText('Optional: Select specific patients to receive this notification. Leave empty to send to ALL patients.')
                        ->columnSpanFull(),
                ]),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')
                    ->label('ID')
                    ->sortable()
                    ->searchable(),

                TextColumn::make('title')
                    ->sortable()
                    ->searchable()
                    ->weight(FontWeight::Bold)
                    ->wrap(),

                TextColumn::make('message')
                    ->limit(50)
                    ->searchable()
                    ->wrap()
                    ->toggleable(),

                ImageColumn::make('image')
                    ->disk('public')
                    ->height(40)
                    ->toggleable(),

                TextColumn::make('patients_count')
                    ->label('Target')
                    ->counts('patients')
                    ->formatStateUsing(function ($state, FirebaseNotification $record) {
                        if ($state == 0) {
                            return 'All Patients';
                        }
                        return $state . ' Patient' . ($state > 1 ? 's' : '');
                    })
                    ->badge()
                    ->color(fn($state) => $state == 0 ? 'info' : 'success'),

                TextColumn::make('status')
                    ->badge()
                    ->color(fn(string $state): string => match ($state) {
                        'sent' => 'success',
                        'scheduled' => 'warning',
                        'pending' => 'gray',
                    })
                    ->formatStateUsing(fn(string $state): string => ucfirst($state))
                    ->sortable(),

                TextColumn::make('send_date')
                    ->label('Send Date')
                    ->dateTime('M d, Y h:i A')
                    ->sortable()
                    ->toggleable(),

                TextColumn::make('created_at')
                    ->dateTime('M d, Y h:i A')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('logs_count')
                    ->label('Sent Count')
                    ->counts('logs')
                    ->sortable()
                    ->toggleable(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('status')
                    ->options([
                        'sent' => 'Sent',
                        'scheduled' => 'Scheduled',
                        'pending' => 'Pending',
                    ])
                    ->query(function (Builder $query, array $data) {
                        if (!$data['value']) {
                            return $query;
                        }

                        return match ($data['value']) {
                            'sent' => $query->where('is_sent', true),
                            'scheduled' => $query->where('is_sent', false)
                                ->whereNotNull('send_date')
                                ->where('send_date', '>', now()),
                            'pending' => $query->where('is_sent', false)
                                ->where(function ($q) {
                                        $q->whereNull('send_date')
                                        ->orWhere('send_date', '<=', now());
                                    }),
                        };
                    }),

                Tables\Filters\Filter::make('target')
                    ->label('Target Audience')
                    ->form([
                        Select::make('target_type')
                            ->options([
                                'all' => 'All Patients',
                                'specific' => 'Specific Patients',
                            ])
                            ->placeholder('Select target type'),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        if (!isset($data['target_type'])) {
                            return $query;
                        }

                        return match ($data['target_type']) {
                            'all' => $query->doesntHave('patients'),
                            'specific' => $query->has('patients'),
                            default => $query,
                        };
                    }),

                Tables\Filters\Filter::make('send_date')
                    ->form([
                        DatePicker::make('send_from')
                            ->placeholder('From'),
                        DatePicker::make('send_until')
                            ->placeholder('Until'),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->when(
                                $data['send_from'],
                                fn(Builder $query, $date): Builder => $query->whereDate('send_date', '>=', $date),
                            )
                            ->when(
                                $data['send_until'],
                                fn(Builder $query, $date): Builder => $query->whereDate('send_date', '<=', $date),
                            );
                    }),
            ])
            ->actions([
                ViewAction::make(),
                EditAction::make(),
                DeleteAction::make(),
            ])
            ->bulkActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('created_at', 'desc');
    }

    public static function infolist(Schema $infolist): Schema
    {
        return $infolist
            ->schema([
                Section::make('Notification Information')
                    ->schema([
                        TextEntry::make('title')
                            ->weight(FontWeight::Bold),

                        TextEntry::make('message')
                            ->columnSpanFull(),

                        ImageEntry::make('image')
                            ->disk('public')
                            ->height(200)
                            ->hidden(fn($state) => !$state),

                        TextEntry::make('screen_event')
                            ->placeholder('Not set')
                            ->badge(),

                        TextEntry::make('send_date')
                            ->dateTime('M d, Y h:i A')
                            ->placeholder('Not scheduled'),

                        TextEntry::make('status')
                            ->badge()
                            ->color(fn(string $state): string => match ($state) {
                                'sent' => 'success',
                                'scheduled' => 'warning',
                                'pending' => 'gray',
                            })
                            ->formatStateUsing(fn(string $state): string => ucfirst($state)),
                    ])
                    ->columns(2),

                Section::make('Target Audience')
                    ->schema([
                        TextEntry::make('patients.name')
                            ->listWithLineBreaks()
                            ->limitList(10)
                            ->expandableLimitedList()
                            ->placeholder('All Patients')
                            ->badge(),
                    ]),

                Section::make('Metadata')
                    ->schema([
                        TextEntry::make('created_at')
                            ->dateTime('M d, Y h:i A'),

                        TextEntry::make('updated_at')
                            ->dateTime('M d, Y h:i A'),
                    ])
                    ->columns(2),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            RelationManagers\FirebaseNotificationLogsRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListFirebaseNotifications::route('/'),
            'create' => Pages\CreateFirebaseNotification::route('/create'),
            'view' => Pages\ViewFirebaseNotification::route('/{record}'),
            'edit' => Pages\EditFirebaseNotification::route('/{record}/edit'),
        ];
    }
}
