<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\Page;
use App\Models\Post;
use App\Models\Department;
use App\Models\Teacher;
use App\Models\Collective;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\View\View;
class CmsController extends Controller {
 private array $modules=[
  'home'=>['title'=>'Главная','icon'=>'⌂','count'=>'12 блоков'],'pages'=>['title'=>'Страницы','icon'=>'□','count'=>'Страницы сайта'],
  'news'=>['title'=>'Новости','icon'=>'N','count'=>'Публикации','post_type'=>'news'],'events'=>['title'=>'Афиша','icon'=>'◉','count'=>'Мероприятия','post_type'=>'event'],
  'announcements'=>['title'=>'Анонсы','icon'=>'A','count'=>'Пресс-центр','post_type'=>'announcement'],'media-about'=>['title'=>'СМИ о нас','icon'=>'M','count'=>'Публикации СМИ','post_type'=>'media_about'],
  'departments'=>['title'=>'Отделения','icon'=>'11','count'=>'11 отделений'],'teachers'=>['title'=>'Преподаватели','icon'=>'P','count'=>'Карточки педагогов'],
  'collectives'=>['title'=>'Коллективы','icon'=>'♫','count'=>'Творческие коллективы'],'documents'=>['title'=>'Документы','icon'=>'D','count'=>'Файлы и категории'],
  'media'=>['title'=>'Медиатека','icon'=>'▶','count'=>'Фото · видео · аудио'],'forms'=>['title'=>'Заявки','icon'=>'↗','count'=>'Обращения и формы'],
  'settings'=>['title'=>'Настройки','icon'=>'⚙','count'=>'Сайт · SEO · контакты'],
 ];
 public function dashboard(): View { return view('admin.dashboard',['modules'=>$this->modules]); }
 public function module(string $module): View|RedirectResponse {
  abort_unless(isset($this->modules[$module]),404);
  if($module==='home') return redirect()->route('admin.home.edit');
  if($module==='settings') return redirect()->route('admin.settings.edit');
  if(in_array($module,['departments','teachers','collectives'])) return redirect()->route('admin.people.index',$module);
  if($module==='media') return view('admin.media'); if($module==='forms') return view('admin.forms');
  $items=collect();
  if($module==='pages') $items=Page::latest('updated_at')->paginate(30);
  elseif(isset($this->modules[$module]['post_type'])) $items=Post::type($this->modules[$module]['post_type'])->latest('updated_at')->paginate(30);
  return view('admin.module',['module'=>$module,'meta'=>$this->modules[$module],'items'=>$items]);
 }
 public function editor(string $module,string $id='new'): View {
  abort_unless(isset($this->modules[$module]),404); $record=null;
  if($id!=='new'){ if($module==='pages') $record=Page::findOrFail($id); elseif(isset($this->modules[$module]['post_type'])) $record=Post::type($this->modules[$module]['post_type'])->findOrFail($id); }
  return view('admin.editor',['module'=>$module,'id'=>$id,'meta'=>$this->modules[$module],'record'=>$record,'departments'=>Department::where('is_active',true)->orderBy('sort')->get(),'teachers'=>Teacher::where('is_active',true)->orderBy('name')->get(),'collectives'=>Collective::where('is_active',true)->orderBy('sort')->orderBy('title')->get()]);
 }
 public function save(Request $request,string $module,string $id='new'): RedirectResponse {
  abort_unless($module==='pages'||isset($this->modules[$module]['post_type']),404);
  $data=$request->validate(['title'=>'required|string|max:255','slug'=>'nullable|string|max:255','excerpt'=>'nullable|string','content'=>'nullable|string','status'=>'required|in:draft,published,scheduled','published_at'=>'nullable|date','seo_title'=>'nullable|string|max:255','seo_description'=>'nullable|string','department_id'=>'nullable|integer|exists:departments,id','teacher_id'=>'nullable|integer|exists:teachers,id','collective_id'=>'nullable|integer|exists:collectives,id']);
  $data['slug']=Str::slug($data['slug']?:$data['title']); if(!$data['slug']) $data['slug']=Str::random(10);
  if($module==='pages'){ $record=$id==='new'?new Page:Page::findOrFail($id); $data['type']='page'; }
  else { $record=$id==='new'?new Post:Post::type($this->modules[$module]['post_type'])->findOrFail($id); $data['type']=$this->modules[$module]['post_type']; unset($data['seo_title'],$data['seo_description']); $data['meta']=array_filter(['department_id'=>$data['department_id']??null,'teacher_id'=>$data['teacher_id']??null,'collective_id'=>$data['collective_id']??null]); unset($data['department_id'],$data['teacher_id'],$data['collective_id']); }
  $record->fill($data)->save(); return redirect()->route('admin.module',$module)->with('success','Сохранено');
 }
 public function destroy(string $module,string $id): RedirectResponse {
  abort_unless($module==='pages'||isset($this->modules[$module]['post_type']),404);
  $record=$module==='pages'?Page::findOrFail($id):Post::type($this->modules[$module]['post_type'])->findOrFail($id); $record->delete();
  return redirect()->route('admin.module',$module)->with('success','Удалено');
 }
 public function formBuilder(): View{return view('admin.form-builder.index');}
 public function formEdit(string $id='new'): View{return view('admin.form-builder.edit',['id'=>$id]);}
 public function formReport(string $slug): View{return view('admin.form-builder.report',['slug'=>$slug]);}
}