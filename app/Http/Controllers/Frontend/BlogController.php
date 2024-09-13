<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Modules\Blog\Entities\Blog;

class BlogController extends Controller
{
    public function __construct()
    {
        $this->middleware('maintenanceMode');
    }

    public function allBlog()
    {
        try {
            return view(theme('pages.blogs'));
        } catch (\Exception $e) {
            GettingError($e->getMessage(), url()->current(), request()->ip(), request()->userAgent());
        }
    }


    public function blogDetails(Request $request, $slug)
    {
        $blog = Blog::where('slug', $slug)->with('user')->firstOrFail();

        try {

            if ($blog->status == 0) {
                if ($request->preview != 1) {
                    Toastr::error('Blog status is not active', 'Failed');
                    return Redirect::to('/');
                }
            }

            if (empty($request->preview)) {
                $blog->viewed = $blog->viewed + 1;
                $blog->save();
            }
            return view(theme('pages.blogDetails'), compact('blog'));
        } catch (\Exception $e) {
            GettingError($e->getMessage(), url()->current(), request()->ip(), request()->userAgent());
        }
    }

    public function loadMoreData(Request $request)
    {
        $data = null;
        if ($request->id > 0) {
            $data = Blog::where('status', 1)->with('user')
                ->where('id', '<', $request->id)
                ->orderBy('id', 'DESC')
                ->limit(5)
                ->get();
        }

        $output = '';
        $last_id = '';

        if ($data) {
            foreach ($data as $blog) {
                $output .= view(theme('components.single-blog-post'), compact('blog'));
                $last_id = $blog->id;
            }
        }
        $result['last_id'] = $last_id;
        $result['view'] = $output;
        return $result;
    }
}
