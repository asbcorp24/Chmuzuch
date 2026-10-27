<?php
namespace App\Http\Controllers;
use App\Models\Document;
use App\Models\SectionEntry;
use Illuminate\View\View;
class ServicePortalController extends Controller {
 public function safety(): View {return $this->index('safety','Безопасность','Безопасная образовательная среда');}
 public function employees(): View {return $this->index('employees','Работникам','Рабочее пространство');}
 private function index(string $portal,string $title,string $eyebrow): View {$items=SectionEntry::portal($portal)->where('is_active',true)->orderBy('sort')->get();return view('service.index',['mode'=>$portal,'title'=>$title,'eyebrow'=>$eyebrow,'items'=>$items]);}
 public function show(string $portal,string $slug): View {abort_unless(in_array($portal,['safety','employees'],true),404);$page=SectionEntry::portal($portal)->where('is_active',true)->where('slug',$slug)->firstOrFail();$documents=Document::where('is_public',true)->where('category',$portal.'.'.$slug)->orderByDesc('document_date')->get();return view('service.show',compact('portal','page','slug','documents'));}
}