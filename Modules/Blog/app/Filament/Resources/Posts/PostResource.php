<?php

namespace Modules\Blog\Filament\Resources\Posts;

use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Modules\Blog\Filament\Resources\Posts\Pages\CreatePost;
use Modules\Blog\Filament\Resources\Posts\Pages\EditPost;
use Modules\Blog\Filament\Resources\Posts\Pages\ListPosts;
use Modules\Blog\Filament\Resources\Posts\Schemas\PostForm;
use Modules\Blog\Filament\Resources\Posts\Tables\PostsTable;
use Modules\Blog\Models\Post;

class PostResource extends Resource
{
    protected static ?string $model = Post::class;

     protected static ?string $recordTitleAttribute = 'display_name';

    public static function getGloballySearchableAttributes(): array
    {
        return ['translations.name'];
    }
    
    public static function getNavigationGroup(): ?string
    {
        return __('Blogs');
    }

    // ✅ TRANSLATABLE navigation label (sidebar)
    public static function getNavigationLabel(): string
    {
        return __('Posts');
    }

    // ✅ TRANSLATABLE plural label (used in list page titles)
    public static function getPluralLabel(): string
    {
        return __('Posts');
    }

    // ✅ TRANSLATABLE singular label (used in forms)
    public static function getModelLabel(): string
    {
        return __('Post');
    }

    // ✅ TRANSLATABLE breadcrumb (top navigation)
    public static function getBreadcrumb(): string
    {
        return __('Posts');
    }

    public static function form(Schema $schema): Schema
    {
        return PostForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return PostsTable::configure($table);
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
            'index' => ListPosts::route('/'),
            'create' => CreatePost::route('/create'),
            'edit' => EditPost::route('/{record}/edit'),
        ];
    }
}
