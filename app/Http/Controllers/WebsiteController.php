<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Modules\Doctors\Models\Doctor;
use Modules\Departments\Models\Department;
use Modules\CMS\Models\Post;

class WebsiteController extends Controller
{
    /** Homepage */
    public function home()
    {
        return view('website.home');
    }

    /** About Us page */
    public function about()
    {
        return view('website.pages.about');
    }

    /** Departments / Services page */
    public function services()
    {
        $departments = Department::where('status', 'active')->get();
        return view('website.pages.services', compact('departments'));
    }

    /** Doctors listing page */
    public function doctors()
    {
        $doctors = Doctor::with('department')
            ->where('status', 'active')
            ->get();
        return view('website.pages.doctors', compact('doctors'));
    }

    /** Blog listing page */
    public function blog()
    {
        $posts = Post::where('status', 'published')
            ->latest('published_at')
            ->get();
        return view('website.pages.blog.index', compact('posts'));
    }

    /** Single blog post page */
    public function blogShow(string $slug)
    {
        $post    = Post::where('slug', $slug)->where('status', 'published')->firstOrFail();
        $related = Post::where('slug', '!=', $slug)
            ->where('status', 'published')
            ->latest('published_at')
            ->take(3)
            ->get();

        return view('website.pages.blog.show', compact('post', 'related'));
    }

    /** Contact page */
    public function contact()
    {
        return view('website.pages.contact');
    }
}
