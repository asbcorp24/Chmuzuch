<?php
namespace App\Http\Controllers;
use App\Models\{Document,LearningOffer,Post,Teacher};
class DshiController extends Controller {
 private function teachers($programs){$ids=$programs->flatMap(fn($p)=>$p->content['teacher_ids']??[])->map(fn($id)=>(int)$id)->unique()->values();if($ids->isEmpty())return collect();$order=$ids->flip();return Teacher::where('is_active',true)->whereIn('id',$ids)->get()->sortBy(fn($t)=>$order[$t->id]??9999)->values();}
 private function events($programs){$slugs=$programs->flatMap(fn($p)=>$p->content['event_slugs']??[])->filter()->unique()->values();return $slugs->isEmpty()?collect():Post::published()->type('event')->whereIn('slug',$slugs)->orderBy('starts_at')->get();}
 public function index(){$programs=LearningOffer::scope('dshi')->where('is_active',true)->orderBy('sort')->get();return view('dshi.index',['programs'=>$programs,'documents'=>Document::where('is_public',true)->where('category','dshi')->orderByDesc('document_date')->get(),'teachers'=>$this->teachers($programs)->take(6),'events'=>$this->events($programs)->take(6)]);}
 public function show(string $slug){$program=LearningOffer::scope('dshi')->where('is_active',true)->where('slug',$slug)->firstOrFail();$documents=Document::where('is_public',true)->where('category','dshi.'.$slug)->orderByDesc('document_date')->get();$teachers=$this->teachers(collect([$program]));$events=$this->events(collect([$program]));return view('dshi.show',compact('program','documents','teachers','events'));}
}