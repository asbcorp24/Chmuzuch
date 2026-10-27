<?php
namespace App\Http\Controllers;
use Illuminate\View\View;
class PublicSectionController extends Controller {
 public function dormitory(): View { return view('public.dormitory'); }
 public function media(): View { return view('public.media'); }
 public function achievements(): View { return view('public.achievements'); }
 public function gratitudes(): View { return view('public.gratitudes'); }
 public function contacts(): View { return view('public.contacts'); }
}