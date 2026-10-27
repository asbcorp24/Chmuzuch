<?php
namespace App\Http\Controllers;
use App\Models\Document;use App\Models\SectionEntry;use Illuminate\View\View;
class ServicePortalController {
 private array $portals=['safety'=>['Безопасность','Безопасная образовательная среда'],'employees'=>['Работникам','Рабочее пространство'],'anticorruption'=>['Противодействие коррупции','Открытость и профилактика'],'tenants'=>['Арендаторам','Имущество и аренда']];
 public function safety(): View{return $this->index('safety');} public function employees(): View{return $this->index('employees');} public function anticorruption(): View{return $this->index('anticorruption');} public function tenants(): View{return $this->index('tenants');}
 private function index(string $portal): View{abort_unless(isset($this->portals[$portal]),404);[$title,$eyebrow]=$this->portals[$portal];$items=SectionEntry::portal($portal)->where('is_active',true)->orderBy('sort')->get();return view('service.index',compact('portal','title','eyebrow','items')+['mode'=>$portal]);}
 public function show(string $portal,string $slug): View{abort_unless(isset($this->portals[$portal]),404);$page=SectionEntry::portal($portal)->where('is_active',true)->where('slug',$slug)->firstOrFail();$documents=Document::where('is_public',true)->where('category',$portal.'.'.$slug)->orderByDesc('document_date')->get();[$title]=$this->portals[$portal];return view('service.show',compact('portal','page','slug','documents','title'));}
}