<?php

namespace Modules\Blog\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\Blog\Http\Resources\PostResource;
use Modules\Blog\Models\Post;

class BlogController extends Controller
{
    /**
     * Display a listing of active posts.
     */
    public function index(Request $request)
    {
        $posts = Post::where('status', true)
            ->orderBy('order', 'asc')
            ->get();

        return PostResource::collection($posts);
    }
}
