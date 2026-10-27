<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\Page;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
class HomeBuilderController extends Controller {
 public function edit(): View { $page=Page::firstOrCreate(['slug'=>'home'],['title'=>'Главная','type'=>'builder','status'=>'published','blocks'=>config('home_blocks',[])]); return view('admin.home',['page'=>$page,'blocks'=>$page->blocks??[]]); }
 public function save(Request $r): RedirectResponse { $data=$r->validate(['blocks_json'=>'required|json']); $blocks=json_decode($data['blocks_json'],true); abort_unless(is_array($blocks),422); $page=Page::firstOrCreate(['slug'=>'home'],['title'=>'Главная']); $page->update(['type'=>'builder','status'=>'published','blocks'=>$blocks]); return back()->with('success','Главная сохранена'); }
}