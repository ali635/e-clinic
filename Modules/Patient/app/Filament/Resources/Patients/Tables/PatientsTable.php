<?php

namespace Modules\Patient\Filament\Resources\Patients\Tables;

use Carbon\Carbon;
use Filament\Forms\Components\TextInput;
use Illuminate\Support\Facades\DB;
use Filament\Forms\Components\TextInput as FormTextInput;
use Filament\Forms\Components\Select as FormSelect;
use Filament\Tables\Table;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\TrashedFilter;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ToggleColumn;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\ForceDeleteBulkAction;
use Filament\Actions\RestoreBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Modules\Location\Models\City;
use Modules\Patient\Models\Disease;
use Illuminate\Database\Eloquent\Builder;

class PatientsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->label(__('name'))
                    ->searchable()
                    ->sortable(),

                TextColumn::make('email')
                    ->label(__('email'))
                    ->searchable()
                    ->sortable(),

                // country and city (relations)
                TextColumn::make('country.name')
                    ->label(__('country'))
                    ->sortable(),

                TextColumn::make('city.name')
                    ->label(__('city'))
                    ->sortable(),

                // computed age column (requires 'birthdate' cast to date on the model)
                TextColumn::make('age')
                    ->label(__('age'))
                    ->getStateUsing(fn($record) => $record->date_of_birth ? $record->date_of_birth->age : null)
                    ->sortable(),

                TextColumn::make('gender')
                    ->label(__('gender'))
                    ->searchable()
                    ->sortable(),

                ToggleColumn::make('status')
                    ->label(__('status')),
            ])
            ->filters([
                // Soft-deletes filter
                // TrashedFilter::make(),

                // Name text filter (works in addition to searchable column)
                Filter::make('name')
                    ->form([
                        FormTextInput::make('name')->placeholder(__('Search name...')),
                    ])
                    ->query(function ($query, array $data) {
                        if (empty($data['name'])) {
                            return $query;
                        }
                        return $query->where('name', 'like', '%' . $data['name'] . '%');
                    }),

                // Email text filter
                Filter::make('email')
                    ->form([
                        FormTextInput::make('email')->placeholder(__('Search email...')),
                    ])
                    ->query(function ($query, array $data) {
                        if (empty($data['email'])) {
                            return $query;
                        }
                        return $query->where('email', 'like', '%' . $data['email'] . '%');
                    }),

                // City (uses relationship => assumes patients table has city relation)
                SelectFilter::make('city_id')
                    ->label(__('city'))
                    ->options(function () {
                        return City::with('translations')
                            ->get()
                            ->pluck('name', 'id')
                            ->toArray();
                    })
                    ->searchable(),

                // Gender select filter (adjust options to your app translations / values)
                SelectFilter::make('gender')
                    ->options([
                        'male' => __('Male'),
                        'female' => __('Female'),
                    ])
                    ->label(__('gender')),

                // Age range filter (uses TIMESTAMPDIFF to compute age from birthdate)
                Filter::make('age')
                    ->form([
                        TextInput::make('min_age')->numeric()->placeholder(__('Min age')),
                        TextInput::make('max_age')->numeric()->placeholder(__('Max age')),
                    ])
                    ->query(function ($query, array $data) {
                        // only run when birthdate exists in DB
                        // Uses DB raw TIMESTAMPDIFF function which is accurate for years
                        if (! empty($data['min_age'])) {
                            $query->whereRaw('TIMESTAMPDIFF(YEAR, date_of_birth, CURDATE()) >= ?', [(int) $data['min_age']]);
                        }
                        if (! empty($data['max_age'])) {
                            $query->whereRaw('TIMESTAMPDIFF(YEAR, date_of_birth, CURDATE()) <= ?', [(int) $data['max_age']]);
                        }
                        return $query;
                    })
                    ->label(__('age')),


                SelectFilter::make('disease_id')
                    ->label(__('disease'))
                    ->options(fn() => Disease::with('translations')->get()->pluck('name', 'id'))
                    ->multiple()
                    ->searchable()
                    ->query(function (Builder $query, array $data) {
                        if (empty($data['values'])) {
                            return $query;
                        }

                        $ids = $data['values'];

                        return $query->whereHas('diseasesMany', function (Builder $q) use ($ids) {
                            $q->whereIn('diseases.id', $ids);
                        });
                    }),
            ])
            ->recordActions([
                ViewAction::make(),
                EditAction::make(),
                DeleteAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                    ForceDeleteBulkAction::make(),
                    // RestoreBulkAction::make(),
                ]),
            ]);
    }
}
