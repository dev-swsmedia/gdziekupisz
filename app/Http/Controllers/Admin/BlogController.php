<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Admin\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use App\Models\BlogPosts;
use App\Models\BlogCategories;


class BlogController extends Controller
{
    public function __construct()
    {
        parent::__construct();
    }
    
    public function index(Request $request) : View
    {
        return view('admin.blog.index');
    }
    
    public function categories_index(Request $request) : View
    {
        $data['categories'] = BlogCategories::all();
        return view('admin.blog.categories', $data);
    }
    
    public function edit(Request $request, $id = null) : View
    {
        $data['categories'] = BlogCategories::all();
        
        if($id == null) return view('admin.blog.editor', $data);
        
        $data['post'] = BlogPosts::find($id);
        
        if($data['post'] == null) return abort('404');
        
        return view('admin.blog.editor', $data);
    }
    
    public function save(Request $request, $id = null) : RedirectResponse
    {
        $validator = Validator::make($request->all(), [
            'post_title' => [                
                'required',
                'max:255',
                Rule::unique('blog_posts')->where('id', '<>', $id),            
            ],
            'post_content' => 'required'
        ]);
        
        $attributeNames = array(
            'post_title' => 'Tytuł wpisu',
            'post_content' => 'Treść wpisu',
        );
        
        $validator->setAttributeNames($attributeNames);
        
        if ($validator->fails()) {
            $errors = '<ul>';
            
            foreach($validator->errors()->all() as $err)
            {
                $errors .= '<li>'.$err.'</li>';
            }
            
            $errors .= '</ul>';
            
            return redirect()->back()->withErrors(['message' => $errors])->withInput();
        }
        
        try {
            BlogPosts::updateOrCreate(
                ['id' => $id],
                [
                    'post_title' => $request->post_title,
                    'post_lead' =>  $request->post_lead,
                    'post_content' => $request->post_content,
                    'post_image' => $request->post_image,
                    'post_seo_keywords' => $request->post_seo_keywords,
                    'post_seo_description' => $request->post_seo_description,
                    'post_url' => ($request->post_url !== null) ? $request->post_url : Str::slug($request->post_title),
                    'post_category' => $request->post_category,
                    //'post_ai' => $request->post_ai,
                    'active' => $request->active                    
                ]
             );
            return redirect(route('admin.blog.index'))->with('message', 'Zapisano zmiany'); 
        } catch(\Exception $e) {
            return redirect(route('admin.blog.index'))->withErrors(['message' => 'Nie zapisano zmian ['.$e->getMessage().']']);
        }       
    }
    
    public function category_save(Request $request) : RedirectResponse
    {
        $id = $request->id;
        try {
            BlogCategories::updateOrCreate(
                ['id' => $id],
                [
                    'category_name' => $request->category_name,
                    'category_url' => ($request->category_url !== null) ? $request->category_url : Str::slug($request->category_name),
                ]
                );
            return redirect(route('admin.blog.categories'))->with('message', 'Zapisano zmiany');
        } catch(\Exception $e) {
            return redirect(route('admin.blog.categories'))->withErrors(['message' => 'Nie zapisano zmian ['.$e->getMessage().']']);
        }
    }
    
    public function delete($id) : RedirectResponse
    {
        try {
            BlogPosts::find($id)->delete();
            return redirect(route('admin.blog.index'))->with('message', 'Usunięto wpis');
        } catch(\Exception $e) {
            return redirect(route('admin.blog.index'))->withErrors(['message' => 'Nie zapisano zmian ['.$e->getMessage().']']);
        } 
    }
    
    public function category_delete($id) : RedirectResponse
    {
        try {
            BlogCategories::find($id)->delete();
            return redirect(route('admin.blog.categories'))->with('message', 'Usunięto kategorię bloga');
        } catch(\Exception $e) {
            return redirect(route('admin.blog.categories'))->withErrors(['message' => 'Nie zapisano zmian ['.$e->getMessage().']']);
        }
    }
    
    
    function __dt_GetPosts(Request $request) : JsonResponse
    {
        $columns = array(
            0 => 'id',
            1 => 'post_image',
            2 => 'post_title',
            3 => 'created_at',
            4 => 'active'
        );
        
        $orderBy = $columns[$request->query('order')[0]['column']];
        $order = $request->query('order')[0]['dir'];
        
        $records = BlogPosts::orderBy($orderBy, $order);
        
        // append search query if needed
        if ($request->query('search')['value'] !== NULL && !empty($request->query('search')['value']))
        {
            $records = $records->where('post_title', 'LIKE', '%'.$request->query('search')['value'].'%');
        }
        $records = $records->whereNull('deleted_at');
        
        // count total number of messages
        $total = $records->count();
        
        // get items for current page
        $records = $records->skip($request->query('start'))
                            ->take($request->query('length'));
        
        // count total number of filtered messages
        $filtered = $records->count();
        
        // execute query
        $records = $records->get();
        
        // make a return array
        $return = array();
        
        $return['recordTotal'] = $total;
        $return['recordsFiltered'] = $total;
        
        $return['data'] = array();
        
        foreach($records as $r)
        {
            $image = '';
            if($r->post_image !== null && str_contains($r->post_image, 'http')) {
                $image = '<img src="'.$r->post_image.'" style="max-width: 250px; max-height: 60px;" />';
            } else if($r->post_image !== null) {
                $image = '<img src="'.asset('storage/uploads/'.$r->post_image).'" style="max-width: 250px; max-height: 60px;" />';
            }
                
            $category_url = ($r->category !== null) ? $r->category->category_url : 0;
            
            $tmp = array();
            $tmp[] = $r->id;
            $tmp[] = $image; 
            $tmp[] = $r->post_title;
            $tmp[] = date('d.m.Y H:i:s', strtotime($r->created_at));
            $tmp[] = ($r->active > 0) ? '<span class="badge barge-success bg-success">Opublikowany</span>' : '<span class="badge barge-danger bg-danger">Nieopublikowany</span>';
            $tmp[] = '<button class="btn-outline-primary btn btn-xs previewLink mr-2" data-url="'.route('web.blog.post', [$category_url, $r->id, $r->post_url]).'"><i class="fa fa-link"></i>&nbsp;Link</button><button class="btn-outline-danger btn btn-xs delete" data-title="'.$r->post_title.'" data-href="'.route('admin.blog.delete', $r->id).'"><i class="fa fa-trash"></i></button>';
            
            $return['data'][] = $tmp;
        }
        
        return Response::json($return);
    }
}
