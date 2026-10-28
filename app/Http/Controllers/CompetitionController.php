<?php
namespace App\Http\Controllers;
use App\Models\{Activity,Document,Form,Post,Media};
use Illuminate\View\View;
class CompetitionController extends Controller {
 public function index(): View {$competitions=Activity::type('competition')->where('is_active',true)->orderByDesc('year')->orderByDesc('starts_at')->get();$years=$competitions->pluck('year')->filter()->unique()->sortDesc()->values();return view('competitions.index',compact('competitions','years'));}
 public function show(string $slug): View {$competition=Activity::type('competition')->where('is_active',true)->where('slug',$slug)->firstOrFail();$documents=Document::where('is_public',true)->where('category','competition.'.$slug)->orderByDesc('document_date')->get();$form=!empty($competition->meta['form_slug'])?Form::where('slug',$competition->meta['form_slug'])->where('is_active',true)->first():null;$event=!empty($competition->meta['event_slug'])?Post::published()->type('event')->where('slug',$competition->meta['event_slug'])->first():null;$media=Media::where('meta->activity_id',$competition->id)->latest()->limit(18)->get();return view('competitions.show',compact('competition','documents','form','event','media'));}
}