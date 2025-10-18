<?php

namespace Modules\Blog\Filament\Resources\Posts\Pages;

use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\App;
use Modules\Blog\Filament\Resources\Posts\PostResource;

class EditPost extends EditRecord
{
    protected static string $resource = PostResource::class;


    protected function handleRecordUpdate(Model $record, array $data): Model
    {
        // Update or insert translation
        $postId = $record->id;
        $locale    = $data['locale'] ?? App::getLocale();

        // Prepare translation data
        $translationData = [
            'name'             => $data['name'] ?? null,
            'description'      => $data['description'] ?? null,
            'locale'           => $locale,
        ];

        // Check if translation exists
        $exists = \DB::table('post_translations')
            ->where('post_id', $postId)
            ->where('locale', $locale)
            ->exists();

        if ($exists) {
            // Update existing translation
            \DB::table('post_translations')
                ->where('post_id', $postId)
                ->where('locale', $locale)
                ->update($translationData);
        } else {
            // Insert new translation
            $translationData['post_id'] = $postId;
            \DB::table('post_translations')->insert($translationData);
        }

        // Update main post record (excluding translation fields)
        $postData = array_diff_key($data, array_flip(['name', 'description', 'locale']));
        if ($postData) {
            $record->update($postData);
        }

        return $record;
    }


    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
