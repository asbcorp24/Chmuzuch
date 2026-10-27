<?php
namespace App\Http\Controllers;
use App\Models\Activity;
use App\Models\Document;
use App\Models\Form;
use Illuminate\View\View;
class CompetitionController extends Controller {
 public function index(): View {$competitions=Activity::type('competition')->where('is_active',true)->orderByDesc('year')->orderByDesc('starts_at')->get();$years=$competitions->pluck('year')->filter()->unique()->sortDesc()->values();return view('competitions.index',compact('competitions','years'));}
 public function show(string $slug): View {$competition=Activity::type('competition')->where('is_active',true)->where('slug',$slug)->firstOrFail();$documents=Document::where('is_public',true)->where('category','competition.'.$slug)->orderByDesc('document_date')->get();$form=!empty($competition->meta['form_slug'])?Form::where('slug',$competition->meta['form_slug'])->where('is_active',true)->first():null;return view('competitions.show',compact('competition','documents','form'));}
}