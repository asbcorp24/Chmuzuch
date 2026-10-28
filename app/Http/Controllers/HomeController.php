<?php
namespace App\Http\Controllers;
use App\Models\Collective;
use App\Models\Department;
use App\Models\Page;
use App\Models\Post;
use Illuminate\View\View;
class HomeController extends Controller {
 public function index(): View {
  $page=Page::where('slug','home')->first();
  $blocks=$page?->blocks??[];
  if (!is_array($blocks) || !collect($blocks)->contains(fn($block) => is_array($block) && ($block['enabled'] ?? true))) {
   $blocks=[
    ['id'=>'hero','enabled'=>true],
    ['id'=>'news','enabled'=>true],
    ['id'=>'events','enabled'=>true],
    ['id'=>'departments','enabled'=>true],
    ['id'=>'collectives','enabled'=>true],
    ['id'=>'media','enabled'=>true],
    ['id'=>'portals','enabled'=>true],
   ];
  }
  return view('home',['page'=>$page,'blocks'=>collect($blocks)->filter(fn($b)=>$b['enabled']??true)->values(),'news'=>Post::published()->type('news')->latest('published_at')->limit(3)->get(),'announcements'=>Post::published()->type('announcement')->latest('published_at')->limit(3)->get(),'events'=>Post::published()->type('event')->orderBy('starts_at')->limit(3)->get(),'departments'=>Department::where('is_active',true)->orderBy('sort')->get(),'collectives'=>Collective::where('is_active',true)->orderBy('sort')->orderBy('title')->limit(6)->get()]);
 }
}