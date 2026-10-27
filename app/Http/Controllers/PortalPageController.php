<?php
namespace App\Http\Controllers;
use App\Models\Collective;
use App\Models\Department;
use App\Models\Document;
use App\Models\EducationProgram;
use App\Models\Page;
use App\Models\Post;
use Illuminate\View\View;
class PortalPageController extends Controller {
 private array $defaults=[
  'about'=>[['id'=>'hero','enabled'=>true,'title'=>'Об училище'],['id'=>'map','enabled'=>true,'title'=>'Разделы'],['id'=>'history','enabled'=>true,'title'=>'История'],['id'=>'pavlov','enabled'=>true,'title'=>'Ф. П. Павлов'],['id'=>'departments','enabled'=>true,'title'=>'Отделения'],['id'=>'collectives','enabled'=>true,'title'=>'Творческие коллективы'],['id'=>'pride','enabled'=>true,'title'=>'Наша гордость'],['id'=>'facilities','enabled'=>true,'title'=>'Материальная база']],
  'applicants'=>[['id'=>'hero','enabled'=>true,'title'=>'Абитуриенту'],['id'=>'steps','enabled'=>true,'title'=>'Как поступить'],['id'=>'programs','enabled'=>true,'title'=>'Специальности'],['id'=>'documents','enabled'=>true,'title'=>'Документы'],['id'=>'exams','enabled'=>true,'title'=>'Вступительные испытания'],['id'=>'results','enabled'=>true,'title'=>'Результаты'],['id'=>'contact','enabled'=>true,'title'=>'Задать вопрос']],
  'students'=>[['id'=>'hero','enabled'=>true,'title'=>'Студенту'],['id'=>'schedule','enabled'=>true,'title'=>'Расписание'],['id'=>'study','enabled'=>true,'title'=>'Учебный процесс'],['id'=>'library','enabled'=>true,'title'=>'Библиотека'],['id'=>'practice','enabled'=>true,'title'=>'Практика'],['id'=>'life','enabled'=>true,'title'=>'Студенческая жизнь'],['id'=>'documents','enabled'=>true,'title'=>'Документы']],
  'activity'=>[['id'=>'hero','enabled'=>true,'title'=>'Деятельность училища'],['id'=>'directions','enabled'=>true,'title'=>'Основные направления']]
 ];
 public function show(string $slug): View {
  abort_unless(isset($this->defaults[$slug]),404); $page=Page::firstOrCreate(['slug'=>$slug],['title'=>ucfirst($slug),'type'=>'builder','status'=>'published','blocks'=>$this->defaults[$slug]]);
  $blocks=collect($page->blocks??$this->defaults[$slug])->filter(fn($b)=>$b['enabled']??true)->values();
  $data=['page'=>$page,'blocks'=>$blocks,'departments'=>Department::where('is_active',true)->orderBy('sort')->get(),'collectives'=>Collective::orderBy('title')->limit(6)->get(),'programs'=>EducationProgram::where('is_active',true)->orderBy('sort')->get(),'documents'=>Document::where('is_public',true)->where('category',$slug)->orderByDesc('document_date')->get(),'events'=>Post::published()->type('event')->orderBy('starts_at')->limit(3)->get()];
  return view('portals.'.$slug,$data);
 }
}