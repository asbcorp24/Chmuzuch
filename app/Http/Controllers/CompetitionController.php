<?php
namespace App\Http\Controllers;
use Illuminate\View\View;
class CompetitionController extends Controller {
 public function index(): View { return view('competitions.index',['competitions'=>config('competitions',[])]); }
 public function show(string $slug): View { $items=config('competitions',[]); abort_unless(isset($items[$slug]),404); return view('competitions.show',['competition'=>$items[$slug],'slug'=>$slug]); }
}