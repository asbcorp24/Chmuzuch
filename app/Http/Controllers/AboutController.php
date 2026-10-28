<?php
namespace App\Http\Controllers;
use App\Models\Page;
use Illuminate\View\View;
class AboutController extends Controller {
 public function index(): View {return app(PortalPageController::class)->about();}
 public function section(string $section): View {
  $allowed=['history','pavlov','leadership','structure','facilities'];
  abort_unless(in_array($section,$allowed,true),404);
  $page=Page::published()->where('slug',$section)->firstOrFail();
  return view('public.content-page',compact('page'));
 }
}