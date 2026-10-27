<?php
namespace App\Http\Controllers;
use App\Models\Page;
use App\Models\Form;
use Illuminate\View\View;
class ContentPageController extends Controller {
 private array $titles=[
  'history'=>'История училища','pavlov'=>'Ф. П. Павлов','leadership'=>'Руководство','structure'=>'Структура училища','facilities'=>'Материальная база',
  'student-council'=>'Студенческое самоуправление','dorm-council'=>'Студенческий совет общежития','sport-club'=>'Студенческий спортивный клуб','philharmonic'=>'Студенческая филармония','personal-growth'=>'Школа личностного роста','volunteering'=>'Волонтёрское движение',
  'career'=>'Карьера','aesthetic-class'=>'Эстетический класс при СОШ','federal-competitions'=>'Федеральные олимпиады и конкурсы','dormitory-documents'=>'Документы общежития','dormitory-victories'=>'Наши победы','feedback'=>'Обратная связь'
 ];
 public function show(string $key): View {
  abort_unless(isset($this->titles[$key]),404);
  $page=Page::published()->where('slug',$key)->first() ?? new Page(['slug'=>$key,'title'=>$this->titles[$key],'status'=>'published']);
  $embeddedForm=!empty($page->blocks['form_slug'])?Form::where('slug',$page->blocks['form_slug'])->where('is_active',true)->first():null; return view('public.content-page',compact('page','embeddedForm'));
 }
 private function structured(string $key,array $categories): View{$page=Page::published()->where('slug',$key)->first()??new Page(['slug'=>$key,'title'=>$this->titles[$key],'status'=>'published']);$documents=\App\Models\Document::where('is_public',true)->whereIn('category',$categories)->orderByDesc('document_date')->get();$embeddedForm=!empty($page->blocks['form_slug'])?Form::where('slug',$page->blocks['form_slug'])->where('is_active',true)->first():null;return view('public.structured-page',compact('page','documents','embeddedForm'));}
 public function history(): View{return $this->show('history');} public function pavlov(): View{return $this->show('pavlov');} public function leadership(): View{return $this->show('leadership');} public function structure(): View{return $this->show('structure');} public function facilities(): View{return $this->show('facilities');}
 public function council(): View{return $this->show('student-council');} public function dormCouncil(): View{return $this->show('dorm-council');} public function sportClub(): View{return $this->show('sport-club');} public function philharmonic(): View{return $this->show('philharmonic');} public function personalGrowth(): View{return $this->show('personal-growth');} public function volunteering(): View{return $this->show('volunteering');}
 public function career(): View{return $this->show('career');} public function aesthetic(): View{return $this->structured('aesthetic-class',['aesthetic-class']);} public function federal(): View{return $this->structured('federal-competitions',['federal-competitions']);} public function dormDocuments(): View{return $this->show('dormitory-documents');} public function dormVictories(): View{return $this->show('dormitory-victories');} public function feedback(): View{$page=Page::published()->where('slug','feedback')->first()??new Page(['slug'=>'feedback','title'=>'Обратная связь','status'=>'published']);$form=Form::where('slug','feedback')->where('is_active',true)->first();return view('feedback.index',compact('page','form'));}
}