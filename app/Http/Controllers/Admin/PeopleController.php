<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\Collective;
use App\Models\Department;
use App\Models\Teacher;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\View\View;
class PeopleController extends Controller {
 public function index(string $entity): View { $this->guard($entity); $items=$this->query($entity)->latest('updated_at')->paginate(30); return view('admin.people.index',compact('entity','items')); }
 public function edit(string $entity,string $id='new'): View { $this->guard($entity); $record=$id==='new'?null:$this->query($entity)->findOrFail($id); return view('admin.people.edit',['entity'=>$entity,'record'=>$record,'departments'=>Department::orderBy('sort')->get(),'teachers'=>Teacher::orderBy('name')->get()]); }
 public function save(Request $r,string $entity,string $id='new'): RedirectResponse {
  $this->guard($entity); $base=['title'=>'nullable|string|max:255','name'=>'nullable|string|max:255','slug'=>'nullable|string|max:255','description'=>'nullable|string','history'=>'nullable|string','department_id'=>'nullable|exists:departments,id','head_teacher_id'=>'nullable|exists:teachers,id','leader_id'=>'nullable|exists:teachers,id','position'=>'nullable|string|max:255','education'=>'nullable|string','qualifications'=>'nullable|string','bio'=>'nullable|string','repertoire'=>'nullable|string','sort'=>'nullable|integer|min:0','is_active'=>'nullable|boolean'];
  $d=$r->validate($base); $label=$entity==='teachers'?($d['name']??''):($d['title']??''); abort_if(!$label,422,'Название обязательно');
  $d['slug']=Str::slug($d['slug']?:$label); $d['is_active']=$r->boolean('is_active'); $model=$this->model($entity); $record=$id==='new'?new $model:$model::findOrFail($id); $record->fill($d)->save();
  return redirect()->route('admin.people.index',$entity)->with('success','Сохранено');
 }
 public function destroy(string $entity,string $id): RedirectResponse { $this->guard($entity); $this->query($entity)->findOrFail($id)->delete(); return back()->with('success','Удалено'); }
 private function guard(string $e): void { abort_unless(in_array($e,['departments','teachers','collectives']),404); }
 private function model(string $e): string { return ['departments'=>Department::class,'teachers'=>Teacher::class,'collectives'=>Collective::class][$e]; }
 private function query(string $e){$m=$this->model($e);return $m::query();}
}