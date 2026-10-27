<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\Activity;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\View\View;
class ActivityController extends Controller {
 private function type(string $type): string {abort_unless(in_array($type,['project','conference','competition'],true),404);return $type;}
 public function index(string $type): View {$type=$this->type($type);return view('admin.activities.index',['type'=>$type,'items'=>Activity::type($type)->orderByDesc('year')->orderByDesc('starts_at')->paginate(30)]);}
 public function edit(string $type,string $id='new'): View {$type=$this->type($type);$record=$id==='new'?null:Activity::type($type)->findOrFail($id);return view('admin.activities.edit',compact('type','record'));}
 public function save(Request $r,string $type,string $id='new'): RedirectResponse {$type=$this->type($type);$d=$r->validate(['title'=>'required|string|max:255','slug'=>'nullable|string|max:255','subtitle'=>'nullable|string|max:255','status'=>'nullable|string|max:100','year'=>'nullable|integer|min:2000|max:2100','lead'=>'nullable|string|max:255','description'=>'nullable|string','starts_at'=>'nullable|date','ends_at'=>'nullable|date','place'=>'nullable|string|max:255','symbol'=>'nullable|string|max:20','is_active'=>'nullable|boolean']);$d['type']=$type;$d['slug']=Str::slug($d['slug']?:$d['title']);$d['is_active']=$r->boolean('is_active');$record=$id==='new'?new Activity:Activity::type($type)->findOrFail($id);$record->fill($d)->save();return redirect()->route('admin.activities.index',$type)->with('success','Материал сохранён');}
 public function destroy(string $type,Activity $activity): RedirectResponse {$type=$this->type($type);abort_unless($activity->type===$type,404);$activity->delete();return back()->with('success','Материал удалён');}
}