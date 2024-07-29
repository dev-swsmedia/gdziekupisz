<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\View\View;
use App\Models\BlogPosts;
use App\Models\BlogCategories;

class BlogController extends Controller
{
    public function index(Request $request, $category_slug = null) : View
    {
        $posts = BlogPosts::orderBy('id', 'DESC');
        
        $vdata['category'] = 'Blog';
        $vdata['current'] = null;
        
        $cid = null;
        
        if($category_slug !== null) {        
            $category = BlogCategories::where('category_url', $category_slug)->first();
            if($category !== null) {
                $posts = $posts->where('post_category', $category->id);
                $vdata['current'] = $category->category_name;   
            }
                
        }
        $vdata['categories'] = BlogCategories::orderBy('category_name', 'ASC')->get();
        $vdata['posts'] = $posts->paginate(config('pagination.items_per_page'));

        $this->meta(
            (isset($category) && $category !== null) ? $category->category_name : 'Blog - wszystkie',
            'Blog Wolnego Słowa'
            );
        
        return view('web.blog.index', $vdata);
    }
    
    public function post(Request $request, $category_slug = null, $post_id)
    {
        try {            
            $vdata['post'] = BlogPosts::find($post_id);
            $vdata['category'] = BlogCategories::find($vdata['post']->post_category);
            
            $this->meta(
                $vdata['post']->post_title,
                $vdata['post']->post_seo_description
                );
            
            return view('web.blog.post', $vdata);            
        } catch(\Exception $e) {
            abort(404);
        }               
    }
}
