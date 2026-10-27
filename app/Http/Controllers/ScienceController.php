<?php
namespace App\Http\Controllers;
use Illuminate\View\View;
class ScienceController extends Controller {
 public function index(): View { $d=config('science',[]); return view('science.index',['projects'=>$d['projects']??[],'conferences'=>$d['conferences']??[]]); }
 public function project(string $slug): View { $items=config('science.projects',[]); abort_unless(isset($items[$slug]),404); return view('science.project',['project'=>$items[$slug]]); }
 public function conference(string $slug): View { $items=config('science.conferences',[]); abort_unless(isset($items[$slug]),404); return view('science.conference',['conference'=>$items[$slug],'slug'=>$slug]); }
}