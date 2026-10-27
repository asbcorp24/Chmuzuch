<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\Collective;
use App\Models\Department;
use App\Models\Teacher;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
class PeopleController extends Controller {
 public function index(string $entity){$this->guard($entity);return view('admin.people.index',['entity'=>$entity,'items'=>$this->query($entity)->latest('updated_at')->paginate(30)]);}
 public function edit(string $entity,string $id='new'){$this->guard($entity);$record=$id==='new'?null:$this->query($entity)->findOrFail($id);return view('admin.people.edit',['entity'=>$entity,'record'=>$record,'departments'=>Department::orderBy('sort')->get(),'teachers'=>Teacher::where('is_active',true)->orderBy('name')->get()]);}
 public function save(Request $r,string $entity,string $id='new'){$this->guard($entity);$base=['title'=>'nullable|string|max:255','name'=>'nullable|string|max:255','slug'=>'nullable|string|max:255','description'=>'nullable|string','history'=>'nullable|string','department_id'=>'nullable|exists:departments,id','head_teacher_id'=>'nullable|exists:teachers,id','leader_id'=>'nullable|exists:teachers,id','position'=>'nullable|string|max:255','education'=>'nullable|string','qualifications'=>'nullable|string','bio'=>'nullable|string','repertoire'=>'nullable|string','sort'=>'nullable|integer|min:0','is_active'=>'nullable|boolean','specialties'=>'nullable|string','disciplines'=>'nullable|string','achievements_text'=>'nullable|string','members'=>'nullable|string'];$d=$r->validate($base);$label=$entity==='teachers'?($d['name']??''):($d['title']??'');abort_if(!$label,422,'Название обязательно');$record=$id==='new'?new ($this->model($entity)):$this->query($entity)->findOrFail($id);$slug=Str::slug($d['slug']?:$label);$exists=$this->query($entity)->where('slug',$slug)->when($record->exists,fn($q)=>$q->whereKeyNot($record->id))->exists();if($exists)return back()->withErrors(['slug'=>'Такой slug уже используется.'])->withInput();$d['slug']=$slug;$d['is_active']=$r->boolean('is_active');
 if($entity==='departments'){$d['meta']=$this->meta($d,['specialties','disciplines','achievements_text']);}
 if($entity==='collectives'){$d['meta']=$this->meta($d,['members','achievements_text']);}
 if($entity==='teachers'){$lines=$this->lines($d['achievements_text']??'');$disc=$this->lines($d['disciplines']??'');$d['achievements']=['items'=>$lines,'disciplines'=>$disc];unset($d['achievements_text'],$d['disciplines']);}
 $record->fill($d)->save();return redirect()->route('admin.people.index',$entity)->with('success','Сохранено');}
 private function meta(array &$d,array $keys): array {$m=[];foreach($keys as $k){$v=trim((string)($d[$k]??''));if($v!=='')$m[$k]=$v;unset($d[$k]);}return $m;}
 private function lines(string $v): array{return array_values(array_filter(array_map('trim',preg_split('/\r\n|\r|\n/',$v))));}
 public function destroy(string $entity,string $id){$this->guard($entity);$this->query($entity)->findOrFail($id)->delete();return back()->with('success','Удалено');}
 private function guard(string $e): void{abort_unless(in_array($e,['departments','teachers','collectives']),404);} private function model(string $e): string{return ['departments'=>Department::class,'teachers'=>Teacher::class,'collectives'=>Collective::class][$e];} private function query(string $e){$m=$this->model($e);return $m::query();}
}