<?php
namespace App\Http\Controllers;
use Illuminate\View\View;
class CollectiveController extends Controller {
 public function index(): View { return view('collectives.index',['collectives'=>config('collectives',[])]); }
 public function show(string $slug): View { $items=config('collectives',[]); abort_unless(isset($items[$slug]),404); return view('collectives.show',['collective'=>$items[$slug],'slug'=>$slug]); }
}