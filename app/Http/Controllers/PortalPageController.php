<?php
namespace App\Http\Controllers;
use App\Models\{Collective,Department,Document,EducationProgram,Form,Page,Post};
use Illuminate\View\View;
class PortalPageController extends Controller {
 private array $defaults=[
 'about'=>[['id'=>'hero','enabled'=>true,'title'=>'Об училище'],['id'=>'map','enabled'=>true,'title'=>'Разделы'],['id'=>'history','enabled'=>true,'title'=>'История'],['id'=>'pavlov','enabled'=>true,'title'=>'Ф. П. Павлов'],['id'=>'departments','enabled'=>true,'title'=>'Отделения'],['id'=>'teachers','enabled'=>true,'title'=>'Преподаватели'],['id'=>'collectives','enabled'=>true,'title'=>'Творческие коллективы'],['id'=>'pride','enabled'=>true,'title'=>'Наша гордость'],['id'=>'facilities','enabled'=>true,'title'=>'Материальная база'],['id'=>'contacts','enabled'=>true,'title'=>'Контакты']],
 'applicants'=>[['id'=>'hero','enabled'=>true,'title'=>'Абитуриенту'],['id'=>'nav','enabled'=>true,'title'=>'Навигация'],['id'=>'steps','enabled'=>true,'title'=>'Как поступить'],['id'=>'programs','enabled'=>true,'title'=>'Специальности'],['id'=>'rules','enabled'=>true,'title'=>'Правила приёма'],['id'=>'exams','enabled'=>true,'title'=>'Вступительные испытания'],['id'=>'schedule','enabled'=>true,'title'=>'Расписание испытаний'],['id'=>'results','enabled'=>true,'title'=>'Результаты'],['id'=>'documents','enabled'=>true,'title'=>'Документы'],['id'=>'open_day','enabled'=>true,'title'=>'День открытых дверей'],['id'=>'faq','enabled'=>true,'title'=>'Вопросы'],['id'=>'contact','enabled'=>true,'title'=>'Задать вопрос']],
 'students'=>[['id'=>'hero','enabled'=>true,'title'=>'Студенту'],['id'=>'fast','enabled'=>true,'title'=>'Быстрый доступ'],['id'=>'schedule','enabled'=>true,'title'=>'Расписание'],['id'=>'study','enabled'=>true,'title'=>'Учебный процесс'],['id'=>'library','enabled'=>true,'title'=>'Библиотека'],['id'=>'practice','enabled'=>true,'title'=>'Практика'],['id'=>'support','enabled'=>true,'title'=>'Поддержка'],['id'=>'life','enabled'=>true,'title'=>'Студенческая жизнь'],['id'=>'events','enabled'=>true,'title'=>'События'],['id'=>'documents','enabled'=>true,'title'=>'Документы']],
 'activity'=>[['id'=>'hero','enabled'=>true,'title'=>'Деятельность училища'],['id'=>'directions','enabled'=>true,'title'=>'Основные направления']]
 ];
 private array $titles=['about'=>'Об училище','applicants'=>'Абитуриенту','students'=>'Студенту','activity'=>'Деятельность училища'];
 public function about(): View{return $this->show('about');} public function applicants(): View{return $this->show('applicants');} public function students(): View{return $this->show('students');} public function activity(): View{return $this->show('activity');}
 public function show(string $slug): View {
  abort_unless(isset($this->defaults[$slug]),404);
  $page=Page::where('slug',$slug)->where('status','published')->first() ?? new Page(['slug'=>$slug,'title'=>$this->titles[$slug],'type'=>'builder','status'=>'published','blocks'=>$this->defaults[$slug]]);
  $blocks=collect($page->blocks??$this->defaults[$slug])->filter(fn($b)=>$b['enabled']??true)->values();
  $data=['page'=>$page,'blocks'=>$blocks,'departments'=>Department::where('is_active',true)->orderBy('sort')->get(),'collectives'=>Collective::where('is_active',true)->orderBy('sort')->orderBy('title')->limit(6)->get(),'programs'=>EducationProgram::where('is_active',true)->orderBy('sort')->get(),'documents'=>Document::where('is_public',true)->where('category',$slug)->orderByDesc('document_date')->get(),'events'=>Post::published()->type('event')->orderBy('starts_at')->limit(3)->get()];
  if($slug==='applicants'){$data['admissionDocuments']=collect(['rules','exams','schedule','results'])->mapWithKeys(fn($kind)=>[$kind=>Document::where('is_public',true)->where('category','applicants.'.$kind)->orderByDesc('document_date')->get()]);$data['openDay']=Post::published()->type('event')->where('starts_at','>=',now())->where(function($q){$q->where('meta->audience','applicants')->orWhere('slug','like','%open%')->orWhere('title','like','%открыт%');})->orderBy('starts_at')->first();$data['questionForm']=Form::where('is_active',true)->whereIn('slug',['applicants-question','feedback'])->orderByRaw("CASE WHEN slug='applicants-question' THEN 0 ELSE 1 END")->first();}
  return view('portals.'.$slug,$data);
 }
 public function defaults(string $slug): array {abort_unless(isset($this->defaults[$slug]),404);return $this->defaults[$slug];}
 public function title(string $slug): string {abort_unless(isset($this->titles[$slug]),404);return $this->titles[$slug];}
}