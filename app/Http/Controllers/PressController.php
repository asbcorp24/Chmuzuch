<?php
namespace App\Http\Controllers;
use App\Models\Post;
use Illuminate\View\View;
class PressController extends Controller {
 public function index(): View {
  return view('press.index',['news'=>Post::published()->type('news')->latest('published_at')->paginate(12),'announcements'=>Post::published()->type('announcement')->latest('published_at')->limit(6)->get(),'media'=>Post::published()->type('media_about')->latest('published_at')->limit(6)->get()]);
 }
 public function article(string $type,string $slug): View {
  $map=['news'=>'news','announcements'=>'announcement','media'=>'media_about']; abort_unless(isset($map[$type]),404);
  $article=Post::published()->type($map[$type])->where('slug',$slug)->firstOrFail(); return view('press.article',['article'=>$article,'type'=>$type]);
 }
 public function events(): View { return view('events.index',['events'=>Post::published()->type('event')->orderBy('starts_at')->paginate(30)]); }
 public function event(string $slug): View { $event=Post::published()->type('event')->where('slug',$slug)->firstOrFail(); return view('events.show',['event'=>$event]); }
}