<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Page;
use Illuminate\Http\Request;

class PageController extends Controller
{
    public function show($slug)
    {
        $page = Page::where('active', true)->where('slug', $slug)->firstOrFail();
        return view('frontend.page.show', compact('page'));
    }
}
