<?php

namespace Modules\Blog\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\Blog\Models\Post;

class BlogController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
          // Optional filters
        $isHome = $request->query('is_home');
        $lang   = $request->query('lang', app()->getLocale());

        // Set current language for translatable model
        app()->setLocale($lang);

        $query = Post::query()->where('status', 1);

        if (!is_null($isHome)) {
            $query->where('is_home', (int) $isHome);
        }

        // Fetch posts ordered by "order" column
        $posts = $query->orderBy('order', 'asc')->get();

        return view('blog.index', [
            'posts' => $posts,
            'lang' => $lang,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('blog::create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request) {}

    /**
     * Show the specified resource.
     */
    public function show($id)
    {
        return view('blog::show');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        return view('blog::edit');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id) {}

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id) {}
}
