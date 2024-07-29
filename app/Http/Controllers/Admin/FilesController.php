<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Admin\Controller;
use App\Models\FilesManager;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Response;
use Intervention\Image\Facades\Image;

class FilesController extends Controller
{
    function __construct()
    {
        parent::__construct();
    }
    
    public function index() : View
    {
        return view('admin.filesmanager.index');
    }
    
    public function edit(?int $file_id = null) : View
    {
        $data = [];
        
        if($file_id !== null) {
            $data['file'] = FilesManager::find($file_id);
        }
        
        return view('admin.filesmanager.editor', $data);
    }
    
    public function save(Request $request, int|null $id = null)
    {
        
        try {
            if($id == null)
            {
                Validator::make($request->all(), [
                    'file' => [
                        'required',
                    ],
                    'file_name' => ['required']
                ])->validate();
            }
            
            $data = [];
            
            $data['file_name'] = $request->file_name;
            $data['file_description'] = $request->file_desc;
            
            if($id == null) {
                $data['file_path'] = $this->__uploadFile($request);
                $data['file_type'] = $request->file('file')->getMimeType();
                
                if(str_contains($data['file_type'], 'image')) $this->__resizeImage($request->file('file')->getRealPath(), public_path('storage/uploads/'.$data['file_path']));
                
                $fm = new FilesManager();
                $fm->file_name = $data['file_name'];
                $fm->file_description = $data['file_description'];
                $fm->file_path = $data['file_path'];
                $fm->file_type = $data['file_type'];
                $fm->save();
            } else {
                FilesManager::find($request->id)->update($data);
            }
            
            if($request->ajax !== null) {
                return response('OK', 200);
            }
            
            return redirect(route('admin.filesmanager.index'))->with('message', 'Zapisano zmiany');
            
        } catch(\Exception $e) {
            
            if($request->ajax !== null) {
                return response($e->getMessage(), 500);
            }
            
            return redirect(route('admin.filesmanager.index'))->withErrors(['message' => 'Nie zapisano zmian ['.$e->getMessage().']']);
        }
    }
    
    public function delete(Request $request, $id)
    {
        try {
            $file = FilesManager::find($id);
            if(Storage::disk('uploads')->delete($file->file_path)) $file->delete();
            
            return redirect(route('admin.filesmanager.index'))->with('message', 'Usunięto plik');
        } catch (\Exception $e) {
            return redirect(route('admin.filesmanager.index'))->withErrors(['message' => 'Plik nie został usunięty ['.$e->getMessage().']']);
        }
    }
    
    public function __dt_getFiles(Request $request) : JsonResponse
    {
        switch($request->for) {
            case 'index':
            default:
                $columns = array(
                0 => 'file_id',
                1 => 'file_path',
                2 => 'file_name',
                3 => 'file_description',
                4 => 'file_type',
                );
                break;
                
            case 'selector':
                $columns = array(
                0 => 'file_id',
                1 => 'file_path',
                2 => 'file_name',
                );
                break;
        }
        
        $orderBy = $columns[$request->query('order')[0]['column']];
        $order = $request->query('order')[0]['dir'];
        
        $records = FilesManager::orderBy($orderBy, $order);
        
        if($request->type !== null)
        {
            $records = $records->where('file_type', 'like', '%'.$request->type.'%');
        }
        
        
        // append search query if needed
        if ($request->query('search')['value'] !== NULL && !empty($request->query('search')['value']))
        {
            $records = $records->where('file_name', 'LIKE', '%'.$request->query('search')['value'].'%')
            ->orWhere('file_description', 'LIKE', '%'.$request->query('search')['value'].'%');
        }
        
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
        
        switch($request->for) {
            case 'index':
            default:
                foreach($records as $r)
                {
                    $tmp = array();
                    $tmp[] = $r->file_id;
                    $tmp[] = (str_contains($r->file_type, 'image') || str_contains($r->file_type, 'pdf')) ? '<img src="'.asset('storage/uploads/'.$r->file_path).'" style="max-width: 250px; max-height: 60px;" />' : '';
                    $tmp[] = $r->file_name;
                    $tmp[] = $r->file_description;
                    $tmp[] = $r->file_type;
                    $tmp[] = '<a class="btn btn-primary btn-xs mr-2" href="'.asset('storage/uploads/'.$r->file_path).'" target="_blank"><i class="fa fa-search mr-1"></i>Podgląd</a><button class="btn-outline-primary btn btn-xs previewLink mr-2" data-url="'.asset('storage/uploads/'.$r->file_path).'"><i class="fa fa-link"></i>&nbsp;Link</button>
                        <button class="btn btn-xs btn-danger deleteFile" data-href="'.route('admin.filesmanager.delete', $r->file_id).'" data-id="'.$r->file_id.'" data-title="'.$r->file_name.'"><i class="fa fa-trash"></i></button>';
                    
                    $return['data'][] = $tmp;
                }
                break;
                
            case 'selector':
                foreach($records as $r)
                {
                    $tmp = array();
                    $tmp[] = $r->file_id;
                    $tmp[] = (str_contains($r->file_type, 'image') || str_contains($r->file_type, 'pdf')) ? '<img src="'.asset('storage/uploads/'.$r->file_path).'" style="max-width: 250px; max-height: 60px;" />' : '';
                    $tmp[] = $r->file_name;
                    $tmp[] = '<a class="btn btn-outline-primary btn-xs mr-2" href="'.asset('storage/uploads/'.$r->file_path).'" target="_blank"><i class="fa fa-search mr-1"></i>Podgląd</a><button class="btn-primary btn btn-xs selectFile mr-2" data-url="'.asset('storage/uploads/'.$r->file_path).'"><i class="fa fa-check"></i>&nbsp;Wybierz</button>                       ';
                    
                    $return['data'][] = $tmp;
                }
                break;
        }
        
        
        
        return Response::json($return);
    }
    
    private function __uploadFile(Request $request)
    {
        $file = $request->file('file');
        return $file->storeAs('', $file->hashName(), 'uploads');
    }
    
    private function __resizeImage(string $source, string $filepath) : void
    {
        Image::make($source)
            ->resize(null,1080, function($constraint) {
                $constraint->aspectRatio();
                $constraint->upsize();                
            })->save($filepath);
    }
}
