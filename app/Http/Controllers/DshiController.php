<?php
namespace App\Http\Controllers;
use Illuminate\View\View;
class DshiController extends Controller {
 public function index(): View { return view('dshi.index',['programs'=>config('dshi_programs',[])]); }
 public function show(string $slug): View { $items=config('dshi_programs',[]); abort_unless(isset($items[$slug]),404); return view('dshi.show',['program'=>$items[$slug],'slug'=>$slug]); }
}