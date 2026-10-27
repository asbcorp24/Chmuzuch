<?php
namespace App\Http\Controllers;
use Illuminate\View\View;
class OfficialController extends Controller {
 public function index(): View { $sections=config('official_sections',[]); return view('official.index',['sections'=>$sections,'groups'=>collect($sections)->groupBy('group')]); }
 public function show(string $slug): View { $items=config('official_sections',[]); abort_unless(isset($items[$slug]),404); return view('official.show',['page'=>$items[$slug],'slug'=>$slug]); }
}