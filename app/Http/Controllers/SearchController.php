<?php
namespace App\Http\Controllers;
use App\Models\{Page,Post,Teacher,Department,Collective,EducationProgram,LearningOffer,Activity,SectionEntry,Document,Achievement,Media};
use Illuminate\Http\Request;
use Illuminate\View\View;
class SearchController extends Controller {
 public function __invoke(Request $request): View {
  $q=trim((string)$request->query('q',''));$results=collect();
  if(mb_strlen($q)>=2){
   $like='%'.str_replace(['%','_'],['\\%','\\_'],$q).'%';
   $add=function($rows,$type,$url)use(&$results){foreach($rows as $row)$results->push(['type'=>$type,'title'=>$row->title??$row->name,'text'=>$row->excerpt??$row->description??$row->caption??$row->position,'url'=>$url($row)]);};
   $add(Page::published()->where(fn($x)=>$x->where('title','like',$like)->orWhere('content','like',$like))->limit(15)->get(),'Страница',fn($x)=>'/'.$x->slug);
   $add(Post::published()->where(fn($x)=>$x->where('title','like',$like)->orWhere('excerpt','like',$like)->orWhere('content','like',$like))->limit(20)->get(),'Публикация',function($x){if($x->type==='event')return route('events.show',$x->slug);$type=['news'=>'news','announcement'=>'announcements','media_about'=>'media'][$x->type]??'news';return route('press.article',[$type,$x->slug]);});
   $add(Teacher::where('is_active',true)->where(fn($x)=>$x->where('name','like',$like)->orWhere('bio','like',$like)->orWhere('qualifications','like',$like))->limit(15)->get(),'Преподаватель',fn($x)=>route('teachers.show',$x->slug));
   $add(Department::where('is_active',true)->where(fn($x)=>$x->where('title','like',$like)->orWhere('description','like',$like))->limit(10)->get(),'Отделение',fn($x)=>route('departments.show',$x->slug));
   $add(Collective::where('is_active',true)->where(fn($x)=>$x->where('title','like',$like)->orWhere('description','like',$like))->limit(10)->get(),'Коллектив',fn($x)=>route('collectives.show',$x->slug));
   $add(EducationProgram::where('is_active',true)->where(fn($x)=>$x->where('title','like',$like)->orWhere('description','like',$like))->limit(10)->get(),'Образовательная программа',fn($x)=>route('education.program',$x->slug));
   $add(LearningOffer::where('is_active',true)->where(fn($x)=>$x->where('title','like',$like)->orWhere('description','like',$like))->limit(10)->get(),'Программа',fn($x)=>$x->scope==='dshi'?route('dshi.program',$x->slug):route('additional.course',$x->slug));
   $add(Activity::where('is_active',true)->where(fn($x)=>$x->where('title','like',$like)->orWhere('description','like',$like))->limit(15)->get(),'Проект / конкурс',fn($x)=>$x->type==='competition'?route('competitions.show',$x->slug):($x->type==='conference'?route('science.conference',$x->slug):route('science.project',$x->slug)));
   $add(SectionEntry::where('is_active',true)->where(fn($x)=>$x->where('title','like',$like)->orWhere('content','like',$like))->limit(15)->get(),'Официальная информация',fn($x)=>$x->portal==='official'?route('official.show',$x->slug):route('service.show',[$x->portal,$x->slug]));
   $add(Document::where('is_public',true)->where('title','like',$like)->limit(15)->get(),'Документ',fn($x)=>asset('storage/'.$x->file_path));
   $add(Achievement::where(fn($x)=>$x->where('title','like',$like)->orWhere('person_name','like',$like)->orWhere('competition','like',$like))->limit(15)->get(),'Достижение',fn($x)=>route('achievements',['year'=>$x->year]));
   $add(Media::where(fn($x)=>$x->where('title','like',$like)->orWhere('caption','like',$like))->limit(10)->get(),'Медиа',fn($x)=>$x->type==='video'?route('video-gallery'):($x->type==='audio'?route('audio'):route('media')));
  }
  return view('search',compact('q','results'));
 }
}