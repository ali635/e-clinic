<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Modules\Blog\Models\Post;
use Modules\Booking\Models\Feedback;
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

        $feedbacks = Feedback::query()
            ->with(['patient', 'visit.service'])
            ->whereNotNull('comments')
            ->whereNotNull('rating')
            ->where('rating', '>', 0)
            ->latest()
            ->take(12)
            ->get();

        return view('home.index', compact('services', 'posts', 'banners', 'feedbacks'));
    }

    public function privacy()
    {
        return view('privacy.privacy');
    }
}
