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
        $lang   = $request->query('lang', app()->getLocale());
        $isHome = $request->query('is_home');

        app()->setLocale($lang);

        $posts = Post::where('status', true);

        if (!is_null($isHome) && $isHome == 1) {
            $posts = $posts->where('is_home', (int) $isHome);
        }

        $posts =  $posts->orderBy('order', 'asc')
            ->get();

        return response()->json([
            'status' => true,
            'message' => 'Posts retrieved successfully',
            'lang' => $lang,
            'data' => PostResource::collection($posts),
        ]);
    }

    public function show(Request $request, $id)
    {
        // set language for translations
        $lang = $request->query('lang', app()->getLocale());
        app()->setLocale($lang);

        $post = Post::with('translations')->findOrFail($id);

        return response()->json([
            'status' => true,
            'message' => 'Post retrieved successfully',
            'lang' => $lang,
            'data' => new PostResource($post),
        ]);
    }
}
