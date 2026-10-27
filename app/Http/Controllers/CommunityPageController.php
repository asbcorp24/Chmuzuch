<?php
namespace App\Http\Controllers;
use App\Models\Document;
use App\Models\Page;
use App\Models\Post;
use Illuminate\View\View;
class CommunityPageController extends Controller {
 private array $defaults=[
 'student-life'=>[['id'=>'hero','title'=>'Студенческая жизнь','enabled'=>true],['id'=>'projects','title'=>'Направления','enabled'=>true],['id'=>'events','title'=>'События','enabled'=>true],['id'=>'support','title'=>'Поддержка','enabled'=>true]],
 'dormitory'=>[['id'=>'hero','title'=>'Общежитие','enabled'=>true],['id'=>'info','title'=>'Общая информация','enabled'=>true],['id'=>'council','title'=>'Студенческий совет','enabled'=>true],['id'=>'documents','title'=>'Документы','enabled'=>true],['id'=>'victories','title'=>'Наши победы','enabled'=>true]],
 'library'=>[['id'=>'hero','title'=>'Библиотека','enabled'=>true],['id'=>'collections','title'=>'Фонды','enabled'=>true],['id'=>'digital','title'=>'Электронные ресурсы','enabled'=>true],['id'=>'documents','title'=>'Документы библиотеки','enabled'=>true]],
 'practice'=>[['id'=>'hero','title'=>'Сектор практики','enabled'=>true],['id'=>'directions','title'=>'Практическая подготовка','enabled'=>true],['id'=>'documents','title'=>'Документы и графики','enabled'=>true],['id'=>'career','title'=>'Практика и карьера','enabled'=>true]],
 'union'=>[['id'=>'hero','title'=>'Профком училища','enabled'=>true],['id'=>'committee','title'=>'Профсоюзный комитет','enabled'=>true],['id'=>'commission','title'=>'Ревизионная комиссия','enabled'=>true],['id'=>'documents','title'=>'Документы','enabled'=>true],['id'=>'contacts','title'=>'Контакты','enabled'=>true]]
 ];
 public function studentLife(): View{return $this->show('student-life');} public function dormitory(): View{return $this->show('dormitory');} public function library(): View{return $this->show('library');} public function practice(): View{return $this->show('practice');} public function union(): View{return $this->show('union');}
 public function show(string $slug): View {abort_unless(isset($this->defaults[$slug]),404);$page=Page::where('slug',$slug)->where('status','published')->first() ?? new Page(['slug'=>$slug,'title'=>$this->defaults[$slug][0]['title'],'type'=>'builder','status'=>'published','blocks'=>$this->defaults[$slug]]);$blocks=collect($page->blocks??$this->defaults[$slug])->filter(fn($b)=>$b['enabled']??true)->values();$documents=Document::where('is_public',true)->where('category',$slug)->orderByDesc('document_date')->get();$events=Post::published()->type('event')->orderBy('starts_at')->limit(6)->get();return view('community.'.$slug,compact('page','blocks','documents','events'));}
}