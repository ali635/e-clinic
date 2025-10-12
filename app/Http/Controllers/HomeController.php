<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Modules\Blog\Models\Post;
use Modules\Service\Models\Service;
use Modules\Slider\Models\Slider;

class HomeController extends Controller
{
    public function index()
    {
        $services = Service::query()->where('status', 1)
            ->where('is_home', 1)
            ->orderBy('order', 'desc')
            ->take(12)
            ->get();

        $posts = Post::query()->where('status', 1)
            ->where('is_home', 1)
            ->orderBy('order', 'desc')
            ->take(12)
            ->get();

        $banners = Slider::query()->where('status', 1)
            ->orderBy('order', 'desc')
            ->get();

        return view('home.index', compact('services', 'posts', 'banners'));
    }
}
