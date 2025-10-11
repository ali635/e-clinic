<?php

namespace Modules\Blog\Filament\Resources\Posts\Schemas;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;
use Illuminate\Support\Str;
use Filament\Schemas\Components\Utilities\Set;
use Modules\Blog\Models\Post;

class PostForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->label(__(' name'))
                    ->maxLength(255)
                    ->required()
                    ->live(onBlur: true)
                    ->afterStateUpdated(function (string $operation, $state, Set $set): void {
                        if ($operation !== 'create') {
                            return;
                        }

                        $set('slug', Str::slug($state));
                    }),

                TextInput::make('slug')
                    ->label(__(' slug'))
                    ->disabled()
                    ->dehydrated()
                    ->required()
                    ->maxLength(255)
                    ->unique(Post::class, 'slug', ignoreRecord: true),

                TextInput::make('link')
                    ->label(__(' link'))
                    ->maxLength(255)
                    ->required(),

                RichEditor::make('description')
                    ->label(__(' description'))
                    ->required(),

                FileUpload::make('image')
                    ->label(__(' image'))
                    ->disk('public')
                    ->directory('blog')
                    ->required(),

                Toggle::make('status')
                    ->label(__('status'))
                    ->required(),

                TextInput::make('order')
                    ->label(__('order'))
                    ->numeric()
                    ->required(),

                Toggle::make('is_home')
                    ->label(__('is home'))
                    ->required(),
            ]);
    }
}
