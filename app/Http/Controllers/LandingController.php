<?php

namespace App\Http\Controllers;

use App\Models\NewsCategory;
use App\Models\News;
use Illuminate\Http\Request;

class LandingController extends Controller
{
    public function index()
    {
        $categories=NewsCategory::all();
        $news=News::orderBy('created_at','desc')->paginate(8);

        return view('welcome', compact('categories','news',));
    }

    public function category($id)
    {
        $news = News::with('newsCategory')
            ->where('news_category_id', $id)
            ->latest()
            ->paginate(8);

        $categories = NewsCategory::all();

        return view('welcome', compact('news', 'categories'));
    }
}
