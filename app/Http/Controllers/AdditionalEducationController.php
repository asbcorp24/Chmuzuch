<?php
namespace App\Http\Controllers;
use Illuminate\View\View;
class AdditionalEducationController extends Controller {
 public function index(): View { return view('additional.index',['courses'=>config('additional_courses',[])]); }
 public function show(string $slug): View { $items=config('additional_courses',[]); abort_unless(isset($items[$slug]),404); return view('additional.show',['course'=>$items[$slug],'slug'=>$slug]); }
}