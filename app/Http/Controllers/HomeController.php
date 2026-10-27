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
  $blocks=$page?->blocks??config('home_blocks',[]);
  return view('home',['page'=>$page,'blocks'=>collect($blocks)->filter(fn($b)=>$b['enabled']??true)->values(),'news'=>Post::published()->type('news')->latest('published_at')->limit(3)->get(),'announcements'=>Post::published()->type('announcement')->latest('published_at')->limit(3)->get(),'events'=>Post::published()->type('event')->orderBy('starts_at')->limit(3)->get(),'departments'=>Department::where('is_active',true)->orderBy('sort')->get(),'collectives'=>Collective::orderBy('title')->limit(6)->get()]);
 }
}