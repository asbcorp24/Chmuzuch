<?php
namespace App\Http\Controllers;
use App\Models\{Page,Post,Teacher,Department,Collective,EducationProgram,LearningOffer,Activity,SectionEntry};
use Illuminate\Http\Request;
use Illuminate\View\View;
class SearchController extends Controller {
 public function __invoke(Request $request): View {
  $q=trim((string)$request->query('q',''));$results=collect();
  if(mb_strlen($q)>=2){
   $like='%'.str_replace(['%','_'],['\\%','\\_'],$q).'%';
   $add=function($rows,$type,$url)use(&$results){foreach($rows as $row)$results->push(['type'=>$type,'title'=>$row->title??$row->name,'text'=>$row->excerpt??$row->lead??$row->description??$row->position,'url'=>$url($row)]);};
   $add(Page::published()->where(fn($x)=>$x->where('title','like',$like)->orWhere('content','like',$like))->limit(10)->get(),'Страница',fn($x)=>'/'.$x->slug);
   $add(Post::published()->where(fn($x)=>$x->where('title','like',$like)->orWhere('content','like',$like))->limit(15)->get(),'Публикация',fn($x)=>$x->type==='event'?'/events/'.$x->slug:'/press/'.$x->slug);
   $add(Teacher::where('is_active',true)->where(fn($x)=>$x->where('name','like',$like)->orWhere('bio','like',$like))->limit(10)->get(),'Преподаватель',fn($x)=>'/teachers/'.$x->slug);
   $add(Department::where('is_active',true)->where('title','like',$like)->limit(10)->get(),'Отделение',fn($x)=>'/departments/'.$x->slug);
   $add(Collective::where('title','like',$like)->limit(10)->get(),'Коллектив',fn($x)=>'/collectives/'.$x->slug);
   $add(EducationProgram::where('is_active',true)->where('title','like',$like)->limit(10)->get(),'Образовательная программа',fn($x)=>'/education/programs/'.$x->slug);
   $add(LearningOffer::where('is_active',true)->where('title','like',$like)->limit(10)->get(),'Программа',fn($x)=>$x->scope==='dshi'?'/dshi/programs/'.$x->slug:'/additional-education/courses/'.$x->slug);
   $add(Activity::where('is_active',true)->where('title','like',$like)->limit(15)->get(),'Проект / конкурс',fn($x)=>$x->type==='competition'?'/competitions/'.$x->slug:($x->type==='conference'?'/science/conferences/'.$x->slug:'/science/projects/'.$x->slug));
   $add(SectionEntry::where('is_active',true)->where(fn($x)=>$x->where('title','like',$like)->orWhere('content','like',$like))->limit(15)->get(),'Официальная информация',fn($x)=>$x->portal==='official'?'/official/'.$x->slug:'/'.$x->portal.'/'.$x->slug);
  }
  return view('search',compact('q','results'));
 }
}