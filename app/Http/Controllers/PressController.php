<?php
namespace App\Http\Controllers;
use Illuminate\View\View;
class PressController extends Controller {
 public function index(): View { $d=config('press',[]); return view('press.index',['news'=>$d['news']??[],'announcements'=>$d['announcements']??[],'media'=>$d['media']??[]]); }
 public function article(string $type,string $slug): View { $map=['news'=>'news','announcements'=>'announcements','media'=>'media']; abort_unless(isset($map[$type]),404); $items=config('press.'.$map[$type],[]); abort_unless(isset($items[$slug]),404); return view('press.article',['article'=>$items[$slug],'type'=>$type]); }
 public function events(): View { return view('events.index',['events'=>config('press.events',[])]); }
 public function event(string $slug): View { $items=config('press.events',[]); abort_unless(isset($items[$slug]),404); return view('events.show',['event'=>$items[$slug]]); }
}