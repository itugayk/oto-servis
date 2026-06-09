<?php

namespace App\Http\Controllers;

use App\Models\BlogPost;
use App\Models\Brand;
use App\Models\GalleryItem;
use App\Models\Service;
use App\Models\Testimonial;

class PublicController extends Controller
{
    public function home()
    {
        return view('pages.home', [
            'services' => Service::active()->orderBy('sort_order')->get(),
            'brands' => Brand::active()->orderBy('sort_order')->get(),
            'gallery' => GalleryItem::active()->orderBy('sort_order')->take(6)->get(),
            'testimonials' => Testimonial::approved()->orderByDesc('is_featured')->take(6)->get(),
            'posts' => BlogPost::published()->latest('published_at')->take(3)->get(),
        ]);
    }

    public function services()
    {
        return view('pages.services', [
            'services' => Service::active()->orderBy('sort_order')->get(),
        ]);
    }

    public function serviceShow(Service $service)
    {
        abort_unless($service->is_active, 404);

        return view('pages.service-show', [
            'service' => $service,
            'others' => Service::active()->where('id', '!=', $service->id)->orderBy('sort_order')->take(4)->get(),
        ]);
    }

    public function appointment()
    {
        return view('pages.appointment');
    }

    public function brands()
    {
        return view('pages.brands', [
            'brands' => Brand::active()->orderBy('sort_order')->get(),
        ]);
    }

    public function gallery()
    {
        $items = GalleryItem::active()->orderBy('sort_order')->get();

        return view('pages.gallery', [
            'items' => $items,
            'categories' => $items->pluck('category')->unique()->values(),
        ]);
    }

    public function blog()
    {
        return view('pages.blog', [
            'posts' => BlogPost::published()->latest('published_at')->paginate(9),
        ]);
    }

    public function blogShow(BlogPost $post)
    {
        abort_unless($post->is_published, 404);

        return view('pages.blog-show', [
            'post' => $post,
            'related' => BlogPost::published()->where('id', '!=', $post->id)->latest('published_at')->take(3)->get(),
        ]);
    }

    public function contact()
    {
        return view('pages.contact');
    }
}
