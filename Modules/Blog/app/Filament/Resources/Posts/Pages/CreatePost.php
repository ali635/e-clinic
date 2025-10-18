<?php

namespace Modules\Blog\Filament\Resources\Posts\Pages;

use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Facades\App;
use Modules\Blog\Filament\Resources\Posts\PostResource;
use Modules\Blog\Models\Post;

class CreatePost extends CreateRecord
{
    protected static string $resource = PostResource::class;

    protected function handleRecordCreation(array $data): \Illuminate\Database\Eloquent\Model
    {
        return \DB::transaction(function () use ($data) {
            // Insert into posts table
            $postId = \DB::table('posts')->insertGetId([
                'link'    => $data['link']   ?? null,
                'slug'    => $data['slug']   ?? null,
                'image'    => $data['image']   ?? null,
                'status' => $data['status'] ?? true,
                'is_home' => $data['is_home'] ?? true,
                'order'    => $data['order']   ?? 0,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            // Insert into post_translations table
                \DB::table('post_translations')->insert([
                    'post_id'  => $postId,
                    'locale'      => App::getLocale(),
                    'name'        => $data['name'],
                    'description' => $data['description'] ?? null,

                ]);
            
            // Return a fresh model instance
            return Post::find($postId);
        });
    }
}
