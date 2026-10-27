<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\Media;
use App\Models\Department;
use App\Models\Teacher;
use App\Models\Collective;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;
class MediaController extends Controller {
 public function index(Request $r): View { $type=$r->string('type')->toString(); $q=Media::latest(); if($type)$q->where('type',$type); return view('admin.media',['items'=>$q->paginate(48)->withQueryString(),'type'=>$type,'departments'=>Department::where('is_active',true)->orderBy('sort')->get(),'teachers'=>Teacher::where('is_active',true)->orderBy('name')->get(),'collectives'=>Collective::where('is_active',true)->orderBy('sort')->orderBy('title')->get()]); }
 public function store(Request $r): RedirectResponse {
  $r->validate(['files'=>'required','files.*'=>'file|max:102400','title'=>'nullable|string|max:255','department_id'=>'nullable|integer|exists:departments,id','teacher_id'=>'nullable|integer|exists:teachers,id','collective_id'=>'nullable|integer|exists:collectives,id']);
  foreach($r->file('files',[]) as $file){ $mime=$file->getMimeType()?:''; $ext=strtolower($file->getClientOriginalExtension()); $type=str_starts_with($mime,'image/')?'image':(str_starts_with($mime,'video/')?'video':(str_starts_with($mime,'audio/')?'audio':(in_array($ext,['glb','gltf'])?'3d':'document'))); $path=$file->store('media/'.$type,'public'); Media::create(['type'=>$type,'title'=>$r->input('title')?:pathinfo($file->getClientOriginalName(),PATHINFO_FILENAME),'path'=>$path,'mime_type'=>$mime,'size'=>$file->getSize(),'alt'=>$r->input('alt'),'meta'=>array_filter(['department_id'=>$r->input('department_id'),'teacher_id'=>$r->input('teacher_id'),'collective_id'=>$r->input('collective_id')])]); }
  return back()->with('success','Файлы загружены');
 }
 public function update(Request $r,Media $media): RedirectResponse { $d=$r->validate(['title'=>'nullable|string|max:255','alt'=>'nullable|string|max:255','caption'=>'nullable|string','department_id'=>'nullable|integer|exists:departments,id','teacher_id'=>'nullable|integer|exists:teachers,id','collective_id'=>'nullable|integer|exists:collectives,id']); $d['meta']=array_filter(['department_id'=>$d['department_id']??null,'teacher_id'=>$d['teacher_id']??null,'collective_id'=>$d['collective_id']??null]);unset($d['department_id'],$d['teacher_id'],$d['collective_id']);$media->update($d); return back()->with('success','Медиа обновлено'); }
 public function destroy(Media $media): RedirectResponse { Storage::disk('public')->delete($media->path); $media->delete(); return back()->with('success','Файл удалён'); }
}