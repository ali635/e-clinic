<?php

namespace Modules\Blog\Filament\Resources\Posts\Schemas;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class PostForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->label(__(' name'))
                    ->maxLength(255)
                    ->required(),

                TextInput::make('link')
                    ->label(__(' link'))
                    ->maxLength(255)
                    ->required(),

                RichEditor::make('description')
                    ->label(__(' description'))
                    ->required(),

                FileUpload::make('image')
                    ->label(__(' image'))
                    ->directory('service')
                    ->required(),

                Toggle::make('status')
                    ->label(__('status'))
                    ->required(),

                TextInput::make('order')
                    ->label(__('order'))
                    ->numeric()
                    ->required(),
            ]);
    }
}
