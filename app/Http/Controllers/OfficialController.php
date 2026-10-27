<?php
namespace App\Http\Controllers;
use App\Models\Document;
use App\Models\SectionEntry;
use Illuminate\View\View;
class OfficialController extends Controller {
 public function index(): View {$sections=SectionEntry::portal('official')->where('is_active',true)->orderBy('sort')->get();return view('official.index',['sections'=>$sections,'groups'=>$sections->groupBy(fn($x)=>$x->group?:'Сведения')]);}
 public function show(string $slug): View {$page=SectionEntry::portal('official')->where('is_active',true)->where('slug',$slug)->firstOrFail();$documents=Document::where('is_public',true)->where('category','official.'.$slug)->orderByDesc('document_date')->get();return view('official.show',compact('page','slug','documents'));}
}