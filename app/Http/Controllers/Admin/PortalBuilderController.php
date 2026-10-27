<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\Page;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
class PortalBuilderController extends Controller {
 private array $allowed=['about','applicants','students','activity'];
 public function edit(string $slug): View { abort_unless(in_array($slug,$this->allowed,true),404); $page=Page::where('slug',$slug)->firstOrFail(); return view('admin.portal-builder',['page'=>$page,'blocks'=>$page->blocks??[],'slug'=>$slug]); }
 public function save(Request $r,string $slug): RedirectResponse { abort_unless(in_array($slug,$this->allowed,true),404); $d=$r->validate(['blocks_json'=>'required|json']); $blocks=json_decode($d['blocks_json'],true); abort_unless(is_array($blocks),422); Page::where('slug',$slug)->firstOrFail()->update(['blocks'=>$blocks,'type'=>'builder','status'=>'published']); return back()->with('success','Страница сохранена'); }
}