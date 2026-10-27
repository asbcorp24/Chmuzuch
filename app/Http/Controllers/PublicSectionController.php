<?php
namespace App\Http\Controllers;
use App\Models\{Media,Achievement,Setting,Form,Department,Teacher,Collective};
use Illuminate\Http\Request;use Illuminate\View\View;
class PublicSectionController extends Controller {
 private function mediaQuery(Request $r,string $type){$q=Media::where('type',$type)->latest();foreach(['department','teacher','collective'] as $key){if($r->filled($key))$q->where('meta->'.$key.'_id',$r->integer($key));}return $q;}
 private function mediaFilters(): array{return ['departments'=>Department::where('is_active',true)->orderBy('sort')->get(),'teachers'=>Teacher::where('is_active',true)->orderBy('name')->get(),'collectives'=>Collective::where('is_active',true)->orderBy('sort')->orderBy('title')->get()];}
 public function media(Request $r): View{return view('public.media',['images'=>$this->mediaQuery($r,'image')->limit(24)->get(),'videos'=>$this->mediaQuery($r,'video')->limit(12)->get(),'audio'=>$this->mediaQuery($r,'audio')->limit(16)->get()]+$this->mediaFilters());}
 public function videoGallery(Request $r): View{return view('public.video-gallery',['items'=>$this->mediaQuery($r,'video')->paginate(18)->withQueryString()]+$this->mediaFilters());}
 public function audio(Request $r): View{return view('public.audio',['items'=>$this->mediaQuery($r,'audio')->paginate(30)->withQueryString()]+$this->mediaFilters());}
 public function achievements(Request $r): View{$q=Achievement::with(['teacher','department','collective'])->orderByDesc('year')->latest();if($r->filled('type'))$q->where('type',$r->string('type'));if($r->filled('year'))$q->where('year',$r->integer('year'));if($r->filled('department'))$q->where('department_id',$r->integer('department'));if($r->filled('teacher'))$q->where('teacher_id',$r->integer('teacher'));if($r->filled('collective'))$q->where('collective_id',$r->integer('collective'));return view('public.achievements',['items'=>$q->paginate(30)->withQueryString(),'departments'=>Department::where('is_active',true)->orderBy('sort')->get(),'teachers'=>Teacher::where('is_active',true)->orderBy('name')->get(),'collectives'=>Collective::where('is_active',true)->orderBy('title')->get(),'years'=>Achievement::whereNotNull('year')->distinct()->orderByDesc('year')->pluck('year')]);}
 public function pride(): View{return view('public.pride',['items'=>Achievement::where('type','pride')->with(['teacher','department','collective'])->orderByDesc('year')->paginate(24)]);}
 public function laureates(): View{return view('public.laureates',['items'=>Achievement::where('type','laureate')->with(['teacher','department','collective'])->orderByDesc('year')->paginate(40)]);}
 public function gratitudes(): View{return view('public.gratitudes',['items'=>Achievement::where('type','gratitude')->orderByDesc('year')->paginate(24)]);}
 public function contacts(): View{return view('public.contacts',['settings'=>Setting::grouped(),'feedbackForm'=>Form::where('slug','feedback')->where('is_active',true)->first()]);}
}