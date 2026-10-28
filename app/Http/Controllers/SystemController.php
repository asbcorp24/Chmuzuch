<?php
namespace App\Http\Controllers;
use App\Models\{Page,Department,Collective,Activity};
use Illuminate\View\View;
class SystemController extends Controller {
 public function sitemap(): View {
  return view('system.sitemap',[
   'departments'=>Department::where('is_active',true)->orderBy('sort')->get(),
   'collectives'=>Collective::where('is_active',true)->orderBy('sort')->orderBy('title')->get(),
   'activities'=>Activity::where('is_active',true)->orderByDesc('year')->get(),
  ]);
 }
 private function legal(string $slug,string $title,string $kind): View {$page=Page::published()->where('slug',$slug)->first();return view('system.legal',compact('page','title','kind'));}
 public function privacy(): View {return $this->legal('privacy','Политика обработки персональных данных','privacy');}
 public function consent(): View {return $this->legal('personal-data-consent','Согласие на обработку персональных данных','consent');}
 public function cookies(): View {return $this->legal('cookies','Политика использования cookie','cookies');}
}