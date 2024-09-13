<?php

namespace App\View\Components;

use Illuminate\View\Component;
use Modules\Blog\Entities\Blog;

class BlogDetailsPageSection extends Component
{
    public $blog;

    public function __construct($blog)
    {
        $this->blog = $blog;
    }


    public function render()
    {
        $relatedBlogs = Blog::approved()->where('slug', '!=', $this->blog->slug)->inRandomOrder()->take(4)->get();

        return view(theme('components.blog-details-page-section'), compact('relatedBlogs'));
    }
}
